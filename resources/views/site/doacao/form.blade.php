<x-layout.app :titulo="'Doar para ' . $instituicao->nome">
    <section class="max-w-xl mx-auto px-6 pt-10 pb-24">
        <x-doacao.stepper :etapaAtual="1" />

        <x-ui.card :hover="false" padding="lg">
            <div class="text-center mb-8">
                <h1 class="font-serif text-xl font-bold text-bark-800 mb-1">Escolha o valor da sua doação</h1>
                <p class="text-sm text-bark-400">Toda contribuição faz a diferença!</p>
            </div>

            @if($errors->any())
                <div class="mb-6">
                    <x-ui.alerta tipo="erro">Corrija os erros abaixo para continuar.</x-ui.alerta>
                </div>
            @endif

            <form method="POST" action="{{ route('doacao.store', $instituicao->slug) }}"
                  x-data="{
                      valor: '{{ old('valor', '') }}',
                      anonimo: {{ old('anonimo') ? 'true' : 'false' }},
                      custom: false,
                      escolher(v) { this.valor = v; this.custom = false; }
                  }">
                @csrf

                <div class="space-y-6">
                    {{-- Amount buttons --}}
                    <div>
                        <div class="flex flex-wrap gap-2 justify-center mb-4">
                            @foreach([10, 20, 50, 100] as $v)
                                <button type="button" @click="escolher({{ $v }})"
                                    :class="valor == {{ $v }} && !custom
                                        ? 'border-night-800 bg-night-800 text-white'
                                        : 'border-cream-300 text-bark-600 hover:border-night-700'"
                                    class="px-5 py-2.5 rounded-full border text-sm font-semibold transition-all cursor-pointer">
                                    R$ {{ $v }}
                                </button>
                            @endforeach
                            <button type="button" @click="custom = true; valor = ''; $nextTick(() => $refs.customInput.focus())"
                                :class="custom ? 'border-night-800 bg-night-800 text-white' : 'border-cream-300 text-bark-600 hover:border-night-700'"
                                class="px-5 py-2.5 rounded-full border text-sm font-semibold transition-all cursor-pointer">
                                Outro valor
                            </button>
                        </div>

                        <div x-show="custom" x-cloak x-transition class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-bark-400 text-sm font-medium">R$</span>
                            <input type="number" x-ref="customInput" x-model="valor"
                                   placeholder="Digite o valor" min="5" step="0.01"
                                   class="w-full pl-10 pr-4 py-3 rounded-xl border border-cream-300 text-sm font-semibold text-bark-800 focus:border-night-700 focus:ring-2 focus:ring-night-800/10 transition-colors">
                        </div>

                        <input type="hidden" name="valor" :value="valor">

                        @error('valor')<p class="text-xs text-terra-500 mt-2 text-center">{{ $message }}</p>@enderror

                        <p class="text-xs text-bark-300 text-center mt-3">
                            Você será direcionado para o pagamento via PIX.
                        </p>
                    </div>

                    <div class="border-t border-cream-200"></div>

                    {{-- Personal info --}}
                    <div class="space-y-4">
                        <x-ui.input label="Seu nome" nome="nome_doador" placeholder="Como você quer ser identificado" :obrigatorio="true" />
                        <x-ui.input label="E-mail (opcional)" nome="email_doador" tipo="email" placeholder="Para receber o comprovante" />

                        <div class="flex items-center justify-between py-3 px-4 rounded-xl bg-cream-50 border border-cream-200">
                            <div>
                                <p class="text-sm font-medium text-bark-700">Doação anônima</p>
                                <p class="text-xs text-bark-400">Seu nome não aparecerá publicamente</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="anonimo" value="1" x-model="anonimo" class="sr-only peer">
                                <div class="w-10 h-5 bg-cream-300 rounded-full peer peer-checked:bg-night-800 peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                            </label>
                        </div>

                        <x-ui.input label="Mensagem (opcional)" nome="mensagem" tipo="textarea" placeholder="Deixe uma mensagem de apoio..." />
                    </div>

                    {{-- Submit --}}
                    <button type="submit" class="w-full py-3.5 text-sm font-semibold text-white bg-night-800 hover:bg-night-700 rounded-xl transition-colors">
                        Continuar
                    </button>
                </div>
            </form>
        </x-ui.card>

        <p class="text-center text-xs text-bark-300 mt-4">
            Doação para <span class="font-medium text-bark-500">{{ $instituicao->nome }}</span>
        </p>
    </section>
</x-layout.app>
