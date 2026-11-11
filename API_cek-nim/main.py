import os
import logging
from fastapi import FastAPI, HTTPException, Header, Depends
from fastapi.middleware.cors import CORSMiddleware
from fastapi.responses import HTMLResponse
from pydantic import BaseModel
from sqlmodel import Session, select
from config.db import engine, create_db
from models.nim import Modul
from contextlib import asynccontextmanager
from typing import List, Optional
from scalar_fastapi import get_scalar_api_reference

logging.basicConfig(level=logging.INFO)
logger = logging.getLogger("api-cek-nim")

API_KEY = os.getenv("API_KEY", "your-secret-api-key-change-me")


def verify_api_key(authorization: Optional[str] = Header(None)):
    if not authorization or authorization != f"Bearer {API_KEY}":
        raise HTTPException(status_code=401, detail="Unauthorized: API key tidak valid")


@asynccontextmanager
async def lifespan(app: FastAPI):
    create_db()
    logger.info("API Cek NIM started")
    yield
    logger.info("API Cek NIM stopped")


app = FastAPI(
    title="API Cek NIM",
    lifespan=lifespan,
    docs_url=None,
    redoc_url=None,
)

app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)


# ---------- Skema request ----------
class NimSingle(BaseModel):
    nim: int
    password: Optional[str] = "mhs123"


class NimBulk(BaseModel):
    nims: List[int]
    password: Optional[str] = "mhs123"


class NimUpdate(BaseModel):
    nim: int
    password: Optional[str] = None
    nim_baru: Optional[int] = None


class NimBulkUpdate(BaseModel):
    items: List[NimUpdate]


class NimBulkDelete(BaseModel):
    nims: List[int]


# ---------- Endpoint ----------
@app.get("/", tags=["Pencarian & Informasi"])
def home():
    return {"status": "online", "service": "API Cek NIM"}


@app.get("/docs", include_in_schema=False)
async def scalar_html():
    return get_scalar_api_reference(
        openapi_url=app.openapi_url,
        title=app.title + " - Documentation",
        dark_mode=True,
        hide_download_button=False,
    )


