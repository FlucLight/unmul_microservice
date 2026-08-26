from fastapi import FastAPI, HTTPException
from datetime import datetime
from sqlalchemy import text
from sqlmodel import Session, select
from config.db import engine, create_db
from models.kumpul import kumpul, kumpul_update, beri_nilai
from contextlib import asynccontextmanager

# ambil id
def kumpul_nilai_id(kumpul_id: int):
    with Session(engine) as session:
        result = session.get(kumpul, kumpul_id)
        return result


# migrasi ringan: tambah kolom catatan_dosen jika belum ada (untuk database lama)
def migrate_db():
    with engine.begin() as conn:
        try:
            conn.execute(text("ALTER TABLE kumpul ADD COLUMN catatan_dosen TEXT NULL"))
        except Exception:
            pass
        try:
            conn.execute(text("ALTER TABLE kumpul ADD COLUMN dinilai_at DATETIME NULL"))
        except Exception:
            pass
        try:
            conn.execute(text("ALTER TABLE kumpul ADD COLUMN resubmit_status VARCHAR NULL DEFAULT 'none'"))
        except Exception:
            pass


@asynccontextmanager
async def lifespan(app: FastAPI):
    create_db()
    migrate_db()
    yield

app = FastAPI(lifespan=lifespan)

@app.get("/")
def home():
    return "Halo polizia federao"

@app.post("/kumpul-tugas")
def kumpul_tugas(data_kumpul: kumpul):
    with Session(engine) as session:
        session.add(data_kumpul)
        session.commit()
        session.refresh(data_kumpul)
        return data_kumpul


@app.get("/ambil-kumpul")
async def ambilkumpul():
    with Session(engine) as session:
        statement = select(kumpul)
        result = session.exec(statement).all()
        return result

@app.patch("/edit-kumpul/{kumpul_id}")
async def editdata(kumpul_id: int, kumpul_data: kumpul_update):
    with Session(engine) as session:
        db_tugas = session.get(kumpul, kumpul_id)
        if not db_tugas:
            raise HTTPException(status_code=404, detail="Tugas yang dikumpulkan tidak ditemukan")
        else:
            kumpul_edit = kumpul_data.model_dump(exclude_unset=True)
            db_tugas.sqlmodel_update(kumpul_edit)
            session.add(db_tugas)
            session.commit()
            session.refresh(db_tugas)
            return db_tugas 


from models.kumpul import kumpul, kumpul_update, beri_nilai


@app.patch("/beri-nilai/{kumpul_id}")
async def berinilai(kumpul_id: int, data_nilai: beri_nilai):
    with Session(engine) as session:
        db_kumpul = session.get(kumpul, kumpul_id)
        if not db_kumpul:
            raise HTTPException(status_code=404, detail="Data pengumpulan tidak ditemukan")
        else:
            data_update = data_nilai.model_dump(exclude_unset=True)
            # CATATAN PERUBAHAN: nilai lama langsung diganti (overwrite) dan
            # 'dinilai_at' dicatat ulang setiap kali dosen memberi/mengubah nilai.
            if "nilai" in data_update:
                db_kumpul.nilai = data_nilai.nilai
                db_kumpul.nilai_mahasiswa = float(data_nilai.nilai)
                db_kumpul.dinilai_at = datetime.now()
            if "catatan_dosen" in data_update:
                db_kumpul.catatan_dosen = data_nilai.catatan_dosen
            session.add(db_kumpul)
            session.commit()
            session.refresh(db_kumpul)
            return db_kumpul


@app.delete("/hapus-kumpul/{kumpul_id}")
async def hapuskumpul(kumpul_id: int):
    with Session(engine) as session:
        db_nilai = session.get(kumpul, kumpul_id)
        if not db_nilai:
            raise HTTPException(status_code=404, detail="data kumpul tidak ditemukan")
        else:
            session.delete(db_nilai)
            session.commit()
            return "Udah dihapus dari tabase polizao mas"

            