<x-layout.admin titulo="Doações">
    {{-- Filters --}}
    <form method="GET" action="{{ route('admin.doacoes.index') }}" class="mb-6">
        <div class="flex flex-wrap gap-3">
            <select name="campanha_id" class="px-4 py-2.5 rounded-xl border border-cream-300 text-sm bg-white text-bark-800 focus:border-terra-300 focus:ring-2 focus:ring-terra-100">
                <option value="">Todas as campanhas</option>
                @foreach($campanhas as $camp)
                    <option value="{{ $camp->id }}" {{ request('campanha_id') == $camp->id ? 'selected' : '' }}>
                        {{ $camp->titulo }}
                    </option>
                @endforeach
            </select>

            <select name="situacao" class="px-4 py-2.5 rounded-xl border border-cream-300 text-sm bg-white text-bark-800 focus:border-terra-300 focus:ring-2 focus:ring-terra-100">
                <option value="">Todas as situações</option>
                @foreach(\App\Enums\SituacaoDoacao::cases() as $sit)
                    <option value="{{ $sit->value }}" {{ request('situacao') === $sit->value ? 'selected' : '' }}>
                        {{ $sit->label() }}
                    </option>
                @endforeach
            </select>

            <x-ui.botao variante="primario" tamanho="sm" tipo="submit">Filtrar</x-ui.botao>
        </div>
    </form>

    <x-ui.card :hover="false" padding="none">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-cream-200">
                        <th class="text-left text-xs font-semibold text-bark-500 uppercase tracking-wider px-6 py-4">Doador</th>
                        <th class="text-left text-xs font-semibold text-bark-500 uppercase tracking-wider px-6 py-4">Campanha</th>
                        <th class="text-right text-xs font-semibold text-bark-500 uppercase tracking-wider px-6 py-4">Valor</th>
                        <th class="text-center text-xs font-semibold text-bark-500 uppercase tracking-wider px-6 py-4">Situação</th>
                        <th class="text-right text-xs font-semibold text-bark-500 uppercase tracking-wider px-6 py-4">Data</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-cream-200">
                    @forelse($doacoes as $doacao)
                        <tr class="hover:bg-cream-100 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full flex items-center justify-center text-xs font-bold shrink-0
                                        {{ $doacao->anonimo ? 'bg-cream-200 text-bark-400' : 'bg-terra-50 text-terra-500' }}">
                                        {{ strtoupper(substr($doacao->nomeExibicao(), 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-bark-700">{{ $doacao->nomeExibicao() }}</p>
                                        @if($doacao->email_doador)
                                            <p class="text-xs text-bark-400">{{ $doacao->email_doador }}</p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-bark-500">{{ $doacao->campanha->titulo }}</td>
                            <td class="px-6 py-4 text-sm font-bold text-bark-700 text-right">R$ {{ number_format($doacao->valor, 2, ',', '.') }}</td>
                            <td class="px-6 py-4 text-center">
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
                            </td>
                            <td class="px-6 py-4 text-sm text-bark-500 text-right">{{ $doacao->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-bark-400">
                                Nenhuma doação encontrada.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($doacoes->hasPages())
            <div class="p-6 border-t border-cream-200">
                {{ $doacoes->withQueryString()->links() }}
            </div>
        @endif
    </x-ui.card>
</x-layout.admin>
