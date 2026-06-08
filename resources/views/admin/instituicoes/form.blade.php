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
                <h2 class="font-serif text-lg font-bold text-bark-800 mb-6">Logo e Situação</h2>

                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-bark-700 mb-1.5">Logo da instituição</label>
                        @if(isset($instituicao) && $instituicao->logoUrl())
                            <div class="mb-3 w-24 h-24 rounded-xl overflow-hidden bg-cream-200">
                                <img src="{{ $instituicao->logoUrl() }}" class="w-full h-full object-cover">
                            </div>
                        @endif
                        <input type="file" name="logo" accept="image/*"
                               class="block w-full text-sm text-bark-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-terra-50 file:text-terra-600 hover:file:bg-terra-100">
                        <p class="text-xs text-bark-400 mt-1.5">JPG, PNG ou WebP. Máximo 2MB.</p>
                        @error('logo')
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
