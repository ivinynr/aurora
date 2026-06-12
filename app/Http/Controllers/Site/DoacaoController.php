<?php

namespace App\Http\Controllers\Site;

use App\Enums\SituacaoCampanha;
use App\Enums\SituacaoDoacao;
use App\Http\Controllers\Controller;
use App\Http\Requests\DoacaoRequest;
use App\Models\Campanha;
use App\Services\DoacaoService;
use App\Services\Pagamento\PagamentoServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class DoacaoController extends Controller
{
    public function __construct(
        private DoacaoService $doacaoService,
        private PagamentoServiceInterface $pagamentoService,
    ) {}

    public function create(string $slug): Response
    {
        $campanha = $this->campanhaAtiva($slug);

        return Inertia::render('Site/Doacao/Form', [
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

    public function pagamento(string $slug, int $doacaoId): Response|RedirectResponse
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

        return Inertia::render('Site/Doacao/Pagamento', [
            'campanha' => $campanha,
            'doacao' => $doacao,
            'pagamento' => [
                'transaction_id' => $transacao->transaction_id,
                'qr_code_src' => $this->qrCodeSrc($transacao->qr_code),
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

        $resultado = $this->doacaoService->verificarPagamento($doacao);

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

        return redirect()->route('doacao.sucesso', [$slug, $doacaoId]);
    }

    /**
     * Endpoint consultado via polling pela tela de pagamento, para detectar
     * automaticamente quando o Pix for confirmado, sem precisar do botão "Já paguei".
     */
    public function status(string $slug, int $doacaoId): JsonResponse
    {
        $campanha = Campanha::where('slug', $slug)->firstOrFail();
        $doacao = $campanha->doacoes()->findOrFail($doacaoId);

        $resultado = $this->doacaoService->verificarPagamento($doacao);

        return response()->json([
            'pago' => ! empty($resultado['pago']),
            'situacao' => $resultado['situacao'] ?? $doacao->situacao->value,
        ]);
    }

    public function sucesso(string $slug, int $doacaoId): Response
    {
        $campanha = Campanha::where('slug', $slug)->firstOrFail();
        $doacao = $campanha->doacoes()->findOrFail($doacaoId);

        return Inertia::render('Site/Doacao/Sucesso', [
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

    /**
     * Resolve a URL/dataURI exibida no <img> do QR Code a partir do valor
     * retornado pelo gateway de pagamento (pode ser base64, URL absoluta ou caminho relativo).
     */
    private function qrCodeSrc(?string $qrCode): ?string
    {
        if (empty($qrCode)) {
            return null;
        }

        if (Str::startsWith($qrCode, ['data:', 'http://', 'https://'])) {
            return $qrCode;
        }

        if (Str::startsWith($qrCode, '/')) {
            return asset(ltrim($qrCode, '/'));
        }

        return 'data:image/png;base64,' . $qrCode;
    }
}
