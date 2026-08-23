<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'nomer_induk' => ['required', 'string', 'max:50', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        // Registrasi mandiri selalu ber-role 'mahasiswa'.
        // Akun Dosen / Admin hanya dapat dibuat oleh Admin melalui menu Manajemen Akun.
        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'nomer_induk' => $input['nomer_induk'],
            'role' => 'mahasiswa',
            'password' => Hash::make($input['password']),
        ]);
    }
}
