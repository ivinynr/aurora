import { Link } from '@inertiajs/react';
import { motion } from 'framer-motion';
import { MapPin } from 'lucide-react';
import { fadeUp, hoverCard } from '../../Utils/animacoes';

const MotionLink = motion.create(Link);

export default function Card({ instituicao }) {
    const totalCampanhas = instituicao.campanhas_count ?? instituicao.campanhas?.length ?? 0;

    return (
        <MotionLink
            variants={fadeUp}
            {...hoverCard}
            href={route('instituicoes.show', instituicao.slug)}
            className="group bg-white rounded-xl shadow-warm border border-cream-200 overflow-hidden block"
        >
            <div className="aspect-[16/10] bg-cream-200 relative overflow-hidden">
                {instituicao.logo_url ? (
                    <img
                        src={instituicao.logo_url}
                        alt={instituicao.nome}
                        className="w-full h-full object-cover group-hover:scale-[1.02] transition-transform duration-700"
                    />
                ) : (
                    <div className="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-cream-200 to-cream-300">
                        <span className="font-serif text-4xl font-bold text-bark-200">{instituicao.nome.substring(0, 1)}</span>
                    </div>
                )}
            </div>

            <div className="p-5">
                <h3 className="font-serif text-lg font-bold text-bark-800 mb-1 group-hover:text-terra-500 transition-colors">
                    {instituicao.nome}
                </h3>

                {instituicao.missao ? (
                    <p className="text-sm text-bark-400 italic mb-3 line-clamp-1">"{instituicao.missao}"</p>
                ) : (
                    <p className="text-sm text-bark-400 mb-3 line-clamp-2">{instituicao.descricao}</p>
                )}

                <div className="mt-4 pt-3 border-t border-cream-200 flex items-center justify-between">
                    {instituicao.cidade ? (
                        <span className="inline-flex items-center gap-1 text-xs text-bark-300">
                            <MapPin className="w-3.5 h-3.5" strokeWidth={1.7} />
                            {instituicao.cidade}, {instituicao.estado}
                        </span>
                    ) : (
                        <span></span>
                    )}
                    <span className="text-xs font-medium text-bark-400">
                        {totalCampanhas} {totalCampanhas === 1 ? 'campanha' : 'campanhas'}
                    </span>
                </div>
            </div>
        </MotionLink>
    );
}
