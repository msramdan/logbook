<?php

namespace App\Http\Requests\Users;

use App\Actions\Fortify\PasswordValidationRules;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    use PasswordValidationRules;

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
            'name' => ['required', 'min:3', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,'.$this->setId()],
            'avatar' => ['nullable', 'image', 'max:1024'],
            'role' => ['required', 'exists:roles,id'],
            'password' => ['nullable', ...$this->passwordRules()],
        ];
    }

    private function setId(): int|string
    {
        $user = $this->route('user');

        if ($user instanceof \App\Models\User) {
            return $user->getKey();
        }

        if (is_numeric($user)) {
            return $user;
        }

        // Fallback: ambil id setelah segment "users" (tanpa cek "api" di URL,
        // karena domain misalnya rapidiy ikut match)
        $segments = $this->segments();
        $index = array_search('users', $segments, true);

        if ($index !== false && isset($segments[$index + 1]) && is_numeric($segments[$index + 1])) {
            return $segments[$index + 1];
        }

        return 0;
    }
}
