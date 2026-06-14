import { useState, useEffect } from 'react';
import { Link, usePage } from '@inertiajs/react';
import { User } from 'lucide-react';
import Logo from './Logo';

export default function Navbar({ transparente = false }) {
    const [aberto, setAberto] = useState(false);
    const [rolou, setRolou] = useState(false);
    const { url, props } = usePage();
    const autenticado = !!props.auth?.user;

    // Na variante transparente (sobre o hero), aplica fundo + blur só ao rolar.
    useEffect(() => {
        if (!transparente) return;
        const aoRolar = () => setRolou(window.scrollY > 20);
        aoRolar();
        window.addEventListener('scroll', aoRolar, { passive: true });
        return () => window.removeEventListener('scroll', aoRolar);
    }, [transparente]);

    const ativo = (caminho) => (caminho === '/' ? url === '/' : url.startsWith(caminho));

    // Base comum a TODOS os links — garante alinhamento idêntico (mesma borda/altura).
    const baseLink = 'inline-flex items-center border-b-2 border-transparent pb-1 text-sm font-medium leading-none text-white/90 transition-colors hover:text-white';
    const linkClasses = (caminho) => `${baseLink} ${ativo(caminho) ? 'border-[#FA8002] !text-white' : ''}`;

    // Posição/fundo conforme a variante.
    const posicao = transparente ? 'fixed' : 'sticky';
    const fundo = transparente
        ? rolou
            ? 'bg-[rgba(1,18,65,0.88)] backdrop-blur-[16px]'
            : 'bg-transparent'
        : 'bg-[#011241]';

    return (
        <nav className={`${posicao} top-0 left-0 z-50 w-full border-b border-[rgba(255,255,255,0.08)] transition-colors duration-300 ${fundo}`}>
            <div className="mx-auto flex h-[72px] max-w-[1180px] items-center justify-between px-6">
                <div className="flex items-center">
                    <Link href={route('home')}>
                        <Logo tamanho="sm" cor="claro" />
                    </Link>
                </div>

                <div className="hidden lg:flex items-center gap-8">
                    <Link href={route('home')} className={linkClasses('/')}>Início</Link>
                    <Link href={route('campanhas.index')} className={linkClasses('/campanhas')}>Campanhas</Link>
                    <Link href={route('instituicoes.index')} className={linkClasses('/instituicoes')}>Instituições</Link>
                    <a href={`${route('home')}#como-funciona`} className={baseLink}>Como funciona</a>
                    <a href={`${route('home')}#sobre-nos`} className={baseLink}>Sobre nós</a>
                </div>

                <div className="hidden lg:flex items-center">
                    <Link
                        href={autenticado ? route('admin.dashboard') : route('login')}
                        className="inline-flex h-10 items-center gap-2 rounded-[10px] border border-white/30 bg-white/[0.06] px-5 text-sm font-medium text-white transition-colors hover:bg-white/10"
                    >
                        <User className="w-4 h-4" strokeWidth={1.8} />
                        Painel
                    </Link>
                </div>

                <button onClick={() => setAberto(!aberto)} className="lg:hidden p-2 -mr-2 text-white hover:text-white/80">
                    {!aberto ? (
                        <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="1.5">
                            <path strokeLinecap="round" strokeLinejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    ) : (
                        <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="1.5">
                            <path strokeLinecap="round" strokeLinejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    )}
                </button>
            </div>

            {aberto && (
                <div className="lg:hidden border-t border-white/10 bg-[rgba(1,18,65,0.95)] backdrop-blur-[16px]">
                    <div className="px-6 py-5 space-y-4">
                        <Link href={route('home')} className="block text-sm font-semibold text-white">Início</Link>
                        <Link href={route('campanhas.index')} className="block text-sm font-semibold text-white">Campanhas</Link>
                        <Link href={route('instituicoes.index')} className="block text-sm font-semibold text-white">Instituições</Link>
                        <a href={`${route('home')}#como-funciona`} className="block text-sm font-semibold text-white">Como funciona</a>
                        <a href={`${route('home')}#sobre-nos`} className="block text-sm font-semibold text-white">Sobre nós</a>
                        <Link
                            href={autenticado ? route('admin.dashboard') : route('login')}
                            className="inline-flex items-center gap-2 rounded-xl border border-white/30 bg-white/[0.06] px-4 py-2 text-sm font-bold text-white"
                        >
                            <User className="w-4 h-4" strokeWidth={1.8} />
                            Painel
                        </Link>
                    </div>
                </div>
            )}
        </nav>
    );
}
