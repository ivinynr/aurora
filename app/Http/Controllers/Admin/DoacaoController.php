<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doacao;
use App\Services\DoacaoService;
use App\Services\InstituicaoService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DoacaoController extends Controller
{
    public function __construct(
        private DoacaoService $doacaoService,
        private InstituicaoService $instituicaoService,
    ) {}

    public function index(Request $request): View
    {
        return view('admin.doacoes.index', [
            'doacoes' => $this->doacaoService->listarPaginado($request->only(['instituicao_id', 'situacao'])),
            'instituicoes' => $this->instituicaoService->listarTodas(),
        ]);
    }

    public function show(Doacao $doacao): View
    {
        $doacao->load('instituicao');

        return view('admin.doacoes.show', [
            'doacao' => $doacao,
        ]);
    }
}
