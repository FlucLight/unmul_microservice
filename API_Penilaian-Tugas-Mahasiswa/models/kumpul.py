from datetime import datetime
from typing import Optional
from pydantic import field_validator
from sqlalchemy import Column, DateTime
from sqlmodel import Field, SQLModel

def _parse_dt(v):
    if v is None or v == '':
        return None
    if isinstance(v, str):
        s = v.replace('Z', '+00:00')
        try:
            dt = datetime.fromisoformat(s)
        except ValueError:
            for fmt in ('%Y-%m-%dT%H:%M:%S', '%Y-%m-%d %H:%M:%S', '%Y-%m-%dT%H:%M'):
                try:
                    dt = datetime.strptime(v[:19], fmt)
                    break
                except ValueError:
                    continue
            else:
                raise
        if getattr(dt, 'tzinfo', None) is not None:
            dt = dt.replace(tzinfo=None)
        return dt
    return v

class kumpul(SQLModel, table=True):
    id_kumpul: Optional[int] = Field(default=None, primary_key=True)
    id_tugas: int = Field(index=True)
    nama_mahasiswa: str = Field(index=True, max_length=255)
    file_mahasiswa: Optional[str] = Field(default="", max_length=1000)
    tanggal_kumpul: datetime = Field(sa_column=Column(DateTime(timezone=False), nullable=False))
    nilai: Optional[float] = Field(default=None)
    nilai_mahasiswa: Optional[float] = Field(default=None)
    catatan_dosen: Optional[str] = Field(default=None)
    dinilai_at: Optional[datetime] = Field(default=None, sa_column=Column(DateTime(timezone=False), nullable=True))
    resubmit_status: Optional[str] = Field(default="none", max_length=20)

    @field_validator('tanggal_kumpul', 'dinilai_at', mode='before')
    @classmethod
    def parse_dates(cls, v):
        return _parse_dt(v)

class kumpul_update(SQLModel):
    id_tugas: Optional[int] = None
    nama_mahasiswa: Optional[str] = None
    file_mahasiswa: Optional[str] = None
    tanggal_kumpul: Optional[datetime] = None
    nilai: Optional[float] = None
    catatan_dosen: Optional[str] = None
    dinilai_at: Optional[datetime] = None
    resubmit_status: Optional[str] = None

    @field_validator('tanggal_kumpul', 'dinilai_at', mode='before')
    @classmethod
    def parse_dates(cls, v):
        return _parse_dt(v)

class beri_nilai(SQLModel):
    nilai: float = Field(ge=0, le=100)
    catatan_dosen: Optional[str] = Field(default=None, max_length=1000)
