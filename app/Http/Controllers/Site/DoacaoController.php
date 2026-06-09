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

    public function store(DoacaoRequest $request, string $slug): RedirectResponse
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

        return redirect()->route('doacao.pagamento', [$campanha->slug, $doacao->id]);
    }

    public function pagamento(string $slug, int $doacaoId): View|RedirectResponse
    {
        $campanha = Campanha::where('slug', $slug)->firstOrFail();
        $doacao = $campanha->doacoes()->findOrFail($doacaoId);

        if ($doacao->situacao === SituacaoDoacao::CONFIRMADA) {
            return redirect()->route('doacao.sucesso', [$slug, $doacaoId]);
        }

        $transacao = $doacao->transacoes()->latest('id')->first();

        if (! $transacao) {
            return redirect()->route('doacao.create', $slug);
        }

        return view('site.doacao.pagamento', [
            'campanha' => $campanha,
            'doacao' => $doacao,
            'pagamento' => [
                'transaction_id' => $transacao->transaction_id,
                'qr_code' => $transacao->qr_code,
                'qr_code_text' => $transacao->qr_code_text,
                'valor' => $transacao->valor,
                'expiracao' => optional($transacao->expira_em)->toIso8601String(),
            ],
        ]);
    }

    public function confirmar(string $slug, int $doacaoId): RedirectResponse
    {
        $campanha = Campanha::where('slug', $slug)->firstOrFail();
        $doacao = $campanha->doacoes()->findOrFail($doacaoId);

        if ($doacao->situacao !== SituacaoDoacao::PENDENTE) {
            return redirect()->route('doacao.sucesso', [$slug, $doacaoId]);
        }

        $resultado = $this->pagamentoService->consultarPagamento(
            $doacao->transaction_id ?? "DOA-{$doacao->id}",
        );

        if (! empty($resultado['erro'])) {
            return redirect()
                ->route('doacao.pagamento', [$slug, $doacaoId])
                ->with('erro', $resultado['mensagem'] ?? 'Não foi possível verificar o pagamento no momento.');
        }

        if (empty($resultado['pago'])) {
            return redirect()
                ->route('doacao.pagamento', [$slug, $doacaoId])
                ->with('aviso', 'Ainda não identificamos seu pagamento. Se você acabou de pagar via Pix, aguarde alguns instantes e clique novamente em "Já paguei".');
        }

        $this->doacaoService->confirmar(
            $doacao,
            $resultado['transaction_id'] ?? "CONF-{$doacao->id}",
        );

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
