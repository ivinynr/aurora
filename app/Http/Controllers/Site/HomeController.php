<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Services\CampanhaService;
use App\Services\DoacaoService;
use App\Services\InstituicaoService;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(
        private CampanhaService $campanhaService,
        private DoacaoService $doacaoService,
        private InstituicaoService $instituicaoService,
    ) {}

    public function __invoke(): View
    {
        return view('site.home', [
            'destaques' => $this->campanhaService->destaques(3),
            'ultimasDoacoes' => $this->doacaoService->ultimasDoacoes(8),
            'estatisticas' => $this->doacaoService->estatisticas(),
            'instituicoes' => $this->instituicaoService->destaquesPagina(6),
        ]);
    }
}
