<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TugasController extends Controller
{
    private string $apiBaseUrl = 'http://127.0.0.1:8000';
    private string $api2BaseUrl = 'http://127.0.0.1:8001';

    private function apiKey(): string
    {
        return 'Bearer ' . config('services.api_key', env('API_KEY', 'your-secret-api-key-change-me'));
    }

    private function fetchData(): array
    {
        $tugasList = [];
        $kumpulList = [];
        $apiConnected = true;
        $api2Connected = true;
        $errorMessage = null;

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

        return [$tugasList, $kumpulList, $apiConnected, $api2Connected, $errorMessage];
    }

    private function applyRoleFilters(array $tugasList, array $kumpulList): array
    {
        $user = auth()->user();

        if ($user && $user->isDosen() && !$user->isAdmin()) {
            $tugasList = array_values(array_filter($tugasList, function ($t) use ($user) {
                return strcasecmp($t['nama_dosen'] ?? '', $user->name) === 0;
            }));
        }

        if ($user && $user->isMahasiswa()) {
            $kumpulList = array_values(array_filter($kumpulList, function ($k) use ($user) {
                return strcasecmp($k['nama_mahasiswa'] ?? '', $user->name) === 0;
            }));
        }

        return [$tugasList, $kumpulList];
    }

    public function index()
    {
        [$tugasList, $kumpulList, $apiConnected, $api2Connected, $errorMessage] = $this->fetchData();

        $tugasList = array_values(array_filter($tugasList, function ($t) {
            if (!isset($t['deadline_tugas'])) {
                return true;
            }
            return \Carbon\Carbon::parse($t['deadline_tugas'])->isFuture();
        }));

        [$tugasList, $kumpulList] = $this->applyRoleFilters($tugasList, $kumpulList);

        return view('tugas.index', compact('tugasList', 'kumpulList', 'apiConnected', 'api2Connected', 'errorMessage'));
    }

    public function arsip(Request $request)
    {
        [$tugasList, $kumpulList, $apiConnected, $api2Connected, $errorMessage] = $this->fetchData();

        $tugasList = array_values(array_filter($tugasList, function ($t) {
            if (!isset($t['deadline_tugas'])) {
                return false;
            }
            return \Carbon\Carbon::parse($t['deadline_tugas'])->isPast();
        }));

        $sort = $request->query('sort', 'deadline_desc');
        $deadlineAsc = $sort === 'deadline_asc';
        usort($tugasList, function ($a, $b) use ($deadlineAsc) {
            $ta = \Carbon\Carbon::parse($a['deadline_tugas'] ?? now())->timestamp;
            $tb = \Carbon\Carbon::parse($b['deadline_tugas'] ?? now())->timestamp;
            return $deadlineAsc ? $ta <=> $tb : $tb <=> $ta;
        });

        [$tugasList, $kumpulList] = $this->applyRoleFilters($tugasList, $kumpulList);

        return view('tugas.arsip', compact('tugasList', 'kumpulList', 'apiConnected', 'api2Connected', 'errorMessage'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_tugas' => 'required|string|max:255',
            'deskripsi_tugas' => 'nullable|string|max:5000',
            'deadline_tugas' => 'required|after:now',
        ], [
            'nama_tugas.required' => 'Nama tugas wajib diisi.',
            'deskripsi_tugas.max' => 'Deskripsi tugas maksimal 5000 karakter.',
            'deadline_tugas.required' => 'Deadline tugas wajib diisi.',
            'deadline_tugas.after' => 'Deadline tugas harus di masa depan.',
        ]);

        $namaDosen = auth()->user()->name ?? 'Dosen';
        $deadlineFormatted = date('Y-m-d\TH:i:s', strtotime($request->deadline_tugas));

        try {
            $response = Http::withHeaders([
                'Authorization' => $this->apiKey(),
            ])->post("{$this->apiBaseUrl}/tambah", [
                'nama_tugas' => $request->nama_tugas,
                'deskripsi_tugas' => $request->deskripsi_tugas ?? null,
                'nama_dosen' => $namaDosen,
                'deadline_tugas' => $deadlineFormatted,
                'show_nilai' => $request->boolean('show_nilai'),
            ]);

            if ($response->successful()) {
                return redirect()->route('tugas.index')->with('success', 'Tugas berhasil ditambahkan!');
            }

            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan tugas: ' . $response->body());
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Koneksi ke FastAPI gagal: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_tugas' => 'required|string|max:255',
            'nama_dosen' => 'required|string|max:255',
            'deskripsi_tugas' => 'nullable|string|max:5000',
            'deadline_tugas' => 'required|after:now',
        ], [
            'deadline_tugas.required' => 'Deadline tugas wajib diisi.',
            'deadline_tugas.after' => 'Deadline tugas harus di masa depan.',
        ]);

        $user = auth()->user();
        if ($user->isDosen() && !$user->isAdmin()) {
            try {
                $check = Http::timeout(3)->get("{$this->apiBaseUrl}/ambil-tugas/{$id}");
                if ($check->successful()) {
                    $tugasData = $check->json();
                    if (strcasecmp($tugasData['nama_dosen'] ?? '', $user->name) !== 0) {
                        return redirect()->back()->with('error', 'Anda hanya bisa mengubah tugas yang Anda buat sendiri.');
                    }
                } else {
                    return redirect()->back()->with('error', 'Tidak dapat memverifikasi kepemilikan tugas. Silakan coba lagi.');
                }
            } catch (\Exception $e) {
                Log::error("Check tugas ownership error: " . $e->getMessage());
                return redirect()->back()->with('error', 'Tidak dapat memverifikasi kepemilikan tugas. Silakan coba lagi.');
            }
        }

        $deadlineFormatted = date('Y-m-d\TH:i:s', strtotime($request->deadline_tugas));

        try {
            $response = Http::withHeaders([
                'Authorization' => $this->apiKey(),
            ])->patch("{$this->apiBaseUrl}/edit/{$id}", [
                'nama_tugas' => $request->nama_tugas,
                'deskripsi_tugas' => $request->deskripsi_tugas ?? null,
                'nama_dosen' => $request->nama_dosen,
                'deadline_tugas' => $deadlineFormatted,
                'show_nilai' => $request->boolean('show_nilai'),
            ]);

            if ($response->successful()) {
                return redirect()->route('tugas.index')->with('success', 'Tugas berhasil diperbarui!');
            }

            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui tugas: ' . $response->body());
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Koneksi ke FastAPI gagal: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $user = auth()->user();
        if ($user->isDosen() && !$user->isAdmin()) {
            try {
                $check = Http::timeout(3)->get("{$this->apiBaseUrl}/ambil-tugas/{$id}");
                if ($check->successful()) {
                    $tugasData = $check->json();
                    if (strcasecmp($tugasData['nama_dosen'] ?? '', $user->name) !== 0) {
                        return redirect()->back()->with('error', 'Anda hanya bisa menghapus tugas yang Anda buat sendiri.');
                    }
                } else {
                    return redirect()->back()->with('error', 'Tidak dapat memverifikasi kepemilikan tugas. Silakan coba lagi.');
                }
            } catch (\Exception $e) {
                Log::error("Check tugas ownership error: " . $e->getMessage());
                return redirect()->back()->with('error', 'Tidak dapat memverifikasi kepemilikan tugas. Silakan coba lagi.');
            }
        }

        try {
            Http::withHeaders([
                'Authorization' => $this->apiKey(),
            ])->delete("{$this->api2BaseUrl}/hapus-by-tugas/{$id}");

            $response = Http::withHeaders([
                'Authorization' => $this->apiKey(),
            ])->delete("{$this->apiBaseUrl}/hapus/{$id}");

            if ($response->successful()) {
                return redirect()->route('tugas.index')->with('success', 'Tugas dan semua pengumpulan terkait berhasil dihapus!');
            }

            return redirect()->back()->with('error', 'Gagal menghapus tugas: ' . $response->body());
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Koneksi ke FastAPI gagal: ' . $e->getMessage());
        }
    }
}
