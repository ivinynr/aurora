<x-layout.admin :titulo="isset($instituicao) ? 'Editar Instituição' : 'Nova Instituição'">
    <div class="max-w-3xl">
        <a href="{{ route('admin.instituicoes.index') }}" class="inline-flex items-center gap-2 text-sm text-bark-500 hover:text-terra-500 transition-colors mb-6">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Voltar
        </a>

        @if($errors->any())
            <div class="mb-6">
                <x-ui.alerta tipo="erro">
                    Corrija os erros abaixo para continuar.
                </x-ui.alerta>
            </div>
        @endif

        <form method="POST"
              action="{{ isset($instituicao) ? route('admin.instituicoes.update', $instituicao) : route('admin.instituicoes.store') }}"
              enctype="multipart/form-data">
            @csrf
            @if(isset($instituicao))
                @method('PUT')
            @endif

            <x-ui.card :hover="false" padding="lg">
                <h2 class="font-serif text-lg font-bold text-bark-800 mb-6">Informações da Instituição</h2>

                <div class="space-y-5">
                    <x-ui.input label="Nome" nome="nome" :obrigatorio="true" placeholder="Nome da instituição" :valor="$instituicao->nome ?? ''" />
                    <x-ui.input label="Missão" nome="missao" placeholder="Frase curta que define a missão (ex: Transformar vidas através da educação)" :valor="$instituicao->missao ?? ''" />
                    <x-ui.input label="Descrição" nome="descricao" tipo="textarea" :obrigatorio="true" placeholder="Descreva a instituição, o trabalho que realiza e o impacto social..." :valor="$instituicao->descricao ?? ''" />

                    <x-ui.input label="Chave PIX" nome="chave_pix" placeholder="E-mail, CPF/CNPJ ou telefone" dica="Usada como referência da instituição." :valor="$instituicao->chave_pix ?? ''" />

                    <div>
                        <label for="segmento" class="block text-sm font-medium text-bark-700 mb-1.5">Segmento</label>
                        <select name="segmento" id="segmento"
                                class="block w-full px-4 py-3 rounded-xl border border-cream-300 bg-white text-sm text-bark-800 focus:border-terra-300 focus:ring-2 focus:ring-terra-100 transition-colors">
                            <option value="">— Selecione —</option>
                            @foreach(\App\Enums\SegmentoInstituicao::opcoes() as $opcao)
                                <option value="{{ $opcao['valor'] }}" @selected(old('segmento', $instituicao->segmento?->value ?? '') === $opcao['valor'])>
                                    {{ $opcao['label'] }}
                                </option>
                            @endforeach
                        </select>
                        @error('segmento')
                            <p class="text-xs text-terra-500 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </x-ui.card>

            <x-ui.card :hover="false" padding="lg" class="mt-6">
                <h2 class="font-serif text-lg font-bold text-bark-800 mb-6">Contato e Localização</h2>

                <div class="space-y-5">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <x-ui.input label="Telefone" nome="telefone" placeholder="(83) 99999-0000" :valor="$instituicao->telefone ?? ''" />
                        <x-ui.input label="E-mail" nome="email" tipo="email" placeholder="contato@instituicao.org.br" :valor="$instituicao->email ?? ''" />
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <x-ui.input label="Instagram" nome="instagram" placeholder="@perfil" :valor="$instituicao->instagram ?? ''" />
                        <x-ui.input label="Website" nome="website" placeholder="https://..." :valor="$instituicao->website ?? ''" />
                    </div>
                    <x-ui.input label="Endereço" nome="endereco" placeholder="Rua, número, bairro" :valor="$instituicao->endereco ?? ''" />
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <x-ui.input label="Cidade" nome="cidade" placeholder="João Pessoa" :valor="$instituicao->cidade ?? ''" />
                        <x-ui.input label="Estado" nome="estado" placeholder="PB" :valor="$instituicao->estado ?? ''" />
                    </div>
                </div>
            </x-ui.card>

            <x-ui.card :hover="false" padding="lg" class="mt-6">
                <h2 class="font-serif text-lg font-bold text-bark-800 mb-6">Imagem e Situação</h2>

                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-bark-700 mb-1.5">Imagem da instituição</label>
                        @if(isset($instituicao) && $instituicao->logoUrl())
                            <div class="mb-3 w-24 h-24 rounded-xl overflow-hidden bg-cream-200">
                                <img src="{{ $instituicao->logoUrl() }}" class="w-full h-full object-cover">
                            </div>
                        @endif
                        <input type="file" name="imagem" accept="image/*"
                               class="block w-full text-sm text-bark-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-terra-50 file:text-terra-600 hover:file:bg-terra-100">
                        <p class="text-xs text-bark-400 mt-1.5">JPG, PNG ou WebP. Máximo 2MB.</p>
                        @error('imagem')
                            <p class="text-xs text-terra-500 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-bark-700 mb-1.5">Fotos da instituição</label>
                        @if(isset($instituicao) && $instituicao->fotosUrls())
                            <div class="flex gap-2 flex-wrap mb-3">
                                @foreach($instituicao->fotosUrls() as $foto)
                                    <div class="w-20 h-20 rounded-xl overflow-hidden bg-cream-200">
                                        <img src="{{ $foto }}" class="w-full h-full object-cover">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        <input type="file" name="fotos[]" multiple accept="image/*"
                               class="block w-full text-sm text-bark-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-terra-50 file:text-terra-600 hover:file:bg-terra-100">
                        <p class="text-xs text-bark-400 mt-1.5">JPG, PNG ou WebP. Máximo 2MB por imagem. Múltiplas imagens.</p>
                        @error('fotos')
                            <p class="text-xs text-terra-500 font-medium mt-1">{{ $message }}</p>
                        @enderror
                        @error('fotos.*')
                            <p class="text-xs text-terra-500 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div x-data="{ selos: @js(old('selos', array_column($instituicao->selos ?? [], 'nome'))) }">
                        <label class="block text-sm font-medium text-bark-700 mb-1.5">Selos / Reconhecimentos</label>
                        <template x-for="(selo, index) in selos" :key="index">
                            <div class="flex gap-2 mb-2">
                                <input type="text" :name="'selos[' + index + ']'" x-model="selos[index]"
                                       placeholder="Ex: Selo UNESCO, Utilidade Pública..."
                                       class="flex-1 px-4 py-2.5 rounded-xl border border-cream-300 bg-white text-sm text-bark-800 placeholder:text-bark-300 focus:border-terra-300 focus:ring-2 focus:ring-terra-100 transition-colors">
                                <button type="button" @click="selos.splice(index, 1)"
                                        class="px-3 py-2 rounded-xl text-sm text-red-500 hover:bg-red-50 transition-colors">
                                    Remover
                                </button>
                            </div>
                        </template>
                        <button type="button" @click="selos.push('')"
                                class="text-sm text-terra-500 hover:text-terra-600 font-medium transition-colors">
                            + Adicionar selo
                        </button>
                        @error('selos.*')
                            <p class="text-xs text-terra-500 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between p-4 rounded-xl bg-cream-100">
                        <div>
                            <p class="text-sm font-medium text-bark-700">Instituição ativa</p>
                            <p class="text-xs text-bark-400 mt-0.5">Instituições inativas não aparecem no site</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="hidden" name="ativa" value="0">
                            <input type="checkbox" name="ativa" value="1"
                                   {{ old('ativa', $instituicao->ativa ?? true) ? 'checked' : '' }}
                                   class="sr-only peer">
                            <div class="w-11 h-6 bg-bark-300 peer-focus:ring-2 peer-focus:ring-terra-100 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-terra-500"></div>
                        </label>
                    </div>
                </div>
            </x-ui.card>

            <div class="mt-6 flex items-center gap-4">
                <x-ui.botao variante="primario" tamanho="lg" tipo="submit">
                    {{ isset($instituicao) ? 'Salvar Alterações' : 'Cadastrar Instituição' }}
                </x-ui.botao>
                <a href="{{ route('admin.instituicoes.index') }}" class="text-sm text-bark-500 hover:text-bark-700">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</x-layout.admin>
