<x-layout.app :titulo="$instituicao->nome . ' — Aurora'">

    {{-- Hero: Video or Image --}}
    <div class="relative bg-night-800 overflow-hidden">
        @if($instituicao->video_url)
            @php
                preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $instituicao->video_url, $matches);
                $youtubeId = $matches[1] ?? null;
            @endphp
            @if($youtubeId)
                <div class="aspect-video max-h-[70vh] w-full">
                    <iframe src="https://www.youtube.com/embed/{{ $youtubeId }}?rel=0&modestbranding=1&autoplay=1&mute=1"
                            class="w-full h-full" frameborder="0"
                            allow="autoplay; encrypted-media" allowfullscreen></iframe>
                </div>
            @endif
        @elseif($instituicao->imagem)
            <div class="aspect-[21/9] max-h-[50vh] w-full relative">
                <img src="{{ Storage::url($instituicao->imagem) }}" alt="{{ $instituicao->nome }}"
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-bark-900/60 to-transparent"></div>
            </div>
        @else
            <div class="h-6"></div>
        @endif
    </div>

    <section class="max-w-4xl mx-auto px-6 pt-10 pb-24">
        {{-- Back --}}
        <a href="{{ route('instituicoes.index') }}" class="inline-flex items-center gap-1.5 text-sm text-bark-400 hover:text-bark-600 transition-colors mb-8">
            &larr; Voltar
        </a>

        {{-- Header --}}
        <div class="mb-10">
            <h1 class="font-serif text-3xl lg:text-5xl font-bold text-bark-800 leading-tight mb-3">{{ $instituicao->nome }}</h1>
            @if($instituicao->missao)
                <p class="text-xl text-bark-400 italic font-serif">"{{ $instituicao->missao }}"</p>
            @endif
            @if($instituicao->cidade)
                <p class="text-sm text-bark-300 mt-3">{{ $instituicao->cidade }}, {{ $instituicao->estado }}</p>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            {{-- Story --}}
            <div class="lg:col-span-2 space-y-10">
                {{-- Description as narrative --}}
                <div class="text-bark-600 leading-relaxed text-[16px] space-y-4 font-light">
                    {!! nl2br(e($instituicao->descricao)) !!}
                </div>

                {{-- Contact --}}
                @if($instituicao->instagram || $instituicao->telefone || $instituicao->email)
                    <div class="border-t border-cream-200 pt-6">
                        <p class="text-xs text-bark-300 uppercase tracking-wider font-semibold mb-3">Contato</p>
                        <div class="space-y-1.5">
                            @if($instituicao->telefone)
                                <p class="text-sm text-bark-500">{{ $instituicao->telefone }}</p>
                            @endif
                            @if($instituicao->email)
                                <p class="text-sm text-bark-500">{{ $instituicao->email }}</p>
                            @endif
                            @if($instituicao->instagram)
                                <p class="text-sm text-bark-500">{{ $instituicao->instagram }}</p>
                            @endif
                            @if($instituicao->website)
                                <p class="text-sm text-bark-500">{{ $instituicao->website }}</p>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- Updates as timeline / stories --}}
                @if($instituicao->atualizacoes->isNotEmpty())
                    <div class="border-t border-cream-200 pt-6">
                        <p class="text-xs text-bark-300 uppercase tracking-wider font-semibold mb-5">Histórias e atualizações</p>
                        <div class="space-y-6">
                            @foreach($instituicao->atualizacoes as $att)
                                <div class="relative pl-6 border-l-2 border-cream-300">
                                    <div class="absolute left-[-5px] top-1 w-2 h-2 rounded-full bg-terra-400"></div>
                                    <h3 class="font-serif font-bold text-bark-800">{{ $att->titulo }}</h3>
                                    <p class="text-sm text-bark-500 mt-1 leading-relaxed">{{ $att->descricao }}</p>
                                    <p class="text-xs text-bark-300 mt-2">{{ $att->created_at->diffForHumans() }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <div class="space-y-6">
                {{-- Donate card --}}
                <div class="bg-white rounded-xl shadow-warm border border-cream-200 p-6">
                    <p class="font-serif text-lg font-bold text-bark-800 mb-1">Apoie esta causa</p>
                    <p class="text-sm text-bark-400 mb-5 leading-relaxed">
                        Sua contribuição ajuda diretamente quem mais precisa. Não existe valor pequeno.
                    </p>
                    <a href="{{ route('doacao.create', $instituicao->slug) }}"
                       class="block w-full py-3.5 text-sm font-semibold text-white bg-terra-500 hover:bg-terra-600 rounded-xl transition-colors text-center">
                        Fazer uma doação
                    </a>
                </div>

                {{-- Recent supporters --}}
                @if($instituicao->doacoes->isNotEmpty())
                    <div class="bg-white rounded-xl shadow-warm border border-cream-200 p-6">
                        <p class="text-xs text-bark-300 uppercase tracking-wider font-semibold mb-4">Apoiadores recentes</p>
                        <x-instituicao.mural-apoiadores :doacoes="$instituicao->doacoes" />
                    </div>
                @endif
            </div>
        </div>
    </section>
</x-layout.app>
