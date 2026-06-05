<?php

namespace App\Providers;

use App\Services\Pagamento\ConfraPixService;
use App\Services\Pagamento\MockPagamentoService;
use App\Services\Pagamento\PagamentoServiceInterface;
use Illuminate\Support\ServiceProvider;

class PagamentoServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(PagamentoServiceInterface::class, function () {
            if (config('services.confrapix.token')) {
                return new ConfraPixService();
            }

            return new MockPagamentoService();
        });
    }

    public function boot(): void
    {
        //
    }
}
