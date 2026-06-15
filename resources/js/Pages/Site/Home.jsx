import { Link } from '@inertiajs/react';
import { motion } from 'framer-motion';
import {
    ShieldCheck,
    Lock,
    BarChart3,
    Users,
    DollarSign,
    Heart,
    Search,
    ArrowRight,
    Target,
    MapPin,
} from 'lucide-react';
import AppLayout from '../../Layouts/AppLayout';
import { fadeUp, fadeInScale, containerStagger, flutuar, hoverTap, viewportOnce } from '../../Utils/animacoes';

const MotionLink = motion.create(Link);

const FEATURES_HERO = [
    [ShieldCheck, 'Instituições verificadas'],
    [Lock, 'Pagamento seguro via PIX'],
    [BarChart3, 'Transparência total'],
];

const STATS = [
    [Users, 'bg-[#0D3B9E]/10 text-[#0D3B9E]', '+500', 'Famílias ajudadas'],
    [DollarSign, 'bg-[#0D3B9E]/10 text-[#0D3B9E]', '+R$ 120.000', 'Arrecadados'],
    [Heart, 'bg-[#FA8002]/10 text-[#FA8002]', '+3.200', 'Doações realizadas'],
];

const PASSOS = [
    ['1. Escolha', 'Navegue pelas campanhas e escolha a causa que deseja apoiar.', Search],
    ['2. Doe', 'Faça sua doação de forma segura via PIX em segundos.', Heart],
    ['3. Acompanhe', 'Veja o andamento da campanha com total transparência.', ShieldCheck],
    ['4. Impacte', 'Sua doação chega a quem precisa e transforma vidas.', Users],
];

