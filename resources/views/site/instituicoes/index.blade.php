<x-layout.app titulo="Instituições — Aurora">
    <section class="max-w-5xl mx-auto px-6 pt-12 pb-24">
        <div class="text-center mb-12">
            <h1 class="font-serif text-3xl font-bold text-bark-800 mb-3">Instituições</h1>
            <p class="text-bark-400">Conheça quem está fazendo a diferença.</p>
        </div>

        <form method="GET" action="{{ route('instituicoes.index') }}" class="mb-10 max-w-lg mx-auto">
            <div class="flex gap-2">
                <input type="text" name="busca" value="{{ request('busca') }}"
                       placeholder="Buscar por nome ou cidade..."
                       class="flex-1 px-4 py-2.5 rounded-xl border border-cream-300 bg-white text-sm text-bark-800 placeholder:text-bark-300 focus:border-terra-300 focus:ring-2 focus:ring-terra-100 transition-colors">
                <button type="submit" class="px-5 py-2.5 rounded-xl text-sm font-medium text-white bg-terra-500 hover:bg-terra-600 transition-colors">
                    Buscar
                </button>
            </div>
        </form>

        @if($instituicoes->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($instituicoes as $instituicao)
                    <x-instituicao.card :instituicao="$instituicao" />
                @endforeach
            </div>

            <div class="mt-10">{{ $instituicoes->withQueryString()->links() }}</div>
        @else
            <div class="text-center py-16">
                <p class="font-serif text-xl text-bark-300 mb-2">Nenhuma instituição encontrada.</p>
                <p class="text-sm text-bark-300">Tente buscar com outros termos.</p>
            </div>
        @endif
    </section>
</x-layout.app>
