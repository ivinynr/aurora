<x-layout.app titulo="Aurora">

    {{-- Hero --}}
    <section class="bg-cream-50">
        <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-2 min-h-[420px]">
            {{-- Texto --}}
            <div class="flex flex-col justify-center gap-5 px-8 py-14 lg:py-16 lg:px-12">
                @if($estatisticas['total_doadores'] > 0)
                    <div class="flex items-center gap-2 bg-white border border-cream-200 rounded-full px-4 py-1.5 w-fit text-xs text-rosa-500 font-medium">
                        <span class="w-1.5 h-1.5 rounded-full bg-rosa-500"></span>
                        {{ $estatisticas['total_doadores'] }} {{ $estatisticas['total_doadores'] === 1 ? 'doador' : 'doadores' }} na plataforma
                    </div>
                @endif

                <h1 class="font-serif text-3xl sm:text-4xl font-bold text-night-800 leading-tight">
                    Às vezes, um pequeno gesto
                    <em class="text-rosa-500 block">muda uma vida inteira.</em>
                </h1>

                <p class="text-bark-400 text-[15px] leading-relaxed max-w-sm">
                    Conectamos pessoas que querem ajudar com instituições que precisam de apoio real. Cada doação tem nome, rosto e história.
                </p>

                <div class="flex gap-7 mt-1">
                    <div class="border-l-2 border-cream-200 pl-3.5">
                        <p class="text-xl font-medium text-night-800">{{ $instituicoes->count() }}</p>
                        <p class="text-xs text-bark-300">instituições</p>
                    </div>
                    <div class="border-l-2 border-cream-200 pl-3.5">
                        <p class="text-xl font-medium text-night-800">{{ $estatisticas['total_doacoes'] }}</p>
                        <p class="text-xs text-bark-300">doações</p>
                    </div>
                    <div class="border-l-2 border-cream-200 pl-3.5">
                        <p class="text-xl font-medium text-night-800">R$ {{ number_format($estatisticas['total_doado'], 0, ',', '.') }}</p>
                        <p class="text-xs text-bark-300">arrecadados</p>
                    </div>
                </div>

                <a href="{{ route('instituicoes.index') }}"
                   class="flex items-center gap-2 bg-rosa-500 hover:bg-rosa-600 text-white rounded-lg px-5 py-3 text-sm font-medium w-fit transition-colors mt-1">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    Escolher uma instituição
                </a>
            </div>

            {{-- Grid de fotos reais --}}
            <div class="hidden lg:grid grid-cols-2 gap-0.5 overflow-hidden">
                @php
                    $comImagem = $instituicoes->filter(fn($i) => $i->imagem)->take(3);
                @endphp

                @if($comImagem->count() >= 1)
                    <div class="row-span-2 relative overflow-hidden">
                        <img src="{{ Storage::url($comImagem->first()->imagem) }}" alt="{{ $comImagem->first()->nome }}"
                             class="w-full h-full object-cover">
                        <span class="absolute bottom-3 left-3 bg-white/90 text-night-800 text-[11px] font-medium px-2.5 py-1 rounded-full">
                            {{ $comImagem->first()->nome }} · {{ $comImagem->first()->estado }}
                        </span>
                    </div>
                @endif

                @foreach($comImagem->skip(1)->take(2) as $inst)
                    <div class="relative overflow-hidden">
                        <img src="{{ Storage::url($inst->imagem) }}" alt="{{ $inst->nome }}"
                             class="w-full h-full object-cover">
                        <span class="absolute bottom-3 left-3 bg-white/90 text-night-800 text-[11px] font-medium px-2.5 py-1 rounded-full">
                            {{ $inst->nome }} · {{ $inst->estado }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Faixa de impacto --}}
    <section class="bg-night-800">
        <div class="max-w-6xl mx-auto px-8 py-8 grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="text-center">
                <p class="text-2xl font-medium text-cream-50">{{ $instituicoes->count() }} <span class="text-sm text-rosa-500">ONGs</span></p>
                <p class="text-xs text-sage-400 mt-1">na plataforma</p>
            </div>
            <div class="text-center">
                <p class="text-2xl font-medium text-cream-50">{{ $estatisticas['total_doacoes'] }} <span class="text-sm text-rosa-500">doações</span></p>
                <p class="text-xs text-sage-400 mt-1">realizadas</p>
            </div>
            <div class="text-center">
                <p class="text-2xl font-medium text-cream-50">R$ {{ number_format($estatisticas['total_doado'], 0, ',', '.') }}</p>
                <p class="text-xs text-sage-400 mt-1">arrecadados</p>
            </div>
            <div class="text-center">
                <p class="text-2xl font-medium text-cream-50">{{ $estatisticas['total_doadores'] }} <span class="text-sm text-rosa-500">pessoas</span></p>
                <p class="text-xs text-sage-400 mt-1">já doaram</p>
            </div>
        </div>
    </section>

    {{-- Instituições --}}
    <section class="bg-cream-50 py-14 lg:py-20">
        <div class="max-w-6xl mx-auto px-8">
            <p class="text-[11px] text-rosa-500 font-medium uppercase tracking-wider mb-1">Perto de você</p>
            <h2 class="font-serif text-2xl font-bold text-night-800">Instituições que precisam do seu apoio agora</h2>
            <p class="text-sm text-bark-300 mt-1.5 mb-8">Cada uma com uma história real. Escolha uma e faça parte dela.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($instituicoes as $instituicao)
                    <a href="{{ route('instituicoes.show', $instituicao->slug) }}"
                       class="group bg-white rounded-2xl border border-cream-200 overflow-hidden card-lift block">

                        <div class="h-44 bg-cream-200 relative overflow-hidden">
                            @if($instituicao->imagem)
                                <img src="{{ Storage::url($instituicao->imagem) }}" alt="{{ $instituicao->nome }}"
                                     class="w-full h-full object-cover group-hover:scale-[1.02] transition-transform duration-700">
                            @else
                                <div class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-cream-200 to-cream-300">
                                    <span class="font-serif text-4xl font-bold text-bark-200">{{ mb_substr($instituicao->nome, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="p-5">
                            <h3 class="font-serif text-[15px] font-bold text-night-800 mb-2 group-hover:text-rosa-500 transition-colors">
                                {{ $instituicao->nome }}
                            </h3>

                            @if($instituicao->missao)
                                <p class="text-[13px] text-bark-400 italic border-l-2 border-cream-200 pl-2.5 mb-4 line-clamp-2">
                                    "{{ $instituicao->missao }}"
                                </p>
                            @else
                                <p class="text-[13px] text-bark-400 border-l-2 border-cream-200 pl-2.5 mb-4 line-clamp-2">
                                    {{ $instituicao->descricao }}
                                </p>
                            @endif

                            <div class="flex items-center justify-between">
                                <div>
                                    @if($instituicao->cidade)
                                        <p class="text-xs text-bark-300 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            {{ $instituicao->cidade }}, {{ $instituicao->estado }}
                                        </p>
                                    @endif
                                    @if($instituicao->valor_arrecadado > 0)
                                        <p class="text-xs text-rosa-500 font-medium mt-1 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            R$ {{ number_format($instituicao->valor_arrecadado, 0, ',', '.') }} arrecadados
                                        </p>
                                    @endif
                                </div>
                                <span class="flex items-center gap-1.5 bg-night-800 text-white text-[13px] font-medium rounded-md px-3.5 py-1.5 group-hover:bg-night-700 transition-colors">
                                    Apoiar
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            @if($instituicoes->isEmpty())
                <div class="text-center py-20">
                    <p class="font-serif text-xl text-bark-300">Nenhuma instituição cadastrada ainda.</p>
                </div>
            @endif
        </div>
    </section>

    {{-- Depoimentos / Últimas doações --}}
    @if($ultimasDoacoes->isNotEmpty())
        <section class="bg-white border-t border-cream-200">
            <div class="max-w-6xl mx-auto px-8 py-14 lg:py-20 grid grid-cols-1 lg:grid-cols-3 gap-12 items-start">
                <div>
                    <p class="text-[11px] text-rosa-500 font-medium uppercase tracking-wider mb-2">Histórias reais</p>
                    <h2 class="font-serif text-2xl font-bold text-night-800 leading-snug">
                        Quem doa, também recebe algo de volta.
                    </h2>
                </div>

                <div class="lg:col-span-2 flex flex-col gap-3.5">
                    @foreach($ultimasDoacoes->take(4) as $doacao)
                        <div class="bg-cream-50 rounded-xl p-5 border-l-[3px] {{ $loop->even ? 'border-night-800' : 'border-rosa-500' }}">
                            <p class="text-[13px] text-bark-500 leading-relaxed italic mb-3">
                                "Doou R$ {{ number_format($doacao->valor, 2, ',', '.') }} para {{ $doacao->instituicao->nome }}."
                            </p>
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-medium
                                    {{ $loop->even ? 'bg-sage-100 text-night-800' : 'bg-cream-200 text-rosa-500' }}">
                                    {{ mb_strtoupper(mb_substr($doacao->nome_doador, 0, 1)) }}{{ mb_strtoupper(mb_substr(explode(' ', $doacao->nome_doador)[1] ?? '', 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-[13px] font-medium text-night-800">{{ $doacao->nome_doador }}</p>
                                    <p class="text-xs text-bark-300">{{ $doacao->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

</x-layout.app>
