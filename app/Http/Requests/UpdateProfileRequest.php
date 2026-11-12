<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            // name sengaja tidak diubah user (nama asli dikelola admin)
            'username' => [
                'nullable',
                'string',
                'min:3',
                'max:30',
                'regex:/^[a-z0-9_.]+$/',
                Rule::unique('users', 'username')->ignore($this->user()->id),
            ],
            'email' => ['nullable', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->user()->id)],
            'phone' => ['nullable', 'string', 'max:30'],
            'bio' => ['nullable', 'string', 'max:160'],
        ];
    }

    public function messages(): array
    {
        return [
            'username.min' => 'Username minimal 3 karakter.',
            'username.max' => 'Username maksimal 30 karakter.',
            'username.regex' => 'Username hanya boleh huruf kecil, angka, garis bawah (_), dan titik (.).',
            'username.unique' => 'Username sudah digunakan.',
            'bio.max' => 'Bio maksimal 160 karakter.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $email = $this->input('email');
        $phone = $this->input('phone');
        $bio = $this->input('bio');
        $username = $this->input('username');

        // Strip nama (tidak boleh diubah user)
        $this->request->remove('name');

        $this->merge([
            'username' => is_string($username) && trim($username) !== '' ? strtolower(trim($username)) : null,
            'email' => is_string($email) && trim($email) === '' ? null : $email,
            'phone' => is_string($phone) && trim($phone) === '' ? null : $phone,
            'bio' => is_string($bio) && trim($bio) === '' ? null : $bio,
        ]);
    }
}
