import { useState } from 'react';
import { Head, Link, router, usePage } from '@inertiajs/react';
import Logo from '../Components/Layout/Logo';
import Alerta from '../Components/UI/Alerta';

const LINKS = [
    {
        rota: 'admin.dashboard',
        ativoEm: 'admin.dashboard',
        label: 'Dashboard',
        icone: 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
    },
    {
        rota: 'admin.campanhas.index',
        ativoEm: ['admin.campanhas.*', 'admin.atualizacoes.*'],
        label: 'Campanhas',
        icone: 'M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z',
    },
    {
        rota: 'admin.instituicoes.index',
        ativoEm: 'admin.instituicoes.*',
        label: 'Instituições',
        icone: 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4',
    },
    {
        rota: 'admin.doacoes.index',
        ativoEm: 'admin.doacoes.*',
        label: 'Doações',
        icone: 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
    },
];

function NavLink({ link, onClick }) {
    const ativoEm = Array.isArray(link.ativoEm) ? link.ativoEm : [link.ativoEm];
    const ativo = ativoEm.some((padrao) => route().current(padrao));

    return (
        <Link
            href={route(link.rota)}
            onClick={onClick}
            className={`flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm transition-colors ${
                ativo ? 'bg-terra-50 text-terra-600 font-medium' : 'text-bark-500 hover:bg-cream-100 hover:text-bark-700'
            }`}
        >
            <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="1.5">
                <path strokeLinecap="round" strokeLinejoin="round" d={link.icone} />
            </svg>
            {link.label}
        </Link>
    );
}

function SidebarConteudo({ onNavegar }) {
    return (
        <>
            <div className="h-14 flex items-center px-5 border-b border-cream-200">
                <Link href={route('home')}><Logo tamanho="sm" /></Link>
            </div>

            <nav className="p-3 space-y-0.5">
                {LINKS.map((link) => (
                    <NavLink key={link.rota} link={link} onClick={onNavegar} />
                ))}

                <div className="pt-3 mt-3 border-t border-cream-200 space-y-0.5">
                    <Link
                        href={route('home')}
                        onClick={onNavegar}
                        className="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm text-bark-400 hover:text-bark-600 hover:bg-cream-100 transition-colors"
                    >
                        <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="1.5">
                            <path strokeLinecap="round" strokeLinejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                        Ver site
                    </Link>
                    <button
                        type="button"
                        onClick={() => router.post(route('logout'))}
                        className="w-full flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm text-bark-400 hover:text-terra-500 hover:bg-terra-50 transition-colors"
                    >
                        <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="1.5">
                            <path strokeLinecap="round" strokeLinejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Sair
                    </button>
                </div>
            </nav>
        </>
    );
}

export default function AdminLayout({ titulo, children }) {
    const [sidebarAberta, setSidebarAberta] = useState(false);
    const { auth, flash } = usePage().props;
    const temFlash = flash?.sucesso || flash?.erro;

    return (
        <div className="min-h-screen bg-cream-100 font-sans antialiased">
            <Head title={titulo} />

            <aside className="fixed inset-y-0 left-0 z-40 w-60 bg-white border-r border-cream-200 hidden lg:block">
                <SidebarConteudo />
            </aside>

            {sidebarAberta && (
                <div className="fixed inset-0 z-50 lg:hidden">
                    <div className="absolute inset-0 bg-black/30" onClick={() => setSidebarAberta(false)} />
                    <aside className="absolute inset-y-0 left-0 w-60 bg-white border-r border-cream-200">
                        <SidebarConteudo onNavegar={() => setSidebarAberta(false)} />
                    </aside>
                </div>
            )}

            <div className="lg:pl-60">
                <header className="h-14 bg-white border-b border-cream-200 flex items-center justify-between px-6 sticky top-0 z-30">
                    <div className="flex items-center gap-3">
                        <button
                            type="button"
                            onClick={() => setSidebarAberta(true)}
                            className="lg:hidden p-1.5 rounded-lg text-bark-400 hover:bg-cream-100"
                        >
                            <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="1.5">
                                <path strokeLinecap="round" strokeLinejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        <h1 className="font-serif text-lg font-bold text-bark-800">{titulo}</h1>
                    </div>
                    <span className="text-sm text-bark-400">{auth?.user?.name ?? ''}</span>
                </header>

                <div className="p-6">
                    {temFlash && (
                        <div className="mb-6 space-y-3">
                            {flash.sucesso && <Alerta tipo="sucesso">{flash.sucesso}</Alerta>}
                            {flash.erro && <Alerta tipo="erro">{flash.erro}</Alerta>}
                        </div>
                    )}

                    {children}
                </div>
            </div>
        </div>
    );
}
