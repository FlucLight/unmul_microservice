from fastapi import FastAPI, HTTPException
from sqlmodel import Session, select
from config.db import engine, create_db
from models.modul import Modul, Modul_update
from contextlib import asynccontextmanager

# ambil id
def modul_id(modul_id: int):
    with Session(engine) as session:
        result = session.get(Modul, modul_id)
        return result


@asynccontextmanager
async def lifespan(app: FastAPI):
    create_db()
    yield

app = FastAPI(lifespan=lifespan)

@app.get("/")
def home():
    return "Halo disini gue"

@app.post("/Tambah-modul")
def tambah_modul(data_modul: Modul):
    with Session(engine) as session:
        session.add(data_modul)
        session.commit()
        session.refresh(data_modul)
        return data_modul


@app.get("/ambil-modul")
async def ambilmodul():
    with Session(engine) as session:
        statement = select(Modul)
        result = session.exec(statement).all()
        return result

@app.patch("/edit-modul/{modul_id}")
async def editmodul(modul_id: int, modul_data: Modul_update):
    with Session(engine) as session:
        db_modul = session.get(Modul, modul_id)
        if not db_modul:
            raise HTTPException(status_code=404, detail="Modul tidak ditemukan")
        else:
            modul_edit = modul_data.model_dump(exclude_unset=True)
            db_modul.sqlmodel_update(modul_edit)
            session.add(db_modul)
            session.commit()
            session.refresh(db_modul)
            return db_modul 




@app.delete("/hapus-modul/{modul_id}")
async def hapusmodul(modul_id: int):
    with Session(engine) as session:
        db_modul = session.get(Modul, modul_id)
        if not db_modul:
            raise HTTPException(status_code=404, detail="Modul tidak ditemukan")
        else:
            session.delete(db_modul)
            session.commit()
            return "Modul berhasil dihapus"
            