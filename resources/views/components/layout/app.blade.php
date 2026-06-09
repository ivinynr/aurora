<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    <title>{{ $titulo ?? 'Aurora' }}</title>
    <meta name="description" content="{{ $descricao ?? 'Conectando quem quer ajudar a quem precisa de ajuda.' }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=playfair-display:400,500,600,700,800i|plus-jakarta-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="min-h-screen bg-cream-100 text-bark-800 font-sans antialiased flex flex-col">
    <x-layout.navbar />

    <main class="flex-1 relative z-10">
        @if(session('sucesso') || session('erro') || session('aviso'))
            <div class="max-w-xl mx-auto px-6 pt-6">
                @if(session('sucesso'))
                    <x-ui.alerta tipo="sucesso">{{ session('sucesso') }}</x-ui.alerta>
                @endif
                @if(session('erro'))
                    <x-ui.alerta tipo="erro">{{ session('erro') }}</x-ui.alerta>
                @endif
                @if(session('aviso'))
                    <x-ui.alerta tipo="aviso">{{ session('aviso') }}</x-ui.alerta>
                @endif
            </div>
        @endif

        {{ $slot }}
    </main>

    <x-layout.footer />

    @stack('scripts')
</body>
</html>
