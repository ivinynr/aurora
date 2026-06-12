const ETAPAS = [
    { numero: 1, label: 'Valor' },
    { numero: 2, label: 'Pagamento' },
    { numero: 3, label: 'Confirmação' },
];

export default function Stepper({ etapaAtual = 1 }) {
    return (
        <div className="flex items-center justify-center gap-0 mb-10">
            {ETAPAS.map((etapa, indice) => {
                const ativa = etapa.numero === etapaAtual;
                const completa = etapa.numero < etapaAtual;

                return (
                    <div key={etapa.numero} className="flex items-center">
                        <div className="flex flex-col items-center">
                            <div
                                className={`w-10 h-10 rounded-full flex items-center justify-center text-sm font-semibold transition-colors ${
                                    completa || ativa ? 'bg-night-800 text-white' : 'bg-cream-200 text-bark-400'
                                }`}
                            >
                                {completa ? (
                                    <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5">
                                        <path strokeLinecap="round" strokeLinejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                ) : (
                                    etapa.numero
                                )}
                            </div>
                            <span className={`text-xs mt-1.5 font-medium ${ativa || completa ? 'text-bark-700' : 'text-bark-300'}`}>
                                {etapa.label}
                            </span>
                        </div>

                        {indice < ETAPAS.length - 1 && (
                            <div className={`w-16 sm:w-24 h-0.5 mx-2 mb-5 ${ETAPAS[indice + 1].numero <= etapaAtual ? 'bg-night-800' : 'bg-cream-200'}`}></div>
                        )}
                    </div>
                );
            })}
        </div>
    );
}
