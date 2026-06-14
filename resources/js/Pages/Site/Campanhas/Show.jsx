import { useState } from 'react';
import { Link } from '@inertiajs/react';
import { motion } from 'framer-motion';
import { BadgeCheck, Lock, Share2, ArrowLeft } from 'lucide-react';
import AppLayout from '../../../Layouts/AppLayout';
import BarraProgresso from '../../../Components/UI/BarraProgresso';
import MuralApoiadores from '../../../Components/Instituicao/MuralApoiadores';
import { tempoRelativo } from '../../../Utils/tempo';
import { fadeUp, hoverTap } from '../../../Utils/animacoes';

const MotionLink = motion.create(Link);

function extrairYoutubeId(url) {
    if (!url) return null;
    const match = url.match(/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/);
    return match ? match[1] : null;
}

export default function Show({ campanha, totalDoadores }) {
    const [copiado, setCopiado] = useState(false);
    const youtubeId = extrairYoutubeId(campanha.video_url);

    function compartilhar() {
        navigator.clipboard.writeText(window.location.href);
        setCopiado(true);
        setTimeout(() => setCopiado(false), 2000);
    }

    return (
        <AppLayout titulo={`${campanha.titulo} — Aurora`} descricao={campanha.resumo}>
            <div className="relative bg-night-800 overflow-hidden">
                {youtubeId ? (
                    <div className="aspect-video max-h-[60vh] w-full">
                        <iframe
                            src={`https://www.youtube.com/embed/${youtubeId}?rel=0&modestbranding=1`}
                            className="w-full h-full"
                            frameBorder="0"
                            allow="encrypted-media"
                            allowFullScreen
                        />
                    </div>
                ) : campanha.imagem_url ? (
                    <div className="w-full flex justify-center py-6 px-4">
                        <img
                            src={campanha.imagem_url}
                            alt={campanha.titulo}
                            className="mx-auto max-h-[55vh] w-auto max-w-4xl rounded-2xl object-cover shadow-warm-lg"
                        />
                    </div>
                ) : (
                    <div className="h-4"></div>
                )}
            </div>

            <section className="max-w-5xl mx-auto px-6 pt-8 pb-24">
                <Link href={route('campanhas.index')} className="inline-flex items-center gap-1.5 text-sm text-bark-400 hover:text-bark-600 transition-colors mb-6">
                    <ArrowLeft className="w-4 h-4" strokeWidth={1.8} />
                    Voltar para campanhas
                </Link>

                <div className="grid grid-cols-1 lg:grid-cols-3 gap-10">
                    <div className="lg:col-span-2 space-y-10">
                        <motion.div initial="hidden" animate="show" variants={fadeUp}>
                            <Link
                                href={route('instituicoes.show', campanha.instituicao.slug)}
                                className="inline-flex items-center gap-1.5 text-xs font-medium text-terra-500 hover:text-terra-600 mb-2"
                            >
                                <BadgeCheck className="w-3.5 h-3.5" strokeWidth={1.8} />
                                {campanha.instituicao.nome}
                            </Link>
                            <h1 className="font-serif text-3xl lg:text-4xl font-bold text-night-800 leading-tight">{campanha.titulo}</h1>
                            <p className="text-lg text-bark-400 mt-3">{campanha.resumo}</p>
                        </motion.div>

                        <div className="text-bark-600 leading-relaxed text-[16px] space-y-4 font-light whitespace-pre-line">
                            {campanha.descricao}
                        </div>

                        {campanha.atualizacoes?.length > 0 && (
                            <div className="border-t border-cream-200 pt-8">
                                <h2 className="font-serif text-xl font-bold text-night-800 mb-5">Atualizações da campanha</h2>
                                <div className="space-y-6">
                                    {campanha.atualizacoes.map((att) => (
                                        <div key={att.id} className="relative pl-6 border-l-2 border-cream-300">
                                            <div className="absolute left-[-5px] top-1.5 w-2 h-2 rounded-full bg-terra-500"></div>
                                            <p className="text-xs text-bark-300 mb-1">
                                                {new Intl.DateTimeFormat('pt-BR').format(new Date(att.created_at))} · {tempoRelativo(att.created_at)}
                                            </p>
                                            <h3 className="font-serif font-bold text-night-800">{att.titulo}</h3>
                                            {att.imagem_url && (
                                                <img src={att.imagem_url} alt={att.titulo} className="rounded-xl mt-3 mb-2 max-h-72 w-full object-cover" />
                                            )}
                                            <p className="text-sm text-bark-500 mt-1 leading-relaxed">{att.descricao}</p>
                                        </div>
                                    ))}
                                </div>
                            </div>
                        )}
                    </div>

                    <div className="space-y-6">
                        <div className="bg-white rounded-2xl shadow-warm border border-cream-200 p-6 lg:sticky lg:top-20">
                            <BarraProgresso
                                percentual={campanha.percentual_arrecadado}
                                meta={campanha.meta}
                                arrecadado={campanha.valor_arrecadado}
                                tamanho="lg"
                            />

                            <div className="grid grid-cols-2 gap-3 mt-5 mb-5">
                                <div className="text-center bg-cream-100 rounded-xl py-3">
                                    <p className="text-lg font-bold text-night-800">{totalDoadores}</p>
                                    <p className="text-xs text-bark-400">apoiadores</p>
                                </div>
                                <div className="text-center bg-cream-100 rounded-xl py-3">
                                    <p className="text-lg font-bold text-night-800">{Math.round(campanha.percentual_arrecadado)}%</p>
                                    <p className="text-xs text-bark-400">da meta</p>
                                </div>
                            </div>

                            {campanha.aceita_doacoes ? (
                                <>
                                    <MotionLink
                                        {...hoverTap}
                                        href={route('doacao.create', campanha.slug)}
                                        className="block w-full py-3.5 text-sm font-semibold text-white bg-rosa-500 hover:bg-rosa-600 rounded-xl transition-colors text-center"
                                    >
                                        Doar agora
                                    </MotionLink>
                                    <p className="text-center text-xs text-bark-300 mt-3 flex items-center justify-center gap-1">
                                        <Lock className="w-3.5 h-3.5" strokeWidth={1.5} />
                                        Pagamento seguro via PIX
                                    </p>
                                </>
                            ) : (
                                <div className="w-full py-3.5 text-sm font-semibold text-bark-400 bg-cream-200 rounded-xl text-center">
                                    Campanha encerrada
                                </div>
                            )}

                            <motion.button
                                {...hoverTap}
                                type="button"
                                onClick={compartilhar}
                                className="w-full mt-3 py-2.5 text-sm font-medium text-bark-500 hover:text-bark-700 border border-cream-300 rounded-xl transition-colors flex items-center justify-center gap-2"
                            >
                                <Share2 className="w-4 h-4" strokeWidth={1.7} />
                                <span>{copiado ? 'Link copiado!' : 'Compartilhar campanha'}</span>
                            </motion.button>
                        </div>

                        {campanha.doacoes?.length > 0 && (
                            <div className="bg-white rounded-2xl shadow-warm border border-cream-200 p-6">
                                <p className="text-xs text-bark-300 uppercase tracking-wider font-semibold mb-4">Apoiadores recentes</p>
                                <MuralApoiadores doacoes={campanha.doacoes} />
                            </div>
                        )}
                    </div>
                </div>
            </section>
        </AppLayout>
    );
}
