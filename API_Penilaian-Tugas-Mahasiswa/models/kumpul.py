from datetime import datetime
from typing import Optional
from sqlmodel import Field, SQLModel

class kumpul(SQLModel, table=True):
    id_kumpul: Optional[int] = Field(default=None, primary_key=True)
    id_tugas: int = Field(index=True)
    nama_mahasiswa: str = Field(index=True, max_length=255)
    file_mahasiswa: Optional[str] = Field(default="", max_length=1000)
    tanggal_kumpul: datetime = Field(...)
    nilai: Optional[float] = Field(default=None)
    nilai_mahasiswa: Optional[float] = Field(default=None)
    catatan_dosen: Optional[str] = Field(default=None)
    dinilai_at: Optional[datetime] = Field(default=None)
    resubmit_status: Optional[str] = Field(default="none", max_length=20)

class kumpul_update(SQLModel):
    id_tugas: Optional[int] = None
    nama_mahasiswa: Optional[str] = None
    file_mahasiswa: Optional[str] = None
    tanggal_kumpul: Optional[datetime] = None
    nilai: Optional[float] = None
    catatan_dosen: Optional[str] = None
    dinilai_at: Optional[datetime] = None
    resubmit_status: Optional[str] = None

class beri_nilai(SQLModel):
    nilai: float = Field(ge=0, le=100)
    catatan_dosen: Optional[str] = Field(default=None, max_length=1000)
