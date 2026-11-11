from typing import Optional
from sqlmodel import Field, SQLModel

class Modul(SQLModel, table=True):
    id_mahasiswa: Optional[int] = Field(default=None, primary_key=True)
    nim: int = Field(index=True)
    password: str = Field(index=True)
   

class Modul_update(SQLModel):
    id_mahasiswa: Optional[int] = None
    nim: Optional[int] = None
    password: Optional[str] = None