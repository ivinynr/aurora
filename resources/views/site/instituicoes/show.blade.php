<x-layout.app :titulo="$instituicao->nome . ' — Aurora'">

    {{-- Bloco principal: Carrossel + Info --}}
    <section class="bg-cream-100 py-10 lg:py-14">
        <div class="max-w-7xl mx-auto px-6">
            <a href="{{ route('instituicoes.index') }}" class="inline-flex items-center gap-1.5 text-sm text-bark-400 hover:text-bark-600 transition-colors mb-6">
                &larr; Todas as instituições
            </a>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">

                {{-- ESQUERDA: Slideshow automático --}}
                @php $fotos = $instituicao->fotosUrls(); @endphp
                <div x-data="{
                        atual: 0,
                        fotos: @js($fotos),
                        timer: null,
                        iniciar() {
                            if (this.fotos.length > 1) {
                                this.timer = setInterval(() => { this.proximo() }, 4000)
                            }
                        },
                        proximo() {
                            this.atual = (this.atual + 1) % this.fotos.length
                        },
                        anterior() {
                            this.atual = (this.atual - 1 + this.fotos.length) % this.fotos.length
                        },
                        irPara(idx) {
                            this.atual = idx;
                            clearInterval(this.timer);
                            this.iniciar();
                        }
                     }"
                     x-init="iniciar()"
                     @mouseenter="clearInterval(timer)"
                     @mouseleave="iniciar()"
                     class="space-y-3">
                    <div class="aspect-[3/2] rounded-2xl overflow-hidden bg-cream-200 relative group">
                        <template x-if="fotos.length > 0">
                            <template x-for="(foto, idx) in fotos" :key="idx">
                                <img :src="foto" :alt="'{{ e($instituicao->nome) }}'"
                                     x-show="atual === idx"
                                     x-transition:enter="transition ease-out duration-500"
                                     x-transition:enter-start="opacity-0"
                                     x-transition:enter-end="opacity-100"
                                     x-transition:leave="transition ease-in duration-300"
                                     x-transition:leave-start="opacity-100"
                                     x-transition:leave-end="opacity-0"
                                     class="absolute inset-0 w-full h-full object-cover">
                            </template>
                        </template>
                        @if(empty($fotos))
                            @if($instituicao->logoUrl())
                                <img src="{{ $instituicao->logoUrl() }}" alt="{{ $instituicao->nome }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-cream-200 to-cream-300">
                                    <span class="font-serif text-6xl font-bold text-bark-200">{{ mb_substr($instituicao->nome, 0, 1) }}</span>
                                </div>
                            @endif
                        @endif

                        {{-- Setas de navegação --}}
                        <template x-if="fotos.length > 1">
                            <div>
                                <button @click="irPara((atual - 1 + fotos.length) % fotos.length)"
                                        class="absolute left-3 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-black/30 hover:bg-black/50 text-white flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                                </button>
                                <button @click="irPara((atual + 1) % fotos.length)"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-black/30 hover:bg-black/50 text-white flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                </button>
                            </div>
                        </template>

                        {{-- Indicadores (bolinhas) --}}
                        <template x-if="fotos.length > 1">
                            <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-1.5">
                                <template x-for="(foto, idx) in fotos" :key="'dot-'+idx">
                                    <button @click="irPara(idx)"
                                            :class="atual === idx ? 'bg-white w-6' : 'bg-white/50 w-2 hover:bg-white/80'"
                                            class="h-2 rounded-full transition-all duration-300"></button>
                                </template>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- DIREITA: Informações --}}
                <div class="flex flex-col justify-center">
                    @if($instituicao->segmento)
                        <div class="mb-3">
                            <x-ui.badge :cor="$instituicao->segmento->cor()">
                                {{ $instituicao->segmento->label() }}
                            </x-ui.badge>
                        </div>
                    @endif

                    <h1 class="font-serif text-2xl lg:text-4xl font-bold text-bark-800 leading-tight">
                        {{ $instituicao->nome }}
                    </h1>

                    @if($instituicao->cidade)
                        <p class="text-sm text-bark-400 mt-2">{{ $instituicao->cidade }}, {{ $instituicao->estado }}</p>
                    @endif

                    @if($instituicao->missao)
                        <p class="text-bark-600 leading-relaxed mt-4">{{ $instituicao->missao }}</p>
                    @endif

                    @if($instituicao->campanhas->isNotEmpty())
                        <div class="mt-6">
                            <a href="{{ route('doacao.create', $instituicao->campanhas->first()->slug) }}"
                               class="inline-flex items-center gap-2 bg-rosa-500 hover:bg-rosa-600 text-white rounded-xl px-7 py-3.5 text-sm font-semibold transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                                Fazer doação
                            </a>
                        </div>
                    @endif

                    <p class="text-xs text-bark-300 leading-relaxed mt-4 max-w-md">
                        * Sua doação será feita através da plataforma. Não retemos nenhum valor da sua doação,
                        nem seus dados pessoais. Atuamos conectando quem se importa, com quem faz.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Bloco inferior: Detalhes --}}
    <section class="max-w-7xl mx-auto px-6 py-12 space-y-10">

        {{-- Descrição completa --}}
        <div class="max-w-3xl">
            <h2 class="font-serif text-xl font-bold text-bark-800 mb-4">Sobre a instituição</h2>
            <div class="text-bark-600 leading-relaxed text-[15px] space-y-4 font-light">
                {!! nl2br(e($instituicao->descricao)) !!}
            </div>
        </div>

        {{-- Website + Selos --}}
        <div class="flex flex-wrap items-start gap-8">
            @if($instituicao->website)
                <a href="{{ $instituicao->website }}" target="_blank" rel="noopener"
                   class="inline-flex items-center gap-2 bg-cream-200 hover:bg-cream-300 text-bark-700 rounded-xl px-5 py-2.5 text-sm font-medium transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                    </svg>
                    Visitar site da instituição
                </a>
            @endif

            @if($instituicao->selos && count($instituicao->selos) > 0)
                <div>
                    <p class="text-xs text-bark-300 uppercase tracking-wider font-semibold mb-2">Reconhecimentos</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach($instituicao->selos as $selo)
                            <x-ui.badge cor="sage">{{ $selo['nome'] }}</x-ui.badge>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        {{-- Segundo botão de doação --}}
        @if($instituicao->campanhas->isNotEmpty())
            <div>
                <a href="{{ route('doacao.create', $instituicao->campanhas->first()->slug) }}"
                   class="inline-flex items-center gap-2 bg-rosa-500 hover:bg-rosa-600 text-white rounded-xl px-7 py-3.5 text-sm font-semibold transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                    Fazer doação
                </a>
            </div>
        @endif

        {{-- Campanhas da instituição --}}
        @if($instituicao->campanhas->isNotEmpty())
            <div class="border-t border-cream-200 pt-10">
                <h2 class="font-serif text-xl font-bold text-bark-800 mb-5">Campanhas</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($instituicao->campanhas as $campanha)
                        <x-campanha.card :campanha="$campanha" />
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Contato --}}
        @if($instituicao->telefone || $instituicao->email || $instituicao->instagram || $instituicao->website)
            <div class="border-t border-cream-200 pt-10">
                <h2 class="font-serif text-xl font-bold text-bark-800 mb-4">Contato</h2>
                <div class="flex flex-wrap gap-6 text-sm text-bark-600">
                    @if($instituicao->telefone)
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-bark-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/>
                            </svg>
                            <span>{{ $instituicao->telefone }}</span>
                        </div>
                    @endif
                    @if($instituicao->email)
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-bark-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                            </svg>
                            <span>{{ $instituicao->email }}</span>
                        </div>
                    @endif
                    @if($instituicao->instagram)
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-bark-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z"/>
                            </svg>
                            <span>{{ $instituicao->instagram }}</span>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        {{-- Instituições do mesmo segmento --}}
        @if($relacionadas->isNotEmpty())
            <div class="border-t border-cream-200 pt-10">
                <h2 class="font-serif text-xl font-bold text-bark-800 mb-5">Instituições do mesmo segmento</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    @foreach($relacionadas as $rel)
                        <x-instituicao.card :instituicao="$rel" />
                    @endforeach
                </div>
            </div>
        @endif
    </section>

</x-layout.app>
