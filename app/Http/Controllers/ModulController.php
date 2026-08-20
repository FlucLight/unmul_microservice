<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ModulController extends Controller
{
    private string $apiBaseUrl = 'http://127.0.0.1:8000';  // FastAPI 1 (Tugas)
    private string $api2BaseUrl = 'http://127.0.0.1:8001'; // FastAPI 2 (Pengumpulan)
    private string $api3BaseUrl = 'http://127.0.0.1:8002'; // FastAPI 3 (Modul Kuliah)

    /**
     * Menampilkan halaman daftar modul kuliah
     */
    public function index()
    {
        $modulList = [];
        $apiConnected = true;
        $api2Connected = true;
        $api3Connected = true;
        $errorMessage = null;

        // Check FastAPI 1
        try {
            $resp1 = Http::timeout(2)->get("{$this->apiBaseUrl}/");
            $apiConnected = $resp1->successful();
        } catch (\Exception $e) {
            $apiConnected = false;
        }

        // Check FastAPI 2
        try {
            $resp2 = Http::timeout(2)->get("{$this->api2BaseUrl}/");
            $api2Connected = $resp2->successful();
        } catch (\Exception $e) {
            $api2Connected = false;
        }

        // Fetch Modul List dari FastAPI 3 (Port 8002)
        try {
            $response = Http::timeout(3)->get("{$this->api3BaseUrl}/ambil-modul");

            if ($response->successful()) {
                $modulList = $response->json();
            } else {
                $api3Connected = false;
                $errorMessage = "Gagal mengambil data dari API Modul (Port 8002). Status: " . $response->status();
            }
        } catch (\Exception $e) {
            $api3Connected = false;
            $errorMessage = "Tidak dapat terhubung ke server API Modul di {$this->api3BaseUrl}. Pastikan server API_Modul-Kuliah (Port 8002) sudah berjalan.";
            Log::error("API Modul Error: " . $e->getMessage());
        }

        return view('modul.index', compact('modulList', 'apiConnected', 'api2Connected', 'api3Connected', 'errorMessage'));
    }

    /**
     * Menyimpan data modul baru ke FastAPI 3
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_modul' => 'required|string|max:255',
            'file_modul' => 'required|string|max:1000',
        ], [
            'nama_modul.required' => 'Nama modul wajib diisi.',
            'file_modul.required' => 'Link file / Google Drive modul wajib diisi.',
        ]);

        $namaDosen = $request->nama_dosen ?? auth()->user()->name ?? 'Dosen';
        $tanggalDiupload = now()->format('Y-m-d\TH:i:s');

        try {
            $response = Http::post("{$this->api3BaseUrl}/Tambah-modul", [
                'nama_modul' => $request->nama_modul,
                'nama_dosen' => $namaDosen,
                'file_modul' => $request->file_modul,
                'tanggal_diupload' => $tanggalDiupload,
            ]);

            if ($response->successful()) {
                return redirect()->route('modul.index')->with('success', 'Modul kuliah berhasil ditambahkan!');
            }

            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan modul: ' . $response->body());
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Koneksi ke API Modul gagal: ' . $e->getMessage());
        }
    }

    /**
     * Mengupdate data modul via FastAPI 3
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_modul' => 'required|string|max:255',
            'file_modul' => 'required|string|max:1000',
        ]);

        $namaDosen = $request->nama_dosen ?? auth()->user()->name ?? 'Dosen';
        $tanggalDiupload = now()->format('Y-m-d\TH:i:s');

        try {
            $response = Http::patch("{$this->api3BaseUrl}/edit-modul/{$id}", [
                'nama_modul' => $request->nama_modul,
                'nama_dosen' => $namaDosen,
                'file_modul' => $request->file_modul,
                'tanggal_diupload' => $tanggalDiupload,
            ]);

            if ($response->successful()) {
                return redirect()->route('modul.index')->with('success', 'Modul kuliah berhasil diperbarui!');
            }

            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui modul: ' . $response->body());
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Koneksi ke API Modul gagal: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus modul via FastAPI 3
     */
    public function destroy($id)
    {
        try {
            $response = Http::delete("{$this->api3BaseUrl}/hapus-modul/{$id}");

            if ($response->successful()) {
                return redirect()->route('modul.index')->with('success', 'Modul kuliah berhasil dihapus!');
            }

            return redirect()->back()->with('error', 'Gagal menghapus modul: ' . $response->body());
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Koneksi ke API Modul gagal: ' . $e->getMessage());
        }
    }
}
