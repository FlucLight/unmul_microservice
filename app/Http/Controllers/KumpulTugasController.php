<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class KumpulTugasController extends Controller
{
    private string $api2BaseUrl = 'http://127.0.0.1:8001';

    /**
     * Menyimpan data pengumpulan tugas mahasiswa ke FastAPI2
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
            $response = Http::timeout(3)->post("{$this->api2BaseUrl}/kumpul-tugas", [
                'id_tugas' => (int) $request->id_tugas,
                'nama_mahasiswa' => $namaMahasiswa,
                'file_mahasiswa' => $fileMahasiswa,
                'nilai_mahasiswa' => 0.0,
                'tanggal_kumpul' => $tanggalKumpul,
            ]);

            if ($response->successful()) {
                return redirect()->back()->with('success', 'Tugas berhasil dikumpulkan!');
            }

            return redirect()->back()->withInput()->with('error', 'Gagal mengumpulkan tugas: ' . $response->body());
        } catch (\Exception $e) {
            Log::error("FastAPI2 Error: " . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Tidak dapat terhubung ke FastAPI2 (Port 8001). Pastikan server fastAPI2 sudah berjalan.');
        }
    }

    /**
     * Memberikan nilai tugas mahasiswa via FastAPI2
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
                return redirect()->back()->with('success', 'Nilai & catatan penilaian berhasil disimpan!');
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

