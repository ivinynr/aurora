import { Link } from '@inertiajs/react';
import AppLayout from '../../Layouts/AppLayout';

const IMAGENS_CAMPANHA = [
    'https://images.unsplash.com/photo-1593113598332-cd288d649433?auto=format&fit=crop&w=900&q=85',
    'https://images.unsplash.com/photo-1576765974022-b6b8d48c28a8?auto=format&fit=crop&w=900&q=85',
    'https://images.unsplash.com/photo-1601758228041-f3b2795255f1?auto=format&fit=crop&w=900&q=85',
];

const CAMPANHAS_MOCKADAS = [
    {
        titulo: 'Cestas Básicas',
        descricao: 'Ajude famílias em situação de vulnerabilidade.',
        imagem: 'https://images.unsplash.com/photo-1593113598332-cd288d649433?auto=format&fit=crop&w=640&q=80',
        arrecadado: 3500,
        meta: 5000,
        doacoes: 42,
        slug: null,
    },
    {
        titulo: 'Tratamento Infantil',
        descricao: 'Contribua para tratamentos e medicamentos.',
        imagem: 'https://images.unsplash.com/photo-1607453998774-d533f65dac99?auto=format&fit=crop&w=640&q=80',
        arrecadado: 2450,
        meta: 5000,
        doacoes: 31,
        slug: null,
    },
    {
        titulo: 'Abrigo Pet Feliz',
        descricao: 'Ajude na alimentação e cuidados dos animais.',
        imagem: 'https://images.unsplash.com/photo-1552053831-71594a27632d?auto=format&fit=crop&w=640&q=80',
        arrecadado: 1280,
        meta: 3000,
        doacoes: 18,
        slug: null,
    },
];

const FEATURES_HERO = [
    ['M12 3l7 4v5c0 4.5-2.8 8.4-7 9-4.2-.6-7-4.5-7-9V7l7-4z', 'Instituições verificadas'],
    ['M16.5 10.5V7.75a4.5 4.5 0 00-9 0v2.75M5.75 10.5h12.5v9H5.75v-9z', 'Pagamento seguro via PIX'],
    ['M5 19V9m7 10V5m7 14v-7', 'Transparência total'],
];

const STATS = [
    ['M16 19a4 4 0 00-8 0M12 12a3 3 0 100-6 3 3 0 000 6zm8 7a3 3 0 00-5.2-2', 'bg-[#0D3B9E]/10 text-[#0D3B9E]', '+500', 'Famílias ajudadas'],
    ['M12 6v12m4-8.5A3.5 3.5 0 0012 7H9.8a2.8 2.8 0 000 5.6h4.4a2.8 2.8 0 010 5.6H12a3.5 3.5 0 01-4-2.5', 'bg-[#0D3B9E]/10 text-[#0D3B9E]', '+R$ 120.000', 'Arrecadados'],
    ['M20.8 8.6a5.1 5.1 0 00-8.1-3.9l-.7.7-.7-.7a5.1 5.1 0 00-8.1 6.2L12 20l8.8-9.1a5.1 5.1 0 000-2.3z', 'bg-[#FA8002]/10 text-[#FA8002]', '+3.200', 'Doações realizadas'],
];

const PASSOS = [
    ['1. Escolha', 'Navegue pelas campanhas e escolha a causa que deseja apoiar.', 'M21 21l-4.3-4.3m1.3-5.2a6.5 6.5 0 11-13 0 6.5 6.5 0 0113 0z'],
    ['2. Doe', 'Faça sua doação de forma segura via PIX em segundos.', 'M20.8 8.6a5.1 5.1 0 00-8.1-3.9l-.7.7-.7-.7a5.1 5.1 0 00-8.1 6.2L12 20l8.8-9.1a5.1 5.1 0 000-2.3z'],
    ['3. Acompanhe', 'Veja o andamento da campanha com total transparência.', 'M12 3l7 4v5c0 4.5-2.8 8.4-7 9-4.2-.6-7-4.5-7-9V7l7-4zm-3 9l2 2 4-5'],
    ['4. Impacte', 'Sua doação chega a quem precisa e transforma vidas.', 'M16 19a4 4 0 00-8 0M12 12a3 3 0 100-6 3 3 0 000 6zm8 7a3 3 0 00-5.2-2'],
];

