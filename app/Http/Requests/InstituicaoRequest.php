<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InstituicaoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:255'],
            'descricao' => ['required', 'string'],
            'missao' => ['nullable', 'string', 'max:255'],
            'meta' => ['nullable', 'numeric', 'min:0'],
            'telefone' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'instagram' => ['nullable', 'string', 'max:100'],
            'website' => ['nullable', 'url', 'max:255'],
            'chave_pix' => ['nullable', 'string', 'max:255'],
            'video_url' => ['nullable', 'url', 'max:500'],
            'imagem' => ['nullable', 'image', 'max:2048'],
            'endereco' => ['nullable', 'string', 'max:255'],
            'cidade' => ['nullable', 'string', 'max:100'],
            'estado' => ['nullable', 'string', 'max:2'],
            'ativa' => ['boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'nome' => 'Nome da instituição',
            'descricao' => 'Descrição',
            'missao' => 'Missão',
            'meta' => 'Meta de arrecadação',
            'telefone' => 'Telefone',
            'email' => 'E-mail',
            'instagram' => 'Instagram',
            'website' => 'Website',
            'chave_pix' => 'Chave PIX',
            'video_url' => 'Vídeo (YouTube)',
            'imagem' => 'Imagem',
            'endereco' => 'Endereço',
            'cidade' => 'Cidade',
            'estado' => 'Estado',
        ];
    }
}
