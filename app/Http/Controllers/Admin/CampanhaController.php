<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CampanhaRequest;
use App\Models\Campanha;
use App\Services\CampanhaService;
use App\Services\InstituicaoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CampanhaController extends Controller
{
    public function __construct(
        private CampanhaService $campanhaService,
        private InstituicaoService $instituicaoService,
    ) {}

    public function index(): View
    {
        return view('admin.campanhas.index', [
            'campanhas' => $this->campanhaService->listarTodas(),
        ]);
    }

    public function create(): View
    {
        return view('admin.campanhas.form', [
            'instituicoes' => $this->instituicaoService->listarTodas(),
        ]);
    }

    public function store(CampanhaRequest $request): RedirectResponse
    {
        $dados = $request->validated();

        if ($request->hasFile('imagem')) {
            $dados['imagem'] = $request->file('imagem')->store('campanhas', 'public');
        }

        $this->campanhaService->criar($dados);

        return redirect()->route('admin.campanhas.index')
            ->with('sucesso', 'Campanha criada com sucesso!');
    }

    public function edit(Campanha $campanha): View
    {
        return view('admin.campanhas.form', [
            'campanha' => $campanha,
            'instituicoes' => $this->instituicaoService->listarTodas(),
        ]);
    }

    public function update(CampanhaRequest $request, Campanha $campanha): RedirectResponse
    {
        $dados = $request->validated();

        if ($request->hasFile('imagem')) {
            $dados['imagem'] = $request->file('imagem')->store('campanhas', 'public');
        }

        $this->campanhaService->atualizar($campanha, $dados);

        return redirect()->route('admin.campanhas.index')
            ->with('sucesso', 'Campanha atualizada com sucesso!');
    }

    public function destroy(Campanha $campanha): RedirectResponse
    {
        $campanha->delete();

        return redirect()->route('admin.campanhas.index')
            ->with('sucesso', 'Campanha removida com sucesso!');
    }

    public function encerrar(Campanha $campanha): RedirectResponse
    {
        $this->campanhaService->encerrar($campanha);

        return redirect()->route('admin.campanhas.index')
            ->with('sucesso', 'Campanha encerrada com sucesso!');
    }
}
