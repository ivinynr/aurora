<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AtualizacaoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->ehAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'titulo' => ['required', 'string', 'max:255'],
            'descricao' => ['required', 'string'],
            'imagem' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    public function attributes(): array
    {
        return [
            'titulo' => 'Título',
            'descricao' => 'Descrição',
            'imagem' => 'Imagem',
        ];
    }
}
