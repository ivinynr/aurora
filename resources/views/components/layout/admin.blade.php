@props(['titulo' => 'Admin'])

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $titulo }} — Aurora</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=playfair-display:400,500,600,700|plus-jakarta-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-cream-100 font-sans antialiased" x-data="{ sidebarAberta: false }">
    <aside class="fixed inset-y-0 left-0 z-40 w-60 bg-white border-r border-cream-200 hidden lg:block">
        <div class="h-14 flex items-center px-5 border-b border-cream-200">
            <a href="{{ route('home') }}"><x-layout.logo tamanho="sm" /></a>
        </div>

        <nav class="p-3 space-y-0.5">
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm transition-colors
               {{ request()->routeIs('admin.dashboard') ? 'bg-terra-50 text-terra-600 font-medium' : 'text-bark-500 hover:bg-cream-100 hover:text-bark-700' }}">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Dashboard
            </a>
            <a href="{{ route('admin.campanhas.index') }}"
               class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm transition-colors
               {{ request()->routeIs('admin.campanhas.*') || request()->routeIs('admin.atualizacoes.*') ? 'bg-terra-50 text-terra-600 font-medium' : 'text-bark-500 hover:bg-cream-100 hover:text-bark-700' }}">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
                Campanhas
            </a>
            <a href="{{ route('admin.instituicoes.index') }}"
               class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm transition-colors
               {{ request()->routeIs('admin.instituicoes.*') ? 'bg-terra-50 text-terra-600 font-medium' : 'text-bark-500 hover:bg-cream-100 hover:text-bark-700' }}">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                Instituições
            </a>
            <a href="{{ route('admin.doacoes.index') }}"
               class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm transition-colors
               {{ request()->routeIs('admin.doacoes.*') ? 'bg-terra-50 text-terra-600 font-medium' : 'text-bark-500 hover:bg-cream-100 hover:text-bark-700' }}">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Doações
            </a>

            <div class="pt-3 mt-3 border-t border-cream-200 space-y-0.5">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm text-bark-400 hover:text-bark-600 hover:bg-cream-100 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                    Ver site
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm text-bark-400 hover:text-terra-500 hover:bg-terra-50 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Sair
                    </button>
                </form>
            </div>
        </nav>
    </aside>

    <div class="lg:pl-60">
        <header class="h-14 bg-white border-b border-cream-200 flex items-center justify-between px-6 sticky top-0 z-30">
            <div class="flex items-center gap-3">
                <button @click="sidebarAberta = true" class="lg:hidden p-1.5 rounded-lg text-bark-400 hover:bg-cream-100">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <h1 class="font-serif text-lg font-bold text-bark-800">{{ $titulo }}</h1>
            </div>
            <span class="text-sm text-bark-400">{{ auth()->user()->name ?? '' }}</span>
        </header>

        <div class="p-6">
            @if(session('sucesso'))
                <div class="mb-6"><x-ui.alerta tipo="sucesso">{{ session('sucesso') }}</x-ui.alerta></div>
            @endif
            @if(session('erro'))
                <div class="mb-6"><x-ui.alerta tipo="erro">{{ session('erro') }}</x-ui.alerta></div>
            @endif
            {{ $slot }}
        </div>
    </div>
</body>
</html>
