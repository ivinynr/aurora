<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Services\InstituicaoService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InstituicaoController extends Controller
{
    public function __construct(
        private InstituicaoService $instituicaoService,
    ) {}

    public function index(Request $request): View
    {
        return view('site.instituicoes.index', [
            'instituicoes' => $this->instituicaoService->listarPaginado($request->only(['busca', 'cidade'])),
            'cidades' => $this->instituicaoService->cidadesDisponiveis(),
        ]);
    }

    public function show(string $slug): View
    {
        $instituicao = $this->instituicaoService->buscarPorSlug($slug);

        abort_if(!$instituicao, 404, 'Instituição não encontrada.');

        return view('site.instituicoes.show', [
            'instituicao' => $instituicao,
        ]);
    }
}
