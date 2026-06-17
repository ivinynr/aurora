import { Link } from '@inertiajs/react';
import { motion } from 'framer-motion';
import { Heart, Globe, Phone, Mail, ArrowLeft } from 'lucide-react';
import AppLayout from '../../../Layouts/AppLayout';
import Badge from '../../../Components/UI/Badge';
import Carrossel from '../../../Components/Instituicao/Carrossel';
import CampanhaCard from '../../../Components/Campanha/Card';
import InstituicaoCard from '../../../Components/Instituicao/Card';
import { fadeUp, containerStagger, hoverTap, viewportOnce } from '../../../Utils/animacoes';

const MotionLink = motion.create(Link);

export default function Show({ instituicao, relacionadas }) {
    const temCampanhas = instituicao.campanhas?.length > 0;
    const primeiraCampanha = instituicao.campanhas?.[0];
    const temContato = instituicao.telefone || instituicao.email || instituicao.instagram || instituicao.website;

    const instagramUrl = instituicao.instagram
        ? instituicao.instagram.startsWith('http')
            ? instituicao.instagram
            : `https://instagram.com/${instituicao.instagram.replace('@', '')}`
        : null;

    return (
        <AppLayout titulo={`${instituicao.nome} — Aurora`}>
            <section className="bg-cream-100 py-10 lg:py-14">
                <div className="max-w-7xl mx-auto px-6">
                    <Link href={route('instituicoes.index')} className="inline-flex items-center gap-1.5 text-sm text-bark-400 hover:text-bark-600 transition-colors mb-6">
                        <ArrowLeft className="w-4 h-4" strokeWidth={1.8} />
                        Todas as instituições
                    </Link>

                    <div className="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
                        <Carrossel fotos={instituicao.fotos_urls} nome={instituicao.nome} logoUrl={instituicao.logo_url} />

                        <motion.div initial="hidden" animate="show" variants={containerStagger} className="flex flex-col justify-center">
                            {instituicao.segmento_label && (
                                <motion.div variants={fadeUp} className="mb-3">
                                    <Badge cor={instituicao.segmento_cor}>{instituicao.segmento_label}</Badge>
                                </motion.div>
                            )}

                            <motion.h1 variants={fadeUp} className="font-serif text-2xl lg:text-4xl font-bold text-bark-800 leading-tight">
                                {instituicao.nome}
                            </motion.h1>

                            {instituicao.cidade && (
                                <motion.p variants={fadeUp} className="text-sm text-bark-400 mt-2">{instituicao.cidade}, {instituicao.estado}</motion.p>
                            )}

                            {temCampanhas && (
                                <motion.div variants={fadeUp} className="mt-6">
                                    <MotionLink
                                        {...hoverTap}
                                        href={route('doacao.create', primeiraCampanha.slug)}
                                        className="inline-flex items-center gap-2 bg-rosa-500 hover:bg-rosa-600 text-white rounded-xl px-7 py-3.5 text-sm font-semibold transition-colors"
                                    >
                                        <Heart className="w-4 h-4" fill="currentColor" strokeWidth={0} />
                                        Fazer doação
                                    </MotionLink>
                                </motion.div>
                            )}
                        </motion.div>
                    </div>
                </div>
            </section>

            <section className="max-w-7xl mx-auto px-6 py-12 space-y-8">
                <div className="grid grid-cols-1 lg:grid-cols-3 gap-10">
                    <div className="lg:col-span-2">
                        <h2 className="font-serif text-xl font-bold text-bark-800 mb-4">Sobre a instituição</h2>
                        <div className="text-bark-600 leading-relaxed text-[15px] space-y-4 font-light whitespace-pre-line">
                            {instituicao.descricao}
                        </div>

                        <div className="flex flex-wrap items-start gap-6 mt-6">
                            {instituicao.website && (
                                <motion.a
                                    {...hoverTap}
                                    href={instituicao.website}
                                    target="_blank"
                                    rel="noopener"
                                    className="inline-flex items-center gap-2 bg-cream-200 hover:bg-cream-300 text-bark-700 rounded-xl px-5 py-2.5 text-sm font-medium transition-colors"
                                >
                                    <Globe className="w-4 h-4" strokeWidth={1.6} />
                                    Ver site
                                </motion.a>
                            )}

                            {instituicao.selos?.length > 0 && (
                                <div>
                                    <p className="text-xs text-bark-300 uppercase tracking-wider font-semibold mb-2">Reconhecimentos</p>
                                    <div className="flex flex-wrap gap-2">
                                        {instituicao.selos.map((selo, indice) => (
                                            <Badge key={indice} cor="sage">{selo.nome}</Badge>
                                        ))}
                                    </div>
                                </div>
                            )}
                        </div>
                    </div>

                    {temContato && (
                        <div>
                            <h2 className="font-serif text-xl font-bold text-bark-800 mb-4">Contato</h2>
                            <div className="flex flex-col gap-4 text-sm text-bark-600">
                                {instituicao.telefone && (
                                    <a href={`tel:${instituicao.telefone.replace(/\D/g, '')}`} className="flex items-center gap-2 hover:text-bark-800 transition-colors">
                                        <Phone className="w-4 h-4 text-bark-300" strokeWidth={1.6} />
                                        <span>{instituicao.telefone}</span>
                                    </a>
                                )}
                                {instituicao.email && (
                                    <a href={`mailto:${instituicao.email}`} className="flex items-center gap-2 hover:text-bark-800 transition-colors">
                                        <Mail className="w-4 h-4 text-bark-300" strokeWidth={1.6} />
                                        <span>{instituicao.email}</span>
                                    </a>
                                )}
                                {instagramUrl && (
                                    <a href={instagramUrl} target="_blank" rel="noopener" className="flex items-center gap-2 hover:text-bark-800 transition-colors">
                                        <svg className="w-4 h-4 text-bark-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="1.5">
                                            <path strokeLinecap="round" strokeLinejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z"/>
                                            <path strokeLinecap="round" strokeLinejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z"/>
                                        </svg>
                                        <span>{instituicao.instagram}</span>
                                    </a>
                                )}
                            </div>
                        </div>
                    )}
                </div>

                {temCampanhas && (
                    <div className="border-t border-cream-200 pt-8">
                        <h2 className="font-serif text-xl font-bold text-bark-800 mb-5">Campanhas</h2>
                        <motion.div
                            variants={containerStagger}
                            initial="hidden"
                            whileInView="show"
                            viewport={viewportOnce}
                            className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6"
                        >
                            {instituicao.campanhas.map((campanha) => (
                                <CampanhaCard key={campanha.id} campanha={campanha} />
                            ))}
                        </motion.div>
                    </div>
                )}

                {relacionadas?.length > 0 && (
                    <div className="border-t border-cream-200 pt-8">
                        <h2 className="font-serif text-xl font-bold text-bark-800 mb-5">Instituições do mesmo segmento</h2>
                        <motion.div
                            variants={containerStagger}
                            initial="hidden"
                            whileInView="show"
                            viewport={viewportOnce}
                            className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5"
                        >
                            {relacionadas.map((rel) => (
                                <InstituicaoCard key={rel.id} instituicao={rel} />
                            ))}
                        </motion.div>
                    </div>
                )}
            </section>
        </AppLayout>
    );
}
