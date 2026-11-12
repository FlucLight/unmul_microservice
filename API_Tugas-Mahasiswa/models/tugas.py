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

class tugas(SQLModel, table=True):
    id_tugas: Optional[int] = Field(default=None, primary_key=True)
    nama_tugas: str = Field(index=True, max_length=255)
    deskripsi_tugas: Optional[str] = Field(default=None)
    nama_dosen: str = Field(index=True, max_length=255)
    deadline_tugas: datetime = Field(sa_column=Column(DateTime(timezone=False), nullable=False))
    show_nilai: bool = Field(default=True)

    @field_validator('deadline_tugas', mode='before')
    @classmethod
    def parse_deadline(cls, v):
        return _parse_dt(v)

class tugas_update(SQLModel):
    nama_tugas: Optional[str] = None
    deskripsi_tugas: Optional[str] = None
    nama_dosen: Optional[str] = None
    deadline_tugas: Optional[datetime] = None
    show_nilai: Optional[bool] = None

    @field_validator('deadline_tugas', mode='before')
    @classmethod
    def parse_deadline(cls, v):
        return _parse_dt(v)
