export default function Input({
    label = '',
    nome = '',
    tipo = 'text',
    obrigatorio = false,
    placeholder = '',
    dica = '',
    valor = '',
    erro = '',
    className = '',
    onChange,
    ...props
}) {
    const campoClasses = `block w-full px-4 py-3 rounded-xl border border-cream-300 bg-white text-bark-800 placeholder:text-bark-300 focus:border-terra-300 focus:ring-2 focus:ring-terra-100 transition-colors text-sm ${className}`;

    return (
        <div className="space-y-1.5">
            {label && (
                <label htmlFor={nome} className="block text-sm font-medium text-bark-700">
                    {label}
                    {obrigatorio && <span className="text-terra-400">*</span>}
                </label>
            )}

            {tipo === 'textarea' ? (
                <textarea
                    name={nome}
                    id={nome}
                    placeholder={placeholder}
                    required={obrigatorio}
                    value={valor}
                    onChange={onChange}
                    rows={4}
                    className={`${campoClasses} resize-none`}
                    {...props}
                />
            ) : (
                <input
                    type={tipo}
                    name={nome}
                    id={nome}
                    value={valor}
                    onChange={onChange}
                    placeholder={placeholder}
                    required={obrigatorio}
                    className={campoClasses}
                    {...props}
                />
            )}

            {dica && <p className="text-xs text-bark-300">{dica}</p>}
            {erro && <p className="text-xs text-terra-500 font-medium">{erro}</p>}
        </div>
    );
}
