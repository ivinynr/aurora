const estilos = {
    sucesso: 'bg-sage-50 border-sage-200 text-sage-500',
    erro: 'bg-terra-50 border-terra-200 text-terra-600',
    aviso: 'bg-honey-50 border-honey-200 text-honey-400',
    info: 'bg-cream-200 border-cream-300 text-bark-600',
};

export default function Alerta({ tipo = 'info', className = '', children }) {
    return (
        <div className={`flex items-start gap-3 p-4 rounded-xl border text-sm ${estilos[tipo] ?? estilos.info} ${className}`}>
            <div className="font-medium">{children}</div>
        </div>
    );
}
