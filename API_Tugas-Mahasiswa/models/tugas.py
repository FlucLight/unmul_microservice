from datetime import datetime
from typing import Optional
from sqlmodel import Field, SQLModel

# CATATAN PERUBAHAN:
# - Kolom baru 'show_nilai': izin dari dosen apakah nilai tugas ini
#   boleh ditampilkan ke mahasiswa atau tidak (default: True).
class tugas(SQLModel, table=True):
    id_tugas: Optional[int] = Field(default=None, primary_key=True)
    nama_tugas: str = Field(index=True)
    nama_dosen: str = Field(index=True)
    deadline_tugas: datetime = Field(...)
    show_nilai: bool = Field(default=True)

class tugas_update(SQLModel):
    nama_tugas : str
    nama_dosen : str
    deadline_tugas: datetime
    show_nilai: bool = True
