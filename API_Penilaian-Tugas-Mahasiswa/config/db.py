from sqlmodel import SQLModel, create_engine
# alamat mysql
engine = create_engine(f"mysql+pymysql://root:@localhost:3306/db_tugas")
# buat database dan tabel dari sqlmodel
def create_db():
    SQLModel.metadata.create_all(engine)
