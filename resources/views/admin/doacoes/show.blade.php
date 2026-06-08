<x-layout.admin titulo="Detalhes da Doação">
    <div class="max-w-2xl">
        <a href="{{ route('admin.doacoes.index') }}" class="inline-flex items-center gap-2 text-sm text-bark-500 hover:text-terra-500 transition-colors mb-6">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Voltar
        </a>

        <x-ui.card :hover="false" padding="lg">
            <div class="text-center pb-6 border-b border-cream-200 mb-6">
                <p class="text-sm text-bark-500">Valor da doação</p>
                <p class="text-4xl font-extrabold text-terra-500 font-serif mt-1">R$ {{ number_format($doacao->valor, 2, ',', '.') }}</p>
            </div>

            <div class="space-y-4">
                <div class="flex items-center justify-between py-2 border-b border-cream-100">
                    <span class="text-sm text-bark-500">Doador</span>
                    <span class="text-sm font-semibold text-bark-700">{{ $doacao->nomeExibicao() }}</span>
                </div>
                @if($doacao->email_doador)
                    <div class="flex items-center justify-between py-2 border-b border-cream-100">
                        <span class="text-sm text-bark-500">E-mail</span>
                        <span class="text-sm text-bark-700">{{ $doacao->email_doador }}</span>
                    </div>
                @endif
                <div class="flex items-center justify-between py-2 border-b border-cream-100">
                    <span class="text-sm text-bark-500">Campanha</span>
                    <span class="text-sm font-semibold text-bark-700 text-right">{{ $doacao->campanha->titulo }}</span>
                </div>
                <div class="flex items-center justify-between py-2 border-b border-cream-100">
                    <span class="text-sm text-bark-500">Instituição</span>
                    <span class="text-sm text-bark-700 text-right">{{ $doacao->campanha->instituicao->nome }}</span>
                </div>
                <div class="flex items-center justify-between py-2 border-b border-cream-100">
                    <span class="text-sm text-bark-500">Situação</span>
                    @php
                        $corSituacao = match($doacao->situacao->value) {
                            'confirmada' => 'sage',
                            'pendente' => 'honey',
                            'expirada' => 'bark',
                            'cancelada' => 'bark',
                            default => 'bark',
                        };
                    @endphp
                    <x-ui.badge :cor="$corSituacao">{{ $doacao->situacao->label() }}</x-ui.badge>
                </div>
                <div class="flex items-center justify-between py-2 border-b border-cream-100">
                    <span class="text-sm text-bark-500">Anônima</span>
                    <span class="text-sm text-bark-700">{{ $doacao->anonimo ? 'Sim' : 'Não' }}</span>
                </div>
                <div class="flex items-center justify-between py-2 border-b border-cream-100">
                    <span class="text-sm text-bark-500">Data</span>
                    <span class="text-sm text-bark-700">{{ $doacao->created_at->format('d/m/Y H:i:s') }}</span>
                </div>
                @if($doacao->transaction_id)
                    <div class="flex items-center justify-between py-2 border-b border-cream-100">
                        <span class="text-sm text-bark-500">ID da Transação</span>
                        <span class="text-xs font-mono text-bark-400">{{ $doacao->transaction_id }}</span>
                    </div>
                @endif
                @if($doacao->mensagem)
                    <div class="py-2">
                        <p class="text-sm text-bark-500 mb-1">Mensagem</p>
                        <p class="text-sm text-bark-700 bg-cream-100 rounded-xl p-4">"{{ $doacao->mensagem }}"</p>
                    </div>
                @endif
            </div>
        </x-ui.card>

        @if($doacao->transacoes->isNotEmpty())
            <x-ui.card :hover="false" padding="lg" class="mt-6">
                <h2 class="font-serif text-lg font-bold text-bark-800 mb-4">Transações de pagamento</h2>
                <div class="space-y-3">
                    @foreach($doacao->transacoes as $transacao)
                        <div class="p-4 rounded-xl bg-cream-100 text-sm">
                            <div class="flex items-center justify-between mb-1">
                                <span class="font-mono text-xs text-bark-500">{{ $transacao->transaction_id ?? '—' }}</span>
                                <x-ui.badge :cor="$transacao->status === 'confirmada' ? 'sage' : 'honey'">{{ ucfirst($transacao->status) }}</x-ui.badge>
                            </div>
                            <div class="flex items-center justify-between text-xs text-bark-400">
                                <span>Gateway: {{ $transacao->gateway }}</span>
                                <span>{{ $transacao->pago_em ? 'Pago em ' . $transacao->pago_em->format('d/m/Y H:i') : 'Criada em ' . $transacao->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </x-ui.card>
        @endif
    </div>
</x-layout.admin>
