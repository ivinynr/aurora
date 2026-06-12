import { Link } from '@inertiajs/react';
import Logo from './Logo';

export default function Footer() {
    const ano = new Date().getFullYear();

    return (
        <footer className="border-t border-cream-300/60 mt-auto">
            <div className="max-w-5xl mx-auto px-6 py-12">
                <div className="flex flex-col md:flex-row items-start justify-between gap-8">
                    <div className="max-w-xs">
                        <div className="mb-2"><Logo tamanho="sm" /></div>
                        <p className="text-sm text-bark-400 leading-relaxed">
                            Conectando quem quer ajudar a quem precisa de ajuda. Cada gesto conta.
                        </p>
                    </div>

                    <div className="flex gap-12">
                        <div>
                            <p className="text-xs font-semibold text-bark-500 uppercase tracking-wider mb-3">Navegação</p>
                            <div className="space-y-2">
                                <Link href={route('home')} className="block text-sm text-bark-400 hover:text-bark-700 transition-colors">Início</Link>
                                <Link href={route('campanhas.index')} className="block text-sm text-bark-400 hover:text-bark-700 transition-colors">Campanhas</Link>
                                <Link href={route('instituicoes.index')} className="block text-sm text-bark-400 hover:text-bark-700 transition-colors">Instituições</Link>
                            </div>
                        </div>
                        <div>
                            <p className="text-xs font-semibold text-bark-500 uppercase tracking-wider mb-3">Segurança</p>
                            <p className="text-sm text-bark-400">Pagamentos via PIX</p>
                            <p className="text-sm text-bark-400">processados por Confrapag</p>
                        </div>
                    </div>
                </div>

                <div className="mt-10 pt-6 border-t border-cream-300/40 flex flex-col sm:flex-row items-center justify-between gap-2">
                    <p className="text-xs text-bark-300">&copy; {ano} Aurora &mdash; Hackathon Confrapag + UNIESP</p>
                    <p className="text-xs text-bark-300">Feito com cuidado na Paraíba</p>
                </div>
            </div>
        </footer>
    );
}
