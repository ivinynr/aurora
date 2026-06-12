<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Services\CampanhaService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CampanhaController extends Controller
{
    public function __construct(
        private CampanhaService $campanhaService,
    ) {}

    public function index(Request $request): Response
    {
        return Inertia::render('Site/Campanhas/Index', [
            'campanhas' => $this->campanhaService->listarPaginado($request->only(['busca'])),
            'busca' => $request->input('busca', ''),
        ]);
    }

    public function show(string $slug): Response
    {
        $campanha = $this->campanhaService->buscarPorSlug($slug);

        abort_if(! $campanha, 404, 'Campanha não encontrada.');

        return Inertia::render('Site/Campanhas/Show', [
            'campanha' => $campanha,
            'totalDoadores' => $campanha->totalDoadores(),
        ]);
    }
}
