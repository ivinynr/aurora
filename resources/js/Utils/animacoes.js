// Variantes e helpers de animação derivados do front.json (bloco "animations").
// Reutilizados em todas as páginas do site para manter consistência.

// fadeUp: entrada com fade + leve subida (hero, títulos, itens de lista)
export const fadeUp = {
    hidden: { opacity: 0, y: 24 },
    show: { opacity: 1, y: 0, transition: { duration: 0.6, ease: 'easeOut' } },
};

// fadeInScale: entrada com fade + zoom (ilustrações, cartões em destaque)
export const fadeInScale = {
    hidden: { opacity: 0, scale: 0.92 },
    show: { opacity: 1, scale: 1, transition: { duration: 0.7, ease: 'easeOut' } },
};

// containerStagger: orquestra a entrada dos filhos em sequência
export const containerStagger = {
    hidden: {},
    show: { transition: { staggerChildren: 0.12 } },
};

// flutuar: floating_cards { effect: "floating", duration: 4, repeat: "infinite" }
export const flutuar = (delay = 0) => ({
    animate: { y: [0, -12, 0] },
    transition: { duration: 4, repeat: Infinity, ease: 'easeInOut', delay },
});

// hoverTap: buttons { hover_scale: 1.03, tap_scale: 0.98 }
export const hoverTap = { whileHover: { scale: 1.03 }, whileTap: { scale: 0.98 } };

// hoverCard: campaign_cards.hover { scale: 1.03, shadow: true }
export const hoverCard = {
    whileHover: { y: -6, scale: 1.03 },
    transition: { type: 'spring', stiffness: 300, damping: 22 },
};

// viewport padrão para animações disparadas ao rolar a página
export const viewportOnce = { once: true, amount: 0.2 };
