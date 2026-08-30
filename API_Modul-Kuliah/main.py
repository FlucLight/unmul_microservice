import os
import logging
from fastapi import FastAPI, HTTPException, Header, Depends
from fastapi.middleware.cors import CORSMiddleware
from sqlmodel import Session, select
from config.db import engine, create_db
from models.modul import Modul, Modul_update
from contextlib import asynccontextmanager
from typing import Optional

logging.basicConfig(level=logging.INFO)
logger = logging.getLogger("api-modul")

API_KEY = os.getenv("API_KEY", "your-secret-api-key-change-me")


def verify_api_key(authorization: Optional[str] = Header(None)):
    if not authorization or authorization != f"Bearer {API_KEY}":
        raise HTTPException(status_code=401, detail="Unauthorized: API key tidak valid")


@asynccontextmanager
async def lifespan(app: FastAPI):
    create_db()
    logger.info("API Modul Kuliah started")
    yield
    logger.info("API Modul Kuliah stopped")


app = FastAPI(title="API Modul Kuliah", lifespan=lifespan)

app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)


@app.get("/")
def home():
    return {"status": "online", "service": "API Modul Kuliah"}


@app.post("/Tambah-modul")
def tambah_modul(data_modul: Modul, _: str = Depends(verify_api_key)):
    try:
        with Session(engine) as session:
            session.add(data_modul)
            session.commit()
            session.refresh(data_modul)
            logger.info(f"Modul ditambahkan: {data_modul.nama_modul}")
            return data_modul
    except Exception as e:
        logger.error(f"Error tambah modul: {e}")
        raise HTTPException(status_code=500, detail="Gagal menambahkan modul")


@app.get("/ambil-modul")
async def ambilmodul():
    try:
        with Session(engine) as session:
            statement = select(Modul)
            result = session.exec(statement).all()
            return result
    except Exception as e:
        logger.error(f"Error ambil modul: {e}")
        raise HTTPException(status_code=500, detail="Gagal mengambil data modul")


@app.get("/ambil-modul/{modul_id}")
async def ambil_modul_by_id(modul_id: int):
    try:
        with Session(engine) as session:
            db_modul = session.get(Modul, modul_id)
            if not db_modul:
                raise HTTPException(status_code=404, detail="Modul tidak ditemukan")
            return db_modul
    except HTTPException:
        raise
    except Exception as e:
        logger.error(f"Error ambil modul {modul_id}: {e}")
        raise HTTPException(status_code=500, detail="Gagal mengambil data modul")


@app.patch("/edit-modul/{modul_id}")
async def editmodul(modul_id: int, modul_data: Modul_update, _: str = Depends(verify_api_key)):
    try:
        with Session(engine) as session:
            db_modul = session.get(Modul, modul_id)
            if not db_modul:
                raise HTTPException(status_code=404, detail="Modul tidak ditemukan")
            modul_edit = modul_data.model_dump(exclude_unset=True)
            db_modul.sqlmodel_update(modul_edit)
            session.add(db_modul)
            session.commit()
            session.refresh(db_modul)
            logger.info(f"Modul diupdate: {modul_id}")
            return db_modul
    except HTTPException:
        raise
    except Exception as e:
        logger.error(f"Error update modul {modul_id}: {e}")
        raise HTTPException(status_code=500, detail="Gagal mengupdate modul")


@app.delete("/hapus-modul/{modul_id}")
async def hapusmodul(modul_id: int, _: str = Depends(verify_api_key)):
    try:
        with Session(engine) as session:
            db_modul = session.get(Modul, modul_id)
            if not db_modul:
                raise HTTPException(status_code=404, detail="Modul tidak ditemukan")
            session.delete(db_modul)
            session.commit()
            logger.info(f"Modul dihapus: {modul_id}")
            return {"message": "Modul berhasil dihapus"}
    except HTTPException:
        raise
    except Exception as e:
        logger.error(f"Error hapus modul {modul_id}: {e}")
        raise HTTPException(status_code=500, detail="Gagal menghapus modul")
