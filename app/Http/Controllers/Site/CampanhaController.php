<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Services\CampanhaService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CampanhaController extends Controller
{
    public function __construct(
        private CampanhaService $campanhaService,
    ) {}

    public function index(Request $request): View
    {
        return view('site.campanhas.index', [
            'campanhas' => $this->campanhaService->listarPaginado($request->only(['busca'])),
        ]);
    }

    public function show(string $slug): View
    {
        $campanha = $this->campanhaService->buscarPorSlug($slug);

        abort_if(! $campanha, 404, 'Campanha não encontrada.');

        return view('site.campanhas.show', [
            'campanha' => $campanha,
        ]);
    }
}