@app.get("/kelola", response_class=HTMLResponse, tags=["Manajemen Data NIM"])
def kelola_nim():
    return """<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Kelola NIM - API Cek NIM</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>body{font-family:system-ui,-apple-system,Segoe UI,Roboto,sans-serif}</style>
</head>
<body class="bg-slate-100 text-slate-800 min-h-screen">
  <div class="max-w-6xl mx-auto p-4 sm:p-6">
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3 mb-4">
      <div>
        <h1 class="text-2xl font-bold">Kelola Data NIM</h1>
        <p class="text-sm text-slate-500">Tambah, edit, hapus (satuan & massal) — API Cek NIM (db_cek)</p>
      </div>
      <div class="flex items-center gap-2">
        <span id="statusDot" class="w-2.5 h-2.5 rounded-full bg-slate-300"></span>
        <span id="statusText" class="text-xs text-slate-500">Belum terhubung</span>
      </div>
    </div>

    <div id="alert" class="hidden mb-4 p-3 rounded-lg text-sm font-medium"></div>

    <!-- API Key -->
    <div class="bg-white rounded-xl border border-slate-200 p-4 mb-4 shadow-sm">
      <div class="flex flex-col sm:flex-row gap-2 sm:items-end">
        <div class="flex-1">
          <label class="block text-xs font-semibold text-slate-600 mb-1">API Key (Bearer)</label>
          <input id="apiKey" type="password" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm" placeholder="Masukkan API_KEY (contoh: your-secret-api-key-change-me)" />
        </div>
        <div class="flex gap-2">
          <button onclick="saveKey()" class="px-4 py-2 rounded-lg bg-slate-800 text-white text-sm font-semibold hover:bg-slate-900">Simpan Key</button>
          <button onclick="loadData()" class="px-4 py-2 rounded-lg bg-amber-500 text-white text-sm font-semibold hover:bg-amber-600">Muat Data</button>
        </div>
      </div>
      <p class="text-xs text-slate-400 mt-2">Key disimpan di browser (localStorage) dan dikirim sebagai <code>Authorization: Bearer &lt;key&gt;</code>.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-4">
      <!-- Tambah Satuan -->
      <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm">
        <h2 class="font-semibold mb-3">Tambah Satu NIM</h2>
        <div class="space-y-2">
          <input id="addNim" type="number" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm" placeholder="NIM" />
          <input id="addPass" type="text" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm" placeholder="Password (default: mhs123)" />
          <button onclick="addSingle()" class="w-full px-3 py-2 rounded-lg bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-700">Tambah</button>
        </div>
      </div>

      <!-- Import Massal -->
      <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm">
        <h2 class="font-semibold mb-3">Tambah Massal (Import)</h2>
        <div class="space-y-2">
          <textarea id="bulkAddNims" rows="3" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm" placeholder="Daftar NIM, pisahkan dengan baris baru/koma/spasi&#10;Contoh:&#10;2109106051&#10;2109106052"></textarea>
          <input id="bulkAddPass" type="text" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm" placeholder="Password untuk semua (default: mhs123)" />
          <button onclick="addBulk()" class="w-full px-3 py-2 rounded-lg bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-700">Import Massal</button>
        </div>
      </div>

      <!-- Aksi Massal Terpilih -->
      <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-sm">
        <h2 class="font-semibold mb-3">Aksi Massal (Data Terpilih)</h2>
        <div class="space-y-2">
          <input id="bulkEditPass" type="text" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm" placeholder="Password baru (untuk edit massal)" />
          <button onclick="editBulkSelected()" class="w-full px-3 py-2 rounded-lg bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700">Edit Password (Terpilih)</button>
          <button onclick="deleteBulkSelected()" class="w-full px-3 py-2 rounded-lg bg-red-600 text-white text-sm font-semibold hover:bg-red-700">Hapus (Terpilih)</button>
          <p class="text-xs text-slate-400">Centang baris pada tabel untuk memilih data.</p>
        </div>
      </div>
    </div>

    <!-- Tabel Data -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 p-4 border-b border-slate-200">
        <div class="flex items-center gap-2">
          <h2 class="font-semibold">Data NIM</h2>
          <span id="countBadge" class="text-xs px-2 py-0.5 rounded-full bg-slate-100 text-slate-600">0</span>
        </div>
        <div class="flex gap-2">
          <input id="search" oninput="render()" type="text" class="border border-slate-300 rounded-lg px-3 py-1.5 text-sm" placeholder="Cari NIM..." />
          <button onclick="loadData()" class="px-3 py-1.5 rounded-lg border border-slate-300 text-sm hover:bg-slate-50">Refresh</button>
        </div>
      </div>
      <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
          <thead class="bg-slate-50 text-slate-600">
            <tr>
              <th class="p-3 text-left w-10"><input id="checkAll" type="checkbox" onchange="toggleAll(this)" /></th>
              <th class="p-3 text-left">ID</th>
              <th class="p-3 text-left">NIM</th>
              <th class="p-3 text-left">Password</th>
              <th class="p-3 text-left">Aksi</th>
            </tr>
          </thead>
          <tbody id="tbody" class="divide-y divide-slate-100"></tbody>
        </table>
      </div>
      <div id="empty" class="hidden p-8 text-center text-slate-400 text-sm">Belum ada data. Klik "Muat Data".</div>
    </div>
  </div>

  <!-- Modal Edit -->
  <div id="modal" class="hidden fixed inset-0 z-50 bg-black/40 items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-5">
      <h3 class="font-semibold text-lg mb-3">Edit NIM</h3>
      <input id="editOldNim" type="hidden" />
      <div class="space-y-2">
        <div>
          <label class="block text-xs font-medium text-slate-600 mb-1">NIM (baru/lama)</label>
          <input id="editNim" type="number" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm" />
        </div>
        <div>
          <label class="block text-xs font-medium text-slate-600 mb-1">Password</label>
          <input id="editPass" type="text" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm" />
        </div>
      </div>
      <div class="flex justify-end gap-2 mt-4">
        <button onclick="closeModal()" class="px-4 py-2 rounded-lg border border-slate-300 text-sm">Batal</button>
        <button onclick="saveEdit()" class="px-4 py-2 rounded-lg bg-blue-600 text-white text-sm font-semibold">Simpan</button>
      </div>
    </div>
  </div>

<script>
let rows = [];
const $ = (id) => document.getElementById(id);

function getKey() { return localStorage.getItem('cek_nim_api_key') || $('apiKey').value.trim(); }
function saveKey() { localStorage.setItem('cek_nim_api_key', $('apiKey').value.trim()); showAlert('API key disimpan.', 'ok'); }
(function init(){ const k = localStorage.getItem('cek_nim_api_key'); if(k) $('apiKey').value = k; })();

function showAlert(msg, type='ok') {
  const el = $('alert');
  el.className = 'mb-4 p-3 rounded-lg text-sm font-medium ' + (type==='ok' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-red-50 text-red-700 border border-red-200');
  el.textContent = msg; el.classList.remove('hidden');
  clearTimeout(window._at); window._at = setTimeout(()=>el.classList.add('hidden'), 4000);
}

async function api(path, opts={}) {
  const key = getKey();
  if (!key) throw new Error('API key belum diisi.');
  const res = await fetch(path, {
    ...opts,
    headers: { 'Content-Type': 'application/json', 'Authorization': 'Bearer ' + key, ...(opts.headers||{}) }
  });
  const text = await res.text();
  let data; try { data = text ? JSON.parse(text) : {}; } catch(e){ data = {raw:text}; }
  if (!res.ok) throw new Error((data && (data.detail || data.message)) || ('HTTP '+res.status));
  return data;
}

function parseNims(text) {
  return (text||'').split(/[\\s,;]+/).map(s=>s.trim()).filter(Boolean).map(Number).filter(n=>!isNaN(n));
}

async function loadData() {
  try {
    const data = await api('/ambil-nim');
    rows = Array.isArray(data) ? data : [];
    $('statusDot').className = 'w-2.5 h-2.5 rounded-full bg-emerald-500';
    $('statusText').textContent = 'Terhubung';
    render();
  } catch(e) {
    $('statusDot').className = 'w-2.5 h-2.5 rounded-full bg-red-500';
    $('statusText').textContent = 'Gagal';
    showAlert(e.message, 'err');
  }
}

function render() {
  const q = ($('search').value||'').trim();
  const filtered = q ? rows.filter(r => String(r.nim).includes(q)) : rows;
  $('countBadge').textContent = filtered.length + ' / ' + rows.length;
  const tb = $('tbody');
  if (!filtered.length) { tb.innerHTML = ''; $('empty').classList.remove('hidden'); return; }
  $('empty').classList.add('hidden');
  tb.innerHTML = filtered.map(r => `
    <tr class="hover:bg-slate-50">
      <td class="p-3"><input type="checkbox" class="rowcb" data-nim="${r.nim}"></td>
      <td class="p-3 text-slate-500">${r.id_mahasiswa ?? ''}</td>
      <td class="p-3 font-medium">${r.nim}</td>
      <td class="p-3 text-slate-600">${r.password ?? ''}</td>
      <td class="p-3">
        <div class="flex gap-2">
          <button onclick='openEdit(${JSON.stringify(r)})' class="px-2.5 py-1 rounded bg-blue-50 text-blue-700 hover:bg-blue-100 text-xs font-semibold">Edit</button>
          <button onclick="deleteOne(${r.nim})" class="px-2.5 py-1 rounded bg-red-50 text-red-700 hover:bg-red-100 text-xs font-semibold">Hapus</button>
        </div>
      </td>
    </tr>`).join('');
  $('checkAll').checked = false;
}

function toggleAll(el) { document.querySelectorAll('.rowcb').forEach(cb => cb.checked = el.checked); }
function selectedNims() { return Array.from(document.querySelectorAll('.rowcb:checked')).map(cb => Number(cb.dataset.nim)); }

async function addSingle() {
  const nim = Number($('addNim').value);
  const password = $('addPass').value.trim() || 'mhs123';
  if (!nim) return showAlert('NIM wajib diisi.', 'err');
  try {
    await api('/tambah-nim', {method:'POST', body: JSON.stringify({nim, password})});
    $('addNim').value=''; $('addPass').value='';
    showAlert('NIM berhasil ditambahkan.', 'ok'); loadData();
  } catch(e){ showAlert(e.message,'err'); }
}

async function addBulk() {
  const nims = parseNims($('bulkAddNims').value);
  const password = $('bulkAddPass').value.trim() || 'mhs123';
  if (!nims.length) return showAlert('Masukkan minimal satu NIM.', 'err');
  try {
    const r = await api('/import-nim', {method:'POST', body: JSON.stringify({nims, password})});
    $('bulkAddNims').value='';
    showAlert(`Import selesai: ditambah ${r.ditambah}, dilewati ${r.dilewati}.`, 'ok'); loadData();
  } catch(e){ showAlert(e.message,'err'); }
}

function openEdit(r) {
  $('editOldNim').value = r.nim; $('editNim').value = r.nim; $('editPass').value = r.password || '';
  const m = $('modal'); m.classList.remove('hidden'); m.classList.add('flex');
}
function closeModal(){ const m=$('modal'); m.classList.add('hidden'); m.classList.remove('flex'); }

async function saveEdit() {
  const oldNim = Number($('editOldNim').value);
  const nim = Number($('editNim').value);
  const password = $('editPass').value;
  try {
    await api('/edit-nim/'+oldNim, {method:'PATCH', body: JSON.stringify({nim, password: password||null})});
    closeModal(); showAlert('NIM berhasil diperbarui.', 'ok'); loadData();
  } catch(e){ showAlert(e.message,'err'); }
}

async function deleteOne(nim) {
  if(!confirm('Hapus NIM '+nim+'?')) return;
  try { await api('/hapus-nim/'+nim, {method:'DELETE'}); showAlert('NIM dihapus.','ok'); loadData(); }
  catch(e){ showAlert(e.message,'err'); }
}

async function deleteBulkSelected() {
  const nims = selectedNims();
  if(!nims.length) return showAlert('Pilih minimal satu NIM.', 'err');
  if(!confirm('Hapus '+nims.length+' NIM terpilih?')) return;
  try {
    const r = await api('/hapus-nim-massal', {method:'POST', body: JSON.stringify({nims})});
    showAlert(`Hapus massal: ${r.dihapus} dihapus, tidak ditemukan ${ (r.tidak_ditemukan||[]).length }.`, 'ok'); loadData();
  } catch(e){ showAlert(e.message,'err'); }
}

async function editBulkSelected() {
  const nims = selectedNims();
  const password = $('bulkEditPass').value;
  if(!nims.length) return showAlert('Pilih minimal satu NIM.', 'err');
  if(!password) return showAlert('Isi password baru untuk edit massal.', 'err');
  if(!confirm('Ubah password '+nims.length+' NIM terpilih?')) return;
  try {
    const items = nims.map(nim => ({nim, password}));
    const r = await api('/edit-nim-massal', {method:'PATCH', body: JSON.stringify({items})});
    showAlert(`Edit massal: ${r.diupdate} diperbarui.`, 'ok'); loadData();
  } catch(e){ showAlert(e.message,'err'); }
}

$('modal').addEventListener('click', (e)=>{ if(e.target.id==='modal') closeModal(); });
</script>
</body>
</html>"""


