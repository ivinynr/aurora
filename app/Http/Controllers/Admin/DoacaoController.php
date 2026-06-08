<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doacao;
use App\Services\CampanhaService;
use App\Services\DoacaoService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DoacaoController extends Controller
{
    public function __construct(
        private DoacaoService $doacaoService,
        private CampanhaService $campanhaService,
    ) {}

    public function index(Request $request): View
    {
        return view('admin.doacoes.index', [
            'doacoes' => $this->doacaoService->listarPaginado($request->only(['campanha_id', 'situacao'])),
            'campanhas' => $this->campanhaService->listarTodas(),
        ]);
    }

    public function show(Doacao $doacao): View
    {
        $doacao->load('campanha.instituicao', 'transacoes');

        return view('admin.doacoes.show', [
            'doacao' => $doacao,
        ]);
    }
}
