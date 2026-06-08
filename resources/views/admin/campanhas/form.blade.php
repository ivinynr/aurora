<x-layout.admin :titulo="isset($campanha) ? 'Editar Campanha' : 'Nova Campanha'">
    <div class="max-w-3xl">
        <a href="{{ route('admin.campanhas.index') }}" class="inline-flex items-center gap-2 text-sm text-bark-500 hover:text-terra-500 transition-colors mb-6">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
            Voltar
        </a>

        @if($errors->any())
            <div class="mb-6"><x-ui.alerta tipo="erro">Corrija os erros abaixo para continuar.</x-ui.alerta></div>
        @endif

        <form method="POST"
              action="{{ isset($campanha) ? route('admin.campanhas.update', $campanha) : route('admin.campanhas.store') }}"
              enctype="multipart/form-data">
            @csrf
            @isset($campanha) @method('PUT') @endisset

            <x-ui.card :hover="false" padding="lg">
                <h2 class="font-serif text-lg font-bold text-bark-800 mb-6">Informações da Campanha</h2>
                <div class="space-y-5">
                    <div>
                        <label for="instituicao_id" class="block text-sm font-medium text-bark-700 mb-1.5">Instituição <span class="text-terra-400">*</span></label>
                        <select name="instituicao_id" id="instituicao_id" required
                                class="block w-full px-4 py-3 rounded-xl border border-cream-300 bg-white text-bark-800 text-sm focus:border-terra-300 focus:ring-2 focus:ring-terra-100">
                            <option value="">Selecione a instituição responsável</option>
                            @foreach($instituicoes as $inst)
                                <option value="{{ $inst->id }}" {{ (string) old('instituicao_id', $campanha->instituicao_id ?? '') === (string) $inst->id ? 'selected' : '' }}>
                                    {{ $inst->nome }}
                                </option>
                            @endforeach
                        </select>
                        @error('instituicao_id')<p class="text-xs text-terra-500 font-medium mt-1">{{ $message }}</p>@enderror
                    </div>

                    <x-ui.input label="Título" nome="titulo" :obrigatorio="true" placeholder="Ex: Cestas básicas para 100 famílias" :valor="$campanha->titulo ?? ''" />
                    <x-ui.input label="Resumo" nome="resumo" :obrigatorio="true" placeholder="Uma frase curta que aparece nos cards (até 255 caracteres)" :valor="$campanha->resumo ?? ''" />
                    <x-ui.input label="Descrição completa" nome="descricao" tipo="textarea" :obrigatorio="true" placeholder="Conte a história da campanha, o objetivo e o impacto esperado..." :valor="$campanha->descricao ?? ''" />

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <x-ui.input label="Meta de arrecadação (R$)" nome="meta" tipo="number" :obrigatorio="true" placeholder="0.00" :valor="$campanha->meta ?? ''" />
                        <div>
                            <label for="situacao" class="block text-sm font-medium text-bark-700 mb-1.5">Situação <span class="text-terra-400">*</span></label>
                            <select name="situacao" id="situacao" required
                                    class="block w-full px-4 py-3 rounded-xl border border-cream-300 bg-white text-bark-800 text-sm focus:border-terra-300 focus:ring-2 focus:ring-terra-100">
                                @foreach(\App\Enums\SituacaoCampanha::opcoes() as $opcao)
                                    <option value="{{ $opcao['valor'] }}" {{ old('situacao', $campanha->situacao->value ?? 'rascunho') === $opcao['valor'] ? 'selected' : '' }}>
                                        {{ $opcao['label'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </x-ui.card>

            <x-ui.card :hover="false" padding="lg" class="mt-6">
                <h2 class="font-serif text-lg font-bold text-bark-800 mb-6">Mídia e Período</h2>
                <div class="space-y-5">
                    <x-ui.input label="Vídeo (YouTube)" nome="video_url" placeholder="https://www.youtube.com/watch?v=..." dica="Aparece como cabeçalho na página da campanha." :valor="$campanha->video_url ?? ''" />

                    <div>
                        <label class="block text-sm font-medium text-bark-700 mb-1.5">Imagem de capa</label>
                        @if(isset($campanha) && $campanha->imagemUrl())
                            <div class="mb-3 w-40 h-24 rounded-lg overflow-hidden bg-cream-200">
                                <img src="{{ $campanha->imagemUrl() }}" class="w-full h-full object-cover">
                            </div>
                        @endif
                        <input type="file" name="imagem" accept="image/*"
                               class="block w-full text-sm text-bark-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-terra-50 file:text-terra-600 hover:file:bg-terra-100">
                        <p class="text-xs text-bark-400 mt-1.5">JPG, PNG ou WebP. Máximo 2MB.</p>
                        @error('imagem')<p class="text-xs text-terra-500 font-medium mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <x-ui.input label="Data de início" nome="data_inicio" tipo="date" :valor="isset($campanha) && $campanha->data_inicio ? $campanha->data_inicio->format('Y-m-d') : ''" />
                        <x-ui.input label="Data de término" nome="data_fim" tipo="date" :valor="isset($campanha) && $campanha->data_fim ? $campanha->data_fim->format('Y-m-d') : ''" />
                    </div>

                    <div class="flex items-center justify-between p-4 rounded-xl bg-cream-100">
                        <div>
                            <p class="text-sm font-medium text-bark-700">Campanha em destaque</p>
                            <p class="text-xs text-bark-400 mt-0.5">Aparece em primeiro lugar na home</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="hidden" name="destaque" value="0">
                            <input type="checkbox" name="destaque" value="1" {{ old('destaque', $campanha->destaque ?? false) ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-11 h-6 bg-bark-300 peer-focus:ring-2 peer-focus:ring-terra-100 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-terra-500"></div>
                        </label>
                    </div>
                </div>
            </x-ui.card>

            <div class="mt-6 flex items-center gap-4">
                <x-ui.botao variante="primario" tamanho="lg" tipo="submit">
                    {{ isset($campanha) ? 'Salvar Alterações' : 'Criar Campanha' }}
                </x-ui.botao>
                <a href="{{ route('admin.campanhas.index') }}" class="text-sm text-bark-500 hover:text-bark-700">Cancelar</a>
            </div>
        </form>

        {{-- Atualizações (somente na edição) --}}
        @isset($campanha)
            <x-ui.card :hover="false" padding="lg" class="mt-8">
                <h2 class="font-serif text-lg font-bold text-bark-800 mb-1">Atualizações da campanha</h2>
                <p class="text-sm text-bark-400 mb-6">Publique notícias, fotos e resultados para os doadores.</p>

                <form method="POST" action="{{ route('admin.atualizacoes.store', $campanha) }}" enctype="multipart/form-data" class="space-y-4 mb-8 pb-8 border-b border-cream-200">
                    @csrf
                    <x-ui.input label="Título" nome="titulo" :obrigatorio="true" placeholder="Ex: Entregamos 50 cestas hoje!" />
                    <x-ui.input label="Descrição" nome="descricao" tipo="textarea" :obrigatorio="true" placeholder="Conte o que aconteceu..." />
                    <div>
                        <label class="block text-sm font-medium text-bark-700 mb-1.5">Imagem (opcional)</label>
                        <input type="file" name="imagem" accept="image/*"
                               class="block w-full text-sm text-bark-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-terra-50 file:text-terra-600 hover:file:bg-terra-100">
                    </div>
                    <x-ui.botao variante="secundario" tipo="submit">Publicar atualização</x-ui.botao>
                </form>

                <div class="space-y-4">
                    @forelse($campanha->atualizacoes()->latest()->get() as $att)
                        <div class="flex items-start justify-between gap-4 p-4 rounded-xl bg-cream-100">
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-bark-700">{{ $att->titulo }}</p>
                                <p class="text-xs text-bark-400 mt-0.5">{{ $att->created_at->format('d/m/Y H:i') }}</p>
                                <p class="text-sm text-bark-500 mt-2 line-clamp-2">{{ $att->descricao }}</p>
                            </div>
                            <form method="POST" action="{{ route('admin.atualizacoes.destroy', $att) }}"
                                  onsubmit="return confirm('Remover esta atualização?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 rounded-lg text-bark-400 hover:text-rosa-600 hover:bg-honey-50 transition-colors" title="Remover">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    @empty
                        <p class="text-sm text-bark-400">Nenhuma atualização publicada ainda.</p>
                    @endforelse
                </div>
            </x-ui.card>
        @endisset
    </div>
</x-layout.admin>
