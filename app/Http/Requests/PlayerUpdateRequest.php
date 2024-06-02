<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PlayerUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'level' => ['required', 'int', 'min:1','max:5'],
            'is_goalkeeper' => ['required'],
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'is_goalkeeper' => $this->is_goalkeeper == "on" ? 1 : 0,
        ]);
    }
}