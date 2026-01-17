<?php

namespace App\Http\Requests\Member\Link;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class Store extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Only 'admin' and 'member' roles associated with a company can create short URLs

        $user = Auth::user();

        return $user
            && ($user->role === 'admin' || $user->role === 'member')
            && $user->company_id !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'original_url' => 'required|url|max:2048',
        ];
    }
}
