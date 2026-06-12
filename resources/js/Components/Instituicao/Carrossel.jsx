import { useCarrossel } from '../../Hooks/useCarrossel';

export default function Carrossel({ fotos, nome, logoUrl }) {
    const { atual, irPara, pausar, iniciar } = useCarrossel(fotos.length);

    return (
        <div className="space-y-3" onMouseEnter={pausar} onMouseLeave={iniciar}>
            <div className="aspect-[3/2] rounded-2xl overflow-hidden bg-cream-200 relative group">
                {fotos.length > 0 ? (
                    fotos.map((foto, indice) => (
                        <img
                            key={indice}
                            src={foto}
                            alt={nome}
                            className={`absolute inset-0 w-full h-full object-cover transition-opacity duration-500 ${
                                atual === indice ? 'opacity-100' : 'opacity-0'
                            }`}
                        />
                    ))
                ) : logoUrl ? (
                    <img src={logoUrl} alt={nome} className="w-full h-full object-cover" />
                ) : (
                    <div className="w-full h-full flex items-center justify-center bg-gradient-to-br from-cream-200 to-cream-300">
                        <span className="font-serif text-6xl font-bold text-bark-200">{nome.substring(0, 1)}</span>
                    </div>
                )}

                {fotos.length > 1 && (
                    <>
                        <button
                            type="button"
                            onClick={() => irPara((atual - 1 + fotos.length) % fotos.length)}
                            className="absolute left-3 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-black/30 hover:bg-black/50 text-white flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity"
                        >
                            <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5"><path strokeLinecap="round" strokeLinejoin="round" d="M15 19l-7-7 7-7"/></svg>
                        </button>
                        <button
                            type="button"
                            onClick={() => irPara((atual + 1) % fotos.length)}
                            className="absolute right-3 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-black/30 hover:bg-black/50 text-white flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity"
                        >
                            <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5"><path strokeLinecap="round" strokeLinejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </button>

                        <div className="absolute bottom-3 left-1/2 -translate-x-1/2 flex gap-1.5">
                            {fotos.map((_, indice) => (
                                <button
                                    key={indice}
                                    type="button"
                                    onClick={() => irPara(indice)}
                                    className={`h-2 rounded-full transition-all duration-300 ${
                                        atual === indice ? 'bg-white w-6' : 'bg-white/50 w-2 hover:bg-white/80'
                                    }`}
                                />
                            ))}
                        </div>
                    </>
                )}
            </div>
        </div>
    );
}
