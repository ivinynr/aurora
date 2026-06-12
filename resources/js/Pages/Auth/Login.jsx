import { Head, useForm, Link } from '@inertiajs/react';
import Logo from '../../Components/Layout/Logo';

export default function Login() {
    const { data, setData, post, processing, errors } = useForm({
        email: '',
        password: '',
        remember: false,
    });

    function submeter(e) {
        e.preventDefault();
        post(route('login'));
    }

    return (
        <div className="min-h-screen bg-cream-100 flex items-center justify-center p-6 font-sans antialiased">
            <Head title="Entrar" />

            <div className="w-full max-w-sm">
                <div className="text-center mb-8">
                    <Link href={route('home')} className="inline-block"><Logo tamanho="lg" /></Link>
                    <p className="text-sm text-bark-400 mt-2">Acesso administrativo</p>
                </div>

                <div className="bg-white rounded-xl shadow-warm border border-cream-200 p-7">
                    {errors.email && (
                        <div className="mb-5 p-3 rounded-lg bg-terra-50 border border-terra-100 text-sm text-terra-600">
                            E-mail ou senha incorretos.
                        </div>
                    )}

                    <form onSubmit={submeter} className="space-y-4">
                        <div className="space-y-1.5">
                            <label htmlFor="email" className="block text-sm font-medium text-bark-700">E-mail</label>
                            <input
                                type="email"
                                id="email"
                                value={data.email}
                                onChange={(e) => setData('email', e.target.value)}
                                required
                                autoFocus
                                placeholder="admin@aurora.org.br"
                                className="w-full px-4 py-2.5 rounded-xl border border-cream-300 text-sm text-bark-800 placeholder:text-bark-300 focus:border-terra-300 focus:ring-2 focus:ring-terra-100 transition-colors"
                            />
                        </div>
                        <div className="space-y-1.5">
                            <label htmlFor="password" className="block text-sm font-medium text-bark-700">Senha</label>
                            <input
                                type="password"
                                id="password"
                                value={data.password}
                                onChange={(e) => setData('password', e.target.value)}
                                required
                                placeholder="••••••••"
                                className="w-full px-4 py-2.5 rounded-xl border border-cream-300 text-sm text-bark-800 placeholder:text-bark-300 focus:border-terra-300 focus:ring-2 focus:ring-terra-100 transition-colors"
                            />
                        </div>
                        <label className="flex items-center gap-2 cursor-pointer">
                            <input
                                type="checkbox"
                                checked={data.remember}
                                onChange={(e) => setData('remember', e.target.checked)}
                                className="w-4 h-4 rounded border-cream-300 text-terra-500 focus:ring-terra-400"
                            />
                            <span className="text-sm text-bark-500">Lembrar de mim</span>
                        </label>
                        <button
                            type="submit"
                            disabled={processing}
                            className="w-full py-2.5 text-sm font-semibold text-white bg-terra-500 hover:bg-terra-600 rounded-xl transition-colors disabled:opacity-50"
                        >
                            Entrar
                        </button>
                    </form>
                </div>

                <p className="text-center text-xs text-bark-300 mt-6">Aurora &mdash; Hackathon Confrapag + UNIESP</p>
            </div>
        </div>
    );
}
