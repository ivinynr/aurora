<x-layout.app titulo="Doação Confirmada">
    <section class="max-w-xl mx-auto px-6 pt-10 pb-24">
        <x-doacao.stepper :etapaAtual="3" />

        <x-ui.card :hover="false" padding="lg">
            <div class="text-center mb-8">
                <div class="w-16 h-16 rounded-full bg-night-800/10 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-night-800" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h1 class="font-serif text-xl font-bold text-bark-800 mb-1">Doação realizada com sucesso!</h1>
                <p class="text-sm text-bark-400">
                    Muito obrigado por sua contribuição. Você acabou de fazer a diferença na vida de alguém. 💛
                </p>
            </div>

            <div class="bg-cream-50 rounded-xl border border-cream-200 p-5 mb-6">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-bark-400">Valor doado</p>
                        <p class="text-lg font-bold text-bark-800">R$ {{ number_format($doacao->valor, 2, ',', '.') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-bark-400">Data</p>
                        <p class="text-sm font-medium text-bark-600">{{ now()->format('d/m/Y - H:i') }}</p>
                    </div>
                </div>
            </div>

            <div class="space-y-2.5 text-sm mb-8">
                <div class="flex justify-between py-2 border-b border-cream-200">
                    <span class="text-bark-400">Campanha</span>
                    <span class="font-medium text-bark-700 text-right">{{ $campanha->titulo }}</span>
                </div>
                <div class="flex justify-between py-2 border-b border-cream-200">
                    <span class="text-bark-400">Doador</span>
                    <span class="font-medium text-bark-700">{{ $doacao->nomeExibicao() }}</span>
                </div>
                @if($doacao->transaction_id)
                    <div class="flex justify-between py-2 border-b border-cream-200">
                        <span class="text-bark-400">Transação</span>
                        <span class="text-xs font-mono text-bark-400">{{ $doacao->transaction_id }}</span>
                    </div>
                @endif
            </div>

            <a href="{{ route('campanhas.show', $campanha->slug) }}"
               class="block w-full py-3.5 text-sm font-semibold text-white bg-night-800 hover:bg-night-700 rounded-xl transition-colors text-center">
                Voltar para a campanha
            </a>
        </x-ui.card>
    </section>
</x-layout.app>
