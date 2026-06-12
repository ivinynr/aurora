import { Link } from '@inertiajs/react';
import BarraProgresso from '../UI/BarraProgresso';

export default function Card({ campanha }) {
    return (
        <Link
            href={route('campanhas.show', campanha.slug)}
            className="group bg-white rounded-2xl shadow-warm border border-cream-200 overflow-hidden card-lift block"
        >
            <div className="h-44 bg-cream-200 relative overflow-hidden">
                {campanha.imagem_url ? (
                    <img
                        src={campanha.imagem_url}
                        alt={campanha.titulo}
                        className="w-full h-full object-cover group-hover:scale-[1.02] transition-transform duration-700"
                    />
                ) : (
                    <div className="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-cream-200 to-cream-300">
                        <span className="font-serif text-4xl font-bold text-bark-200">{campanha.titulo.substring(0, 1)}</span>
                    </div>
                )}

                {campanha.destaque && (
                    <span className="absolute top-3 left-3 inline-flex items-center gap-1 bg-rosa-500 text-white text-[11px] font-medium px-2.5 py-1 rounded-full">
                        <svg className="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.957a1 1 0 00.95.69h4.162c.969 0 1.371 1.24.588 1.81l-3.368 2.447a1 1 0 00-.364 1.118l1.287 3.957c.3.921-.755 1.688-1.54 1.118l-3.367-2.447a1 1 0 00-1.175 0l-3.368 2.447c-.784.57-1.838-.197-1.539-1.118l1.286-3.957a1 1 0 00-.363-1.118L2.075 9.4c-.783-.57-.38-1.81.588-1.81h4.162a1 1 0 00.95-.69l1.285-3.957z" />
                        </svg>
                        Destaque
                    </span>
                )}
            </div>

            <div className="p-5">
                <p className="text-xs text-bark-300 mb-1">{campanha.instituicao?.nome}</p>
                <h3 className="font-serif text-[16px] font-bold text-night-800 mb-2 group-hover:text-rosa-500 transition-colors line-clamp-2">
                    {campanha.titulo}
                </h3>
                <p className="text-[13px] text-bark-400 mb-4 line-clamp-2">{campanha.resumo}</p>

                <BarraProgresso
                    percentual={campanha.percentual_arrecadado}
                    meta={campanha.meta}
                    arrecadado={campanha.valor_arrecadado}
                    tamanho="sm"
                />
            </div>
        </Link>
    );
}
