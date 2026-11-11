from sqlmodel import SQLModel, create_engine

engine = create_engine(f"mysql+pymysql://root:@localhost:3306/db_cek")

def create_db():
    SQLModel.metadata.create_all(engine)