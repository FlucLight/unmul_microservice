from fastapi import FastAPI, HTTPException
from sqlalchemy import text
from sqlmodel import Session, select
from config.database import engine, create_db_all
from models.tugas import tugas, tugas_update
from contextlib import asynccontextmanager


# migrasi ringan: tambah kolom show_nilai jika belum ada (untuk database lama)
def migrate_db():
    with engine.begin() as conn:
        try:
            conn.execute(text("ALTER TABLE tugas ADD COLUMN show_nilai BOOLEAN NULL DEFAULT 1"))
        except Exception:
            pass



# untuk ambil id
def tugas_nilai_id(tugas_id: int):
    with Session(engine) as session:
        result = session.get(tugas, tugas_id)
        return result


@asynccontextmanager 
async def lifespan(app: FastAPI):
    create_db_all()
    migrate_db()
    yield


app = FastAPI(lifespan=lifespan)

@app.get("/")
def home():
    return "Halo ini API GUWEH jijir"

@app.post("/tambah")
def tambah_tugas(data_tugas: tugas):
    with Session(engine) as session:
        session.add(data_tugas)
        session.commit()
        session.refresh(data_tugas)
        return data_tugas
    
@app.get("/ambil-tugas")
async def ambiltugas():
    with Session(engine) as session:
        statement = select(tugas)
        result = session.exec(statement).all()
        return result

@app.patch("/edit/{tugas_id}")
async def editdata(tugas_id: int, tugas_data: tugas_update):
    with Session(engine) as session:
        db_crudt = session.get(tugas, tugas_id)
        if not db_crudt:
            raise HTTPException(status_code=404, detail="Tugas tidak ditemukan")
        else:
            tugas_edit = tugas_data.model_dump(exclude_unset=True)
            db_crudt.sqlmodel_update(tugas_edit)
            session.add(db_crudt)
            session.commit()
            session.refresh(db_crudt)
            return db_crudt


@app.delete("/hapus/{tugas_id}")
async def hapusTugas(tugas_id: int):
    with Session(engine) as session:
        db_tugas = session.get(tugas, tugas_id)
        if not db_tugas:
            raise HTTPException(status_code=404, detail="Tugas tidak ditemukan")
        else:
            session.delete(db_tugas)
            session.commit()
            return "Udah dihapus mas"


