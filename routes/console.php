<?php

use App\Services\Pagamento\ConfraPixService;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('confrapix:ping', function (ConfraPixService $confrapix) {
    $resultado = $confrapix->versao();

    if (! empty($resultado['erro'])) {
        $this->error('Falha ao conectar na ConfraPix: '.json_encode($resultado, JSON_UNESCAPED_UNICODE));

        return 1;
    }

    $this->info('ConfraPix acessível. Resposta: '.json_encode($resultado['resposta'], JSON_UNESCAPED_UNICODE));

    return 0;
})->purpose('Testa a conectividade com a API ConfraPix');
