import os
import logging
from datetime import datetime
from fastapi import FastAPI, HTTPException, Header, Depends
from fastapi.middleware.cors import CORSMiddleware
from sqlalchemy import text
from sqlmodel import Session, select
from config.db import engine, create_db
from models.kumpul import kumpul, kumpul_update, beri_nilai
from contextlib import asynccontextmanager
from typing import Optional

logging.basicConfig(level=logging.INFO)
logger = logging.getLogger("api-penilaian")

API_KEY = os.getenv("API_KEY", "your-secret-api-key-change-me")


def verify_api_key(authorization: Optional[str] = Header(None)):
    if not authorization or authorization != f"Bearer {API_KEY}":
        raise HTTPException(status_code=401, detail="Unauthorized: API key tidak valid")


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
            conn.execute(text("ALTER TABLE kumpul ADD COLUMN resubmit_status VARCHAR(20) NULL DEFAULT 'none'"))
        except Exception:
            pass
        try:
            conn.execute(text("ALTER TABLE kumpul ADD COLUMN nilai FLOAT NULL"))
        except Exception:
            pass


@asynccontextmanager
async def lifespan(app: FastAPI):
    create_db()
    migrate_db()
    logger.info("API Penilaian Tugas started")
    yield
    logger.info("API Penilaian Tugas stopped")


app = FastAPI(title="API Penilaian Tugas Mahasiswa", lifespan=lifespan)

app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)


@app.get("/")
def home():
    return {"status": "online", "service": "API Penilaian Tugas Mahasiswa"}


@app.post("/kumpul-tugas")
def kumpul_tugas(data_kumpul: kumpul):
    try:
        with Session(engine) as session:
            statement = select(kumpul).where(
                kumpul.id_tugas == data_kumpul.id_tugas,
                kumpul.nama_mahasiswa == data_kumpul.nama_mahasiswa,
                kumpul.resubmit_status == "pending"
            )
            existing = session.exec(statement).first()
            if existing:
                raise HTTPException(status_code=409, detail="Masih ada pengajuan kirim ulang yang menunggu persetujuan")

            session.add(data_kumpul)
            session.commit()
            session.refresh(data_kumpul)
            logger.info(f"Tugas dikumpulkan: {data_kumpul.nama_mahasiswa} -> tugas {data_kumpul.id_tugas}")
            return data_kumpul
    except HTTPException:
        raise
    except Exception as e:
        logger.error(f"Error kumpul tugas: {e}")
        raise HTTPException(status_code=500, detail="Gagal mengumpulkan tugas")


@app.get("/ambil-kumpul")
async def ambilkumpul():
    try:
        with Session(engine) as session:
            statement = select(kumpul)
            result = session.exec(statement).all()
            return result
    except Exception as e:
        logger.error(f"Error ambil kumpul: {e}")
        raise HTTPException(status_code=500, detail="Gagal mengambil data pengumpulan")


@app.get("/ambil-kumpul/{kumpul_id}")
async def ambil_kumpul_by_id(kumpul_id: int):
    try:
        with Session(engine) as session:
            db_kumpul = session.get(kumpul, kumpul_id)
            if not db_kumpul:
                raise HTTPException(status_code=404, detail="Data pengumpulan tidak ditemukan")
            return db_kumpul
    except HTTPException:
        raise
    except Exception as e:
        logger.error(f"Error ambil kumpul {kumpul_id}: {e}")
        raise HTTPException(status_code=500, detail="Gagal mengambil data pengumpulan")


@app.patch("/edit-kumpul/{kumpul_id}")
async def editdata(kumpul_id: int, kumpul_data: kumpul_update, _: str = Depends(verify_api_key)):
    try:
        with Session(engine) as session:
            db_tugas = session.get(kumpul, kumpul_id)
            if not db_tugas:
                raise HTTPException(status_code=404, detail="Data pengumpulan tidak ditemukan")
            kumpul_edit = kumpul_data.model_dump(exclude_unset=True)
            db_tugas.sqlmodel_update(kumpul_edit)
            session.add(db_tugas)
            session.commit()
            session.refresh(db_tugas)
            logger.info(f"Pengumpulan diupdate: {kumpul_id}")
            return db_tugas
    except HTTPException:
        raise
    except Exception as e:
        logger.error(f"Error update kumpul {kumpul_id}: {e}")
        raise HTTPException(status_code=500, detail="Gagal mengupdate pengumpulan")


