<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\NimMahasiswaTerdaftar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BulkUserController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q', ''));
        $role = $request->get('role');

        $usersQuery = User::query();
        if ($q !== '') {
            $usersQuery->where(function ($w) use ($q) {
                $w->where('name', 'like', "%{$q}%")
                  ->orWhere('nomer_induk', 'like', "%{$q}%")
                  ->orWhere('email', 'like', "%{$q}%")
                  ->orWhere('username', 'like', "%{$q}%");
            });
        }
        if (in_array($role, ['admin','dosen','mahasiswa'], true)) {
            $usersQuery->where('role', $role);
        }

        $users = $usersQuery->orderByDesc('created_at')->paginate(15)->withQueryString();

        $stats = [
            'total' => User::count(),
            'mahasiswa' => User::where('role','mahasiswa')->count(),
            'dosen' => User::where('role','dosen')->count(),
            'admin' => User::where('role','admin')->count(),
        ];

        $preview = session('massal_preview');
        $previewToken = session('massal_preview_token');

        return view('admin.pengguna_massal', compact('users','q','role','stats','preview','previewToken'));
    }

    public function preview(Request $request)
    {
        $request->validate([
            'file' => ['required','file','mimes:json,csv,txt,xlsx,xls','max:5120'],
        ], [
            'file.required' => 'Pilih file untuk diimpor.',
            'file.mimes' => 'Format file harus .json, .csv, atau .xlsx.',
            'file.max' => 'Ukuran file maksimal 5MB.',
        ]);

        $file = $request->file('file');
        $ext = strtolower($file->getClientOriginalExtension() ?: '');

        try {
            $rows = $this->parseRows($file->getRealPath(), $ext);
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal membaca file: ' . $e->getMessage());
        }

        if (count($rows) === 0) {
            return back()->with('error', 'File tidak berisi data yang dapat diproses.');
        }
        if (count($rows) > 500) {
            $rows = array_slice($rows, 0, 500);
        }

        $preview = [];
        $seenNomor = [];
        $seenEmail = [];
        $seenUsername = [];
        foreach ($rows as $i => $row) {
            $normalized = $this->normalizeRow($row);
            $errors = $this->validateRow($normalized, $seenNomor, $seenEmail, $seenUsername);
            $preview[] = [
                'row' => $i + 2, // asumsi baris 1 header
                'data' => $normalized,
                'valid' => count($errors) === 0,
                'errors' => $errors,
                'action' => $this->detectAction($normalized),
            ];
            // track for in-file duplicates only when value present
            if (!empty($normalized['nomer_induk'])) $seenNomor[strtolower($normalized['nomer_induk'])] = true;
            if (!empty($normalized['email'])) $seenEmail[strtolower($normalized['email'])] = true;
            if (!empty($normalized['username'])) $seenUsername[strtolower($normalized['username'])] = true;
        }

        $token = bin2hex(random_bytes(16));
        session([
            'massal_preview' => $preview,
            'massal_preview_token' => $token,
        ]);

        return redirect()->route('admin.pengguna.massal')->with('success', 'Pratinjau siap. Periksa data lalu klik Konfirmasi Impor untuk menyimpan baris valid.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'preview_token' => ['required','string'],
        ]);

        $preview = session('massal_preview');
        $token = session('massal_preview_token');
        if (!$preview || !$token || !hash_equals($token, (string)$request->input('preview_token'))) {
            return back()->with('error', 'Sesi pratinjau tidak valid atau kedaluwarsa. Silakan unggah file kembali.');
        }

        $created = 0; $updated = 0; $failed = 0; $errors = [];
        foreach ($preview as $item) {
            if (empty($item['valid'])) { $failed++; continue; }
            $d = $item['data'];
            try {
                $user = User::where('nomer_induk', $d['nomer_induk'])->first();
                $payload = [
                    'name' => $d['name'],
                    'email' => $d['email'],
                    'nomer_induk' => $d['nomer_induk'],
                    'role' => $d['role'],
                ];
                if (!empty($d['username'])) $payload['username'] = $d['username'];

                if ($user) {
                    // update (jangan ubah password kecuali diberikan)
                    if (!empty($d['password'])) $payload['password'] = Hash::make($d['password']);
                    // validasi unik ulang terhadap user lain
                    $v = Validator::make($payload, [
                        'email' => ['required','email', Rule::unique('users','email')->ignore($user->id)],
                        'username' => ['nullable','string','min:3','max:30','regex:/^[a-z0-9_.]+$/', Rule::unique('users','username')->ignore($user->id)],
                    ]);
                    if ($v->fails()) { $failed++; $errors[] = 'Baris '.$item['row'].': '.$v->errors()->first(); continue; }
                    $user->update($payload);
                    $updated++;
                } else {
                    $password = $d['password'] ?? $d['nomer_induk'] ?? 'password123';
                    $payload['password'] = Hash::make($password);
                    $v = Validator::make($payload, [
                        'email' => ['required','email', Rule::unique('users','email')],
                        'username' => ['nullable','string','min:3','max:30','regex:/^[a-z0-9_.]+$/', Rule::unique('users','username')],
                    ]);
                    if ($v->fails()) { $failed++; $errors[] = 'Baris '.$item['row'].': '.$v->errors()->first(); continue; }
                    User::create($payload);
                    $created++;
                }
            } catch (\Throwable $e) {
                $failed++;
                $errors[] = 'Baris '.$item['row'].': '.$e->getMessage();
            }
        }

        session()->forget(['massal_preview','massal_preview_token']);

        $msg = "Impor selesai: {$created} dibuat, {$updated} diperbarui, {$failed} gagal/dilewati.";
        if (count($errors)) $msg .= ' ' . implode(' | ', array_slice($errors, 0, 3));

        return redirect()->route('admin.pengguna.massal')->with('success', $msg);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!is_array($ids) || empty($ids)) {
            return back()->with('error', 'Pilih minimal satu akun untuk dihapus.');
        }
        $ids = array_values(array_unique(array_map('intval', $ids)));
        $ids = array_filter($ids, fn($id) => $id !== (int) auth()->id());
        $deleted = 0;
        if (!empty($ids)) {
            $deleted = User::whereIn('id', $ids)->delete();
        }
        return back()->with('success', "{$deleted} akun berhasil dihapus.");
    }

    public function template(string $format)
    {
        $format = strtolower($format);
        $headers = ['name','username','nomer_induk','email','role','password'];
        $samples = [
            ['Budi Santoso','budi.s','210101001','budi@unmul.ac.id','mahasiswa','210101001'],
            ['Siti Aminah','siti.a','1987654321','siti@unmul.ac.id','dosen','1987654321'],
        ];

        if ($format === 'json') {
            $data = array_map(fn($r) => array_combine($headers, $r), $samples);
            return response()->json($data, 200, [
                'Content-Disposition' => 'attachment; filename="template_kelola_massal.json"',
            ], JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
        }

        if ($format === 'csv') {
            $filename = 'template_kelola_massal.csv';
            return new StreamedResponse(function () use ($headers, $samples) {
                $out = fopen('php://output', 'w');
                fputcsv($out, $headers);
                foreach ($samples as $r) fputcsv($out, $r);
                fclose($out);
            }, 200, [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            ]);
        }

        if ($format === 'xlsx') {
            $filename = 'template_kelola_massal.xlsx';
            $export = new class($headers, $samples) implements \Maatwebsite\Excel\Concerns\FromArray, \Maatwebsite\Excel\Concerns\WithHeadings {
                public function __construct(private array $h, private array $s) {}
                public function headings(): array { return $this->h; }
                public function array(): array { return $this->s; }
            };
            return Excel::download($export, $filename, \Maatwebsite\Excel\Excel::XLSX);
        }

        abort(404);
    }

    private function parseRows(string $path, string $ext): array
    {
        if ($ext === 'json') {
            $content = file_get_contents($path);
            $data = json_decode($content, true);
            if (!is_array($data)) throw new \RuntimeException('Format JSON tidak valid.');
            // support list of objects or {data:[...]}
            if (isset($data['data']) && is_array($data['data'])) $data = $data['data'];
            // if associative single object, wrap
            $isAssoc = array_keys($data) !== range(0, count($data) - 1);
            if ($isAssoc) $data = [$data];
            return $data;
        }

        if (in_array($ext, ['csv','txt'])) {
            $rows = [];
            if (($h = fopen($path, 'r')) !== false) {
                $header = null;
                while (($data = fgetcsv($h, 0, ',')) !== false) {
                    if ($header === null) { $header = array_map(fn($v)=>trim((string)$v), $data); continue; }
                    if (count(array_filter($data, fn($v)=>trim((string)$v) !== '')) === 0) continue;
                    $row = [];
                    foreach ($header as $i => $key) { $row[$key] = $data[$i] ?? null; }
                    $rows[] = $row;
                }
                fclose($h);
            }
            return $rows;
        }

        if (in_array($ext, ['xlsx','xls'])) {
            $import = new class implements \Maatwebsite\Excel\Concerns\ToArray {
                public function array(array $array) { return $array; }
            };
            $sheets = Excel::toArray($import, $path);
            $sheet = $sheets[0] ?? [];
            if (empty($sheet)) return [];
            $header = array_map(fn($v)=>trim((string)$v), array_shift($sheet));
            $rows = [];
            foreach ($sheet as $data) {
                if (!is_array($data)) continue;
                if (count(array_filter($data, fn($v)=>trim((string)($v ?? '')) !== '')) === 0) continue;
                $row = [];
                foreach ($header as $i => $key) { $row[$key] = $data[$i] ?? null; }
                $rows[] = $row;
            }
            return $rows;
        }

        throw new \RuntimeException('Format tidak didukung.');
    }

    private function normalizeRow(array $row): array
    {
        $get = function ($keys) use ($row) {
            foreach ($keys as $k) {
                foreach ($row as $rk => $rv) {
                    if (strtolower(trim((string)$rk)) === strtolower($k)) return is_string($rv) ? trim($rv) : $rv;
                }
            }
            return null;
        };
        $role = strtolower((string)($get(['role']) ?? 'mahasiswa'));
        if (!in_array($role, ['admin','dosen','mahasiswa'], true)) $role = (string)($get(['role']) ?? 'mahasiswa');
        $username = $get(['username']);
        if (is_string($username)) $username = strtolower(trim($username));
        return [
            'name' => (string)($get(['name','nama','nama_lengkap']) ?? ''),
            'username' => ($username === '' ? null : $username),
            'nomer_induk' => (string)($get(['nomer_induk','nim','nip','nomor_induk']) ?? ''),
            'email' => (string)($get(['email']) ?? ''),
            'role' => $role,
            'password' => (string)($get(['password']) ?? ''),
        ];
    }

    private function validateRow(array $d, array $seenNomor, array $seenEmail, array $seenUsername): array
    {
        $errs = [];
        if ($d['name'] === '') $errs[] = 'Nama wajib diisi.';
        if ($d['nomer_induk'] === '') $errs[] = 'NIM/NIP (nomer_induk) wajib diisi.';
        if ($d['email'] === '') $errs[] = 'Email wajib diisi.';
        elseif (!filter_var($d['email'], FILTER_VALIDATE_EMAIL)) $errs[] = 'Format email tidak valid.';
        if (!in_array($d['role'], ['admin','dosen','mahasiswa'], true)) $errs[] = 'Role harus admin/dosen/mahasiswa.';

        $nomorKey = strtolower($d['nomer_induk']);
        $emailKey = strtolower($d['email']);
        if ($d['nomer_induk'] !== '' && isset($seenNomor[$nomorKey])) $errs[] = 'NIM/NIP duplikat di file.';
        if ($d['email'] !== '' && isset($seenEmail[$emailKey])) $errs[] = 'Email duplikat di file.';
        if (!empty($d['username'])) {
            if (!preg_match('/^[a-z0-9_.]{3,30}$/', $d['username'])) $errs[] = 'Username tidak valid (3-30, huruf kecil/angka/_/.).';
            $uKey = strtolower($d['username']);
            if (isset($seenUsername[$uKey])) $errs[] = 'Username duplikat di file.';
        }

        // cek unik DB (untuk create; jika update by nomer_induk, izinkan milik sendiri)
        if ($d['nomer_induk'] !== '') {
            $existing = User::where('nomer_induk', $d['nomer_induk'])->first();
            if ($d['email'] !== '') {
                $emailOwner = User::where('email', $d['email'])->first();
                if ($emailOwner && (!$existing || $emailOwner->id !== $existing->id)) $errs[] = 'Email sudah terdaftar.';
            }
            if (!empty($d['username'])) {
                $uOwner = User::where('username', $d['username'])->first();
                if ($uOwner && (!$existing || $uOwner->id !== $existing->id)) $errs[] = 'Username sudah terdaftar.';
            }
            // NIM mahasiswa harus valid (sesuai logika existing) untuk data baru / perubahan ke mahasiswa
            if ($d['role'] === 'mahasiswa' && !$existing) {
                try {
                    $rule = new NimMahasiswaTerdaftar();
                    $fail = null;
                    $rule->validate('nomer_induk', $d['nomer_induk'], function($msg) use (&$fail){ $fail = $msg; });
                    if ($fail) $errs[] = $fail;
                } catch (\Throwable $e) {
                    $errs[] = 'Gagal memverifikasi NIM: ' . $e->getMessage();
                }
            }
            if ($d['role'] === 'mahasiswa' && $existing && $existing->role !== 'mahasiswa') {
                try {
                    $rule = new NimMahasiswaTerdaftar();
                    $fail = null;
                    $rule->validate('nomer_induk', $d['nomer_induk'], function($msg) use (&$fail){ $fail = $msg; });
                    if ($fail) $errs[] = $fail;
                } catch (\Throwable $e) {
                    $errs[] = 'Gagal memverifikasi NIM: ' . $e->getMessage();
                }
            }
        } else {
            if ($d['email'] !== '' && User::where('email', $d['email'])->exists()) $errs[] = 'Email sudah terdaftar.';
            if (!empty($d['username']) && User::where('username', $d['username'])->exists()) $errs[] = 'Username sudah terdaftar.';
        }

        if ($d['password'] !== '' && strlen($d['password']) < 8) $errs[] = 'Password minimal 8 karakter (atau kosongkan).';

        return $errs;
    }

    private function detectAction(array $d): string
    {
        if (empty($d['nomer_induk'])) return 'invalid';
        return User::where('nomer_induk', $d['nomer_induk'])->exists() ? 'update' : 'create';
    }
}
