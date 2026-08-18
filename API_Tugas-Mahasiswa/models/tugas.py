from datetime import datetime
from typing import Optional
from sqlmodel import Field, SQLModel

class tugas(SQLModel, table=True):
    id_tugas: Optional[int] = Field(default=None, primary_key=True)
    nama_tugas: str = Field(index=True)
    nama_dosen: str = Field(index=True)
    deadline_tugas: datetime = Field(...)

class tugas_update(SQLModel):
    nama_tugas : str
    nama_dosen : str
    deadline_tugas: datetime
