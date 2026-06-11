<x-layout.app titulo="Aurora — Doe com confiança">
    @php
        $totalDoado = $estatisticas['total_doado'] ?? 15455;
        $totalDoacoes = $estatisticas['total_doacoes'] ?? 118;
        $totalDoadores = $estatisticas['total_doadores'] ?? 18;
        $imagensCampanha = [
            'https://images.unsplash.com/photo-1593113598332-cd288d649433?auto=format&fit=crop&w=900&q=85',
            'https://images.unsplash.com/photo-1576765974022-b6b8d48c28a8?auto=format&fit=crop&w=900&q=85',
            'https://images.unsplash.com/photo-1601758228041-f3b2795255f1?auto=format&fit=crop&w=900&q=85',
        ];

        $campanhasMockadas = collect([
            [
                'titulo' => 'Cestas Básicas',
                'descricao' => 'Ajude famílias em situação de vulnerabilidade.',
                'imagem' => 'https://images.unsplash.com/photo-1593113598332-cd288d649433?auto=format&fit=crop&w=640&q=80',
                'arrecadado' => 3500,
                'meta' => 5000,
                'doacoes' => 42,
                'slug' => null,
            ],
            [
                'titulo' => 'Tratamento Infantil',
                'descricao' => 'Contribua para tratamentos e medicamentos.',
                'imagem' => 'https://images.unsplash.com/photo-1607453998774-d533f65dac99?auto=format&fit=crop&w=640&q=80',
                'arrecadado' => 2450,
                'meta' => 5000,
                'doacoes' => 31,
                'slug' => null,
            ],
            [
                'titulo' => 'Abrigo Pet Feliz',
                'descricao' => 'Ajude na alimentação e cuidados dos animais.',
                'imagem' => 'https://images.unsplash.com/photo-1552053831-71594a27632d?auto=format&fit=crop&w=640&q=80',
                'arrecadado' => 1280,
                'meta' => 3000,
                'doacoes' => 18,
                'slug' => null,
            ],
        ]);

        $campanhas = $destaques->isNotEmpty()
            ? $destaques->map(fn ($campanha, $indice) => [
                'titulo' => $campanha->titulo,
                'descricao' => $campanha->resumo,
                'imagem' => $imagensCampanha[$indice] ?? $campanha->imagemUrl(),
                'arrecadado' => (float) $campanha->valor_arrecadado,
                'meta' => (float) $campanha->meta,
                'doacoes' => $campanha->doacoes_confirmadas_count ?? $campanha->totalDoadores(),
                'slug' => $campanha->slug,
            ])->take(3)->values()
            : $campanhasMockadas;

        $ultimaDoacao = $ultimasDoacoes->first();
        $nomeDoador = $ultimaDoacao?->nomeExibicao() ?? 'Maria';
        $valorDoador = $ultimaDoacao ? number_format($ultimaDoacao->valor, 2, ',', '.') : '50,00';
    @endphp

    <section class="relative h-[650px] min-h-[650px] max-h-[650px] overflow-hidden bg-[#011241] text-white">
        <div class="absolute inset-0 bg-[linear-gradient(110deg,#011241_0%,#02164B_45%,#06245F_72%,#0B2E78_100%)]"></div>

        <div class="relative z-10 mx-auto grid h-full max-w-[1180px] grid-cols-1 items-center px-6 lg:grid-cols-[48%_52%]">
                <div class="max-w-xl">
                    <div class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-4 py-2 text-xs font-semibold text-[#FFFFFF] shadow-[0_14px_36px_rgba(0,0,0,.18)] backdrop-blur">
                        <span class="inline-flex w-5 h-5 items-center justify-center rounded-full bg-[#FA8002]/15 text-[#FA8002]">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3l7 4v5c0 4.5-2.8 8.4-7 9-4.2-.6-7-4.5-7-9V7l7-4z"/></svg>
                        </span>
                        Pagamentos via PIX processados pela Confrapag
                    </div>

                    <h1 class="mt-6 max-w-[560px] font-serif text-4xl font-extrabold leading-[1.08] tracking-normal sm:text-5xl lg:text-[56px]">
                        Transforme solidariedade em
                        <span class="text-[#FA8002]">impacto real.</span>
                    </h1>

                    <p class="mt-5 max-w-[520px] text-[17px] leading-[1.7] text-[rgba(255,255,255,0.86)]">
                        Doe para campanhas de instituições verificadas e acompanhe, com total transparência,
                        cada real chegando a quem precisa.
                    </p>

                    <div class="mt-7 flex flex-col gap-3 sm:flex-row">
                        <a href="{{ route('campanhas.index') }}"
                           class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#FA8002] px-6 py-3.5 text-sm font-bold text-white shadow-[0_18px_35px_rgba(250,128,2,.24)] transition-colors hover:bg-[#E7661D]">
                            Ver campanhas
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </a>
                        <a href="#como-funciona"
                           class="inline-flex items-center justify-center rounded-xl border border-white/25 bg-white/5 px-6 py-3.5 text-sm font-bold text-white transition-colors hover:bg-white/10">
                            Como funciona
                        </a>
                    </div>

                    <div class="mt-7 grid grid-cols-1 gap-3 border-t border-white/10 pt-6 sm:grid-cols-3">
                        @foreach([
                            ['M12 3l7 4v5c0 4.5-2.8 8.4-7 9-4.2-.6-7-4.5-7-9V7l7-4z', 'Instituições verificadas'],
                            ['M16.5 10.5V7.75a4.5 4.5 0 00-9 0v2.75M5.75 10.5h12.5v9H5.75v-9z', 'Pagamento seguro via PIX'],
                            ['M5 19V9m7 10V5m7 14v-7', 'Transparência total'],
                        ] as [$icone, $texto])
                            <div class="flex items-center gap-3">
                                <span class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-white/10 text-white">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $icone }}"/></svg>
                                </span>
                                <p class="text-xs leading-5 text-[#FFFFFF]">{{ $texto }}</p>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-5 grid grid-cols-3 gap-2.5">
                        @foreach([
                            ['R$ '.number_format($totalDoado, 0, ',', '.'), 'arrecadados'],
                            [number_format($totalDoacoes, 0, ',', '.'), 'doações'],
                            [number_format($totalDoadores, 0, ',', '.'), 'doadores'],
                        ] as [$valor, $label])
                            <div class="rounded-xl border border-white/10 bg-white/10 px-3 py-3 backdrop-blur">
                                <p class="text-base font-bold text-white">{{ $valor }}</p>
                                <p class="mt-1 text-xs text-[#FFFFFF]">{{ $label }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="relative mx-auto hidden h-[560px] w-full max-w-[640px] lg:block">
                    <div class="absolute left-[30px] top-[116px] z-[3] rounded-2xl border border-[rgba(255,255,255,0.18)] bg-[rgba(255,255,255,0.10)] px-3.5 py-2.5 shadow-[0_20px_50px_rgba(0,0,0,0.25)] backdrop-blur-[16px]">
                        <div class="flex items-center gap-3">
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-[#0D3B9E]/35 text-white">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M16 19a4 4 0 00-8 0M12 12a3 3 0 100-6 3 3 0 000 6zm8 7a3 3 0 00-5.2-2"/></svg>
                            </span>
                            <div>
                                <p class="text-[13px] font-bold">35 famílias</p>
                                <p class="text-xs text-[#FFFFFF]">já foram ajudadas</p>
                            </div>
                        </div>
                    </div>

                    <div class="absolute right-[40px] top-[94px] z-[3] w-52 rounded-2xl border border-[rgba(255,255,255,0.18)] bg-[rgba(255,255,255,0.10)] p-3.5 shadow-[0_20px_50px_rgba(0,0,0,0.25)] backdrop-blur-[16px]">
                        <div class="flex items-center gap-3">
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-white/12 text-white">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9 9 0 100-18 9 9 0 000 18zm0-4.5a4.5 4.5 0 100-9 4.5 4.5 0 000 9zm3.2-7.7l2.2-2.2"/></svg>
                            </span>
                            <div>
                                <p class="text-[13px] font-bold">Meta da campanha</p>
                                <p class="text-xs text-[#FFFFFF]">78% concluída</p>
                            </div>
                        </div>
                        <div class="mt-3 h-2 rounded-full bg-white/15">
                            <div class="h-full w-[78%] rounded-full bg-[#FA8002]"></div>
                        </div>
                    </div>

                    <svg class="absolute inset-x-0 top-12 z-0 mx-auto h-[430px] w-[500px] text-[rgba(37,99,235,0.20)] opacity-[0.85]" viewBox="0 0 560 500" fill="none" aria-hidden="true">
                        <path fill="currentColor" d="M280 455C237 406 100 330 77 204C59 104 134 44 205 84C242 105 266 141 280 176C294 141 318 105 355 84C426 44 501 104 483 204C460 330 323 406 280 455Z"/>
                    </svg>
                    <div class="absolute inset-x-0 bottom-0 z-[2] mx-auto flex justify-center">
                        @if(file_exists(public_path('images/hero-doacao.png')))
                            <img src="{{ asset('images/hero-doacao-corrigida.png') }}" alt="Família recebendo uma caixa de doação" class="h-[480px] max-h-[480px] w-full translate-y-[35px] object-contain drop-shadow-[0_24px_52px_rgba(0,0,0,.32)]">
                        @else
                            <div class="aspect-square rounded-[2rem] border border-white/15 bg-white/10 p-10 shadow-[0_28px_60px_rgba(0,0,0,.25)] backdrop-blur">
                                <div class="h-full rounded-[1.5rem] bg-gradient-to-br from-[#0D3B9E]/50 to-[#FA8002]/45"></div>
                            </div>
                        @endif
                    </div>

                    <div class="absolute bottom-[92px] right-[170px] z-[3] rounded-2xl border border-[rgba(255,255,255,0.18)] bg-[rgba(255,255,255,0.10)] px-3.5 py-2.5 shadow-[0_20px_50px_rgba(0,0,0,0.25)] backdrop-blur-[16px]">
                        <div class="flex items-center gap-3">
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-[#FA8002] text-xs font-bold text-white">
                                {{ mb_strtoupper(mb_substr($nomeDoador, 0, 1)) }}
                            </span>
                            <div>
                                <p class="text-[13px] font-bold">{{ $nomeDoador }} doou</p>
                                <p class="text-xs text-[#FFFFFF]">R$ {{ $valorDoador }}</p>
                            </div>
                            <svg class="w-5 h-5 text-[#FA8002]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M20.8 8.6a5.1 5.1 0 00-8.1-3.9l-.7.7-.7-.7a5.1 5.1 0 00-8.1 6.2L12 20l8.8-9.1a5.1 5.1 0 000-2.3z"/></svg>
                        </div>
                    </div>
                </div>
        </div>

        <div class="absolute bottom-[-1px] left-0 z-20 w-full overflow-hidden leading-none">
            <svg class="relative block h-[70px] w-full" viewBox="0 0 1440 100" preserveAspectRatio="none" aria-hidden="true">
                <path d="M0,55 C180,25 360,80 540,58 C760,32 940,82 1140,55 C1300,34 1380,42 1440,28 L1440,100 L0,100 Z" fill="#F8F9FD" />
            </svg>
        </div>
    </section>

    <section class="relative z-40 -mt-[30px] bg-[#F8F9FD]">
        <div class="mx-auto max-w-[1060px] px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 rounded-3xl border border-[#011241]/10 bg-[#FFFFFF] px-7 py-7 shadow-[0_18px_55px_rgba(1,18,65,.08)]">
                @foreach([
                    ['+500', 'Famílias ajudadas', 'M16 19a4 4 0 00-8 0M12 12a3 3 0 100-6 3 3 0 000 6zm8 7a3 3 0 00-5.2-2', 'bg-[#0D3B9E]/10 text-[#0D3B9E]'],
                    ['+R$ 120.000', 'Arrecadados', 'M12 6v12m4-8.5A3.5 3.5 0 0012 7H9.8a2.8 2.8 0 000 5.6h4.4a2.8 2.8 0 010 5.6H12a3.5 3.5 0 01-4-2.5', 'bg-[#0D3B9E]/10 text-[#0D3B9E]'],
                    ['+3.200', 'Doações realizadas', 'M20.8 8.6a5.1 5.1 0 00-8.1-3.9l-.7.7-.7-.7a5.1 5.1 0 00-8.1 6.2L12 20l8.8-9.1a5.1 5.1 0 000-2.3z', 'bg-[#FA8002]/10 text-[#FA8002]'],
                ] as [$valor, $label, $icone, $classe])
                    <div class="flex items-center gap-5 md:justify-center">
                        <span class="inline-flex w-16 h-16 shrink-0 items-center justify-center rounded-full {{ $classe }}">
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $icone }}"/></svg>
                        </span>
                        <div>
                            <p class="text-2xl font-bold text-[#02164B]">{{ $valor }}</p>
                            <p class="mt-1 text-sm text-[#02164B]/70">{{ $label }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-[#F8F9FD] py-16 lg:py-20">
        <div class="max-w-6xl mx-auto px-6 lg:px-8">
            <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <h2 class="font-serif text-2xl lg:text-3xl font-bold text-[#02164B]">Campanhas em destaque</h2>
                    <p class="mt-2 text-sm text-[#02164B]/70">Causas verificadas que já podem receber sua doação via PIX.</p>
                </div>
                <a href="{{ route('campanhas.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-[#0D3B9E] hover:text-[#042168]">
                    Ver todas as campanhas
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                @foreach($campanhas as $campanha)
                    @php
                        $percentual = $campanha['meta'] > 0 ? min(100, round(($campanha['arrecadado'] / $campanha['meta']) * 100)) : 0;
                        $url = $campanha['slug'] ? route('campanhas.show', $campanha['slug']) : route('campanhas.index');
                    @endphp
                    <a href="{{ $url }}" class="group block overflow-hidden rounded-2xl border border-[#011241]/10 bg-[#FFFFFF] shadow-[0_14px_38px_rgba(1,18,65,.07)] transition duration-300 hover:-translate-y-1 hover:shadow-[0_20px_50px_rgba(1,18,65,.12)]">
                        <div class="aspect-[16/10] overflow-hidden bg-[#F8F9FD]">
                            @if($campanha['imagem'])
                                <img src="{{ $campanha['imagem'] }}" alt="{{ $campanha['titulo'] }}" class="h-full w-full object-cover transition duration-700 group-hover:scale-[1.03]">
                            @else
                                <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-[#0D3B9E]/15 to-[#FA8002]/20">
                                    <span class="font-serif text-5xl font-bold text-[#0D3B9E]/45">{{ mb_substr($campanha['titulo'], 0, 1) }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="p-6">
                            <h3 class="font-serif text-lg font-bold text-[#02164B]">{{ $campanha['titulo'] }}</h3>
                            <p class="mt-2 min-h-10 text-sm leading-6 text-[#02164B]/70">{{ $campanha['descricao'] }}</p>
                            <div class="mt-5 flex items-baseline justify-between gap-3">
                                <p class="text-sm font-bold text-[#02164B]">
                                    R$ {{ number_format($campanha['arrecadado'], 0, ',', '.') }}
                                    <span class="font-medium text-[#02164B]/55">de R$ {{ number_format($campanha['meta'], 0, ',', '.') }}</span>
                                </p>
                                <p class="text-xs font-bold text-[#02164B]">{{ $percentual }}%</p>
                            </div>
                            <div class="mt-3 h-2 overflow-hidden rounded-full bg-[#011241]/10">
                                <div class="h-full rounded-full bg-[#0D3B9E]" style="width: {{ $percentual }}%"></div>
                            </div>
                            <div class="mt-5 flex items-center gap-3">
                                <div class="flex -space-x-2">
                                    @foreach(['#0D3B9E', '#FA8002', '#052F89'] as $cor)
                                        <span class="h-7 w-7 rounded-full border-2 border-white" style="background: {{ $cor }}"></span>
                                    @endforeach
                                </div>
                                <span class="text-sm text-[#02164B]/70">{{ $campanha['doacoes'] }} doações</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <section id="como-funciona" class="bg-[#F8F9FD] pb-16">
        <div class="max-w-6xl mx-auto px-6 lg:px-8">
            <div class="rounded-3xl border border-[#011241]/10 bg-[#FFFFFF] px-6 py-8 shadow-[0_14px_45px_rgba(1,18,65,.06)] lg:px-8">
                <h2 class="font-serif text-2xl font-bold text-[#02164B]">Como funciona</h2>
                <div class="mt-8 grid grid-cols-1 md:grid-cols-4 gap-6">
                    @foreach([
                        ['1. Escolha', 'Navegue pelas campanhas e escolha a causa que deseja apoiar.', 'M21 21l-4.3-4.3m1.3-5.2a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z'],
                        ['2. Doe', 'Faça sua doação de forma segura via PIX em segundos.', 'M20.8 8.6a5.1 5.1 0 00-8.1-3.9l-.7.7-.7-.7a5.1 5.1 0 00-8.1 6.2L12 20l8.8-9.1a5.1 5.1 0 000-2.3z'],
                        ['3. Acompanhe', 'Veja o andamento da campanha com total transparência.', 'M12 3l7 4v5c0 4.5-2.8 8.4-7 9-4.2-.6-7-4.5-7-9V7l7-4zm-3 9l2 2 4-5'],
                        ['4. Impacte', 'Sua doação chega a quem precisa e transforma vidas.', 'M16 19a4 4 0 00-8 0M12 12a3 3 0 100-6 3 3 0 000 6zm8 7a3 3 0 00-5.2-2'],
                    ] as [$titulo, $texto, $icone])
                        <div>
                            <span class="inline-flex w-14 h-14 items-center justify-center rounded-full bg-[#0D3B9E]/10 text-[#0D3B9E]">
                                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $icone }}"/></svg>
                            </span>
                            <h3 class="mt-5 text-sm font-bold text-[#02164B]">{{ $titulo }}</h3>
                            <p class="mt-2 text-sm leading-6 text-[#02164B]/70">{{ $texto }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section id="sobre-nos" class="bg-[#F8F9FD] pb-20">
        <div class="max-w-6xl mx-auto px-6 lg:px-8">
            <div class="rounded-3xl bg-[#011241] px-8 py-10 text-white shadow-[0_24px_65px_rgba(1,18,65,.22)] lg:px-10">
                <div class="flex flex-col gap-8 md:flex-row md:items-center md:justify-between">
                    <div class="flex items-start gap-5">
                        <span class="inline-flex w-16 h-16 shrink-0 items-center justify-center rounded-full bg-[#042168] text-white">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.08A6.02 6.02 0 0116.5 3C19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                        </span>
                        <div>
                            <h2 class="font-serif text-2xl lg:text-3xl font-bold leading-tight">
                                Pequenas atitudes, grandes
                                <span class="text-[#FA8002]">transformações.</span>
                            </h2>
                            <p class="mt-3 max-w-2xl text-sm leading-7 text-[#FFFFFF]">Juntos, podemos construir um futuro melhor para todos com doações rápidas, seguras e transparentes.</p>
                        </div>
                    </div>

                    <a href="{{ route('campanhas.index') }}" class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-[#FA8002] px-8 py-4 text-sm font-bold text-white transition-colors hover:bg-[#E7661D]">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.08A6.02 6.02 0 0116.5 3C19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                        Quero fazer parte
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-layout.app>
