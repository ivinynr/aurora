<nav x-data="{ aberto: false }" class="sticky top-0 z-50 border-b border-[rgba(255,255,255,0.08)] bg-[#011241]">
    <div class="mx-auto flex h-[72px] max-w-[1180px] items-center justify-between px-6">
            <div class="flex items-center">
            <a href="{{ route('home') }}">
                <x-layout.logo tamanho="sm" cor="claro" />
            </a>
            </div>

            <div class="hidden lg:flex items-center gap-8">
                <a href="{{ route('home') }}" class="border-b-2 pb-1.5 text-sm font-medium text-white transition-colors {{ request()->routeIs('home') ? 'border-[#FA8002]' : 'border-transparent hover:text-white/80' }}">Início</a>
                <a href="{{ route('campanhas.index') }}" class="border-b-2 pb-1.5 text-sm font-medium text-white transition-colors {{ request()->routeIs('campanhas.*') ? 'border-[#FA8002]' : 'border-transparent hover:text-white/80' }}">Campanhas</a>
                <a href="{{ route('instituicoes.index') }}" class="border-b-2 pb-1.5 text-sm font-medium text-white transition-colors {{ request()->routeIs('instituicoes.*') ? 'border-[#FA8002]' : 'border-transparent hover:text-white/80' }}">Instituições</a>
                <a href="{{ route('home') }}#como-funciona" class="text-sm font-medium text-white transition-colors hover:text-white/80">Como funciona</a>
                <a href="{{ route('home') }}#sobre-nos" class="text-sm font-medium text-white transition-colors hover:text-white/80">Sobre nós</a>
            </div>

            <div class="hidden lg:flex items-center">
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex h-10 items-center gap-2 rounded-[10px] border border-white/35 bg-transparent px-5 text-sm font-medium text-white transition-colors hover:bg-white/10">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 7.5a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a7.5 7.5 0 0115 0"/></svg>
                        Painel
                    </a>
                @else
                    <a href="{{ route('login') }}" class="inline-flex h-10 items-center gap-2 rounded-[10px] border border-white/35 bg-transparent px-5 text-sm font-medium text-white transition-colors hover:bg-white/10">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 7.5a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a7.5 7.5 0 0115 0"/></svg>
                        Painel
                    </a>
                @endauth
            </div>

            <button @click="aberto = !aberto" class="lg:hidden p-2 -mr-2 text-white hover:text-white/80">
                <svg x-show="!aberto" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg x-show="aberto" x-cloak class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
    </div>

    <div x-show="aberto" x-cloak x-transition class="lg:hidden border-t border-white/10 bg-[#011241]">
        <div class="px-6 py-5 space-y-4">
            <a href="{{ route('home') }}" class="block text-sm font-semibold text-white">Início</a>
            <a href="{{ route('campanhas.index') }}" class="block text-sm font-semibold text-white">Campanhas</a>
            <a href="{{ route('instituicoes.index') }}" class="block text-sm font-semibold text-white">Instituições</a>
            <a href="{{ route('home') }}#como-funciona" class="block text-sm font-semibold text-white">Como funciona</a>
            <a href="{{ route('home') }}#sobre-nos" class="block text-sm font-semibold text-white">Sobre nós</a>
            @auth
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 rounded-xl border border-white/35 px-4 py-2 text-sm font-bold text-white">Painel</a>
            @else
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 rounded-xl border border-white/35 px-4 py-2 text-sm font-bold text-white">Painel</a>
            @endauth
        </div>
    </div>
</nav>
