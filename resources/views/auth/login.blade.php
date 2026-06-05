<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Entrar — Aurora</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=playfair-display:400,500,600,700|plus-jakarta-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-cream-100 flex items-center justify-center p-6 font-sans antialiased">
    <div class="w-full max-w-sm">
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-block"><x-layout.logo tamanho="lg" /></a>
            <p class="text-sm text-bark-400 mt-2">Acesso administrativo</p>
        </div>

        <div class="bg-white rounded-xl shadow-warm border border-cream-200 p-7">
            @if($errors->any())
                <div class="mb-5 p-3 rounded-lg bg-terra-50 border border-terra-100 text-sm text-terra-600">
                    E-mail ou senha incorretos.
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf
                <div class="space-y-1.5">
                    <label for="email" class="block text-sm font-medium text-bark-700">E-mail</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                           placeholder="admin@aurora.org.br"
                           class="w-full px-4 py-2.5 rounded-xl border border-cream-300 text-sm text-bark-800 placeholder:text-bark-300 focus:border-terra-300 focus:ring-2 focus:ring-terra-100 transition-colors">
                </div>
                <div class="space-y-1.5">
                    <label for="password" class="block text-sm font-medium text-bark-700">Senha</label>
                    <input type="password" name="password" id="password" required placeholder="••••••••"
                           class="w-full px-4 py-2.5 rounded-xl border border-cream-300 text-sm text-bark-800 placeholder:text-bark-300 focus:border-terra-300 focus:ring-2 focus:ring-terra-100 transition-colors">
                </div>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="remember" class="w-4 h-4 rounded border-cream-300 text-terra-500 focus:ring-terra-400">
                    <span class="text-sm text-bark-500">Lembrar de mim</span>
                </label>
                <button type="submit" class="w-full py-2.5 text-sm font-semibold text-white bg-terra-500 hover:bg-terra-600 rounded-xl transition-colors">
                    Entrar
                </button>
            </form>
        </div>

        <p class="text-center text-xs text-bark-300 mt-6">Aurora &mdash; Hackathon Confrapag + UNIESP</p>
    </div>
</body>
</html>
