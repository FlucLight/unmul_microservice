import os
import logging
from fastapi import FastAPI, HTTPException, Header, Depends
from fastapi.middleware.cors import CORSMiddleware
from pydantic import BaseModel
from sqlmodel import Session, select
from config.db import engine, create_db
from models.nim import Modul
from contextlib import asynccontextmanager
from typing import List, Optional

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


app = FastAPI(title="API Cek NIM", lifespan=lifespan)

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


# ---------- Endpoint ----------
@app.get("/")
def home():
    return {"status": "online", "service": "API Cek NIM"}


@app.get("/cek-nim/{nim}")
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


@app.get("/ambil-nim")
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


@app.post("/tambah-nim")
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


@app.post("/import-nim")
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


@app.delete("/hapus-nim/{nim}")
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
