from sqlmodel import SQLModel, create_engine
# from urllib.parse import quote_plus
# ini alamat mysql guweh
engine = create_engine(f"mysql+pymysql://root:@localhost:3306/db_crudt")
# buat database dan tabel dari sqlmodel
def create_db_all():
    SQLModel.metadata.create_all(engine)