<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255', 'unique:users,email,' . $this->user()->id],
            'phone' => ['nullable', 'string', 'max:30'],
            'bio' => ['nullable', 'string', 'max:160'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $email = $this->input('email');
        $phone = $this->input('phone');
        $bio = $this->input('bio');
        $this->merge([
            'email' => is_string($email) && trim($email) === '' ? null : $email,
            'phone' => is_string($phone) && trim($phone) === '' ? null : $phone,
            'bio' => is_string($bio) && trim($bio) === '' ? null : $bio,
        ]);
    }
}
