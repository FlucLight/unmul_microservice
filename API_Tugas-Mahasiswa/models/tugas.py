from datetime import datetime
from typing import Optional
from sqlmodel import Field, SQLModel

class tugas(SQLModel, table=True):
    id_tugas: Optional[int] = Field(default=None, primary_key=True)
    nama_tugas: str = Field(index=True, max_length=255)
    deskripsi_tugas: Optional[str] = Field(default=None)
    nama_dosen: str = Field(index=True, max_length=255)
    deadline_tugas: datetime = Field(...)
    show_nilai: bool = Field(default=True)

class tugas_update(SQLModel):
    nama_tugas: Optional[str] = None
    deskripsi_tugas: Optional[str] = None
    nama_dosen: Optional[str] = None
    deadline_tugas: Optional[datetime] = None
    show_nilai: Optional[bool] = None
