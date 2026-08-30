<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ModulController extends Controller
{
    private string $apiBaseUrl = 'http://127.0.0.1:8000';
    private string $api2BaseUrl = 'http://127.0.0.1:8001';
    private string $api3BaseUrl = 'http://127.0.0.1:8002';

    private function apiKey(): string
    {
        return 'Bearer ' . config('services.api_key', env('API_KEY', 'your-secret-api-key-change-me'));
    }

    /**
     * Pastikan dosen yang login berhak mengelola modul ini (admin selalu boleh).
     */
    private function ensureCanManageModul(int $id): bool
    {
        $user = auth()->user();
        if (!$user || $user->isAdmin()) {
            return true;
        }
        if (!$user->isDosen()) {
            return false;
        }

        try {
            $check = Http::timeout(3)->get("{$this->api3BaseUrl}/ambil-modul/{$id}");
            if ($check->successful()) {
                $data = $check->json();
                return strcasecmp($data['nama_dosen'] ?? '', $user->name) === 0;
            }
        } catch (\Exception $e) {
            Log::error("Check modul ownership error: " . $e->getMessage());
        }

        return false;
    }

    public function index()
    {
        $modulList = [];
        $apiConnected = true;
        $api2Connected = true;
        $api3Connected = true;
        $errorMessage = null;

        try {
            $resp1 = Http::timeout(2)->get("{$this->apiBaseUrl}/");
            $apiConnected = $resp1->successful();
        } catch (\Exception $e) {
            $apiConnected = false;
        }

        try {
            $resp2 = Http::timeout(2)->get("{$this->api2BaseUrl}/");
            $api2Connected = $resp2->successful();
        } catch (\Exception $e) {
            $api2Connected = false;
        }

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

    public function store(Request $request)
    {
        $request->validate([
            'nama_modul' => 'required|string|max:255',
            'file_modul' => 'required|string|max:1000',
        ], [
            'nama_modul.required' => 'Nama modul wajib diisi.',
            'file_modul.required' => 'Link file / Google Drive modul wajib diisi.',
        ]);

        $namaDosen = auth()->user()->name ?? 'Dosen';
        $tanggalDiupload = now()->format('Y-m-d\TH:i:s');

        try {
            $response = Http::withHeaders([
                'Authorization' => $this->apiKey(),
            ])->post("{$this->api3BaseUrl}/Tambah-modul", [
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

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_modul' => 'required|string|max:255',
            'file_modul' => 'required|string|max:1000',
        ]);

        $user = auth()->user();
        if ($user->isDosen() && !$user->isAdmin()) {
            if (!$this->ensureCanManageModul((int) $id)) {
                return redirect()->back()->with('error', 'Anda hanya bisa mengubah modul yang Anda buat sendiri.');
            }
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => $this->apiKey(),
            ])->patch("{$this->api3BaseUrl}/edit-modul/{$id}", [
                'nama_modul' => $request->nama_modul,
                'nama_dosen' => auth()->user()->name ?? 'Dosen',
                'file_modul' => $request->file_modul,
            ]);

            if ($response->successful()) {
                return redirect()->route('modul.index')->with('success', 'Modul kuliah berhasil diperbarui!');
            }

            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui modul: ' . $response->body());
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Koneksi ke API Modul gagal: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $user = auth()->user();
        if ($user->isDosen() && !$user->isAdmin()) {
            if (!$this->ensureCanManageModul((int) $id)) {
                return redirect()->back()->with('error', 'Anda hanya bisa menghapus modul yang Anda buat sendiri.');
            }
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => $this->apiKey(),
            ])->delete("{$this->api3BaseUrl}/hapus-modul/{$id}");

            if ($response->successful()) {
                return redirect()->route('modul.index')->with('success', 'Modul kuliah berhasil dihapus!');
            }

            return redirect()->back()->with('error', 'Gagal menghapus modul: ' . $response->body());
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Koneksi ke API Modul gagal: ' . $e->getMessage());
        }
    }
}
