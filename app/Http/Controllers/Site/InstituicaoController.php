<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Services\InstituicaoService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class InstituicaoController extends Controller
{
    public function __construct(
        private InstituicaoService $instituicaoService,
    ) {}

    public function index(Request $request): Response
    {
        return Inertia::render('Site/Instituicoes/Index', [
            'instituicoes' => $this->instituicaoService->listarPaginado($request->only(['busca', 'cidade'])),
            'cidades' => $this->instituicaoService->cidadesDisponiveis(),
            'busca' => $request->input('busca', ''),
        ]);
    }

    public function show(string $slug): Response
    {
        $instituicao = $this->instituicaoService->buscarPorSlug($slug);

        abort_if(!$instituicao, 404, 'Instituição não encontrada.');

        $relacionadas = $instituicao->segmento
            ? $this->instituicaoService->listarPorSegmento(
                $instituicao->segmento->value,
                $instituicao->id,
            )
            : collect();

        return Inertia::render('Site/Instituicoes/Show', [
            'instituicao' => $instituicao,
            'relacionadas' => $relacionadas,
        ]);
    }
}
