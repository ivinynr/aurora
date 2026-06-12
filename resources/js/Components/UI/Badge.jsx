const cores = {
    emerald: 'bg-sage-50 text-sage-500',
    sage: 'bg-sage-50 text-sage-500',
    amber: 'bg-honey-50 text-honey-400',
    honey: 'bg-honey-50 text-honey-400',
    rose: 'bg-terra-50 text-terra-500',
    slate: 'bg-cream-200 text-bark-500',
    terra: 'bg-terra-50 text-terra-500',
};

const tamanhos = {
    sm: 'text-xs px-2.5 py-0.5',
    md: 'text-sm px-3 py-1',
};

export default function Badge({ cor = 'terra', tamanho = 'sm', className = '', children }) {
    const classes = `inline-flex items-center font-medium rounded-full ${cores[cor] ?? cores.terra} ${tamanhos[tamanho] ?? tamanhos.sm} ${className}`;

    return <span className={classes}>{children}</span>;
}
