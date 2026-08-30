import os
import logging
from datetime import datetime
from fastapi import FastAPI, HTTPException, Header, Depends
from fastapi.middleware.cors import CORSMiddleware
from sqlalchemy import text
from sqlmodel import Session, select
from config.database import engine, create_db_all
from models.tugas import tugas, tugas_update
from contextlib import asynccontextmanager
from typing import Optional

logging.basicConfig(level=logging.INFO)
logger = logging.getLogger("api-tugas")

API_KEY = os.getenv("API_KEY", "your-secret-api-key-change-me")


def verify_api_key(authorization: Optional[str] = Header(None)):
    if not authorization or authorization != f"Bearer {API_KEY}":
        raise HTTPException(status_code=401, detail="Unauthorized: API key tidak valid")


def migrate_db():
    with engine.begin() as conn:
        try:
            conn.execute(text("ALTER TABLE tugas ADD COLUMN deskripsi_tugas TEXT NULL"))
        except Exception:
            pass
        try:
            conn.execute(text("ALTER TABLE tugas ADD COLUMN show_nilai BOOLEAN NULL DEFAULT 1"))
        except Exception:
            pass


@asynccontextmanager
async def lifespan(app: FastAPI):
    create_db_all()
    migrate_db()
    logger.info("API Tugas started")
    yield
    logger.info("API Tugas stopped")


app = FastAPI(title="API Tugas Kuliah", lifespan=lifespan)

app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)


@app.get("/")
def home():
    return {"status": "online", "service": "API Tugas Kuliah"}


@app.post("/tambah")
def tambah_tugas(data_tugas: tugas, _: str = Depends(verify_api_key)):
    try:
        with Session(engine) as session:
            session.add(data_tugas)
            session.commit()
            session.refresh(data_tugas)
            logger.info(f"Tugas ditambahkan: {data_tugas.nama_tugas}")
            return data_tugas
    except Exception as e:
        logger.error(f"Error tambah tugas: {e}")
        raise HTTPException(status_code=500, detail="Gagal menambahkan tugas")


@app.get("/ambil-tugas")
async def ambiltugas():
    try:
        with Session(engine) as session:
            statement = select(tugas)
            result = session.exec(statement).all()
            return result
    except Exception as e:
        logger.error(f"Error ambil tugas: {e}")
        raise HTTPException(status_code=500, detail="Gagal mengambil data tugas")


@app.get("/ambil-tugas/{tugas_id}")
async def ambil_tugas_by_id(tugas_id: int):
    try:
        with Session(engine) as session:
            db_tugas = session.get(tugas, tugas_id)
            if not db_tugas:
                raise HTTPException(status_code=404, detail="Tugas tidak ditemukan")
            return db_tugas
    except HTTPException:
        raise
    except Exception as e:
        logger.error(f"Error ambil tugas {tugas_id}: {e}")
        raise HTTPException(status_code=500, detail="Gagal mengambil data tugas")


@app.patch("/edit/{tugas_id}")
async def editdata(tugas_id: int, tugas_data: tugas_update, _: str = Depends(verify_api_key)):
    try:
        with Session(engine) as session:
            db_crudt = session.get(tugas, tugas_id)
            if not db_crudt:
                raise HTTPException(status_code=404, detail="Tugas tidak ditemukan")
            tugas_edit = tugas_data.model_dump(exclude_unset=True)
            db_crudt.sqlmodel_update(tugas_edit)
            session.add(db_crudt)
            session.commit()
            session.refresh(db_crudt)
            logger.info(f"Tugas diupdate: {tugas_id}")
            return db_crudt
    except HTTPException:
        raise
    except Exception as e:
        logger.error(f"Error update tugas {tugas_id}: {e}")
        raise HTTPException(status_code=500, detail="Gagal mengupdate tugas")


@app.delete("/hapus/{tugas_id}")
async def hapusTugas(tugas_id: int, _: str = Depends(verify_api_key)):
    try:
        with Session(engine) as session:
            db_tugas = session.get(tugas, tugas_id)
            if not db_tugas:
                raise HTTPException(status_code=404, detail="Tugas tidak ditemukan")
            session.delete(db_tugas)
            session.commit()
            logger.info(f"Tugas dihapus: {tugas_id}")
            return {"message": "Tugas berhasil dihapus"}
    except HTTPException:
        raise
    except Exception as e:
        logger.error(f"Error hapus tugas {tugas_id}: {e}")
        raise HTTPException(status_code=500, detail="Gagal menghapus tugas")
