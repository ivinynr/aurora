const corBg = {
    sage: 'bg-sage-50 text-sage-500',
    honey: 'bg-honey-50 text-honey-400',
    rose: 'bg-terra-50 text-terra-400',
    terra: 'bg-terra-50 text-terra-400',
};

export default function StatCard({ titulo = '', valor = '', icone = '', cor = 'terra' }) {
    return (
        <div className="bg-white rounded-xl shadow-warm border border-cream-200 p-5">
            <div className="flex items-start justify-between">
                <div>
                    <p className="text-xs font-medium text-bark-400 uppercase tracking-wider mb-1">{titulo}</p>
                    <p className="text-2xl font-bold text-bark-800">{valor}</p>
                </div>
                {icone && (
                    <div className={`w-10 h-10 rounded-lg ${corBg[cor] ?? corBg.terra} flex items-center justify-center`}>
                        <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="1.5">
                            <path strokeLinecap="round" strokeLinejoin="round" d={icone} />
                        </svg>
                    </div>
                )}
            </div>
        </div>
    );
}
