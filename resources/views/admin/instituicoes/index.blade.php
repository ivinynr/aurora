<x-layout.admin titulo="Instituições">
    <div class="flex items-center justify-between mb-6">
        <p class="text-sm text-bark-500">{{ $instituicoes->count() }} instituições cadastradas</p>
        <x-ui.botao variante="primario" :href="route('admin.instituicoes.create')">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Nova Instituição
        </x-ui.botao>
    </div>

    <x-ui.card :hover="false" padding="none">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-cream-200">
                        <th class="text-left text-xs font-semibold text-bark-500 uppercase tracking-wider px-6 py-4">Instituição</th>
                        <th class="text-left text-xs font-semibold text-bark-500 uppercase tracking-wider px-6 py-4">Cidade</th>
                        <th class="text-center text-xs font-semibold text-bark-500 uppercase tracking-wider px-6 py-4">Campanhas</th>
                        <th class="text-center text-xs font-semibold text-bark-500 uppercase tracking-wider px-6 py-4">Situação</th>
                        <th class="text-right text-xs font-semibold text-bark-500 uppercase tracking-wider px-6 py-4">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-cream-200">
                    @forelse($instituicoes as $instituicao)
                        <tr class="hover:bg-cream-100 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-terra-50 flex items-center justify-center text-terra-500 font-bold text-sm shrink-0">
                                        {{ strtoupper(substr($instituicao->nome, 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-bark-700">{{ $instituicao->nome }}</p>
                                        <p class="text-xs text-bark-400">{{ $instituicao->email ?? '—' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-bark-500">{{ $instituicao->cidade ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm font-semibold text-bark-700 text-center">{{ $instituicao->campanhas_count ?? 0 }}</td>
                            <td class="px-6 py-4 text-center">
                                @if($instituicao->ativa)
                                    <x-ui.badge cor="sage">Ativa</x-ui.badge>
                                @else
                                    <x-ui.badge cor="bark">Inativa</x-ui.badge>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.instituicoes.edit', $instituicao) }}"
                                       class="p-2 rounded-lg text-bark-400 hover:text-terra-500 hover:bg-terra-50 transition-colors"
                                       title="Editar">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.instituicoes.destroy', $instituicao) }}" class="inline"
                                          onsubmit="return confirm('Tem certeza que deseja remover esta instituição?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-lg text-bark-400 hover:text-terra-600 hover:bg-terra-50 transition-colors" title="Remover">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-bark-400">
                                Nenhuma instituição cadastrada. Comece adicionando uma!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-ui.card>
</x-layout.admin>