@app.get("/cek-nim/{nim}", tags=["Pencarian & Informasi"])
def cek_nim(nim: int, _: str = Depends(verify_api_key)):
    """Memeriksa apakah NIM terdaftar pada database mahasiswa (db_cek)."""
    try:
        with Session(engine) as session:
            statement = select(Modul).where(Modul.nim == nim)
            data_mahasiswa = session.exec(statement).first()

            if not data_mahasiswa:
                return {"nim": nim, "valid": False, "message": "NIM tidak terdaftar"}

            return {"nim": nim, "valid": True, "message": "NIM terdaftar"}
    except Exception as e:
        logger.error(f"Error cek NIM {nim}: {e}")
        raise HTTPException(status_code=500, detail="Gagal memeriksa NIM")


@app.get("/ambil-nim", tags=["Pencarian & Informasi"])
def ambil_nim(_: str = Depends(verify_api_key)):
    """Mengambil daftar seluruh NIM yang terdaftar di database mahasiswa."""
    try:
        with Session(engine) as session:
            statement = select(Modul)
            result = session.exec(statement).all()
            return result
    except Exception as e:
        logger.error(f"Error ambil NIM: {e}")
        raise HTTPException(status_code=500, detail="Gagal mengambil data NIM")


@app.post("/tambah-nim", tags=["Manajemen Data NIM"])
def tambah_nim(data: NimSingle, _: str = Depends(verify_api_key)):
    """Menambahkan satu NIM baru ke database mahasiswa."""
    try:
        with Session(engine) as session:
            existing = session.exec(select(Modul).where(Modul.nim == data.nim)).first()
            if existing:
                raise HTTPException(status_code=409, detail="NIM sudah terdaftar")

            new_nim = Modul(nim=data.nim, password=data.password)
            session.add(new_nim)
            session.commit()
            session.refresh(new_nim)
            logger.info(f"NIM ditambahkan: {data.nim}")
            return {"message": "NIM berhasil ditambahkan", "data": new_nim}
    except HTTPException:
        raise
    except Exception as e:
        logger.error(f"Error tambah NIM {data.nim}: {e}")
        raise HTTPException(status_code=500, detail="Gagal menambahkan NIM")


