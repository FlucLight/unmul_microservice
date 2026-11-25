from typing import Optional
from sqlalchemy import BigInteger, Column
from sqlmodel import Field, SQLModel

class Modul(SQLModel, table=True):
    id_mahasiswa: Optional[int] = Field(default=None, primary_key=True)
    nim: int = Field(sa_column=Column(BigInteger, index=True, nullable=False))
    password: str = Field(index=True)
   

class Modul_update(SQLModel):
    id_mahasiswa: Optional[int] = None
    nim: Optional[int] = None
    password: Optional[str] = None