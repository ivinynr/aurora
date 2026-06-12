import { useState } from 'react';
import { router } from '@inertiajs/react';
import AppLayout from '../../../Layouts/AppLayout';
import Card from '../../../Components/Campanha/Card';
import Paginacao from '../../../Components/UI/Paginacao';

export default function Index({ campanhas, busca }) {
    const [termo, setTermo] = useState(busca ?? '');

    function buscar(e) {
        e.preventDefault();
        router.get(route('campanhas.index'), { busca: termo }, { preserveState: true });
    }

    return (
        <AppLayout titulo="Campanhas">
            <section className="max-w-6xl mx-auto px-6 pt-12 pb-24">
                <div className="text-center mb-10">
                    <h1 className="font-serif text-3xl lg:text-4xl font-bold text-night-800 mb-3">Campanhas abertas</h1>
                    <p className="text-bark-400">Escolha uma causa e ajude com qualquer valor. Cada doação faz a diferença.</p>
                </div>

                <form onSubmit={buscar} className="mb-10 max-w-lg mx-auto">
                    <div className="flex gap-2">
                        <input
                            type="text"
                            value={termo}
                            onChange={(e) => setTermo(e.target.value)}
                            placeholder="Buscar campanha por título ou descrição..."
                            className="flex-1 px-4 py-3 rounded-xl border border-cream-300 bg-white text-sm text-bark-800 placeholder:text-bark-300 focus:border-terra-300 focus:ring-2 focus:ring-terra-100 transition-colors"
                        />
                        <button type="submit" className="px-6 py-3 rounded-xl text-sm font-semibold text-white bg-terra-500 hover:bg-terra-600 transition-colors">
                            Buscar
                        </button>
                    </div>
                </form>

                {campanhas.data.length > 0 ? (
                    <>
                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            {campanhas.data.map((campanha) => (
                                <Card key={campanha.id} campanha={campanha} />
                            ))}
                        </div>

                        <div className="mt-10">
                            <Paginacao paginador={campanhas} />
                        </div>
                    </>
                ) : (
                    <div className="text-center py-16">
                        <p className="font-serif text-xl text-bark-300 mb-2">Nenhuma campanha encontrada.</p>
                        <p className="text-sm text-bark-300">Tente buscar com outros termos ou volte mais tarde.</p>
                    </div>
                )}
            </section>
        </AppLayout>
    );
}
