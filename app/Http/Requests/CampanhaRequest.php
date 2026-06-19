<?php

namespace App\Http\Requests;

use App\Enums\SituacaoCampanha;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CampanhaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->ehAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'instituicao_id' => ['required', 'integer', Rule::exists('institutions', 'id')],
            'titulo' => ['required', 'string', 'max:255'],
            'resumo' => ['required', 'string', 'max:255'],
            'descricao' => ['required', 'string'],
            'meta' => ['required', 'numeric', 'min:1'],
            'situacao' => ['required', Rule::in(SituacaoCampanha::values())],
            'destaque' => ['boolean'],
            'imagem' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'video_url' => ['nullable', 'url', 'max:500'],
            'data_inicio' => ['nullable', 'date'],
            'data_fim' => ['nullable', 'date', 'after_or_equal:data_inicio'],
        ];
    }

    public function attributes(): array
    {
        return [
            'instituicao_id' => 'Instituição',
            'titulo' => 'Título',
            'resumo' => 'Resumo',
            'descricao' => 'Descrição',
            'meta' => 'Meta de arrecadação',
            'situacao' => 'Situação',
            'destaque' => 'Destaque',
            'imagem' => 'Imagem',
            'video_url' => 'Vídeo (YouTube)',
            'data_inicio' => 'Data de início',
            'data_fim' => 'Data de término',
        ];
    }

    public function messages(): array
    {
        return [
            'meta.min' => 'A meta da campanha precisa ser maior que zero.',
            'data_fim.after_or_equal' => 'A data de término não pode ser anterior à data de início.',
        ];
    }
}
