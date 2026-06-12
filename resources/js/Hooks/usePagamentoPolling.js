import { useEffect, useRef } from 'react';
import { router } from '@inertiajs/react';

export function usePagamentoPolling(statusUrl, sucessoUrl, intervalo = 5000) {
    const verificandoRef = useRef(false);

    useEffect(() => {
        const id = setInterval(async () => {
            if (verificandoRef.current) return;
            verificandoRef.current = true;

            try {
                const resposta = await fetch(statusUrl);
                const dados = await resposta.json();

                if (dados.pago) {
                    clearInterval(id);
                    router.visit(sucessoUrl);
                }
            } catch (e) {
                // mantém o polling mesmo se uma tentativa falhar
            } finally {
                verificandoRef.current = false;
            }
        }, intervalo);

        return () => clearInterval(id);
    }, [statusUrl, sucessoUrl, intervalo]);
}
