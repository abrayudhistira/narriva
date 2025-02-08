<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:100'],
            'profile_picture' => ['nullable', 'file', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // Max 2MB
            'bio' => ['nullable', 'string', 'max:500'],
        ];
    }
}
