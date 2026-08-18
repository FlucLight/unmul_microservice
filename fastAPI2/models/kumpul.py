from datetime import datetime
from typing import Optional
from sqlmodel import Field, SQLModel

class kumpul(SQLModel, table=True):
    id_kumpul: Optional[int] = Field(default=None, primary_key=True)
    id_tugas: int = Field(index=True)
    nama_mahasiswa: str = Field(index=True)
    nilai_mahasiswa: Optional[float] = Field(default=None, index=True)
    file_mahasiswa: Optional[str] = Field(default="", index=True)
    tanggal_kumpul: datetime = Field(...)
    nilai: Optional[int] = Field(default=None)

class kumpul_update(SQLModel):
    id_tugas: Optional[int] = None
    nama_mahasiswa: Optional[str] = None
    nilai_mahasiswa: Optional[float] = None
    file_mahasiswa: Optional[str] = None
    tanggal_kumpul: Optional[datetime] = None
    nilai: Optional[int] = None

class beri_nilai(SQLModel):
    nilai: int = Field(ge=0, le=100)
