const formatador = new Intl.RelativeTimeFormat('pt-BR', { numeric: 'auto' });

const unidades = [
    ['year', 31536000],
    ['month', 2592000],
    ['day', 86400],
    ['hour', 3600],
    ['minute', 60],
    ['second', 1],
];

export function tempoRelativo(data) {
    const diffSegundos = (new Date(data).getTime() - Date.now()) / 1000;

    for (const [unidade, segundos] of unidades) {
        if (Math.abs(diffSegundos) >= segundos || unidade === 'second') {
            return formatador.format(Math.round(diffSegundos / segundos), unidade);
        }
    }

    return formatador.format(0, 'second');
}
