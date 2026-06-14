import { createInertiaApp } from '@inertiajs/react';
import { createRoot } from 'react-dom/client';
import { route } from 'ziggy-js';
import { Ziggy } from './ziggy';

// absolute = false por padrão: gera URLs relativas (/instituicoes), evitando
// que o host/porta fixos do Ziggy apontem para outro servidor.
window.route = (name, params, absolute = false, config) => route(name, params, absolute, config ?? Ziggy);

createInertiaApp({
    title: (titulo) => (titulo ? `${titulo} — Aurora` : 'Aurora'),
    resolve: (name) => {
        const pages = import.meta.glob('./Pages/**/*.jsx', { eager: true });
        return pages[`./Pages/${name}.jsx`];
    },
    setup({ el, App, props }) {
        createRoot(el).render(<App {...props} />);
    },
});
