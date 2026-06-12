import { Head, usePage } from '@inertiajs/react';
import Navbar from '../Components/Layout/Navbar';
import Footer from '../Components/Layout/Footer';
import Alerta from '../Components/UI/Alerta';

export default function AppLayout({ titulo, descricao, children }) {
    const { flash } = usePage().props;
    const temFlash = flash?.sucesso || flash?.erro || flash?.aviso;

    return (
        <div className="min-h-screen flex flex-col">
            <Head title={titulo}>
                {descricao && <meta name="description" content={descricao} />}
            </Head>

            <Navbar />

            <main className="flex-1 relative z-10">
                {temFlash && (
                    <div className="max-w-xl mx-auto px-6 pt-6 space-y-3">
                        {flash.sucesso && <Alerta tipo="sucesso">{flash.sucesso}</Alerta>}
                        {flash.erro && <Alerta tipo="erro">{flash.erro}</Alerta>}
                        {flash.aviso && <Alerta tipo="aviso">{flash.aviso}</Alerta>}
                    </div>
                )}

                {children}
            </main>

            <Footer />
        </div>
    );
}
