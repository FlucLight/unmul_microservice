<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserManagementController extends Controller
{
    /**
     * Halaman manajemen pengguna (khusus Admin).
     */
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();

        return view('admin.pengguna', compact('users'));
    }

    /**
     * Mendaftarkan pengguna baru (Mahasiswa / Dosen / Admin) via NIM / NIP.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'nomer_induk' => ['required', 'string', 'max:50', 'unique:users'],
            'role' => ['required', 'string', 'in:admin,dosen,mahasiswa'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email sudah terdaftar dalam sistem.',
            'nomer_induk.required' => 'Nomor Induk (NIM/NIP) wajib diisi.',
            'nomer_induk.unique' => 'Nomor Induk (NIM/NIP) sudah terdaftar dalam sistem.',
            'role.required' => 'Role pengguna wajib dipilih.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'nomer_induk' => $request->nomer_induk,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.pengguna')->with('success', 'Akun ' . ucfirst($request->role) . ' berhasil didaftarkan!');
    }

    /**
     * Memperbarui data pengguna.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'nomer_induk' => ['required', 'string', 'max:50', 'unique:users,nomer_induk,' . $user->id],
            'role' => ['required', 'string', 'in:admin,dosen,mahasiswa'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.unique' => 'Email sudah digunakan akun lain.',
            'nomer_induk.unique' => 'Nomor Induk sudah digunakan akun lain.',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'nomer_induk' => $request->nomer_induk,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $request->validate(['password' => ['string', 'min:8']], [
                'password.min' => 'Password minimal 8 karakter.',
            ]);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.pengguna')->with('success', 'Data pengguna berhasil diperbarui!');
    }

    /**
     * Menghapus akun pengguna.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.pengguna')->with('success', 'Akun pengguna berhasil dihapus!');
    }
}
