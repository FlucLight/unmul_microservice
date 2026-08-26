from datetime import datetime
from typing import Optional
from sqlmodel import Field, SQLModel

# CATATAN PERUBAHAN (kolom baru di tabel kumpul):
# - dinilai_at       : tanggal & jam (sampai menit) ketika dosen memberi/mengubah nilai.
#                      Nilai lama otomatis terganti setiap kali dosen mengedit.
# - resubmit_status  : status pengajuan kirim ulang tugas:
#                      'none'      = pengumpulan normal
#                      'pending'   = menunggu persetujuan dosen
#                      'disetujui' = kirim ulang disetujui (data lama dihapus)
class kumpul(SQLModel, table=True):
    id_kumpul: Optional[int] = Field(default=None, primary_key=True)
    id_tugas: int = Field(index=True)
    nama_mahasiswa: str = Field(index=True)
    nilai_mahasiswa: Optional[float] = Field(default=None, index=True)
    file_mahasiswa: Optional[str] = Field(default="", index=True)
    tanggal_kumpul: datetime = Field(...)
    nilai: Optional[int] = Field(default=None)
    catatan_dosen: Optional[str] = Field(default=None)
    dinilai_at: Optional[datetime] = Field(default=None)
    resubmit_status: Optional[str] = Field(default="none", index=True)

class kumpul_update(SQLModel):
    id_tugas: Optional[int] = None
    nama_mahasiswa: Optional[str] = None
    nilai_mahasiswa: Optional[float] = None
    file_mahasiswa: Optional[str] = None
    tanggal_kumpul: Optional[datetime] = None
    nilai: Optional[int] = None
    catatan_dosen: Optional[str] = None
    dinilai_at: Optional[datetime] = None
    resubmit_status: Optional[str] = None

class beri_nilai(SQLModel):
    nilai: int = Field(ge=0, le=100)
    catatan_dosen: Optional[str] = Field(default=None)
