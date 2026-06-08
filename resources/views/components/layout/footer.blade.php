<footer class="border-t border-cream-300/60 mt-auto">
    <div class="max-w-5xl mx-auto px-6 py-12">
        <div class="flex flex-col md:flex-row items-start justify-between gap-8">
            <div class="max-w-xs">
                <div class="mb-2"><x-layout.logo tamanho="sm" /></div>
                <p class="text-sm text-bark-400 leading-relaxed">
                    Conectando quem quer ajudar a quem precisa de ajuda. Cada gesto conta.
                </p>
            </div>

            <div class="flex gap-12">
                <div>
                    <p class="text-xs font-semibold text-bark-500 uppercase tracking-wider mb-3">Navegação</p>
                    <div class="space-y-2">
                        <a href="{{ route('home') }}" class="block text-sm text-bark-400 hover:text-bark-700 transition-colors">Início</a>
                        <a href="{{ route('campanhas.index') }}" class="block text-sm text-bark-400 hover:text-bark-700 transition-colors">Campanhas</a>
                        <a href="{{ route('instituicoes.index') }}" class="block text-sm text-bark-400 hover:text-bark-700 transition-colors">Instituições</a>
                    </div>
                </div>
                <div>
                    <p class="text-xs font-semibold text-bark-500 uppercase tracking-wider mb-3">Segurança</p>
                    <p class="text-sm text-bark-400">Pagamentos via PIX</p>
                    <p class="text-sm text-bark-400">processados por Confrapag</p>
                </div>
            </div>
        </div>

        <div class="mt-10 pt-6 border-t border-cream-300/40 flex flex-col sm:flex-row items-center justify-between gap-2">
            <p class="text-xs text-bark-300">&copy; {{ date('Y') }} Aurora &mdash; Hackathon Confrapag + UNIESP</p>
            <p class="text-xs text-bark-300">Feito com cuidado na Paraíba</p>
        </div>
    </div>
</footer>
