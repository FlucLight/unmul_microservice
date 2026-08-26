<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class KumpulTugasController extends Controller
{
    private string $api2BaseUrl = 'http://127.0.0.1:8001';

    /**
     * Mengambil seluruh data pengumpulan dari FastAPI2
     */
    private function fetchKumpul(): array
    {
        try {
            $response = Http::timeout(3)->get("{$this->api2BaseUrl}/ambil-kumpul");
            return $response->successful() ? ($response->json() ?? []) : [];
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Menyimpan data pengumpulan tugas mahasiswa ke FastAPI2.
     *
     * CATATAN PERUBAHAN (perbaikan celah):
     * 1. Cegah pengumpulan ganda (double) -> dicek dulu ke /ambil-kumpul.
     * 2. Kirim ulang TIDAK langsung menimpa data lama; status diset 'pending'
     *    dan harus disetujui dosen lewat approve().
     * 3. ADMIN dikecualikan dari validasi "khusus mahasiswa" -> admin boleh
     *    mengumpulkan tugas juga, tanpa batasan role tambahan.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_tugas' => 'required|integer',
            'file_mahasiswa' => 'nullable|string|max:1000',
        ], [
            'id_tugas.required' => 'ID tugas tidak valid.',
        ]);

        $namaMahasiswa = $request->nama_mahasiswa ?? auth()->user()->name ?? 'Mahasiswa';
        $tanggalKumpul = now()->format('Y-m-d\TH:i:s');
        $fileMahasiswa = $request->file_mahasiswa ?? '';

        try {
            // Cek data yang sudah ada untuk mencegah duplikat
            $existing = collect($this->fetchKumpul())
                ->where('id_tugas', (int) $request->id_tugas)
                ->filter(function ($k) use ($namaMahasiswa) {
                    return strcasecmp($k['nama_mahasiswa'] ?? '', $namaMahasiswa) === 0;
                });

            $hasPending = $existing->contains(function ($k) {
                return ($k['resubmit_status'] ?? 'none') === 'pending';
            });

            if ($hasPending) {
                return redirect()->back()->with('error', 'Masih ada pengajuan kirim ulang yang menunggu persetujuan dosen. Mohon tunggu.');
            }

            $activeCount = $existing->filter(function ($k) {
                return ($k['resubmit_status'] ?? 'none') !== 'pending';
            })->count();

            $isResubmit = $request->boolean('kirim_ulang');

            if ($activeCount > 0 && !$isResubmit) {
                return redirect()->back()->with('error', 'Kamu sudah mengumpulkan tugas ini. Gunakan tombol "Kirim Ulang" jika ingin memperbarui (perlu izin dosen).');
            }

            if ($isResubmit) {
                if ($activeCount === 0) {
                    return redirect()->back()->with('error', 'Kamu belum mengumpulkan tugas ini, gunakan tombol "Kumpulkan".');
                }
                $status = 'pending';
                $pesanSukses = 'Pengajuan kirim ulang terkirim! Menunggu persetujuan dosen.';
            } else {
                $status = 'none';
                $pesanSukses = 'Tugas berhasil dikumpulkan!';
            }

            $response = Http::timeout(3)->post("{$this->api2BaseUrl}/kumpul-tugas", [
                'id_tugas' => (int) $request->id_tugas,
                'nama_mahasiswa' => $namaMahasiswa,
                'file_mahasiswa' => $fileMahasiswa,
                'nilai_mahasiswa' => 0.0,
                'tanggal_kumpul' => $tanggalKumpul,
                'resubmit_status' => $status,
            ]);

            if ($response->successful()) {
                return redirect()->back()->with('success', $pesanSukses);
            }

            return redirect()->back()->withInput()->with('error', 'Gagal mengumpulkan tugas: ' . $response->body());
        } catch (\Exception $e) {
            Log::error("FastAPI2 Error: " . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Tidak dapat terhubung ke FastAPI2 (Port 8001). Pastikan server fastAPI2 sudah berjalan.');
        }
    }

    /**
     * Dosen menyetujui pengajuan kirim ulang:
     * - Pengumpulan baru menjadi aktif (disetujui).
     * - Pengumpulan lama dihapus agar tidak dobel.
     */
    public function approve($id)
    {
        try {
            $semua = collect($this->fetchKumpul());
            $pending = $semua->firstWhere('id_kumpul', (int) $id);

            if (!$pending || ($pending['resubmit_status'] ?? 'none') !== 'pending') {
                return redirect()->back()->with('error', 'Pengajuan kirim ulang tidak ditemukan atau sudah diproses.');
            }

            // Setujui pengumpulan baru
            $response = Http::timeout(3)->patch("{$this->api2BaseUrl}/edit-kumpul/{$id}", [
                'resubmit_status' => 'disetujui',
            ]);

            if (!$response->successful()) {
                return redirect()->back()->with('error', 'Gagal menyetujui kirim ulang: ' . $response->body());
            }

            // Hapus pengumpulan lama (yang aktif sebelumnya) agar tidak dobel
            $lama = $semua->first(function ($k) use ($pending, $id) {
                return (int)($k['id_kumpul'] ?? 0) !== (int)$id
                    && (int)($k['id_tugas'] ?? 0) === (int)($pending['id_tugas'] ?? -1)
                    && strcasecmp($k['nama_mahasiswa'] ?? '', $pending['nama_mahasiswa'] ?? '') === 0
                    && ($k['resubmit_status'] ?? 'none') !== 'pending';
            });

            if ($lama) {
                Http::timeout(3)->delete("{$this->api2BaseUrl}/hapus-kumpul/{$lama['id_kumpul']}");
            }

            $waktu = now()->translatedFormat('j M Y, H:i');
            return redirect()->back()->with('success', "Kirim ulang dari {$pending['nama_mahasiswa']} disetujui pada {$waktu}. Data lama sudah digantikan.");
        } catch (\Exception $e) {
            Log::error("FastAPI2 Error: " . $e->getMessage());
            return redirect()->back()->with('error', 'Koneksi ke FastAPI2 (Port 8001) terputus.');
        }
    }

    /**
     * Dosen menolak pengajuan kirim ulang:
     * - Pengajuan baru dihapus, pengumpulan lama tetap dipakai.
     */
    public function reject($id)
    {
        try {
            $semua = collect($this->fetchKumpul());
            $pending = $semua->firstWhere('id_kumpul', (int) $id);

            if (!$pending || ($pending['resubmit_status'] ?? 'none') !== 'pending') {
                return redirect()->back()->with('error', 'Pengajuan kirim ulang tidak ditemukan atau sudah diproses.');
            }

            $response = Http::timeout(3)->delete("{$this->api2BaseUrl}/hapus-kumpul/{$id}");

            if ($response->successful()) {
                return redirect()->back()->with('success', "Pengajuan kirim ulang dari {$pending['nama_mahasiswa']} ditolak. Pengumpulan sebelumnya tetap digunakan.");
            }

            return redirect()->back()->with('error', 'Gagal menolak pengajuan: ' . $response->body());
        } catch (\Exception $e) {
            Log::error("FastAPI2 Error: " . $e->getMessage());
            return redirect()->back()->with('error', 'Koneksi ke FastAPI2 (Port 8001) terputus.');
        }
    }

    /**
     * Memberikan nilai tugas mahasiswa via FastAPI2.
     *
     * CATATAN PERUBAHAN:
     * - Nilai lama otomatis TERGANTI (overwrite) saat dosen mengedit nilai,
     *   sehingga tidak ada nilai lama yang tersisa.
     * - Waktu penilaian (tanggal, jam, menit) dicatat oleh FastAPI 2 di kolom
     *   'dinilai_at' setiap kali nilai disimpan/diubah.
     */
    public function updateNilai(Request $request, $id)
    {
        $request->validate([
            'nilai' => 'required|integer|min:0|max:100',
            'catatan_dosen' => 'nullable|string|max:1000',
        ], [
            'nilai.required' => 'Nilai wajib diisi.',
            'nilai.min' => 'Nilai minimal 0.',
            'nilai.max' => 'Nilai maksimal 100.',
            'catatan_dosen.max' => 'Catatan maksimal 1000 karakter.',
        ]);

        try {
            $response = Http::timeout(3)->patch("{$this->api2BaseUrl}/beri-nilai/{$id}", [
                'nilai' => (int) $request->nilai,
                'catatan_dosen' => $request->filled('catatan_dosen') ? trim($request->catatan_dosen) : '',
            ]);

            if ($response->successful()) {
                $waktu = now()->translatedFormat('j M Y, H:i');
                return redirect()->back()->with('success', "Nilai & catatan berhasil disimpan pada {$waktu}!");
            }

            return redirect()->back()->with('error', 'Gagal memberikan nilai: ' . $response->body());
        } catch (\Exception $e) {
            Log::error("FastAPI2 Error: " . $e->getMessage());
            return redirect()->back()->with('error', 'Koneksi ke FastAPI2 (Port 8001) terputus.');
        }
    }

    /**
     * Menghapus data pengumpulan tugas via FastAPI2
     */
    public function destroy($id)
    {
        try {
            $response = Http::timeout(3)->delete("{$this->api2BaseUrl}/hapus-kumpul/{$id}");

            if ($response->successful()) {
                return redirect()->back()->with('success', 'Data pengumpulan tugas berhasil dihapus!');
            }

            return redirect()->back()->with('error', 'Gagal menghapus pengumpulan: ' . $response->body());
        } catch (\Exception $e) {
            Log::error("FastAPI2 Error: " . $e->getMessage());
            return redirect()->back()->with('error', 'Koneksi ke FastAPI2 (Port 8001) terputus.');
        }
    }
}