@app.post("/import-nim", tags=["Manajemen Data NIM"])
def import_nim(data: NimBulk, _: str = Depends(verify_api_key)):
    """Menambahkan banyak NIM sekaligus (bulk import) ke database mahasiswa.

    NIM yang sudah terdaftar akan dilewati (tidak error), sehingga aman
    dipanggil berulang kali dengan daftar yang sama.
    """
    try:
        ditambah = 0
        dilewati = 0
        with Session(engine) as session:
            for nim in data.nims:
                existing = session.exec(select(Modul).where(Modul.nim == nim)).first()
                if existing:
                    dilewati += 1
                    continue
                session.add(Modul(nim=nim, password=data.password))
                ditambah += 1
            session.commit()
            logger.info(f"Import NIM: ditambah={ditambah}, dilewati={dilewati}")
            return {
                "message": "Import selesai",
                "ditambah": ditambah,
                "dilewati": dilewati,
                "total_input": len(data.nims),
            }
    except Exception as e:
        logger.error(f"Error import NIM: {e}")
        raise HTTPException(status_code=500, detail="Gagal melakukan import NIM")


@app.patch("/edit-nim/{nim}", tags=["Manajemen Data NIM"])
def edit_nim(nim: int, data: NimSingle, _: str = Depends(verify_api_key)):
    """Mengedit satu data NIM (ganti NIM dan/atau password)."""
    try:
        with Session(engine) as session:
            db_nim = session.exec(select(Modul).where(Modul.nim == nim)).first()
            if not db_nim:
                raise HTTPException(status_code=404, detail="NIM tidak ditemukan")

            # jika nim baru berbeda, pastikan belum dipakai
            if data.nim != nim:
                existing = session.exec(select(Modul).where(Modul.nim == data.nim)).first()
                if existing:
                    raise HTTPException(status_code=409, detail=f"NIM baru {data.nim} sudah terdaftar")
                db_nim.nim = data.nim

            if data.password is not None:
                db_nim.password = data.password

            session.add(db_nim)
            session.commit()
            session.refresh(db_nim)
            logger.info(f"NIM diupdate: {nim} -> {db_nim.nim}")
            return {"message": "NIM berhasil diperbarui", "data": db_nim}
    except HTTPException:
        raise
    except Exception as e:
        logger.error(f"Error edit NIM {nim}: {e}")
        raise HTTPException(status_code=500, detail="Gagal memperbarui NIM")


