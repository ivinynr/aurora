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

        if ($request->hasFile('imagem')) {
            $dados['imagem'] = $request->file('imagem')->store('instituicoes', 'public');
        }

        if ($request->hasFile('fotos')) {
            $dados['fotos'] = array_map(
                fn ($foto) => $foto->store('instituicoes/fotos', 'public'),
                $request->file('fotos'),
            );
        }

        if ($request->has('selos')) {
            $dados['selos'] = collect($request->input('selos', []))
                ->filter(fn ($s) => ! empty(trim($s)))
                ->map(fn ($s) => ['nome' => trim($s)])
                ->values()
                ->all();
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

        if ($request->hasFile('imagem')) {
            $dados['imagem'] = $request->file('imagem')->store('instituicoes', 'public');
        }

        if ($request->hasFile('fotos')) {
            $novasFotos = array_map(
                fn ($foto) => $foto->store('instituicoes/fotos', 'public'),
                $request->file('fotos'),
            );
            $dados['fotos'] = array_merge($instituicao->fotos ?? [], $novasFotos);
        }

        if ($request->has('selos')) {
            $dados['selos'] = collect($request->input('selos', []))
                ->filter(fn ($s) => ! empty(trim($s)))
                ->map(fn ($s) => ['nome' => trim($s)])
                ->values()
                ->all();
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
