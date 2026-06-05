<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\DoacaoRequest;
use App\Models\Instituicao;
use App\Services\DoacaoService;
use App\Services\Pagamento\PagamentoServiceInterface;
use Illuminate\View\View;

class DoacaoController extends Controller
{
    public function __construct(
        private DoacaoService $doacaoService,
        private PagamentoServiceInterface $pagamentoService,
    ) {}

    public function create(string $slug): View
    {
        $instituicao = Instituicao::where('slug', $slug)->where('ativa', true)->firstOrFail();

        return view('site.doacao.form', [
            'instituicao' => $instituicao,
        ]);
    }

    public function store(DoacaoRequest $request, string $slug): View
    {
        $instituicao = Instituicao::where('slug', $slug)->where('ativa', true)->firstOrFail();

        $doacao = $this->doacaoService->registrar($instituicao, $request->validated());

        $pagamento = $this->pagamentoService->gerarCobrancaPix(
            $doacao->valor,
            "Doação para {$instituicao->nome}",
            "DOA-{$doacao->id}"
        );

        return view('site.doacao.pagamento', [
            'instituicao' => $instituicao,
            'doacao' => $doacao,
            'pagamento' => $pagamento,
        ]);
    }

    public function confirmar(string $slug, int $doacaoId)
    {
        $instituicao = Instituicao::where('slug', $slug)->firstOrFail();
        $doacao = $instituicao->doacoes()->findOrFail($doacaoId);

        if ($doacao->situacao->value === 'pendente') {
            $resultado = $this->pagamentoService->consultarPagamento($doacao->transaction_id ?? "DOA-{$doacao->id}");
            $this->doacaoService->confirmar($doacao, $resultado['transaction_id'] ?? "CONF-{$doacao->id}");
        }

        return redirect()->route('doacao.sucesso', [$slug, $doacaoId]);
    }

    public function sucesso(string $slug, int $doacaoId): View
    {
        $instituicao = Instituicao::where('slug', $slug)->firstOrFail();
        $doacao = $instituicao->doacoes()->findOrFail($doacaoId);

        return view('site.doacao.sucesso', [
            'instituicao' => $instituicao,
            'doacao' => $doacao,
        ]);
    }
}
