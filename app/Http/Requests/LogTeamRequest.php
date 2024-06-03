<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LogTeamRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'mandante' => 'required|integer',
            'gols1' => 'required|integer',
            'visitor' => 'required|integer',
            'gols2' => 'required|integer',
        ];
    }
}