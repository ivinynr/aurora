import { useState } from 'react';
import { Link, usePage } from '@inertiajs/react';
import Logo from './Logo';

export default function Navbar() {
    const [aberto, setAberto] = useState(false);
    const { url, props } = usePage();
    const autenticado = !!props.auth?.user;

    const ativo = (caminho) => (caminho === '/' ? url === '/' : url.startsWith(caminho));

    const linkClasses = (caminho) =>
        `border-b-2 pb-1.5 text-sm font-medium text-white transition-colors ${
            ativo(caminho) ? 'border-[#FA8002]' : 'border-transparent hover:text-white/80'
        }`;

    return (
        <nav className="sticky top-0 z-50 border-b border-[rgba(255,255,255,0.08)] bg-[#011241]">
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
                    <a href={`${route('home')}#como-funciona`} className="text-sm font-medium text-white transition-colors hover:text-white/80">Como funciona</a>
                    <a href={`${route('home')}#sobre-nos`} className="text-sm font-medium text-white transition-colors hover:text-white/80">Sobre nós</a>
                </div>

                <div className="hidden lg:flex items-center">
                    <Link
                        href={autenticado ? route('admin.dashboard') : route('login')}
                        className="inline-flex h-10 items-center gap-2 rounded-[10px] border border-white/35 bg-transparent px-5 text-sm font-medium text-white transition-colors hover:bg-white/10"
                    >
                        <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="1.8">
                            <path strokeLinecap="round" strokeLinejoin="round" d="M15.75 7.5a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a7.5 7.5 0 0115 0" />
                        </svg>
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
                <div className="lg:hidden border-t border-white/10 bg-[#011241]">
                    <div className="px-6 py-5 space-y-4">
                        <Link href={route('home')} className="block text-sm font-semibold text-white">Início</Link>
                        <Link href={route('campanhas.index')} className="block text-sm font-semibold text-white">Campanhas</Link>
                        <Link href={route('instituicoes.index')} className="block text-sm font-semibold text-white">Instituições</Link>
                        <a href={`${route('home')}#como-funciona`} className="block text-sm font-semibold text-white">Como funciona</a>
                        <a href={`${route('home')}#sobre-nos`} className="block text-sm font-semibold text-white">Sobre nós</a>
                        <Link
                            href={autenticado ? route('admin.dashboard') : route('login')}
                            className="inline-flex items-center gap-2 rounded-xl border border-white/35 px-4 py-2 text-sm font-bold text-white"
                        >
                            Painel
                        </Link>
                    </div>
                </div>
            )}
        </nav>
    );
}
