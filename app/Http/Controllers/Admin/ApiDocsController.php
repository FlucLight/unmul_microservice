<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiDocsController extends Controller
{
    private function services(): array
    {
        return [
            'tugas' => [
                'name' => 'Service 1 - Master Tugas',
                'port' => '8000',
                'url' => rtrim((string) config('services.api_tugas.url', 'http://127.0.0.1:8000'), '/'),
            ],
            'penilaian' => [
                'name' => 'Service 2 - Penilaian Tugas',
                'port' => '8001',
                'url' => rtrim((string) config('services.api_penilaian.url', 'http://127.0.0.1:8001'), '/'),
            ],
            'modul' => [
                'name' => 'Service 3 - Modul Kuliah',
                'port' => '8002',
                'url' => rtrim((string) config('services.api_modul.url', 'http://127.0.0.1:8002'), '/'),
            ],
            'cek-nim' => [
                'name' => 'Service 4 - Cek NIM',
                'port' => '8003',
                'url' => rtrim((string) config('services.cek_nim.url', 'http://127.0.0.1:8003'), '/'),
            ],
        ];
    }

    public function index(Request $request)
    {
        $services = $this->services();
        $active = $request->query('service', 'tugas');
        if (!isset($services[$active])) {
            $active = 'tugas';
        }

        return view('admin.api-docs', [
            'services' => $services,
            'active' => $active,
        ]);
    }

    public function spec(string $service)
    {
        $services = $this->services();
        if (!isset($services[$service])) {
            abort(404, 'Service tidak ditemukan.');
        }

        $baseUrl = $services[$service]['url'];

        try {
            $response = Http::timeout(5)->acceptJson()->get($baseUrl . '/openapi.json');
        } catch (\Throwable $e) {
            return response()->json([
                'openapi' => '3.0.0',
                'info' => [
                    'title' => $services[$service]['name'] . ' (Offline)',
                    'version' => '0.0.0',
                    'description' => 'Gagal mengambil spesifikasi dari ' . $baseUrl . ': ' . $e->getMessage(),
                ],
                'paths' => (object) [],
            ], 502);
        }

        if (!$response->successful()) {
            return response()->json([
                'openapi' => '3.0.0',
                'info' => [
                    'title' => $services[$service]['name'] . ' (Error)',
                    'version' => '0.0.0',
                    'description' => 'Service merespons status ' . $response->status() . ' saat mengambil /openapi.json',
                ],
                'paths' => (object) [],
            ], 502);
        }

        $spec = $response->json();
        if (!is_array($spec)) {
            $spec = ['openapi' => '3.0.0', 'info' => ['title' => 'Invalid spec', 'version' => '0'], 'paths' => (object) []];
        }

        // Tambahkan server agar "Try it out" menunjuk ke service yang benar (bisa diubah sesuai deployment)
        $spec['servers'] = [
            ['url' => $baseUrl, 'description' => $services[$service]['name']],
        ];

        return response()->json($spec);
    }
}
