<x-layout.app titulo="Pagamento PIX">
    <section class="max-w-xl mx-auto px-6 pt-10 pb-24">
        <x-doacao.stepper :etapaAtual="2" />

        <x-ui.card :hover="false" padding="lg">
            <div class="flex items-start justify-between mb-6">
                <div>
                    <h1 class="font-serif text-xl font-bold text-bark-800 mb-1">Escaneie o QR Code</h1>
                    <p class="text-sm text-bark-400">para realizar o pagamento</p>
                </div>
                {{-- PIX logo --}}
                <div class="flex items-center gap-1.5 text-bark-500">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M15.45 17.97l-3.47-3.47a1.32 1.32 0 010-1.86l3.47-3.47c.39-.39.39-1.02 0-1.41l-2.12-2.12a1 1 0 00-1.41 0L8.45 9.11a1.32 1.32 0 01-1.86 0L3.12 5.64a1 1 0 00-1.41 0L.59 6.76a2 2 0 000 2.83l3.47 3.47a1.32 1.32 0 010 1.86L.59 18.39a2 2 0 000 2.83l1.12 1.12a1 1 0 001.41 0l3.47-3.47a1.32 1.32 0 011.86 0l3.47 3.47a1 1 0 001.41 0l2.12-2.12c.39-.39.39-1.02 0-1.41v.16z"/>
                    </svg>
                    <span class="text-xs font-semibold uppercase tracking-wider">pix</span>
                </div>
            </div>

            <p class="text-sm text-bark-400 mb-6">
                Use o aplicativo do seu banco para escanear o código PIX ao lado.
            </p>

            {{-- Value --}}
            <div class="mb-6">
                <p class="text-xs text-bark-400">Valor da doação</p>
                <p class="text-2xl font-bold text-terra-500">R$ {{ number_format($doacao->valor, 2, ',', '.') }}</p>
            </div>

            {{-- QR Code --}}
            <div class="w-56 h-56 mx-auto mb-6 bg-white rounded-xl border border-cream-200 flex items-center justify-center p-3">
                @if(isset($pagamento['qr_code']) && $pagamento['qr_code'])
                    <img src="data:image/png;base64,{{ $pagamento['qr_code'] }}" alt="QR Code PIX" class="w-full h-full">
                @else
                    <div class="text-center">
                        <span class="text-sm text-bark-300">QR Code PIX</span>
                    </div>
                @endif
            </div>

            {{-- Copy code --}}
            @if(isset($pagamento['qr_code_text']))
                <div x-data="{ copiado: false }" class="mb-6">
                    <div class="flex items-center gap-2 bg-cream-50 rounded-xl p-2.5 border border-cream-200">
                        <input type="text" value="{{ $pagamento['qr_code_text'] }}" readonly
                               class="flex-1 bg-transparent text-xs text-bark-500 font-mono truncate border-0 focus:ring-0 p-0">
                        <button type="button"
                                @click="navigator.clipboard.writeText('{{ $pagamento['qr_code_text'] }}'); copiado = true; setTimeout(() => copiado = false, 2000)"
                                class="shrink-0 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors"
                                :class="copiado ? 'bg-sage-100 text-sage-500' : 'bg-night-800 text-white hover:bg-night-700'">
                            <span x-show="!copiado">Copiar código</span>
                            <span x-show="copiado" x-cloak>Copiado!</span>
                        </button>
                    </div>
                </div>
            @endif

            <p class="text-xs text-bark-300 text-right mb-6">Powered by Confrapag</p>

            {{-- Actions --}}
            <div class="space-y-3">
                <a href="{{ route('doacao.confirmar', [$instituicao->slug, $doacao->id]) }}"
                   class="block w-full py-3.5 text-sm font-semibold text-white bg-night-800 hover:bg-night-700 rounded-xl transition-colors text-center">
                    Já paguei, verificar
                </a>
                <a href="{{ route('instituicoes.show', $instituicao->slug) }}"
                   class="block w-full py-3 text-sm font-medium text-bark-400 hover:text-bark-600 text-center transition-colors">
                    Cancelar doação
                </a>
            </div>
        </x-ui.card>
    </section>
</x-layout.app>
