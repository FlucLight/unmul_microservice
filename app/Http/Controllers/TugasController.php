<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TugasController extends Controller
{
    // Base URL dari FastAPI 1 & FastAPI 2
    private string $apiBaseUrl = 'http://127.0.0.1:8000';
    private string $api2BaseUrl = 'http://127.0.0.1:8001';

    /**
     * Menampilkan halaman daftar tugas (UI Utama)
     */
    public function index()
    {
        $tugasList = [];
        $kumpulList = [];
        $apiConnected = true;
        $api2Connected = true;
        $errorMessage = null;

        // Fetch Data Tugas dari FastAPI 1 (Port 8000)
        try {
            $response = Http::timeout(3)->get("{$this->apiBaseUrl}/ambil-tugas");

            if ($response->successful()) {
                $tugasList = $response->json();
            } else {
                $apiConnected = false;
                $errorMessage = "Gagal mengambil data dari API FastAPI 1. Status: " . $response->status();
            }
        } catch (\Exception $e) {
            $apiConnected = false;
            $errorMessage = "Tidak dapat terhubung ke server FastAPI 1 di {$this->apiBaseUrl}. Pastikan server Python/FastAPI sudah dijalankan.";
            Log::error("API FastAPI 1 Error: " . $e->getMessage());
        }

        // Fetch Data Pengumpulan Tugas dari FastAPI 2 (Port 8001)
        try {
            $response2 = Http::timeout(3)->get("{$this->api2BaseUrl}/ambil-kumpul");
            if ($response2->successful()) {
                $kumpulList = $response2->json();
            } else {
                $api2Connected = false;
            }
        } catch (\Exception $e) {
            $api2Connected = false;
            Log::error("API FastAPI 2 Error: " . $e->getMessage());
        }

        return view('tugas.index', compact('tugasList', 'kumpulList', 'apiConnected', 'api2Connected', 'errorMessage'));
    }

    /**
     * Menyimpan data tugas baru ke API FastAPI
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_tugas' => 'required|string|max:255',
            'deadline_tugas' => 'required',
        ], [
            'nama_tugas.required' => 'Nama tugas wajib diisi.',
            'deadline_tugas.required' => 'Deadline tugas wajib diisi.',
        ]);

        $namaDosen = $request->nama_dosen ?? auth()->user()->name ?? 'Dosen';
        $deadlineFormatted = date('Y-m-d\TH:i:s', strtotime($request->deadline_tugas));

        try {
            $response = Http::post("{$this->apiBaseUrl}/tambah", [
                'nama_tugas' => $request->nama_tugas,
                'nama_dosen' => $namaDosen,
                'deadline_tugas' => $deadlineFormatted,
            ]);

            if ($response->successful()) {
                return redirect()->route('tugas.index')->with('success', 'Tugas berhasil ditambahkan!');
            }

            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan tugas: ' . $response->body());
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Koneksi ke FastAPI gagal: ' . $e->getMessage());
        }
    }

    /**
     * Mengupdate data tugas via API FastAPI
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_tugas' => 'required|string|max:255',
            'nama_dosen' => 'required|string|max:255',
            'deadline_tugas' => 'required',
        ]);

        $deadlineFormatted = date('Y-m-d\TH:i:s', strtotime($request->deadline_tugas));

        try {
            $response = Http::patch("{$this->apiBaseUrl}/edit/{$id}", [
                'nama_tugas' => $request->nama_tugas,
                'nama_dosen' => $request->nama_dosen,
                'deadline_tugas' => $deadlineFormatted,
            ]);

            if ($response->successful()) {
                return redirect()->route('tugas.index')->with('success', 'Tugas berhasil diperbarui!');
            }

            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui tugas: ' . $response->body());
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Koneksi ke FastAPI gagal: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus tugas via API FastAPI
     */
    public function destroy($id)
    {
        try {
            $response = Http::delete("{$this->apiBaseUrl}/hapus/{$id}");

            if ($response->successful()) {
                return redirect()->route('tugas.index')->with('success', 'Tugas berhasil dihapus!');
            }

            return redirect()->back()->with('error', 'Gagal menghapus tugas: ' . $response->body());
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Koneksi ke FastAPI gagal: ' . $e->getMessage());
        }
    }
}
