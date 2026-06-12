const dimensoes = {
    sm: 'w-8 h-8',
    md: 'w-10 h-10',
    lg: 'w-14 h-14',
    xl: 'w-20 h-20',
};

const textoSizes = {
    sm: 'text-lg',
    md: 'text-xl',
    lg: 'text-2xl',
    xl: 'text-4xl',
};

const textoCores = {
    escuro: 'text-bark-800',
    claro: 'text-cream-100',
};

export default function Logo({ tamanho = 'md', cor = 'escuro', semTexto = false, className = '' }) {
    return (
        <div className="flex items-center gap-2">
            <svg className={`${dimensoes[tamanho] ?? dimensoes.md} ${className}`} viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M46 82 C22 62, 4 46, 8 30 C11 18, 22 13, 34 18 C42 22, 46 30, 47 36" fill="#1E3A8A" opacity="0.9" />
                <path d="M54 80 C76 58, 96 40, 90 24 C86 14, 74 10, 63 17 C56 22, 53 30, 52 35" fill="#F59E0B" opacity="0.85" />
                <path d="M42 74 C18 52, 8 38, 16 24 C21 14, 34 16, 40 22 C46 28, 48 36, 48 40" fill="#0D9488" opacity="0.7" />
                <path d="M56 76 C78 54, 92 36, 84 22 C79 12, 66 14, 60 20 C54 26, 52 34, 52 38" fill="#3B82F6" opacity="0.7" />
                <path d="M49 38 C49 28, 40 16, 32 20 C24 24, 22 36, 32 50 C39 60, 49 72, 50 74 C51 72, 61 58, 68 48 C76 34, 74 22, 66 18 C58 14, 51 28, 50 38Z" fill="#1D4ED8" opacity="0.6" />
            </svg>

            {!semTexto && (
                <span className={`font-serif font-bold tracking-tight ${textoSizes[tamanho] ?? textoSizes.md} ${textoCores[cor] ?? textoCores.escuro}`}>
                    aurora
                </span>
            )}
        </div>
    );
}
