import { useState } from 'react';
import { router } from '@inertiajs/react';
import AppLayout from '../../../Layouts/AppLayout';
import Card from '../../../Components/Instituicao/Card';
import Paginacao from '../../../Components/UI/Paginacao';

export default function Index({ instituicoes, busca }) {
    const [termo, setTermo] = useState(busca ?? '');

    function buscar(e) {
        e.preventDefault();
        router.get(route('instituicoes.index'), { busca: termo }, { preserveState: true });
    }

    return (
        <AppLayout titulo="Instituições">
            <section className="max-w-5xl mx-auto px-6 pt-12 pb-24">
                <div className="text-center mb-12">
                    <h1 className="font-serif text-3xl font-bold text-bark-800 mb-3">Instituições</h1>
                    <p className="text-bark-400">Conheça quem está fazendo a diferença.</p>
                </div>

                <form onSubmit={buscar} className="mb-10 max-w-lg mx-auto">
                    <div className="flex gap-2">
                        <input
                            type="text"
                            value={termo}
                            onChange={(e) => setTermo(e.target.value)}
                            placeholder="Buscar por nome ou cidade..."
                            className="flex-1 px-4 py-2.5 rounded-xl border border-cream-300 bg-white text-sm text-bark-800 placeholder:text-bark-300 focus:border-terra-300 focus:ring-2 focus:ring-terra-100 transition-colors"
                        />
                        <button type="submit" className="px-5 py-2.5 rounded-xl text-sm font-medium text-white bg-terra-500 hover:bg-terra-600 transition-colors">
                            Buscar
                        </button>
                    </div>
                </form>

                {instituicoes.data.length > 0 ? (
                    <>
                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            {instituicoes.data.map((instituicao) => (
                                <Card key={instituicao.id} instituicao={instituicao} />
                            ))}
                        </div>

                        <div className="mt-10">
                            <Paginacao paginador={instituicoes} />
                        </div>
                    </>
                ) : (
                    <div className="text-center py-16">
                        <p className="font-serif text-xl text-bark-300 mb-2">Nenhuma instituição encontrada.</p>
                        <p className="text-sm text-bark-300">Tente buscar com outros termos.</p>
                    </div>
                )}
            </section>
        </AppLayout>
    );
}