@app.patch("/beri-nilai/{kumpul_id}")
async def berinilai(kumpul_id: int, data_nilai: beri_nilai, _: str = Depends(verify_api_key)):
    try:
        with Session(engine) as session:
            db_kumpul = session.get(kumpul, kumpul_id)
            if not db_kumpul:
                raise HTTPException(status_code=404, detail="Data pengumpulan tidak ditemukan")
            db_kumpul.nilai = data_nilai.nilai
            db_kumpul.catatan_dosen = data_nilai.catatan_dosen
            db_kumpul.dinilai_at = datetime.now()
            session.add(db_kumpul)
            session.commit()
            session.refresh(db_kumpul)
            logger.info(f"Nilai diberikan: kumpul {kumpul_id}, nilai {data_nilai.nilai}")
            return db_kumpul
    except HTTPException:
        raise
    except Exception as e:
        logger.error(f"Error beri nilai {kumpul_id}: {e}")
        raise HTTPException(status_code=500, detail="Gagal memberikan nilai")


@app.patch("/approve/{kumpul_id}")
async def approve_resubmit(kumpul_id: int, _: str = Depends(verify_api_key)):
    try:
        with Session(engine) as session:
            db_kumpul = session.get(kumpul, kumpul_id)
            if not db_kumpul:
                raise HTTPException(status_code=404, detail="Data pengumpulan tidak ditemukan")
            if db_kumpul.resubmit_status != "pending":
                raise HTTPException(status_code=400, detail="Pengumpulan ini tidak dalam status menunggu persetujuan")
            db_kumpul.resubmit_status = "disetujui"
            db_kumpul.dinilai_at = None
            session.add(db_kumpul)
            session.commit()
            session.refresh(db_kumpul)
            logger.info(f"Resubmit disetujui: kumpul {kumpul_id}")
            return db_kumpul
    except HTTPException:
        raise
    except Exception as e:
        logger.error(f"Error approve resubmit {kumpul_id}: {e}")
        raise HTTPException(status_code=500, detail="Gagal menyetujui pengajuan")


@app.patch("/reject/{kumpul_id}")
async def reject_resubmit(kumpul_id: int, _: str = Depends(verify_api_key)):
    try:
        with Session(engine) as session:
            db_kumpul = session.get(kumpul, kumpul_id)
            if not db_kumpul:
                raise HTTPException(status_code=404, detail="Data pengumpulan tidak ditemukan")
            if db_kumpul.resubmit_status != "pending":
                raise HTTPException(status_code=400, detail="Pengumpulan ini tidak dalam status menunggu persetujuan")
            db_kumpul.resubmit_status = "ditolak"
            session.add(db_kumpul)
            session.commit()
            session.refresh(db_kumpul)
            logger.info(f"Resubmit ditolak: kumpul {kumpul_id}")
            return db_kumpul
    except HTTPException:
        raise
    except Exception as e:
        logger.error(f"Error reject resubmit {kumpul_id}: {e}")
        raise HTTPException(status_code=500, detail="Gagal menolak pengajuan")


@app.delete("/hapus-kumpul/{kumpul_id}")
async def hapuskumpul(kumpul_id: int, _: str = Depends(verify_api_key)):
    try:
        with Session(engine) as session:
            db_nilai = session.get(kumpul, kumpul_id)
            if not db_nilai:
                raise HTTPException(status_code=404, detail="Data kumpul tidak ditemukan")
            session.delete(db_nilai)
            session.commit()
            logger.info(f"Pengumpulan dihapus: {kumpul_id}")
            return {"message": "Pengumpulan berhasil dihapus"}
    except HTTPException:
        raise
    except Exception as e:
        logger.error(f"Error hapus kumpul {kumpul_id}: {e}")
        raise HTTPException(status_code=500, detail="Gagal menghapus pengumpulan")


@app.delete("/hapus-by-tugas/{tugas_id}")
async def hapus_by_tugas(tugas_id: int, _: str = Depends(verify_api_key)):
    try:
        with Session(engine) as session:
            statement = select(kumpul).where(kumpul.id_tugas == tugas_id)
            results = session.exec(statement).all()
            count = len(results)
            for item in results:
                session.delete(item)
            session.commit()
            logger.info(f"{count} pengumpulan dihapus untuk tugas {tugas_id}")
            return {"message": f"{count} pengumpulan berhasil dihapus"}
    except Exception as e:
        logger.error(f"Error hapus kumpulan by tugas {tugas_id}: {e}")
        raise HTTPException(status_code=500, detail="Gagal menghapus pengumpulan")
