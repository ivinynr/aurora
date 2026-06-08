<?php

namespace App\Http\Controllers\Site;

use App\Enums\SituacaoCampanha;
use App\Enums\SituacaoDoacao;
use App\Http\Controllers\Controller;
use App\Http\Requests\DoacaoRequest;
use App\Models\Campanha;
use App\Services\DoacaoService;
use App\Services\Pagamento\PagamentoServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DoacaoController extends Controller
{
    public function __construct(
        private DoacaoService $doacaoService,
        private PagamentoServiceInterface $pagamentoService,
    ) {}

    public function create(string $slug): View
    {
        $campanha = $this->campanhaAtiva($slug);

        return view('site.doacao.form', [
            'campanha' => $campanha,
        ]);
    }

    public function store(DoacaoRequest $request, string $slug): View|RedirectResponse
    {
        $campanha = $this->campanhaAtiva($slug);

        $doacao = $this->doacaoService->registrar($campanha, $request->validated());

        $pagamento = $this->pagamentoService->gerarCobrancaPix(
            (float) $doacao->valor,
            "Doação para {$campanha->titulo}",
            "DOA-{$doacao->id}",
        );

        if (! empty($pagamento['erro'])) {
            $doacao->delete();

            return back()
                ->withInput()
                ->with('erro', $pagamento['mensagem'] ?? 'Não foi possível gerar a cobrança PIX no momento.');
        }

        $this->doacaoService->registrarCobranca($doacao, $pagamento);

        return view('site.doacao.pagamento', [
            'campanha' => $campanha,
            'doacao' => $doacao->fresh(),
            'pagamento' => $pagamento,
        ]);
    }

    public function confirmar(string $slug, int $doacaoId): RedirectResponse
    {
        $campanha = Campanha::where('slug', $slug)->firstOrFail();
        $doacao = $campanha->doacoes()->findOrFail($doacaoId);

        if ($doacao->situacao === SituacaoDoacao::PENDENTE) {
            $resultado = $this->pagamentoService->consultarPagamento(
                $doacao->transaction_id ?? "DOA-{$doacao->id}",
            );

            $this->doacaoService->confirmar(
                $doacao,
                $resultado['transaction_id'] ?? "CONF-{$doacao->id}",
            );
        }

        return redirect()->route('doacao.sucesso', [$slug, $doacaoId]);
    }

    public function sucesso(string $slug, int $doacaoId): View
    {
        $campanha = Campanha::where('slug', $slug)->firstOrFail();
        $doacao = $campanha->doacoes()->findOrFail($doacaoId);

        return view('site.doacao.sucesso', [
            'campanha' => $campanha,
            'doacao' => $doacao,
        ]);
    }

    private function campanhaAtiva(string $slug): Campanha
    {
        return Campanha::where('slug', $slug)
            ->where('situacao', SituacaoCampanha::ATIVA->value)
            ->firstOrFail();
    }
}
