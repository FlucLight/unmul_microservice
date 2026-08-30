from datetime import datetime
from typing import Optional
from sqlmodel import Field, SQLModel

class Modul(SQLModel, table=True):
    id_modul: Optional[int] = Field(default=None, primary_key=True)
    nama_modul: str = Field(index=True, max_length=255)
    nama_dosen: str = Field(index=True, max_length=255)
    file_modul: Optional[str] = Field(default="", max_length=1000)
    tanggal_diupload: datetime = Field(...)

class Modul_update(SQLModel):
    nama_modul: Optional[str] = None
    nama_dosen: Optional[str] = None
    file_modul: Optional[str] = None
    tanggal_diupload: Optional[datetime] = None
