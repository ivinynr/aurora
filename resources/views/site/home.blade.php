<x-layout.app titulo="Aurora — Doe com confiança">

    {{-- Hero --}}
    <section class="relative bg-night-800 overflow-hidden">
        <div class="absolute inset-0 opacity-20 bg-[radial-gradient(circle_at_20%_20%,#3B82F6_0,transparent_45%),radial-gradient(circle_at_80%_0,#0D9488_0,transparent_40%)]"></div>

        <div class="relative max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-10 px-8 py-16 lg:py-20 items-center">
            <div class="flex flex-col gap-5">
                <div class="flex items-center gap-2 bg-white/10 border border-white/15 rounded-full px-4 py-1.5 w-fit text-xs text-cream-50 font-medium">
                    <span class="w-1.5 h-1.5 rounded-full bg-rosa-400"></span>
                    Pagamentos via PIX processados pela Confrapag
                </div>

                <h1 class="font-serif text-3xl sm:text-4xl lg:text-5xl font-bold text-white leading-tight">
                    Transforme solidariedade em
                    <span class="text-rosa-400">impacto real.</span>
                </h1>

                <p class="text-cream-200/90 text-[15px] leading-relaxed max-w-md">
                    Doe para campanhas de instituições verificadas e acompanhe, com total transparência,
                    cada real chegando a quem precisa.
                </p>

                <div class="flex flex-wrap gap-3 mt-1">
                    <a href="{{ route('campanhas.index') }}"
                       class="inline-flex items-center gap-2 bg-rosa-500 hover:bg-rosa-600 text-white rounded-xl px-6 py-3.5 text-sm font-semibold transition-colors">
                        Ver campanhas
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </a>
                    <a href="{{ route('instituicoes.index') }}"
                       class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/15 border border-white/20 text-white rounded-xl px-6 py-3.5 text-sm font-semibold transition-colors">
                        Conhecer instituições
                    </a>
                </div>

                <div class="flex gap-8 mt-3">
                    <div>
                        <p class="text-2xl font-bold text-white">R$ {{ number_format($estatisticas['total_doado'], 0, ',', '.') }}</p>
                        <p class="text-xs text-cream-200/70">arrecadados</p>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-white">{{ $estatisticas['total_doacoes'] }}</p>
                        <p class="text-xs text-cream-200/70">doações</p>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-white">{{ $estatisticas['total_doadores'] }}</p>
                        <p class="text-xs text-cream-200/70">doadores</p>
                    </div>
                </div>
            </div>

            {{-- Imagens das campanhas em destaque --}}
            <div class="hidden lg:grid grid-cols-2 gap-3">
                @php $comImagem = $destaques->filter(fn($c) => $c->imagemUrl())->take(3); @endphp
                @if($comImagem->count() >= 1)
                    <div class="row-span-2 relative rounded-2xl overflow-hidden shadow-warm-lg">
                        <img src="{{ $comImagem->first()->imagemUrl() }}" alt="{{ $comImagem->first()->titulo }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-night-800/70 to-transparent"></div>
                        <span class="absolute bottom-3 left-3 right-3 text-white text-sm font-semibold line-clamp-2">{{ $comImagem->first()->titulo }}</span>
                    </div>
                    @foreach($comImagem->skip(1)->take(2) as $c)
                        <div class="relative rounded-2xl overflow-hidden shadow-warm-lg h-40">
                            <img src="{{ $c->imagemUrl() }}" alt="{{ $c->titulo }}" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-night-800/70 to-transparent"></div>
                            <span class="absolute bottom-2 left-3 right-3 text-white text-xs font-medium line-clamp-1">{{ $c->titulo }}</span>
                        </div>
                    @endforeach
                @else
                    <div class="col-span-2 rounded-2xl bg-white/5 border border-white/10 h-72 flex items-center justify-center">
                        <x-layout.logo tamanho="xl" cor="claro" />
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- Selos de confiança --}}
    <section class="bg-white border-b border-cream-200">
        <div class="max-w-6xl mx-auto px-8 py-6 grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
            @foreach([
                ['M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'Instituições verificadas'],
                ['M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z', 'Pagamento seguro via PIX'],
                ['M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z', 'Transparência total'],
                ['M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z', 'Cada doação acompanhada'],
            ] as [$icone, $texto])
                <div class="flex flex-col items-center gap-2">
                    <div class="w-10 h-10 rounded-xl bg-terra-50 text-terra-500 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $icone }}"/></svg>
                    </div>
                    <p class="text-xs font-medium text-bark-600">{{ $texto }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Campanhas em destaque --}}
    <section class="bg-cream-100 py-14 lg:py-20">
        <div class="max-w-6xl mx-auto px-8">
            <div class="flex items-end justify-between mb-8">
                <div>
                    <p class="text-[11px] text-terra-500 font-semibold uppercase tracking-wider mb-1">Em destaque</p>
                    <h2 class="font-serif text-2xl lg:text-3xl font-bold text-night-800">Campanhas que precisam de você agora</h2>
                </div>
                <a href="{{ route('campanhas.index') }}" class="hidden sm:inline-flex items-center gap-1 text-sm font-medium text-terra-500 hover:text-terra-600">
                    Ver todas
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            @if($destaques->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($destaques as $campanha)
                        <x-campanha.card :campanha="$campanha" />
                    @endforeach
                </div>
            @else
                <x-ui.card :hover="false" class="text-center py-16">
                    <p class="font-serif text-xl text-bark-300">Nenhuma campanha em destaque ainda.</p>
                    <a href="{{ route('campanhas.index') }}" class="text-sm text-terra-500 font-medium mt-2 inline-block">Ver todas as campanhas</a>
                </x-ui.card>
            @endif
        </div>
    </section>

    {{-- Como funciona --}}
    <section class="bg-white border-y border-cream-200 py-14 lg:py-20">
        <div class="max-w-6xl mx-auto px-8">
            <div class="text-center mb-12">
                <p class="text-[11px] text-terra-500 font-semibold uppercase tracking-wider mb-1">Simples e transparente</p>
                <h2 class="font-serif text-2xl lg:text-3xl font-bold text-night-800">Como funciona</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach([
                    ['1', 'Escolha uma campanha', 'Navegue por campanhas de instituições verificadas e encontre uma causa que toca o seu coração.'],
                    ['2', 'Doe via PIX', 'Selecione o valor e pague com PIX em segundos. O QR Code é gerado com segurança pela Confrapag.'],
                    ['3', 'Acompanhe o impacto', 'Veja a arrecadação crescer em tempo real e receba atualizações de como sua doação está ajudando.'],
                ] as [$num, $titulo, $texto])
                    <div class="relative">
                        <div class="w-12 h-12 rounded-2xl bg-night-800 text-white font-serif text-xl font-bold flex items-center justify-center mb-4">{{ $num }}</div>
                        <h3 class="font-serif text-lg font-bold text-night-800 mb-2">{{ $titulo }}</h3>
                        <p class="text-sm text-bark-400 leading-relaxed">{{ $texto }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Faixa de impacto --}}
    <section class="bg-night-800">
        <div class="max-w-6xl mx-auto px-8 py-10 grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="text-center">
                <p class="text-3xl font-bold text-white">R$ {{ number_format($estatisticas['total_doado'], 0, ',', '.') }}</p>
                <p class="text-xs text-cream-200/70 mt-1">arrecadados na plataforma</p>
            </div>
            <div class="text-center">
                <p class="text-3xl font-bold text-white">{{ $estatisticas['total_doacoes'] }}</p>
                <p class="text-xs text-cream-200/70 mt-1">doações realizadas</p>
            </div>
            <div class="text-center">
                <p class="text-3xl font-bold text-white">{{ $estatisticas['total_doadores'] }}</p>
                <p class="text-xs text-cream-200/70 mt-1">pessoas já doaram</p>
            </div>
            <div class="text-center">
                <p class="text-3xl font-bold text-white">R$ {{ number_format($estatisticas['ticket_medio'], 0, ',', '.') }}</p>
                <p class="text-xs text-cream-200/70 mt-1">doação média</p>
            </div>
        </div>
    </section>

    {{-- Últimas doações --}}
    @if($ultimasDoacoes->isNotEmpty())
        <section class="bg-cream-100 py-14 lg:py-20">
            <div class="max-w-6xl mx-auto px-8 grid grid-cols-1 lg:grid-cols-3 gap-12 items-start">
                <div>
                    <p class="text-[11px] text-terra-500 font-semibold uppercase tracking-wider mb-2">Histórias reais</p>
                    <h2 class="font-serif text-2xl lg:text-3xl font-bold text-night-800 leading-snug">
                        Pessoas reais, ajudando de verdade.
                    </h2>
                    <p class="text-sm text-bark-400 mt-3">Cada doação abaixo já foi confirmada e está fazendo a diferença.</p>
                </div>

                <div class="lg:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    @foreach($ultimasDoacoes->take(4) as $doacao)
                        <div class="bg-white rounded-xl p-5 border border-cream-200 shadow-warm">
                            <p class="text-[13px] text-bark-500 leading-relaxed mb-3">
                                Doou <span class="font-semibold text-sage-500">R$ {{ number_format($doacao->valor, 2, ',', '.') }}</span>
                                para <span class="font-medium text-night-800">{{ $doacao->campanha->titulo }}</span>.
                            </p>
                            @if($doacao->mensagem)
                                <p class="text-xs text-bark-400 italic mb-3">"{{ $doacao->mensagem }}"</p>
                            @endif
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-full bg-terra-50 text-terra-500 flex items-center justify-center text-xs font-semibold">
                                    {{ mb_strtoupper(mb_substr($doacao->nomeExibicao(), 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-[13px] font-medium text-night-800">{{ $doacao->nomeExibicao() }}</p>
                                    <p class="text-xs text-bark-300">{{ $doacao->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Instituições em destaque --}}
    @if($instituicoes->isNotEmpty())
        <section class="bg-white border-t border-cream-200 py-14 lg:py-20">
            <div class="max-w-6xl mx-auto px-8">
                <div class="flex items-end justify-between mb-8">
                    <div>
                        <p class="text-[11px] text-terra-500 font-semibold uppercase tracking-wider mb-1">Quem faz acontecer</p>
                        <h2 class="font-serif text-2xl lg:text-3xl font-bold text-night-800">Instituições que transformam vidas</h2>
                    </div>
                    <a href="{{ route('instituicoes.index') }}" class="hidden sm:inline-flex items-center gap-1 text-sm font-medium text-terra-500 hover:text-terra-600">
                        Ver todas
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($instituicoes as $inst)
                        <a href="{{ route('instituicoes.show', $inst->slug) }}"
                           class="group bg-white rounded-xl shadow-warm border border-cream-200 overflow-hidden card-lift block">
                            <div class="aspect-[16/10] bg-cream-200 relative overflow-hidden">
                                @if($inst->logoUrl())
                                    <img src="{{ $inst->logoUrl() }}" alt="{{ $inst->nome }}"
                                         class="w-full h-full object-cover group-hover:scale-[1.02] transition-transform duration-700">
                                @else
                                    <div class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-cream-200 to-cream-300">
                                        <span class="font-serif text-4xl font-bold text-bark-200">{{ mb_substr($inst->nome, 0, 1) }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="p-5">
                                @if($inst->cidade)
                                    <p class="text-xs text-bark-300 mb-1">{{ $inst->cidade }}, {{ $inst->estado }}</p>
                                @endif
                                <h3 class="font-serif text-lg font-bold text-bark-800 mb-2 group-hover:text-terra-500 transition-colors">
                                    {{ $inst->nome }}
                                </h3>
                                @if($inst->missao)
                                    <p class="text-sm text-bark-400 line-clamp-2 mb-4">{{ $inst->missao }}</p>
                                @else
                                    <p class="text-sm text-bark-400 line-clamp-2 mb-4">{{ Str::limit($inst->descricao, 100) }}</p>
                                @endif
                                <span class="inline-flex items-center gap-1 text-sm font-medium text-terra-500">
                                    Conheça
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- CTA final --}}
    <section class="bg-cream-100 border-t border-cream-200 py-16">
        <div class="max-w-3xl mx-auto px-8 text-center">
            <h2 class="font-serif text-2xl lg:text-3xl font-bold text-night-800 mb-3">Sua instituição também pode arrecadar aqui</h2>
            <p class="text-sm text-bark-400 mb-6 max-w-xl mx-auto">
                Crie campanhas, receba doações via PIX e preste contas com transparência. Tudo em um só lugar.
            </p>
            <a href="{{ route('campanhas.index') }}"
               class="inline-flex items-center gap-2 bg-terra-500 hover:bg-terra-600 text-white rounded-xl px-7 py-3.5 text-sm font-semibold transition-colors">
                Começar a doar agora
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
    </section>

</x-layout.app>
