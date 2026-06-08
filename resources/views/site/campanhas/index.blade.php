<x-layout.app titulo="Campanhas — Aurora">
    <section class="max-w-6xl mx-auto px-6 pt-12 pb-24">
        <div class="text-center mb-10">
            <h1 class="font-serif text-3xl lg:text-4xl font-bold text-night-800 mb-3">Campanhas abertas</h1>
            <p class="text-bark-400">Escolha uma causa e ajude com qualquer valor. Cada doação faz a diferença.</p>
        </div>

        <form method="GET" action="{{ route('campanhas.index') }}" class="mb-10 max-w-lg mx-auto">
            <div class="flex gap-2">
                <input type="text" name="busca" value="{{ request('busca') }}"
                       placeholder="Buscar campanha por título ou descrição..."
                       class="flex-1 px-4 py-3 rounded-xl border border-cream-300 bg-white text-sm text-bark-800 placeholder:text-bark-300 focus:border-terra-300 focus:ring-2 focus:ring-terra-100 transition-colors">
                <button type="submit" class="px-6 py-3 rounded-xl text-sm font-semibold text-white bg-terra-500 hover:bg-terra-600 transition-colors">
                    Buscar
                </button>
            </div>
        </form>

        @if($campanhas->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($campanhas as $campanha)
                    <x-campanha.card :campanha="$campanha" />
                @endforeach
            </div>

            <div class="mt-10">{{ $campanhas->links() }}</div>
        @else
            <div class="text-center py-16">
                <p class="font-serif text-xl text-bark-300 mb-2">Nenhuma campanha encontrada.</p>
                <p class="text-sm text-bark-300">Tente buscar com outros termos ou volte mais tarde.</p>
            </div>
        @endif
    </section>
</x-layout.app>
