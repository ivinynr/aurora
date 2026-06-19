<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Services\DoacaoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ConfraPixWebhookController extends Controller
{
    public function __construct(
        private DoacaoService $doacaoService,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $secret = config('services.confrapix.webhook_secret');

        if (empty($secret)) {
            return response()->json(['mensagem' => 'Webhook não configurado.'], 503);
        }

        if (! hash_equals((string) $secret, (string) $request->query('token'))) {
            return response()->json(['mensagem' => 'Não autorizado.'], 401);
        }

        $this->doacaoService->sincronizarPorCallback($request->all());

        return response()->json(['recebido' => true]);
    }
}
