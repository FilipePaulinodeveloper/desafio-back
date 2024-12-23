<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users',
            'password'  => 'required|string|min:8', // Adicionada uma validação de tamanho mínimo para maior segurança
            'phones'    => 'nullable|array', // Valida que o campo seja um array
            'phones.*'  => 'string|regex:/^\+?[0-9\-]{7,15}$/', // Valida cada item do array como um número de telefone (com regex básico)
        ];
    }
}
