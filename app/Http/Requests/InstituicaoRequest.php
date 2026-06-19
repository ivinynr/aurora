<?php

namespace App\Http\Requests;

use App\Enums\SegmentoInstituicao;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InstituicaoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->ehAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:255'],
            'descricao' => ['required', 'string'],
            'missao' => ['nullable', 'string', 'max:255'],
            'telefone' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'instagram' => ['nullable', 'string', 'max:100'],
            'website' => ['nullable', 'url', 'max:255'],
            'chave_pix' => ['nullable', 'string', 'max:255'],
            'imagem' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'endereco' => ['nullable', 'string', 'max:255'],
            'cidade' => ['nullable', 'string', 'max:100'],
            'estado' => ['nullable', 'string', 'max:2'],
            'ativa' => ['boolean'],
            'segmento' => ['nullable', 'string', Rule::in(SegmentoInstituicao::values())],
            'fotos' => ['nullable', 'array', 'max:10'],
            'fotos.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'selos' => ['nullable', 'array', 'max:20'],
            'selos.*' => ['nullable', 'string', 'max:100'],
        ];
    }

    public function attributes(): array
    {
        return [
            'nome' => 'Nome da instituição',
            'descricao' => 'Descrição',
            'missao' => 'Missão',
            'telefone' => 'Telefone',
            'email' => 'E-mail',
            'instagram' => 'Instagram',
            'website' => 'Website',
            'chave_pix' => 'Chave PIX',
            'imagem' => 'Imagem',
            'endereco' => 'Endereço',
            'cidade' => 'Cidade',
            'estado' => 'Estado',
            'segmento' => 'Segmento',
            'fotos' => 'Fotos',
            'fotos.*' => 'Foto',
            'selos' => 'Selos',
            'selos.*' => 'Selo',
        ];
    }
}
