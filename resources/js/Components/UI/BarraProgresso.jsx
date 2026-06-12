const alturas = {
    sm: 'h-1.5',
    md: 'h-2',
    lg: 'h-3',
};

export default function BarraProgresso({ percentual = 0, meta = null, arrecadado = null, tamanho = 'md' }) {
    const altura = alturas[tamanho] ?? alturas.md;
    const pct = Math.min(100, Math.max(0, percentual));

    return (
        <div className="w-full">
            {meta !== null && arrecadado !== null && (
                <div className="flex items-baseline justify-between mb-2">
                    <span className="text-sm font-semibold text-bark-700">
                        R$ {Number(arrecadado).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}
                    </span>
                    {meta > 0 && (
                        <span className="text-xs text-bark-400">
                            meta R$ {Number(meta).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}
                        </span>
                    )}
                </div>
            )}

            <div className={`w-full ${altura} bg-cream-200 rounded-full overflow-hidden`}>
                <div className="h-full rounded-full progress-fill" style={{ width: `${pct}%` }} />
            </div>

            {meta !== null && meta > 0 && (
                <p className="mt-1 text-right text-xs text-bark-400">{Math.round(pct)}% alcançado</p>
            )}
        </div>
    );
}
