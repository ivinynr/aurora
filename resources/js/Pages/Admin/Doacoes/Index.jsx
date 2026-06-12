import { router } from '@inertiajs/react';
import AdminLayout from '../../../Layouts/AdminLayout';
import Card from '../../../Components/UI/Card';
import Botao from '../../../Components/UI/Botao';
import Badge from '../../../Components/UI/Badge';
import Paginacao from '../../../Components/UI/Paginacao';

export default function Index({ doacoes, campanhas, situacoes, filtros }) {
    function filtrar(e) {
        e.preventDefault();
        const form = new FormData(e.target);
        router.get(route('admin.doacoes.index'), {
            campanha_id: form.get('campanha_id') || undefined,
            situacao: form.get('situacao') || undefined,
        });
    }

    return (
        <AdminLayout titulo="Doações">
            <form onSubmit={filtrar} className="mb-6">
                <div className="flex flex-wrap gap-3">
                    <select
                        name="campanha_id"
                        defaultValue={filtros?.campanha_id ?? ''}
                        className="px-4 py-2.5 rounded-xl border border-cream-300 text-sm bg-white text-bark-800 focus:border-terra-300 focus:ring-2 focus:ring-terra-100"
                    >
                        <option value="">Todas as campanhas</option>
                        {campanhas.map((campanha) => (
                            <option key={campanha.id} value={campanha.id}>{campanha.titulo}</option>
                        ))}
                    </select>

                    <select
                        name="situacao"
                        defaultValue={filtros?.situacao ?? ''}
                        className="px-4 py-2.5 rounded-xl border border-cream-300 text-sm bg-white text-bark-800 focus:border-terra-300 focus:ring-2 focus:ring-terra-100"
                    >
                        <option value="">Todas as situações</option>
                        {situacoes.map((opcao) => (
                            <option key={opcao.valor} value={opcao.valor}>{opcao.label}</option>
                        ))}
                    </select>

                    <Botao variante="primario" tamanho="sm" tipo="submit">Filtrar</Botao>
                </div>
            </form>

            <Card hover={false} padding="none">
                <div className="overflow-x-auto">
                    <table className="w-full">
                        <thead>
                            <tr className="border-b border-cream-200">
                                <th className="text-left text-xs font-semibold text-bark-500 uppercase tracking-wider px-6 py-4">Doador</th>
                                <th className="text-left text-xs font-semibold text-bark-500 uppercase tracking-wider px-6 py-4">Campanha</th>
                                <th className="text-right text-xs font-semibold text-bark-500 uppercase tracking-wider px-6 py-4">Valor</th>
                                <th className="text-center text-xs font-semibold text-bark-500 uppercase tracking-wider px-6 py-4">Situação</th>
                                <th className="text-right text-xs font-semibold text-bark-500 uppercase tracking-wider px-6 py-4">Data</th>
                            </tr>
                        </thead>
                        <tbody className="divide-y divide-cream-200">
                            {doacoes.data.length > 0 ? (
                                doacoes.data.map((doacao) => (
                                    <tr key={doacao.id} className="hover:bg-cream-100 transition-colors">
                                        <td className="px-6 py-4">
                                            <div className="flex items-center gap-3">
                                                <div className={`w-9 h-9 rounded-full flex items-center justify-center text-xs font-bold shrink-0 ${
                                                    doacao.anonimo ? 'bg-cream-200 text-bark-400' : 'bg-terra-50 text-terra-500'
                                                }`}>
                                                    {doacao.nome_exibicao.substring(0, 1).toUpperCase()}
                                                </div>
                                                <div>
                                                    <p className="text-sm font-semibold text-bark-700">{doacao.nome_exibicao}</p>
                                                    {doacao.email_doador && (
                                                        <p className="text-xs text-bark-400">{doacao.email_doador}</p>
                                                    )}
                                                </div>
                                            </div>
                                        </td>
                                        <td className="px-6 py-4 text-sm text-bark-500">{doacao.campanha.titulo}</td>
                                        <td className="px-6 py-4 text-sm font-bold text-bark-700 text-right">
                                            R$ {Number(doacao.valor).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}
                                        </td>
                                        <td className="px-6 py-4 text-center">
                                            <Badge cor={doacao.situacao_badge_cor}>{doacao.situacao_label}</Badge>
                                        </td>
                                        <td className="px-6 py-4 text-sm text-bark-500 text-right">
                                            {new Date(doacao.created_at).toLocaleString('pt-BR', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' })}
                                        </td>
                                    </tr>
                                ))
                            ) : (
                                <tr>
                                    <td colSpan={5} className="px-6 py-12 text-center text-bark-400">
                                        Nenhuma doação encontrada.
                                    </td>
                                </tr>
                            )}
                        </tbody>
                    </table>
                </div>

                {doacoes.last_page > 1 && (
                    <div className="p-6 border-t border-cream-200">
                        <Paginacao paginador={doacoes} />
                    </div>
                )}
            </Card>
        </AdminLayout>
    );
}
