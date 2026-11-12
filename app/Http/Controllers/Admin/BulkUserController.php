<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BulkUserController extends Controller
{
    private function baseUrl(): string
    {
        return rtrim((string) config('services.cek_nim.url', 'http://127.0.0.1:8003'), '/');
    }

    private function apiKey(): string
    {
        return (string) config('services.cek_nim.key', env('API_KEY', 'your-secret-api-key-change-me'));
    }

    private function client()
    {
        return Http::timeout(10)->withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey(),
            'Accept' => 'application/json',
        ]);
    }

    public function index(Request $request)
    {
        $q = trim((string) $request->get('q', ''));
        $rows = [];
        $status = 'unknown';
        $error = null;

        try {
            $res = $this->client()->get($this->baseUrl() . '/ambil-nim');
            if ($res->successful()) {
                $data = $res->json();
                $rows = is_array($data) ? $data : [];
                $status = 'online';
            } else {
                $status = 'error';
                $error = $this->extractError($res->json(), $res->status());
            }
        } catch (\Throwable $e) {
            $status = 'offline';
            $error = 'Tidak dapat terhubung ke layanan Cek NIM (' . $this->baseUrl() . '): ' . $e->getMessage();
        }

        if ($q !== '') {
            $rows = array_values(array_filter($rows, function ($r) use ($q) {
                $nim = isset($r['nim']) ? (string) $r['nim'] : '';
                return str_contains($nim, $q);
            }));
        }

        // urutkan terbaru (id_mahasiswa desc) jika ada
        usort($rows, function ($a, $b) {
            return (int)($b['id_mahasiswa'] ?? 0) <=> (int)($a['id_mahasiswa'] ?? 0);
        });

        return view('admin.pengguna_massal', [
            'rows' => $rows,
            'q' => $q,
            'status' => $status,
            'apiError' => $error,
            'total' => count($rows),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nim' => ['required'],
            'password' => ['nullable', 'string'],
        ], [
            'nim.required' => 'NIM wajib diisi.',
        ]);

        $nim = $this->parseSingleNim($data['nim']);
        if ($nim === null) {
            return back()->with('error', 'NIM tidak valid.');
        }
        $password = trim((string)($data['password'] ?? '')) !== '' ? (string)$data['password'] : 'mhs123';

        try {
            $res = $this->client()->post($this->baseUrl() . '/tambah-nim', [
                'nim' => $nim,
                'password' => $password,
            ]);
            if ($res->successful()) {
                return back()->with('success', "NIM {$nim} berhasil ditambahkan.");
            }
            return back()->with('error', $this->extractError($res->json(), $res->status(), 'Gagal menambahkan NIM.'));
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal menghubungi layanan Cek NIM: ' . $e->getMessage());
        }
    }

    public function import(Request $request)
    {
        $data = $request->validate([
            'nims' => ['required', 'string'],
            'password' => ['nullable', 'string'],
        ], [
            'nims.required' => 'Masukkan minimal satu NIM.',
        ]);

        $nims = $this->parseNimList($data['nims']);
        if (empty($nims)) {
            return back()->with('error', 'Tidak ada NIM valid yang ditemukan. Pisahkan NIM dengan baris baru, koma, atau spasi.');
        }
        $password = trim((string)($data['password'] ?? '')) !== '' ? (string)$data['password'] : 'mhs123';

        try {
            $res = $this->client()->post($this->baseUrl() . '/import-nim', [
                'nims' => $nims,
                'password' => $password,
            ]);
            if ($res->successful()) {
                $j = $res->json() ?: [];
                $added = $j['ditambah'] ?? 0;
                $skipped = $j['dilewati'] ?? 0;
                return back()->with('success', "Import selesai: {$added} ditambahkan, {$skipped} dilewati (sudah terdaftar). Total input: " . count($nims) . ".");
            }
            return back()->with('error', $this->extractError($res->json(), $res->status(), 'Gagal import NIM.'));
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal menghubungi layanan Cek NIM: ' . $e->getMessage());
        }
    }

    public function update(Request $request, string $nim)
    {
        $oldNim = $this->parseSingleNim($nim);
        if ($oldNim === null) {
            return back()->with('error', 'NIM tidak valid.');
        }
        $data = $request->validate([
            'nim' => ['nullable'],
            'password' => ['nullable', 'string'],
        ]);

        $newNim = isset($data['nim']) && trim((string)$data['nim']) !== '' ? $this->parseSingleNim($data['nim']) : $oldNim;
        if ($newNim === null) {
            return back()->with('error', 'NIM baru tidak valid.');
        }
        $password = array_key_exists('password', $data) ? trim((string)$data['password']) : null;
        $payload = ['nim' => $newNim];
        $payload['password'] = ($password === null || $password === '') ? null : $password;

        try {
            $res = $this->client()->patch($this->baseUrl() . '/edit-nim/' . $oldNim, $payload);
            if ($res->successful()) {
                return back()->with('success', "Data NIM {$oldNim} berhasil diperbarui.");
            }
            return back()->with('error', $this->extractError($res->json(), $res->status(), 'Gagal memperbarui NIM.'));
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal menghubungi layanan Cek NIM: ' . $e->getMessage());
        }
    }

    public function destroy(string $nim)
    {
        $n = $this->parseSingleNim($nim);
        if ($n === null) {
            return back()->with('error', 'NIM tidak valid.');
        }
        try {
            $res = $this->client()->delete($this->baseUrl() . '/hapus-nim/' . $n);
            if ($res->successful()) {
                return back()->with('success', "NIM {$n} berhasil dihapus.");
            }
            return back()->with('error', $this->extractError($res->json(), $res->status(), 'Gagal menghapus NIM.'));
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal menghubungi layanan Cek NIM: ' . $e->getMessage());
        }
    }

    public function bulkUpdate(Request $request)
    {
        $data = $request->validate([
            'nims' => ['required', 'array', 'min:1'],
            'nims.*' => ['required'],
            'password' => ['required', 'string'],
        ], [
            'nims.required' => 'Pilih minimal satu NIM.',
            'password.required' => 'Isi password baru untuk edit massal.',
        ]);

        $items = [];
        foreach ($data['nims'] as $nim) {
            $n = $this->parseSingleNim($nim);
            if ($n !== null) $items[] = ['nim' => $n, 'password' => $data['password']];
        }
        if (empty($items)) {
            return back()->with('error', 'Tidak ada NIM valid yang dipilih.');
        }

        try {
            $res = $this->client()->patch($this->baseUrl() . '/edit-nim-massal', ['items' => $items]);
            if ($res->successful()) {
                $j = $res->json() ?: [];
                $updated = $j['diupdate'] ?? 0;
                $nf = count($j['tidak_ditemukan'] ?? []);
                $conf = count($j['konflik'] ?? []);
                return back()->with('success', "Edit massal selesai: {$updated} diperbarui, {$nf} tidak ditemukan, {$conf} konflik.");
            }
            return back()->with('error', $this->extractError($res->json(), $res->status(), 'Gagal edit massal NIM.'));
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal menghubungi layanan Cek NIM: ' . $e->getMessage());
        }
    }

    public function bulkDelete(Request $request)
    {
        $data = $request->validate([
            'nims' => ['required', 'array', 'min:1'],
            'nims.*' => ['required'],
        ], [
            'nims.required' => 'Pilih minimal satu NIM.',
        ]);

        $nims = [];
        foreach ($data['nims'] as $nim) {
            $n = $this->parseSingleNim($nim);
            if ($n !== null) $nims[] = $n;
        }
        $nims = array_values(array_unique($nims));
        if (empty($nims)) {
            return back()->with('error', 'Tidak ada NIM valid yang dipilih.');
        }

        try {
            $res = $this->client()->post($this->baseUrl() . '/hapus-nim-massal', ['nims' => $nims]);
            if ($res->successful()) {
                $j = $res->json() ?: [];
                $deleted = $j['dihapus'] ?? 0;
                $nf = count($j['tidak_ditemukan'] ?? []);
                return back()->with('success', "Hapus massal selesai: {$deleted} dihapus, {$nf} tidak ditemukan.");
            }
            return back()->with('error', $this->extractError($res->json(), $res->status(), 'Gagal hapus massal NIM.'));
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal menghubungi layanan Cek NIM: ' . $e->getMessage());
        }
    }

    private function parseSingleNim($value): ?int
    {
        if (is_int($value)) return $value;
        $s = trim((string)$value);
        if ($s === '' || !preg_match('/^\d+$/', $s)) return null;
        return (int) $s;
    }

    private function parseNimList(string $text): array
    {
        $parts = preg_split('/[\s,;]+/', $text) ?: [];
        $nims = [];
        foreach ($parts as $p) {
            $p = trim((string)$p);
            if ($p !== '' && preg_match('/^\d+$/', $p)) $nims[] = (int)$p;
        }
        return array_values(array_unique($nims));
    }

    private function extractError($json, int $status, string $fallback = 'Terjadi kesalahan.'): string
    {
        if (is_array($json)) {
            $detail = $json['detail'] ?? $json['message'] ?? null;
            if (is_string($detail) && $detail !== '') return $detail;
        }
        return $fallback . " (HTTP {$status})";
    }
}
