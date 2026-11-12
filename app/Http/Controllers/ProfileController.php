<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateAvatarRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;

class ProfileController extends Controller
{
    public function show(): View
    {
        return view('profile.show', [
            'user' => Auth::user(),
        ]);
    }

    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->validated();
        unset($data['name']); // nama asli dikelola admin

        $user->fill($data);

        // if email changed and verification is relevant, keep simple (project behavior)
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return back()->with('active_tab', 'profile')->with('status', 'profile-updated')->with('success', 'Profil berhasil diperbarui.');
    }

    public function updateAvatar(UpdateAvatarRequest $request): RedirectResponse
    {
        $user = $request->user();
        $file = $request->file('avatar');

        // hapus avatar lama (kustom)
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }
        // hapus foto Jetstream lama jika ada (agar tidak nyangkut)
        if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
            Storage::disk('public')->delete($user->profile_photo_path);
            $user->profile_photo_path = null;
        }

        $path = $file->store('avatars', 'public');
        $user->avatar = $path;
        $user->save();

        return back()->with('status', 'avatar-updated')->with('success', 'Foto profil berhasil diperbarui.');
    }

    public function deleteAvatar(): RedirectResponse
    {
        $user = Auth::user();

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }
        $user->avatar = null;

        if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }
        $user->profile_photo_path = null;
        $user->save();

        return back()->with('status', 'avatar-deleted')->with('success', 'Foto profil dihapus.');
    }

    public function updatePassword(UpdatePasswordRequest $request): RedirectResponse
    {
        $updater = app(UpdatesUserPasswords::class);
        $updater->update($request->user(), $request->only(['current_password', 'password', 'password_confirmation']));

        return back()->with('status', 'password-updated')->with('success', 'Password berhasil diperbarui.');
    }
}
