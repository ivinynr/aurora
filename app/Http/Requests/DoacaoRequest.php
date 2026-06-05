<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DoacaoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'valor' => ['required', 'numeric', 'min:5'],
            'nome_doador' => ['required', 'string', 'max:255'],
            'email_doador' => ['nullable', 'email', 'max:255'],
            'anonimo' => ['boolean'],
            'mensagem' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function attributes(): array
    {
        return [
            'valor' => 'Valor da doação',
            'nome_doador' => 'Nome do doador',
            'email_doador' => 'E-mail do doador',
            'anonimo' => 'Doação anônima',
            'mensagem' => 'Mensagem',
        ];
    }

    public function messages(): array
    {
        return [
            'valor.min' => 'O valor mínimo para doação é R$ 5,00.',
            'nome_doador.required' => 'Precisamos do seu nome para registrar a doação.',
        ];
    }
}
