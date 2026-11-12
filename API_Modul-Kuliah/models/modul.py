from datetime import datetime
from typing import Optional
from pydantic import field_validator
from sqlalchemy import Column, DateTime
from sqlmodel import Field, SQLModel

class Modul(SQLModel, table=True):
    id_modul: Optional[int] = Field(default=None, primary_key=True)
    nama_modul: str = Field(index=True, max_length=255)
    nama_dosen: str = Field(index=True, max_length=255)
    file_modul: Optional[str] = Field(default="", max_length=1000)
    tanggal_diupload: datetime = Field(sa_column=Column(DateTime(timezone=False), nullable=False))

    @field_validator('tanggal_diupload', mode='before')
    @classmethod
    def parse_tanggal(cls, v):
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
            if dt.tzinfo is not None:
                dt = dt.replace(tzinfo=None)
            return dt
        return v

class Modul_update(SQLModel):
    nama_modul: Optional[str] = None
    nama_dosen: Optional[str] = None
    file_modul: Optional[str] = None
    tanggal_diupload: Optional[datetime] = None

    @field_validator('tanggal_diupload', mode='before')
    @classmethod
    def parse_tanggal(cls, v):
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
            if dt.tzinfo is not None:
                dt = dt.replace(tzinfo=None)
            return dt
        return v
