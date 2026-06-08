<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\InstituicaoRequest;
use App\Models\Instituicao;
use App\Services\InstituicaoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class InstituicaoController extends Controller
{
    public function __construct(
        private InstituicaoService $instituicaoService,
    ) {}

    public function index(): View
    {
        return view('admin.instituicoes.index', [
            'instituicoes' => $this->instituicaoService->listarTodas(),
        ]);
    }

    public function create(): View
    {
        return view('admin.instituicoes.form');
    }

    public function store(InstituicaoRequest $request): RedirectResponse
    {
        $dados = $request->validated();
        $dados['user_id'] = auth()->id();

        if ($request->hasFile('logo')) {
            $dados['logo'] = $request->file('logo')->store('instituicoes', 'public');
        }

        $this->instituicaoService->criar($dados);

        return redirect()->route('admin.instituicoes.index')
            ->with('sucesso', 'Instituição cadastrada com sucesso!');
    }

    public function edit(Instituicao $instituicao): View
    {
        return view('admin.instituicoes.form', [
            'instituicao' => $instituicao,
        ]);
    }

    public function update(InstituicaoRequest $request, Instituicao $instituicao): RedirectResponse
    {
        $dados = $request->validated();

        if ($request->hasFile('logo')) {
            $dados['logo'] = $request->file('logo')->store('instituicoes', 'public');
        }

        $this->instituicaoService->atualizar($instituicao, $dados);

        return redirect()->route('admin.instituicoes.index')
            ->with('sucesso', 'Instituição atualizada com sucesso!');
    }

    public function destroy(Instituicao $instituicao): RedirectResponse
    {
        $instituicao->delete();

        return redirect()->route('admin.instituicoes.index')
            ->with('sucesso', 'Instituição removida com sucesso!');
    }
}
