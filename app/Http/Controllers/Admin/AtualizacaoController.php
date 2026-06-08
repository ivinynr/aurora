<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AtualizacaoRequest;
use App\Models\AtualizacaoCampanha;
use App\Models\Campanha;
use App\Services\CampanhaService;
use Illuminate\Http\RedirectResponse;

class AtualizacaoController extends Controller
{
    public function __construct(
        private CampanhaService $campanhaService,
    ) {}

    public function store(AtualizacaoRequest $request, Campanha $campanha): RedirectResponse
    {
        $dados = $request->validated();

        if ($request->hasFile('imagem')) {
            $dados['imagem'] = $request->file('imagem')->store('atualizacoes', 'public');
        }

        $this->campanhaService->publicarAtualizacao($campanha, $dados);

        return redirect()->route('admin.campanhas.edit', $campanha)
            ->with('sucesso', 'Atualização publicada com sucesso!');
    }

    public function destroy(AtualizacaoCampanha $atualizacao): RedirectResponse
    {
        $campanhaId = $atualizacao->campanha_id;

        $this->campanhaService->removerAtualizacao($atualizacao);

        return redirect()->route('admin.campanhas.edit', $campanhaId)
            ->with('sucesso', 'Atualização removida com sucesso!');
    }
}