@app.patch("/edit-nim-massal", tags=["Manajemen Data NIM"])
def edit_nim_massal(data: NimBulkUpdate, _: str = Depends(verify_api_key)):
    """Mengedit banyak NIM sekaligus.
    Setiap item: {nim: <nim_lama>, nim_baru?: <nim_baru>, password?: <password_baru>}
    """
    try:
        diupdate = 0
        tidak_ditemukan = []
        konflik = []
        with Session(engine) as session:
            for item in data.items:
                db_nim = session.exec(select(Modul).where(Modul.nim == item.nim)).first()
                if not db_nim:
                    tidak_ditemukan.append(item.nim)
                    continue

                target_nim = item.nim_baru if item.nim_baru is not None else item.nim
                if target_nim != item.nim:
                    existing = session.exec(select(Modul).where(Modul.nim == target_nim)).first()
                    if existing:
                        konflik.append({"nim": item.nim, "nim_baru": target_nim, "alasan": "nim_baru sudah terdaftar"})
                        continue
                    db_nim.nim = target_nim

                if item.password is not None:
                    db_nim.password = item.password

                session.add(db_nim)
                diupdate += 1

            session.commit()
            logger.info(f"Edit massal NIM: diupdate={diupdate}, tidak_ditemukan={len(tidak_ditemukan)}, konflik={len(konflik)}")
            return {
                "message": "Edit massal selesai",
                "diupdate": diupdate,
                "tidak_ditemukan": tidak_ditemukan,
                "konflik": konflik,
                "total_input": len(data.items),
            }
    except Exception as e:
        logger.error(f"Error edit massal NIM: {e}")
        raise HTTPException(status_code=500, detail="Gagal melakukan edit massal NIM")


