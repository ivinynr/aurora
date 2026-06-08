<x-layout.admin titulo="Campanhas">
    <div class="flex items-center justify-between mb-6">
        <p class="text-sm text-bark-500">{{ $campanhas->count() }} campanhas cadastradas</p>
        <x-ui.botao variante="primario" :href="route('admin.campanhas.create')">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Nova Campanha
        </x-ui.botao>
    </div>

    <x-ui.card :hover="false" padding="none">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-cream-200">
                        <th class="text-left text-xs font-semibold text-bark-500 uppercase tracking-wider px-6 py-4">Campanha</th>
                        <th class="text-left text-xs font-semibold text-bark-500 uppercase tracking-wider px-6 py-4">Instituição</th>
                        <th class="text-right text-xs font-semibold text-bark-500 uppercase tracking-wider px-6 py-4">Arrecadado / Meta</th>
                        <th class="text-center text-xs font-semibold text-bark-500 uppercase tracking-wider px-6 py-4">Situação</th>
                        <th class="text-right text-xs font-semibold text-bark-500 uppercase tracking-wider px-6 py-4">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-cream-200">
                    @forelse($campanhas as $campanha)
                        <tr class="hover:bg-cream-100 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-xl bg-cream-200 overflow-hidden shrink-0 flex items-center justify-center">
                                        @if($campanha->imagemUrl())
                                            <img src="{{ $campanha->imagemUrl() }}" class="w-full h-full object-cover">
                                        @else
                                            <span class="font-serif font-bold text-bark-300">{{ mb_substr($campanha->titulo, 0, 1) }}</span>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-semibold text-bark-700 truncate max-w-[220px]">{{ $campanha->titulo }}</p>
                                        @if($campanha->destaque)
                                            <span class="text-xs text-rosa-500 font-medium">★ Em destaque</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-bark-500">{{ $campanha->instituicao->nome }}</td>
                            <td class="px-6 py-4 text-right">
                                <p class="text-sm font-semibold text-bark-700">R$ {{ number_format($campanha->valor_arrecadado, 2, ',', '.') }}</p>
                                <p class="text-xs text-bark-400">de R$ {{ number_format($campanha->meta, 2, ',', '.') }} ({{ number_format($campanha->percentualArrecadado(), 0) }}%)</p>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <x-ui.badge :cor="$campanha->situacao->cor() === 'sage' ? 'sage' : ($campanha->situacao->cor() === 'terra' ? 'rose' : 'slate')">
                                    {{ $campanha->situacao->label() }}
                                </x-ui.badge>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('campanhas.show', $campanha->slug) }}" target="_blank"
                                       class="p-2 rounded-lg text-bark-400 hover:text-terra-500 hover:bg-terra-50 transition-colors" title="Ver no site">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    </a>
                                    <a href="{{ route('admin.campanhas.edit', $campanha) }}"
                                       class="p-2 rounded-lg text-bark-400 hover:text-terra-500 hover:bg-terra-50 transition-colors" title="Editar">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    @if(!$campanha->estaEncerrada())
                                        <form method="POST" action="{{ route('admin.campanhas.encerrar', $campanha) }}" class="inline"
                                              onsubmit="return confirm('Encerrar esta campanha? Ela deixará de aceitar doações.')">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="p-2 rounded-lg text-bark-400 hover:text-honey-400 hover:bg-honey-50 transition-colors" title="Encerrar">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            </button>
                                        </form>
                                    @endif
                                    <form method="POST" action="{{ route('admin.campanhas.destroy', $campanha) }}" class="inline"
                                          onsubmit="return confirm('Tem certeza que deseja remover esta campanha?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg text-bark-400 hover:text-rosa-600 hover:bg-honey-50 transition-colors" title="Remover">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-bark-400">
                                Nenhuma campanha cadastrada. Comece criando uma!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-ui.card>
</x-layout.admin>
