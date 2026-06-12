import { Link } from '@inertiajs/react';

export default function Paginacao({ paginador }) {
    if (!paginador || paginador.last_page <= 1) {
        return null;
    }

    return (
        <nav className="flex items-center justify-center gap-1.5 flex-wrap">
            {paginador.links.map((link, indice) => (
                link.url ? (
                    <Link
                        key={indice}
                        href={link.url}
                        dangerouslySetInnerHTML={{ __html: link.label }}
                        className={`min-w-9 h-9 px-3 inline-flex items-center justify-center rounded-lg text-sm transition-colors ${
                            link.active
                                ? 'bg-terra-500 text-white font-semibold'
                                : 'text-bark-500 hover:bg-cream-200'
                        }`}
                    />
                ) : (
                    <span
                        key={indice}
                        dangerouslySetInnerHTML={{ __html: link.label }}
                        className="min-w-9 h-9 px-3 inline-flex items-center justify-center rounded-lg text-sm text-bark-300"
                    />
                )
            ))}
        </nav>
    );
}