export default function Home({ destaques, ultimasDoacoes, estatisticas }) {
    const totalDoado = estatisticas?.total_doado ?? 15455;
    const totalDoacoes = estatisticas?.total_doacoes ?? 118;
    const totalDoadores = estatisticas?.total_doadores ?? 18;

    const campanhas = destaques?.length > 0
        ? destaques.slice(0, 3).map((campanha, indice) => ({
            titulo: campanha.titulo,
            descricao: campanha.resumo,
            imagem: IMAGENS_CAMPANHA[indice] ?? campanha.imagem_url,
            arrecadado: Number(campanha.valor_arrecadado),
            meta: Number(campanha.meta),
            doacoes: campanha.doacoes_confirmadas_count ?? campanha.total_doadores ?? 0,
            slug: campanha.slug,
        }))
        : CAMPANHAS_MOCKADAS;

    const ultimaDoacao = ultimasDoacoes?.[0];
    const nomeDoador = ultimaDoacao?.nome_exibicao ?? 'Maria';
    const valorDoador = ultimaDoacao
        ? Number(ultimaDoacao.valor).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })
        : '50,00';

    return (
        <AppLayout titulo="Aurora — Doe com confiança">
            <section className="relative h-[650px] min-h-[650px] max-h-[650px] overflow-hidden bg-[#011241] text-white">
                <div className="absolute inset-0 bg-[linear-gradient(110deg,#011241_0%,#02164B_45%,#06245F_72%,#0B2E78_100%)]"></div>

                <div className="relative z-10 mx-auto grid h-full max-w-[1180px] grid-cols-1 items-center px-6 lg:grid-cols-[48%_52%]">
                    <div className="max-w-xl">
                        <div className="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-4 py-2 text-xs font-semibold text-[#FFFFFF] shadow-[0_14px_36px_rgba(0,0,0,.18)] backdrop-blur">
                            <span className="inline-flex w-5 h-5 items-center justify-center rounded-full bg-[#FA8002]/15 text-[#FA8002]">
                                <svg className="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2"><path strokeLinecap="round" strokeLinejoin="round" d="M12 3l7 4v5c0 4.5-2.8 8.4-7 9-4.2-.6-7-4.5-7-9V7l7-4z"/></svg>
                            </span>
                            Pagamentos via PIX processados pela Confrapag
                        </div>

                        <h1 className="mt-6 max-w-[560px] font-serif text-4xl font-extrabold leading-[1.08] tracking-normal sm:text-5xl lg:text-[56px]">
                            Transforme solidariedade em{' '}
                            <span className="text-[#FA8002]">impacto real.</span>
                        </h1>

                        <p className="mt-5 max-w-[520px] text-[17px] leading-[1.7] text-[rgba(255,255,255,0.86)]">
                            Doe para campanhas de instituições verificadas e acompanhe, com total transparência,
                            cada real chegando a quem precisa.
                        </p>

                        <div className="mt-7 flex flex-col gap-3 sm:flex-row">
                            <Link
                                href={route('campanhas.index')}
                                className="inline-flex items-center justify-center gap-2 rounded-xl bg-[#FA8002] px-6 py-3.5 text-sm font-bold text-white shadow-[0_18px_35px_rgba(250,128,2,.24)] transition-colors hover:bg-[#E7661D]"
                            >
                                Ver campanhas
                                <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2"><path strokeLinecap="round" strokeLinejoin="round" d="M9 5l7 7-7 7"/></svg>
                            </Link>
                            <a
                                href="#como-funciona"
                                className="inline-flex items-center justify-center rounded-xl border border-white/25 bg-white/5 px-6 py-3.5 text-sm font-bold text-white transition-colors hover:bg-white/10"
                            >
                                Como funciona
                            </a>
                        </div>

                        <div className="mt-7 grid grid-cols-1 gap-3 border-t border-white/10 pt-6 sm:grid-cols-3">
                            {FEATURES_HERO.map(([icone, texto]) => (
                                <div key={texto} className="flex items-center gap-3">
                                    <span className="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-white/10 text-white">
                                        <svg className="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="1.7"><path strokeLinecap="round" strokeLinejoin="round" d={icone}/></svg>
                                    </span>
                                    <p className="text-xs leading-5 text-[#FFFFFF]">{texto}</p>
                                </div>
                            ))}
                        </div>

                        <div className="mt-5 grid grid-cols-3 gap-2.5">
                            {[
                                [`R$ ${totalDoado.toLocaleString('pt-BR')}`, 'arrecadados'],
                                [totalDoacoes.toLocaleString('pt-BR'), 'doações'],
                                [totalDoadores.toLocaleString('pt-BR'), 'doadores'],
                            ].map(([valor, label]) => (
                                <div key={label} className="rounded-xl border border-white/10 bg-white/10 px-3 py-3 backdrop-blur">
                                    <p className="text-base font-bold text-white">{valor}</p>
                                    <p className="mt-1 text-xs text-[#FFFFFF]">{label}</p>
                                </div>
                            ))}
                        </div>
                    </div>

                    <div className="relative mx-auto hidden h-[560px] w-full max-w-[640px] lg:block">
                        <div className="absolute left-[30px] top-[116px] z-[3] rounded-2xl border border-[rgba(255,255,255,0.18)] bg-[rgba(255,255,255,0.10)] px-3.5 py-2.5 shadow-[0_20px_50px_rgba(0,0,0,0.25)] backdrop-blur-[16px]">
                            <div className="flex items-center gap-3">
                                <span className="inline-flex h-8 w-8 items-center justify-center rounded-full bg-[#0D3B9E]/35 text-white">
                                    <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="1.8"><path strokeLinecap="round" strokeLinejoin="round" d="M16 19a4 4 0 00-8 0M12 12a3 3 0 100-6 3 3 0 000 6zm8 7a3 3 0 00-5.2-2"/></svg>
                                </span>
                                <div>
                                    <p className="text-[13px] font-bold">35 famílias</p>
                                    <p className="text-xs text-[#FFFFFF]">já foram ajudadas</p>
                                </div>
                            </div>
                        </div>

                        <div className="absolute right-[40px] top-[94px] z-[3] w-52 rounded-2xl border border-[rgba(255,255,255,0.18)] bg-[rgba(255,255,255,0.10)] p-3.5 shadow-[0_20px_50px_rgba(0,0,0,0.25)] backdrop-blur-[16px]">
                            <div className="flex items-center gap-3">
                                <span className="inline-flex h-8 w-8 items-center justify-center rounded-full bg-white/12 text-white">
                                    <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="1.8"><path strokeLinecap="round" strokeLinejoin="round" d="M12 21a9 9 0 100-18 9 9 0 000 18zm0-4.5a4.5 4.5 0 100-9 4.5 4.5 0 000 9zm3.2-7.7l2.2-2.2"/></svg>
                                </span>
                                <div>
                                    <p className="text-[13px] font-bold">Meta da campanha</p>
                                    <p className="text-xs text-[#FFFFFF]">78% concluída</p>
                                </div>
                            </div>
                            <div className="mt-3 h-2 rounded-full bg-white/15">
                                <div className="h-full w-[78%] rounded-full bg-[#FA8002]"></div>
                            </div>
                        </div>

                        <svg className="absolute inset-x-0 top-12 z-0 mx-auto h-[430px] w-[500px] text-[rgba(37,99,235,0.20)] opacity-[0.85]" viewBox="0 0 560 500" fill="none" aria-hidden="true">
                            <path fill="currentColor" d="M280 455C237 406 100 330 77 204C59 104 134 44 205 84C242 105 266 141 280 176C294 141 318 105 355 84C426 44 501 104 483 204C460 330 323 406 280 455Z"/>
                        </svg>
                        <div className="absolute inset-x-0 bottom-0 z-[2] mx-auto flex justify-center">
                            <img
                                src="/images/hero-doacao-corrigida.png"
                                alt="Família recebendo uma caixa de doação"
                                className="h-[480px] max-h-[480px] w-full translate-y-[35px] object-contain drop-shadow-[0_24px_52px_rgba(0,0,0,.32)]"
                            />
                        </div>

                        <div className="absolute bottom-[92px] right-[170px] z-[3] rounded-2xl border border-[rgba(255,255,255,0.18)] bg-[rgba(255,255,255,0.10)] px-3.5 py-2.5 shadow-[0_20px_50px_rgba(0,0,0,0.25)] backdrop-blur-[16px]">
                            <div className="flex items-center gap-3">
                                <span className="inline-flex h-8 w-8 items-center justify-center rounded-full bg-[#FA8002] text-xs font-bold text-white">
                                    {nomeDoador.substring(0, 1).toUpperCase()}
                                </span>
                                <div>
                                    <p className="text-[13px] font-bold">{nomeDoador} doou</p>
                                    <p className="text-xs text-[#FFFFFF]">R$ {valorDoador}</p>
                                </div>
                                <svg className="w-5 h-5 text-[#FA8002]" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="1.7"><path strokeLinecap="round" strokeLinejoin="round" d="M20.8 8.6a5.1 5.1 0 00-8.1-3.9l-.7.7-.7-.7a5.1 5.1 0 00-8.1 6.2L12 20l8.8-9.1a5.1 5.1 0 000-2.3z"/></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div className="absolute bottom-[-1px] left-0 z-20 w-full overflow-hidden leading-none">
                    <svg className="relative block h-[70px] w-full" viewBox="0 0 1440 100" preserveAspectRatio="none" aria-hidden="true">
                        <path d="M0,55 C180,25 360,80 540,58 C760,32 940,82 1140,55 C1300,34 1380,42 1440,28 L1440,100 L0,100 Z" fill="#F8F9FD" />
                    </svg>
                </div>
            </section>

            <section className="relative z-40 -mt-[30px] bg-[#F8F9FD]">
                <div className="mx-auto max-w-[1060px] px-6">
                    <div className="grid grid-cols-1 md:grid-cols-3 gap-5 rounded-3xl border border-[#011241]/10 bg-[#FFFFFF] px-7 py-7 shadow-[0_18px_55px_rgba(1,18,65,.08)]">
                        {STATS.map(([icone, classe, valor, label]) => (
                            <div key={label} className="flex items-center gap-5 md:justify-center">
                                <span className={`inline-flex w-16 h-16 shrink-0 items-center justify-center rounded-full ${classe}`}>
                                    <svg className="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="1.8"><path strokeLinecap="round" strokeLinejoin="round" d={icone}/></svg>
                                </span>
                                <div>
                                    <p className="text-2xl font-bold text-[#02164B]">{valor}</p>
                                    <p className="mt-1 text-sm text-[#02164B]/70">{label}</p>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            </section>

            <section className="bg-[#F8F9FD] py-16 lg:py-20">
                <div className="max-w-6xl mx-auto px-6 lg:px-8">
                    <div className="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <h2 className="font-serif text-2xl lg:text-3xl font-bold text-[#02164B]">Campanhas em destaque</h2>
                            <p className="mt-2 text-sm text-[#02164B]/70">Causas verificadas que já podem receber sua doação via PIX.</p>
                        </div>
                        <Link href={route('campanhas.index')} className="inline-flex items-center gap-2 text-sm font-bold text-[#0D3B9E] hover:text-[#042168]">
                            Ver todas as campanhas
                            <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2"><path strokeLinecap="round" strokeLinejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </Link>
                    </div>

                    <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        {campanhas.map((campanha, indice) => {
                            const percentual = campanha.meta > 0 ? Math.min(100, Math.round((campanha.arrecadado / campanha.meta) * 100)) : 0;
                            const url = campanha.slug ? route('campanhas.show', campanha.slug) : route('campanhas.index');

                            return (
                                <Link
                                    key={campanha.slug ?? indice}
                                    href={url}
                                    className="group block overflow-hidden rounded-2xl border border-[#011241]/10 bg-[#FFFFFF] shadow-[0_14px_38px_rgba(1,18,65,.07)] transition duration-300 hover:-translate-y-1 hover:shadow-[0_20px_50px_rgba(1,18,65,.12)]"
                                >
                                    <div className="aspect-[16/10] overflow-hidden bg-[#F8F9FD]">
                                        {campanha.imagem ? (
                                            <img src={campanha.imagem} alt={campanha.titulo} className="h-full w-full object-cover transition duration-700 group-hover:scale-[1.03]" />
                                        ) : (
                                            <div className="flex h-full w-full items-center justify-center bg-gradient-to-br from-[#0D3B9E]/15 to-[#FA8002]/20">
                                                <span className="font-serif text-5xl font-bold text-[#0D3B9E]/45">{campanha.titulo.substring(0, 1)}</span>
                                            </div>
                                        )}
                                    </div>
                                    <div className="p-6">
                                        <h3 className="font-serif text-lg font-bold text-[#02164B]">{campanha.titulo}</h3>
                                        <p className="mt-2 min-h-10 text-sm leading-6 text-[#02164B]/70">{campanha.descricao}</p>
                                        <div className="mt-5 flex items-baseline justify-between gap-3">
                                            <p className="text-sm font-bold text-[#02164B]">
                                                R$ {campanha.arrecadado.toLocaleString('pt-BR')}{' '}
                                                <span className="font-medium text-[#02164B]/55">de R$ {campanha.meta.toLocaleString('pt-BR')}</span>
                                            </p>
                                            <p className="text-xs font-bold text-[#02164B]">{percentual}%</p>
                                        </div>
                                        <div className="mt-3 h-2 overflow-hidden rounded-full bg-[#011241]/10">
                                            <div className="h-full rounded-full bg-[#0D3B9E]" style={{ width: `${percentual}%` }}></div>
                                        </div>
                                        <div className="mt-5 flex items-center gap-3">
                                            <div className="flex -space-x-2">
                                                {['#0D3B9E', '#FA8002', '#052F89'].map((cor) => (
                                                    <span key={cor} className="h-7 w-7 rounded-full border-2 border-white" style={{ background: cor }}></span>
                                                ))}
                                            </div>
                                            <span className="text-sm text-[#02164B]/70">{campanha.doacoes} doações</span>
                                        </div>
                                    </div>
                                </Link>
                            );
                        })}
                    </div>
                </div>
            </section>

            <section id="como-funciona" className="bg-[#F8F9FD] pb-16">
                <div className="max-w-6xl mx-auto px-6 lg:px-8">
                    <div className="rounded-3xl border border-[#011241]/10 bg-[#FFFFFF] px-6 py-8 shadow-[0_14px_45px_rgba(1,18,65,.06)] lg:px-8">
                        <h2 className="font-serif text-2xl font-bold text-[#02164B]">Como funciona</h2>
                        <div className="mt-8 grid grid-cols-1 md:grid-cols-4 gap-6">
                            {PASSOS.map(([titulo, texto, icone]) => (
                                <div key={titulo}>
                                    <span className="inline-flex w-14 h-14 items-center justify-center rounded-full bg-[#0D3B9E]/10 text-[#0D3B9E]">
                                        <svg className="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="1.7"><path strokeLinecap="round" strokeLinejoin="round" d={icone}/></svg>
                                    </span>
                                    <h3 className="mt-5 text-sm font-bold text-[#02164B]">{titulo}</h3>
                                    <p className="mt-2 text-sm leading-6 text-[#02164B]/70">{texto}</p>
                                </div>
                            ))}
                        </div>
                    </div>
                </div>
            </section>

            <section id="sobre-nos" className="bg-[#F8F9FD] pb-20">
                <div className="max-w-6xl mx-auto px-6 lg:px-8">
                    <div className="rounded-3xl bg-[#011241] px-8 py-10 text-white shadow-[0_24px_65px_rgba(1,18,65,.22)] lg:px-10">
                        <div className="flex flex-col gap-8 md:flex-row md:items-center md:justify-between">
                            <div className="flex items-start gap-5">
                                <span className="inline-flex w-16 h-16 shrink-0 items-center justify-center rounded-full bg-[#042168] text-white">
                                    <svg className="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.08A6.02 6.02 0 0116.5 3C19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                                </span>
                                <div>
                                    <h2 className="font-serif text-2xl lg:text-3xl font-bold leading-tight">
                                        Pequenas atitudes, grandes{' '}
                                        <span className="text-[#FA8002]">transformações.</span>
                                    </h2>
                                    <p className="mt-3 max-w-2xl text-sm leading-7 text-[#FFFFFF]">Juntos, podemos construir um futuro melhor para todos com doações rápidas, seguras e transparentes.</p>
                                </div>
                            </div>

                            <Link href={route('campanhas.index')} className="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-[#FA8002] px-8 py-4 text-sm font-bold text-white transition-colors hover:bg-[#E7661D]">
                                <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.08A6.02 6.02 0 0116.5 3C19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                                Quero fazer parte
                            </Link>
                        </div>
                    </div>
                </div>
            </section>
        </AppLayout>
    );
}
