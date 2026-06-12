import { useEffect, useRef, useState } from 'react';

export function useCarrossel(total, intervalo = 4000) {
    const [atual, setAtual] = useState(0);
    const timerRef = useRef(null);

    function iniciar() {
        if (total > 1 && !timerRef.current) {
            timerRef.current = setInterval(() => {
                setAtual((indice) => (indice + 1) % total);
            }, intervalo);
        }
    }

    function pausar() {
        clearInterval(timerRef.current);
        timerRef.current = null;
    }

    function irPara(indice) {
        setAtual(indice);
        pausar();
        iniciar();
    }

    useEffect(() => {
        iniciar();
        return pausar;
    }, [total]);

    return { atual, irPara, pausar, iniciar };
}
