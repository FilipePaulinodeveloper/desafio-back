<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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

    public function prepareForValidation()
    {
        $userId = $this->route('id');

        if (!User::find($userId)) {
            abort(404, 'Usuário não encontrado.');
        }
    }
    public function rules()
    {
        $userId = $this->route('id'); // Obtém o ID do usuário da rota


        return [
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users,email,' . $userId,
            'empresa' => 'required',
            'phones'    => 'nullable|array',
            'phones.*.id' => 'nullable|exists:phones,id', // Valida que o ID exista no banco
            'phones.*.phone_number' => 'string|max:16'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'name.string' => 'O nome deve ser um texto.',
            'name.max' => 'O nome não pode ter mais de :max caracteres.',

            'empresa.required' => 'O campo Empresa é obrigatório ',

            'email.required' => 'O campo e-mail é obrigatório.',
            'email.string' => 'O e-mail deve ser um texto.',
            'email.email' => 'O e-mail deve ser um endereço válido.',
            'email.max' => 'O e-mail não pode ter mais de :max caracteres.',
            'email.unique' => 'Este e-mail já está em uso.',

            'phones.array' => 'O campo telefones deve ser uma lista.',
            'phones.*.id.exists' => 'O telefone selecionado não existe no banco de dados.',
            'phones.*.phone_number.string' => 'O número de telefone deve ser um texto.',
            'phones.*.phone_number.max' => 'O número de telefone não pode ter mais de :max caracteres.',
        ];
    }
}