@app.delete("/hapus-nim/{nim}", tags=["Manajemen Data NIM"])
def hapus_nim(nim: int, _: str = Depends(verify_api_key)):
    """Menghapus NIM dari database mahasiswa."""
    try:
        with Session(engine) as session:
            db_nim = session.exec(select(Modul).where(Modul.nim == nim)).first()
            if not db_nim:
                raise HTTPException(status_code=404, detail="NIM tidak ditemukan")
            session.delete(db_nim)
            session.commit()
            logger.info(f"NIM dihapus: {nim}")
            return {"message": "NIM berhasil dihapus"}
    except HTTPException:
        raise
    except Exception as e:
        logger.error(f"Error hapus NIM {nim}: {e}")
        raise HTTPException(status_code=500, detail="Gagal menghapus NIM")


@app.post("/hapus-nim-massal", tags=["Manajemen Data NIM"])
def hapus_nim_massal(data: NimBulkDelete, _: str = Depends(verify_api_key)):
    """Menghapus banyak NIM sekaligus."""
    try:
        dihapus = 0
        tidak_ditemukan = []
        with Session(engine) as session:
            for nim in data.nims:
                db_nim = session.exec(select(Modul).where(Modul.nim == nim)).first()
                if not db_nim:
                    tidak_ditemukan.append(nim)
                    continue
                session.delete(db_nim)
                dihapus += 1
            session.commit()
            logger.info(f"Hapus massal NIM: dihapus={dihapus}, tidak_ditemukan={len(tidak_ditemukan)}")
            return {
                "message": "Hapus massal selesai",
                "dihapus": dihapus,
                "tidak_ditemukan": tidak_ditemukan,
                "total_input": len(data.nims),
            }
    except Exception as e:
        logger.error(f"Error hapus massal NIM: {e}")
        raise HTTPException(status_code=500, detail="Gagal melakukan hapus massal NIM")