export default function Home({ destaques, ultimasDoacoes, instituicoes }) {
    const campanhas = (destaques ?? []).slice(0, 3).map((campanha) => ({
        titulo: campanha.titulo,
        descricao: campanha.resumo,
        imagem: campanha.imagem_url,
        arrecadado: Number(campanha.valor_arrecadado),
        meta: Number(campanha.meta),
        doacoes: campanha.doacoes_confirmadas_count ?? campanha.total_doadores ?? 0,
        slug: campanha.slug,
    }));

    const instituicoesDestaque = (instituicoes ?? []).slice(0, 3);

    const ultimaDoacao = ultimasDoacoes?.[0];

    return (
        <AppLayout titulo="Aurora — Doe com confiança" navbarTransparente>
            <section className="relative h-[650px] min-h-[650px] overflow-hidden bg-[#011241] pt-[88px] text-white">
                <div className="absolute inset-0 bg-[radial-gradient(circle_at_72%_45%,rgba(18,58,140,0.95)_0%,rgba(6,36,95,0.95)_35%,rgba(2,22,75,1)_68%,rgba(1,18,65,1)_100%)]"></div>

                <div className="relative z-20 mx-auto grid h-full max-w-[1180px] grid-cols-1 items-center px-6 lg:grid-cols-[48%_52%]">
                    <motion.div className="max-w-xl -translate-y-[35px]" variants={containerStagger} initial="hidden" animate="show">
                        <motion.div variants={fadeUp} className="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-4 py-2 text-xs font-semibold text-[#FFFFFF] shadow-[0_14px_36px_rgba(0,0,0,.18)] backdrop-blur">
                            <span className="inline-flex w-5 h-5 items-center justify-center rounded-full bg-[#FA8002]/15 text-[#FA8002]">
                                <ShieldCheck className="w-3.5 h-3.5" strokeWidth={2} />
                            </span>
                            Pagamentos via PIX processados pela Confrapag
                        </motion.div>

                        <motion.h1 variants={fadeUp} className="mt-6 max-w-[560px] font-serif text-4xl font-extrabold leading-[1.08] tracking-normal sm:text-5xl lg:text-[56px]">
                            Transforme solidariedade em{' '}
                            <span className="text-[#FA8002]">impacto real.</span>
                        </motion.h1>

                        <motion.p variants={fadeUp} className="mt-5 max-w-[520px] text-[17px] leading-[1.7] text-[rgba(255,255,255,0.86)]">
                            Doe para campanhas de instituições verificadas e acompanhe, com total transparência,
                            cada real chegando a quem precisa.
                        </motion.p>

                        <motion.div variants={fadeUp} className="mt-7 flex flex-col gap-3 sm:flex-row">
                            <MotionLink
                                {...hoverTap}
                                href={route('campanhas.index')}
                                className="inline-flex items-center justify-center gap-2 rounded-xl bg-[#FA8002] px-6 py-3.5 text-sm font-bold text-white shadow-[0_18px_35px_rgba(250,128,2,.24)] transition-colors hover:bg-[#E7661D]"
                            >
                                Ver campanhas
                                <ArrowRight className="w-4 h-4" strokeWidth={2} />
                            </MotionLink>
                            <motion.a
                                {...hoverTap}
                                href="#como-funciona"
                                className="inline-flex items-center justify-center rounded-xl border border-white/25 bg-white/5 px-6 py-3.5 text-sm font-bold text-white transition-colors hover:bg-white/10"
                            >
                                Como funciona
                            </motion.a>
                        </motion.div>

                        <motion.div variants={fadeUp} className="relative z-30 mt-7 -translate-y-3 grid grid-cols-1 gap-3 border-t border-white/10 pt-6 sm:grid-cols-3">
                            {FEATURES_HERO.map(([Icone, texto]) => (
                                <div key={texto} className="flex items-center gap-3">
                                    <span className="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-white/10 text-white">
                                        <Icone className="h-4 w-4" strokeWidth={1.7} />
                                    </span>
                                    <p className="text-xs leading-5 text-[#FFFFFF]">{texto}</p>
                                </div>
                            ))}
                        </motion.div>

                    </motion.div>

                    <motion.div className="relative mx-auto hidden h-[560px] w-full max-w-[640px] lg:block" variants={fadeInScale} initial="hidden" animate="show">
                        <motion.div {...flutuar(0)} className="absolute left-[30px] top-[116px] z-[3] rounded-2xl border border-[rgba(255,255,255,0.18)] bg-[rgba(255,255,255,0.10)] px-3.5 py-2.5 shadow-[0_20px_50px_rgba(0,0,0,0.25)] backdrop-blur-[16px]">
                            <div className="flex items-center gap-3">
                                <span className="inline-flex h-8 w-8 items-center justify-center rounded-full bg-[#0D3B9E]/35 text-white">
                                    <Users className="w-4 h-4" strokeWidth={1.8} />
                                </span>
                                <div>
                                    <p className="text-[13px] font-bold">35 famílias</p>
                                    <p className="text-xs text-[#FFFFFF]">já foram ajudadas</p>
                                </div>
                            </div>
                        </motion.div>

                        <motion.div {...flutuar(1.3)} className="absolute right-[40px] top-[94px] z-[3] w-52 rounded-2xl border border-[rgba(255,255,255,0.18)] bg-[rgba(255,255,255,0.10)] p-3.5 shadow-[0_20px_50px_rgba(0,0,0,0.25)] backdrop-blur-[16px]">
                            <div className="flex items-center gap-3">
                                <span className="inline-flex h-8 w-8 items-center justify-center rounded-full bg-white/12 text-white">
                                    <Target className="w-5 h-5" strokeWidth={1.8} />
                                </span>
                                <div>
                                    <p className="text-[13px] font-bold">Meta da campanha</p>
                                    <p className="text-xs text-[#FFFFFF]">78% concluída</p>
                                </div>
                            </div>
                            <div className="mt-3 h-2 rounded-full bg-white/15">
                                <div className="h-full w-[78%] rounded-full bg-[#FA8002]"></div>
                            </div>
                        </motion.div>

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

                        {ultimaDoacao && (
                            <motion.div {...flutuar(2.2)} className="absolute bottom-[92px] right-[170px] z-[3] rounded-2xl border border-[rgba(255,255,255,0.18)] bg-[rgba(255,255,255,0.10)] px-3.5 py-2.5 shadow-[0_20px_50px_rgba(0,0,0,0.25)] backdrop-blur-[16px]">
                                <div className="flex items-center gap-3">
                                    <span className="inline-flex h-8 w-8 items-center justify-center rounded-full bg-[#FA8002] text-xs font-bold text-white">
                                        {ultimaDoacao.nome_exibicao.substring(0, 1).toUpperCase()}
                                    </span>
                                    <div>
                                        <p className="text-[13px] font-bold">{ultimaDoacao.nome_exibicao} doou</p>
                                        <p className="text-xs text-[#FFFFFF]">R$ {Number(ultimaDoacao.valor).toFixed(2).replace('.', ',')}</p>
                                    </div>
                                    <Heart className="w-5 h-5 text-[#FA8002]" strokeWidth={1.7} fill="currentColor" />
                                </div>
                            </motion.div>
                        )}
                    </motion.div>
                </div>

                <div className="absolute bottom-[-1px] left-0 w-full overflow-hidden leading-none z-20 pointer-events-none">
                    <svg
                        className="relative block w-full h-[90px]"
                        viewBox="0 0 1440 120"
                        preserveAspectRatio="none"
                        aria-hidden="true"
                    >
                        <path
                            d="M0,72 C180,28 360,100 560,74 C760,48 940,92 1140,68 C1300,48 1380,56 1440,38 L1440,120 L0,120 Z"
                            fill="#F8F9FD"
                        />
                    </svg>
                </div>
            </section>

            <section className="relative z-40 -mt-px bg-[#F8F9FD] pb-12">
                <div className="relative z-30 max-w-[1060px] mx-auto mt-[70px] px-6">
                    <motion.div
                        variants={containerStagger}
                        initial="hidden"
                        whileInView="show"
                        viewport={viewportOnce}
                        className="grid grid-cols-1 md:grid-cols-3 gap-5 rounded-3xl border border-[#011241]/10 bg-[#FFFFFF] px-7 py-7 shadow-[0_18px_55px_rgba(1,18,65,.08)]"
                    >
                        {STATS.map(([Icone, classe, valor, label]) => (
                            <motion.div variants={fadeUp} key={label} className="flex items-center gap-5 md:justify-center">
                                <span className={`inline-flex w-16 h-16 shrink-0 items-center justify-center rounded-full ${classe}`}>
                                    <Icone className="w-8 h-8" strokeWidth={1.8} />
                                </span>
                                <div>
                                    <p className="text-2xl font-bold text-[#02164B]">{valor}</p>
                                    <p className="mt-1 text-sm text-[#02164B]/70">{label}</p>
                                </div>
                            </motion.div>
                        ))}
                    </motion.div>
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
                            <ArrowRight className="w-4 h-4" strokeWidth={2} />
                        </Link>
                    </div>

                    <motion.div
                        variants={containerStagger}
                        initial="hidden"
                        whileInView="show"
                        viewport={viewportOnce}
                        className="grid grid-cols-1 lg:grid-cols-3 gap-6"
                    >
                        {campanhas.map((campanha, indice) => {
                            const percentual = campanha.meta > 0 ? Math.min(100, Math.round((campanha.arrecadado / campanha.meta) * 100)) : 0;
                            const url = campanha.slug ? route('campanhas.show', campanha.slug) : route('campanhas.index');

                            return (
                                <MotionLink
                                    key={campanha.slug ?? indice}
                                    variants={fadeUp}
                                    whileHover={{ y: -6, scale: 1.03 }}
                                    transition={{ type: 'spring', stiffness: 300, damping: 22 }}
                                    href={url}
                                    className="group block overflow-hidden rounded-2xl border border-[#011241]/10 bg-[#FFFFFF] shadow-[0_14px_38px_rgba(1,18,65,.07)] hover:shadow-[0_20px_50px_rgba(1,18,65,.12)]"
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
                                </MotionLink>
                            );
                        })}
                    </motion.div>
                </div>
            </section>

            <section id="como-funciona" className="scroll-mt-24 bg-[#F8F9FD] pb-16">
                <div className="max-w-6xl mx-auto px-6 lg:px-8">
                    <div className="rounded-3xl border border-[#011241]/10 bg-[#FFFFFF] px-6 py-8 shadow-[0_14px_45px_rgba(1,18,65,.06)] lg:px-8">
                        <h2 className="font-serif text-2xl font-bold text-[#02164B]">Como funciona</h2>
                        <motion.div
                            variants={containerStagger}
                            initial="hidden"
                            whileInView="show"
                            viewport={viewportOnce}
                            className="mt-8 grid grid-cols-1 md:grid-cols-4 gap-6"
                        >
                            {PASSOS.map(([titulo, texto, Icone]) => (
                                <motion.div variants={fadeUp} key={titulo}>
                                    <span className="inline-flex w-14 h-14 items-center justify-center rounded-full bg-[#0D3B9E]/10 text-[#0D3B9E]">
                                        <Icone className="w-7 h-7" strokeWidth={1.7} />
                                    </span>
                                    <h3 className="mt-5 text-sm font-bold text-[#02164B]">{titulo}</h3>
                                    <p className="mt-2 text-sm leading-6 text-[#02164B]/70">{texto}</p>
                                </motion.div>
                            ))}
                        </motion.div>
                    </div>
                </div>
            </section>

            <section className="bg-[#F8F9FD] pb-16 lg:pb-20">
                <div className="max-w-6xl mx-auto px-6 lg:px-8">
                    <div className="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <h2 className="font-serif text-2xl lg:text-3xl font-bold text-[#02164B]">Instituições em destaque</h2>
                            <p className="mt-2 text-sm text-[#02164B]/70">Organizações verificadas que você pode apoiar com confiança.</p>
                        </div>
                        <Link href={route('instituicoes.index')} className="inline-flex items-center gap-2 text-sm font-bold text-[#0D3B9E] hover:text-[#042168]">
                            Ver todas as instituições
                            <ArrowRight className="w-4 h-4" strokeWidth={2} />
                        </Link>
                    </div>

                    <motion.div
                        variants={containerStagger}
                        initial="hidden"
                        whileInView="show"
                        viewport={viewportOnce}
                        className="grid grid-cols-1 lg:grid-cols-3 gap-6"
                    >
                        {instituicoesDestaque.map((instituicao, indice) => {
                            const url = instituicao.slug ? route('instituicoes.show', instituicao.slug) : route('instituicoes.index');
                            const totalCampanhas = instituicao.campanhas_count ?? 0;

                            return (
                                <MotionLink
                                    key={instituicao.slug ?? indice}
                                    variants={fadeUp}
                                    whileHover={{ y: -6, scale: 1.03 }}
                                    transition={{ type: 'spring', stiffness: 300, damping: 22 }}
                                    href={url}
                                    className="group block overflow-hidden rounded-2xl border border-[#011241]/10 bg-[#FFFFFF] shadow-[0_14px_38px_rgba(1,18,65,.07)] hover:shadow-[0_20px_50px_rgba(1,18,65,.12)]"
                                >
                                    <div className="aspect-[16/10] overflow-hidden bg-[#F8F9FD]">
                                        {instituicao.logo_url ? (
                                            <img src={instituicao.logo_url} alt={instituicao.nome} className="h-full w-full object-cover transition duration-700 group-hover:scale-[1.03]" />
                                        ) : (
                                            <div className="flex h-full w-full items-center justify-center bg-gradient-to-br from-[#0D3B9E]/15 to-[#FA8002]/20">
                                                <span className="font-serif text-5xl font-bold text-[#0D3B9E]/45">{instituicao.nome.substring(0, 1)}</span>
                                            </div>
                                        )}
                                    </div>
                                    <div className="p-6">
                                        <h3 className="font-serif text-lg font-bold text-[#02164B]">{instituicao.nome}</h3>
                                        <p className="mt-2 min-h-10 text-sm leading-6 text-[#02164B]/70 line-clamp-2">
                                            {instituicao.missao || instituicao.descricao}
                                        </p>
                                        <div className="mt-5 flex items-center justify-between gap-3">
                                            {instituicao.cidade ? (
                                                <span className="inline-flex items-center gap-1 text-xs text-[#02164B]/60">
                                                    <MapPin className="w-3.5 h-3.5" strokeWidth={1.7} />
                                                    {instituicao.cidade}, {instituicao.estado}
                                                </span>
                                            ) : <span />}
                                            <span className="text-xs font-bold text-[#02164B]">
                                                {totalCampanhas} {totalCampanhas === 1 ? 'campanha' : 'campanhas'}
                                            </span>
                                        </div>
                                    </div>
                                </MotionLink>
                            );
                        })}
                    </motion.div>
                </div>
            </section>

            <section id="sobre-nos" className="scroll-mt-24 bg-[#F8F9FD] pb-20">
                <div className="max-w-6xl mx-auto px-6 lg:px-8">
                    <motion.div
                        initial={{ opacity: 0, y: 30 }}
                        whileInView={{ opacity: 1, y: 0 }}
                        viewport={viewportOnce}
                        transition={{ duration: 0.6, ease: 'easeOut' }}
                        className="rounded-3xl bg-[#011241] px-8 py-10 text-white shadow-[0_24px_65px_rgba(1,18,65,.22)] lg:px-10"
                    >
                        <div className="flex flex-col gap-8 md:flex-row md:items-center md:justify-between">
                            <div className="flex items-start gap-5">
                                <span className="inline-flex w-16 h-16 shrink-0 items-center justify-center rounded-full bg-[#042168] text-white">
                                    <Heart className="w-8 h-8" fill="currentColor" strokeWidth={0} />
                                </span>
                                <div>
                                    <h2 className="font-serif text-2xl lg:text-3xl font-bold leading-tight">
                                        Pequenas atitudes, grandes{' '}
                                        <span className="text-[#FA8002]">transformações.</span>
                                    </h2>
                                    <p className="mt-3 max-w-2xl text-sm leading-7 text-[#FFFFFF]">Juntos, podemos construir um futuro melhor para todos com doações rápidas, seguras e transparentes.</p>
                                </div>
                            </div>

                            <MotionLink {...hoverTap} href={route('campanhas.index')} className="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-[#FA8002] px-8 py-4 text-sm font-bold text-white transition-colors hover:bg-[#E7661D]">
                                <Heart className="w-5 h-5" fill="currentColor" strokeWidth={0} />
                                Quero fazer parte
                            </MotionLink>
                        </div>
                    </motion.div>
                </div>
            </section>
        </AppLayout>
    );
}
