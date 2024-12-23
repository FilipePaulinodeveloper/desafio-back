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
            'phones'    => 'nullable|array',
            'phones.*.id' => 'nullable|exists:phones,id', // Valida que o ID exista no banco
            'phones.*.phone_number' => 'required|string|regex:/^\+?[0-9\-]{7,15}$/', // Valida o formato do número
        ];
    }
}
