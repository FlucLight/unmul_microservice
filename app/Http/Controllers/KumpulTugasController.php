<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class KumpulTugasController extends Controller
{
    private string $apiBaseUrl = 'http://127.0.0.1:8000';
    private string $api2BaseUrl = 'http://127.0.0.1:8001';

    private function apiKey(): string
    {
        return 'Bearer ' . config('services.api_key', env('API_KEY', 'your-secret-api-key-change-me'));
    }

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
     * Pastikan dosen yang login berhak mengelola pengumpulan untuk tugas ini.
     * Dosen hanya boleh mengelola pengumpulan tugas miliknya sendiri.
     */
    private function ensureCanManage(array $kumpul): bool
    {
        $user = auth()->user();
        if ($user && $user->isAdmin()) {
            return true;
        }
        if (!$user || !$user->isDosen()) {
            return false;
        }

        $idTugas = (int) ($kumpul['id_tugas'] ?? 0);
        if ($idTugas <= 0) {
            return false;
        }

        try {
            $check = Http::timeout(3)->get("{$this->apiBaseUrl}/ambil-tugas/{$idTugas}");
            if ($check->successful()) {
                $tugasData = $check->json();
                return strcasecmp($tugasData['nama_dosen'] ?? '', $user->name) === 0;
            }
        } catch (\Exception $e) {
            Log::error("Check tugas ownership error: " . $e->getMessage());
        }

        return false;
    }

    public function store(Request $request)
    {
        if (!auth()->user()->isMahasiswa()) {
            return redirect()->back()->with('error', 'Hanya mahasiswa yang boleh mengumpulkan tugas.');
        }

        $request->validate([
            'id_tugas' => 'required|integer',
            'file_mahasiswa' => 'nullable|string|max:1000',
        ], [
            'id_tugas.required' => 'ID tugas tidak valid.',
        ]);

        try {
            $tugasResp = Http::timeout(3)->get("{$this->apiBaseUrl}/ambil-tugas/{$request->id_tugas}");
            if ($tugasResp->successful()) {
                $tugasData = $tugasResp->json();
                $deadline = \Carbon\Carbon::parse($tugasData['deadline_tugas'] ?? null);
                if ($deadline->isPast()) {
                    return redirect()->back()->with('error', 'Tugas ini sudah melewati tenggat waktu. Anda tidak bisa mengumpulkan tugas lagi.');
                }
            }
        } catch (\Exception $e) {
            Log::error("Cek deadline error: " . $e->getMessage());
        }

        $namaMahasiswa = auth()->user()->name ?? 'Mahasiswa';
        $tanggalKumpul = now()->format('Y-m-d\TH:i:s');
        $fileMahasiswa = $request->file_mahasiswa ?? '';

        try {
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
                'nilai' => null,
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

    public function approve($id)
    {
        try {
            $semua = collect($this->fetchKumpul());
            $pending = $semua->firstWhere('id_kumpul', (int) $id);

            if (!$pending || ($pending['resubmit_status'] ?? 'none') !== 'pending') {
                return redirect()->back()->with('error', 'Pengajuan kirim ulang tidak ditemukan atau sudah diproses.');
            }

            if (!$this->ensureCanManage($pending)) {
                return redirect()->back()->with('error', 'Anda hanya bisa menyetujui pengajuan kirim ulang untuk tugas yang Anda buat sendiri.');
            }

            $response = Http::timeout(3)->withHeaders([
                'Authorization' => $this->apiKey(),
            ])->patch("{$this->api2BaseUrl}/edit-kumpul/{$id}", [
                'resubmit_status' => 'disetujui',
            ]);

            if (!$response->successful()) {
                return redirect()->back()->with('error', 'Gagal menyetujui kirim ulang: ' . $response->body());
            }

            $lama = $semua->first(function ($k) use ($pending, $id) {
                return (int)($k['id_kumpul'] ?? 0) !== (int)$id
                    && (int)($k['id_tugas'] ?? 0) === (int)($pending['id_tugas'] ?? -1)
                    && strcasecmp($k['nama_mahasiswa'] ?? '', $pending['nama_mahasiswa'] ?? '') === 0
                    && ($k['resubmit_status'] ?? 'none') !== 'pending';
            });

            if ($lama) {
                Http::timeout(3)->withHeaders([
                    'Authorization' => $this->apiKey(),
                ])->delete("{$this->api2BaseUrl}/hapus-kumpul/{$lama['id_kumpul']}");
            }

            $waktu = now()->translatedFormat('j M Y, H:i');
            return redirect()->back()->with('success', "Kirim ulang dari {$pending['nama_mahasiswa']} disetujui pada {$waktu}. Data lama sudah digantikan.");
        } catch (\Exception $e) {
            Log::error("FastAPI2 Error: " . $e->getMessage());
            return redirect()->back()->with('error', 'Koneksi ke FastAPI2 (Port 8001) terputus.');
        }
    }

    public function reject($id)
    {
        try {
            $semua = collect($this->fetchKumpul());
            $pending = $semua->firstWhere('id_kumpul', (int) $id);

            if (!$pending || ($pending['resubmit_status'] ?? 'none') !== 'pending') {
                return redirect()->back()->with('error', 'Pengajuan kirim ulang tidak ditemukan atau sudah diproses.');
            }

            if (!$this->ensureCanManage($pending)) {
                return redirect()->back()->with('error', 'Anda hanya bisa menolak pengajuan kirim ulang untuk tugas yang Anda buat sendiri.');
            }

            $response = Http::timeout(3)->withHeaders([
                'Authorization' => $this->apiKey(),
            ])->delete("{$this->api2BaseUrl}/hapus-kumpul/{$id}");

            if ($response->successful()) {
                return redirect()->back()->with('success', "Pengajuan kirim ulang dari {$pending['nama_mahasiswa']} ditolak. Pengumpulan sebelumnya tetap digunakan.");
            }

            return redirect()->back()->with('error', 'Gagal menolak pengajuan: ' . $response->body());
        } catch (\Exception $e) {
            Log::error("FastAPI2 Error: " . $e->getMessage());
            return redirect()->back()->with('error', 'Koneksi ke FastAPI2 (Port 8001) terputus.');
        }
    }

    public function updateNilai(Request $request, $id)
    {
        $request->validate([
            'nilai' => 'required|numeric|min:0|max:100',
            'catatan_dosen' => 'nullable|string|max:1000',
        ], [
            'nilai.required' => 'Nilai wajib diisi.',
            'nilai.min' => 'Nilai minimal 0.',
            'nilai.max' => 'Nilai maksimal 100.',
            'catatan_dosen.max' => 'Catatan maksimal 1000 karakter.',
        ]);

        try {
            $kumpul = collect($this->fetchKumpul())->firstWhere('id_kumpul', (int) $id);
            if (!$kumpul) {
                return redirect()->back()->with('error', 'Data pengumpulan tidak ditemukan.');
            }

            if (!$this->ensureCanManage($kumpul)) {
                return redirect()->back()->with('error', 'Anda hanya bisa menilai pengumpulan pada tugas yang Anda buat sendiri.');
            }

            $response = Http::timeout(3)->withHeaders([
                'Authorization' => $this->apiKey(),
            ])->patch("{$this->api2BaseUrl}/beri-nilai/{$id}", [
                'nilai' => (float) $request->nilai,
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

    public function destroy($id)
    {
        try {
            $kumpul = collect($this->fetchKumpul())->firstWhere('id_kumpul', (int) $id);
            if (!$kumpul) {
                return redirect()->back()->with('error', 'Data pengumpulan tidak ditemukan.');
            }

            if (!$this->ensureCanManage($kumpul)) {
                return redirect()->back()->with('error', 'Anda hanya bisa menghapus pengumpulan pada tugas yang Anda buat sendiri.');
            }

            $response = Http::timeout(3)->withHeaders([
                'Authorization' => $this->apiKey(),
            ])->delete("{$this->api2BaseUrl}/hapus-kumpul/{$id}");

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
