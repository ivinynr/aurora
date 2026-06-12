<?php

namespace App\Http\Controllers\Admin;

use App\Enums\SituacaoDoacao;
use App\Http\Controllers\Controller;
use App\Models\Doacao;
use App\Services\CampanhaService;
use App\Services\DoacaoService;
use App\Services\Pagamento\PagamentoServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DoacaoController extends Controller
{
    public function __construct(
        private DoacaoService $doacaoService,
        private CampanhaService $campanhaService,
        private PagamentoServiceInterface $pagamentoService,
    ) {}

    public function index(Request $request): Response
    {
        return Inertia::render('Admin/Doacoes/Index', [
            'doacoes' => $this->doacaoService->listarPaginado($request->only(['campanha_id', 'situacao'])),
            'campanhas' => $this->campanhaService->listarTodas(),
            'situacoes' => SituacaoDoacao::opcoes(),
            'filtros' => $request->only(['campanha_id', 'situacao']),
        ]);
    }

    public function show(Doacao $doacao): Response
    {
        $doacao->load('campanha.instituicao', 'transacoes');

        return Inertia::render('Admin/Doacoes/Show', [
            'doacao' => $doacao,
        ]);
    }

    public function cancelar(Doacao $doacao): RedirectResponse
    {
        if ($doacao->situacao === SituacaoDoacao::CANCELADA) {
            return back()->with('erro', 'Esta doação já está cancelada, por isso não pode ser cancelada novamente.');
        }

        if ($doacao->transaction_id) {
            $resultado = $this->pagamentoService->cancelarPagamento($doacao->transaction_id);

            if (! empty($resultado['erro'])) {
                return back()->with('erro', $resultado['mensagem'] ?? 'Não foi possível cancelar a transação no gateway de pagamento.');
            }
        }

        $this->doacaoService->cancelar($doacao);

        return back()->with('sucesso', 'Doação cancelada com sucesso. Se já estava paga, o estorno será processado pela ConfraPix.');
    }
}
