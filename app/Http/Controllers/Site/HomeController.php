<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Services\CampanhaService;
use App\Services\DoacaoService;
use App\Services\InstituicaoService;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function __construct(
        private CampanhaService $campanhaService,
        private DoacaoService $doacaoService,
        private InstituicaoService $instituicaoService,
    ) {}

    public function __invoke(): Response
    {
        return Inertia::render('Site/Home', [
            'destaques' => $this->campanhaService->destaques(3),
            'ultimasDoacoes' => $this->doacaoService->ultimasDoacoes(8),
            'instituicoes' => $this->instituicaoService->destaquesPagina(6),
            'estatisticas' => $this->doacaoService->estatisticas(),
        ]);
    }
}
