<?php

use App\Http\Controllers\Admin\AtualizacaoController;
use App\Http\Controllers\Admin\CampanhaController as AdminCampanhaController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DoacaoController as AdminDoacaoController;
use App\Http\Controllers\Admin\InstituicaoController as AdminInstituicaoController;
use App\Http\Controllers\Site\CampanhaController;
use App\Http\Controllers\Site\DoacaoController;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\InstituicaoController;
use App\Http\Middleware\VerificarAdmin;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::prefix('campanhas')->name('campanhas.')->group(function () {
    Route::get('/', [CampanhaController::class, 'index'])->name('index');
    Route::get('/{slug}', [CampanhaController::class, 'show'])->name('show');
});

Route::prefix('instituicoes')->name('instituicoes.')->group(function () {
    Route::get('/', [InstituicaoController::class, 'index'])->name('index');
    Route::get('/{slug}', [InstituicaoController::class, 'show'])->name('show');
});

Route::prefix('doar/{slug}')->name('doacao.')->group(function () {
    Route::get('/', [DoacaoController::class, 'create'])->name('create');
    Route::post('/', [DoacaoController::class, 'store'])->middleware('throttle:6,1')->name('store');
    Route::get('/{doacaoId}/confirmar', [DoacaoController::class, 'confirmar'])->name('confirmar');
    Route::get('/{doacaoId}/sucesso', [DoacaoController::class, 'sucesso'])->name('sucesso');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', VerificarAdmin::class])->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');

    Route::resource('campanhas', AdminCampanhaController::class)->parameters(['campanhas' => 'campanha']);
    Route::patch('campanhas/{campanha}/encerrar', [AdminCampanhaController::class, 'encerrar'])->name('campanhas.encerrar');
    Route::post('campanhas/{campanha}/atualizacoes', [AtualizacaoController::class, 'store'])->name('atualizacoes.store');
    Route::delete('atualizacoes/{atualizacao}', [AtualizacaoController::class, 'destroy'])->name('atualizacoes.destroy');

    Route::resource('instituicoes', AdminInstituicaoController::class)->parameters(['instituicoes' => 'instituicao']);

    Route::get('doacoes', [AdminDoacaoController::class, 'index'])->name('doacoes.index');
    Route::get('doacoes/{doacao}', [AdminDoacaoController::class, 'show'])->name('doacoes.show');
});

require __DIR__.'/auth.php';
