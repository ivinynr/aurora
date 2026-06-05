<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Services\DoacaoService;
use App\Services\InstituicaoService;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(
        private InstituicaoService $instituicaoService,
        private DoacaoService $doacaoService,
    ) {}

    public function __invoke(): View
    {
        return view('site.home', [
            'instituicoes' => $this->instituicaoService->listarAtivas(),
            'ultimasDoacoes' => $this->doacaoService->ultimasDoacoes(8),
            'estatisticas' => $this->doacaoService->estatisticas(),
        ]);
    }
}
