import { Link } from '@inertiajs/react';

const paddings = {
    none: '',
    sm: 'p-4',
    md: 'p-6',
    lg: 'p-8',
};

export default function Card({ href = null, hover = true, padding = 'md', className = '', children, ...props }) {
    const classes = `bg-white rounded-xl shadow-warm border border-cream-200 overflow-hidden ${paddings[padding] ?? paddings.md} ${hover ? 'card-lift' : ''} ${className}`;

    if (href) {
        return (
            <Link href={href} className={`${classes} block`} {...props}>
                {children}
            </Link>
        );
    }

    return (
        <div className={classes} {...props}>
            {children}
        </div>
    );
}
