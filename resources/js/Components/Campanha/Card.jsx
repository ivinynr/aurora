import { Link } from '@inertiajs/react';
import { motion } from 'framer-motion';
import { Star } from 'lucide-react';
import { fadeUp, hoverCard } from '../../Utils/animacoes';

const MotionLink = motion.create(Link);

export default function Card({ campanha }) {
    const percentual = Math.min(100, Math.max(0, campanha.percentual_arrecadado ?? 0));

    return (
        <MotionLink
            variants={fadeUp}
            {...hoverCard}
            href={route('campanhas.show', campanha.slug)}
            className="group bg-white rounded-2xl shadow-warm overflow-hidden block"
        >
            <div className="aspect-[16/10] relative overflow-hidden">
                {campanha.imagem_url ? (
                    <img
                        src={campanha.imagem_url}
                        alt={campanha.titulo}
                        className="w-full h-full object-cover group-hover:scale-[1.02] transition-transform duration-700"
                    />
                ) : (
                    <div className="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-[#0D3B9E]/15 to-[#FA8002]/20">
                        <span className="font-serif text-5xl font-bold text-[#0D3B9E]/40">{campanha.titulo.substring(0, 1)}</span>
                    </div>
                )}

                {campanha.destaque && (
                    <span className="absolute top-3 left-3 inline-flex items-center gap-1 bg-rosa-500 text-white text-[11px] font-medium px-2.5 py-1 rounded-full">
                        <Star className="w-3 h-3" fill="currentColor" strokeWidth={0} />
                        Destaque
                    </span>
                )}
            </div>

            <div className="p-5">
                <p className="text-xs text-bark-400 mb-1">{campanha.instituicao?.nome}</p>
                <h3 className="font-serif text-[16px] font-bold text-night-800 mb-2 group-hover:text-rosa-500 transition-colors line-clamp-2">
                    {campanha.titulo}
                </h3>
                <p className="text-[13px] text-bark-400 mb-4 line-clamp-2">{campanha.resumo}</p>

                <div>
                    <div className="flex items-baseline justify-between mb-1.5">
                        <span className="text-sm font-semibold text-night-800">
                            R$ {Number(campanha.valor_arrecadado).toLocaleString('pt-BR', { minimumFractionDigits: 0, maximumFractionDigits: 0 })}
                        </span>
                        <span className="text-xs font-bold text-bark-400">{Math.round(percentual)}%</span>
                    </div>
                    <div className="h-1.5 bg-cream-200 rounded-full overflow-hidden">
                        <div className="h-full rounded-full progress-fill" style={{ width: `${percentual}%` }} />
                    </div>
                </div>
            </div>
        </MotionLink>
    );
}
