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
            'empresa' => 'required|string',
            'password'  => 'required|string|min:8', // Adicionada uma validação de tamanho mínimo para maior segurança
            'phones'    => 'nullable|array', // Valida que o campo seja um array
            'phones.*' => 'string|max:16'
        ];
    }

    public function messages()
{
    return [
        'name.required' => 'O nome é obrigatório.',
        'email.required' => 'O e-mail é obrigatório.',
        'email.email' => 'Por favor, insira um e-mail válido.',
        'email.unique' => 'Este e-mail já está em uso.',
        'empresa' => 'required|string',
        'password.required' => 'A senha é obrigatória.',
        'password.min' => 'A senha deve ter pelo menos 8 caracteres.',
        'phones.array' => 'Os telefones devem estar em formato de lista.',
        'phones.*.string' => 'Cada telefone deve ser uma string.',
        'phones.*.max' => 'Cada telefone pode ter no máximo 16 caracteres.',
    ];
}
}
