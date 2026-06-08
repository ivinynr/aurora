<nav x-data="{ aberto: false }" class="border-b border-cream-300/60 bg-cream-100/80 backdrop-blur-sm sticky top-0 z-50">
    <div class="max-w-5xl mx-auto px-6">
        <div class="flex items-center justify-between h-16">
            <a href="{{ route('home') }}">
                <x-layout.logo tamanho="sm" />
            </a>

            <div class="hidden md:flex items-center gap-8">
                <a href="{{ route('home') }}" class="text-sm text-bark-500 hover:text-bark-800 transition-colors">Início</a>
                <a href="{{ route('campanhas.index') }}" class="text-sm text-bark-500 hover:text-bark-800 transition-colors">Campanhas</a>
                <a href="{{ route('instituicoes.index') }}" class="text-sm text-bark-500 hover:text-bark-800 transition-colors">Instituições</a>
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="text-sm text-rosa-500 hover:text-rosa-600 font-medium border-b-2 border-rosa-500 pb-0.5 transition-colors">Painel</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-bark-500 hover:text-bark-800 transition-colors">Entrar</a>
                @endauth
            </div>

            <button @click="aberto = !aberto" class="md:hidden p-2 -mr-2 text-bark-500 hover:text-bark-800">
                <svg x-show="!aberto" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg x-show="aberto" x-cloak class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <div x-show="aberto" x-cloak x-transition class="md:hidden border-t border-cream-300/60 bg-cream-100">
        <div class="px-6 py-4 space-y-3">
            <a href="{{ route('home') }}" class="block text-sm text-bark-600">Início</a>
            <a href="{{ route('campanhas.index') }}" class="block text-sm text-bark-600">Campanhas</a>
            <a href="{{ route('instituicoes.index') }}" class="block text-sm text-bark-600">Instituições</a>
            @auth
                <a href="{{ route('admin.dashboard') }}" class="block text-sm text-rosa-500 font-medium">Painel</a>
            @else
                <a href="{{ route('login') }}" class="block text-sm text-bark-600">Entrar</a>
            @endauth
        </div>
    </div>
</nav>
