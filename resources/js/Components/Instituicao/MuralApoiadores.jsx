import { tempoRelativo } from '../../Utils/tempo';

export default function MuralApoiadores({ doacoes }) {
    const lista = doacoes.slice(0, 10);

    if (lista.length === 0) {
        return <p className="text-sm text-bark-300 text-center py-6">Seja o primeiro a apoiar.</p>;
    }

    return (
        <div className="space-y-2">
            {lista.map((doacao, indice) => (
                <div key={doacao.id} className="py-2.5 animate-fade-in" style={{ animationDelay: `${indice * 60}ms` }}>
                    <div className="flex items-center gap-3">
                        <div
                            className={`w-8 h-8 rounded-full flex items-center justify-center text-xs font-semibold shrink-0 ${
                                doacao.anonimo ? 'bg-cream-200 text-bark-400' : 'bg-terra-50 text-terra-500'
                            }`}
                        >
                            {doacao.anonimo ? '?' : doacao.nome_doador.substring(0, 1).toUpperCase()}
                        </div>
                        <div className="flex-1 min-w-0">
                            <span className="text-sm text-bark-600">{doacao.nome_exibicao}</span>
                            <span className="text-xs text-bark-300 ml-1">{tempoRelativo(doacao.created_at)}</span>
                        </div>
                        <span className="text-sm font-semibold text-bark-700 shrink-0">
                            R$ {Number(doacao.valor).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}
                        </span>
                    </div>
                    {doacao.mensagem && (
                        <p className="text-xs text-bark-400 mt-1.5 ml-11 italic">"{doacao.mensagem}"</p>
                    )}
                </div>
            ))}
        </div>
    );
}
