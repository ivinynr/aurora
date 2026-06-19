import { Link, router } from '@inertiajs/react';
import AdminLayout from '../../../Layouts/AdminLayout';
import Card from '../../../Components/UI/Card';
import Botao from '../../../Components/UI/Botao';
import Badge from '../../../Components/UI/Badge';
import { formatarMoeda } from '../../../Utils/formatacao';

function encerrar(campanha) {
    if (confirm('Encerrar esta campanha? Ela deixará de aceitar doações.')) {
        router.patch(route('admin.campanhas.encerrar', campanha.id));
    }
}

function remover(campanha) {
    if (confirm('Tem certeza que deseja remover esta campanha?')) {
        router.delete(route('admin.campanhas.destroy', campanha.id));
    }
}

export default function Index({ campanhas }) {
    return (
        <AdminLayout titulo="Campanhas">
            <div className="flex items-center justify-between mb-6">
                <p className="text-sm text-bark-500">{campanhas.length} campanhas cadastradas</p>
                <Botao variante="primario" href={route('admin.campanhas.create')}>
                    <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="1.5">
                        <path strokeLinecap="round" strokeLinejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Nova Campanha
                </Botao>
            </div>

            <Card hover={false} padding="none">
                <div className="overflow-x-auto">
                    <table className="w-full">
                        <thead>
                            <tr className="border-b border-cream-200">
                                <th className="text-left text-xs font-semibold text-bark-500 uppercase tracking-wider px-6 py-4">Campanha</th>
                                <th className="text-left text-xs font-semibold text-bark-500 uppercase tracking-wider px-6 py-4">Instituição</th>
                                <th className="text-right text-xs font-semibold text-bark-500 uppercase tracking-wider px-6 py-4">Arrecadado / Meta</th>
                                <th className="text-center text-xs font-semibold text-bark-500 uppercase tracking-wider px-6 py-4">Situação</th>
                                <th className="text-right text-xs font-semibold text-bark-500 uppercase tracking-wider px-6 py-4">Ações</th>
                            </tr>
                        </thead>
                        <tbody className="divide-y divide-cream-200">
                            {campanhas.length > 0 ? (
                                campanhas.map((campanha) => (
                                    <tr key={campanha.id} className="hover:bg-cream-100 transition-colors">
                                        <td className="px-6 py-4">
                                            <div className="flex items-center gap-3">
                                                <div className="w-12 h-12 rounded-xl bg-cream-200 overflow-hidden shrink-0 flex items-center justify-center">
                                                    {campanha.imagem_url ? (
                                                        <img src={campanha.imagem_url} className="w-full h-full object-cover" />
                                                    ) : (
                                                        <span className="font-serif font-bold text-bark-300">{campanha.titulo.substring(0, 1)}</span>
                                                    )}
                                                </div>
                                                <div className="min-w-0">
                                                    <p className="text-sm font-semibold text-bark-700 truncate max-w-[220px]">{campanha.titulo}</p>
                                                    {campanha.destaque && (
                                                        <span className="text-xs text-rosa-500 font-medium">★ Em destaque</span>
                                                    )}
                                                </div>
                                            </div>
                                        </td>
                                        <td className="px-6 py-4 text-sm text-bark-500">{campanha.instituicao.nome}</td>
                                        <td className="px-6 py-4 text-right">
                                            <p className="text-sm font-semibold text-bark-700">R$ {formatarMoeda(campanha.valor_arrecadado)}</p>
                                            <p className="text-xs text-bark-400">de R$ {formatarMoeda(campanha.meta)} ({Math.round(campanha.percentual_arrecadado)}%)</p>
                                        </td>
                                        <td className="px-6 py-4 text-center">
                                            <Badge cor={campanha.situacao_badge_cor}>{campanha.situacao_label}</Badge>
                                        </td>
                                        <td className="px-6 py-4 text-right">
                                            <div className="flex items-center justify-end gap-1">
                                                <a
                                                    href={route('campanhas.show', campanha.slug)}
                                                    target="_blank"
                                                    rel="noopener"
                                                    className="p-2 rounded-lg text-bark-400 hover:text-terra-500 hover:bg-terra-50 transition-colors"
                                                    title="Ver no site"
                                                >
                                                    <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="1.5"><path strokeLinecap="round" strokeLinejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                                </a>
                                                <Link
                                                    href={route('admin.campanhas.edit', campanha.id)}
                                                    className="p-2 rounded-lg text-bark-400 hover:text-terra-500 hover:bg-terra-50 transition-colors"
                                                    title="Editar"
                                                >
                                                    <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="1.5"><path strokeLinecap="round" strokeLinejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                </Link>
                                                {!campanha.esta_encerrada && (
                                                    <button
                                                        type="button"
                                                        onClick={() => encerrar(campanha)}
                                                        className="p-2 rounded-lg text-bark-400 hover:text-honey-400 hover:bg-honey-50 transition-colors"
                                                        title="Encerrar"
                                                    >
                                                        <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="1.5"><path strokeLinecap="round" strokeLinejoin="round" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                    </button>
                                                )}
                                                <button
                                                    type="button"
                                                    onClick={() => remover(campanha)}
                                                    className="p-2 rounded-lg text-bark-400 hover:text-rosa-600 hover:bg-honey-50 transition-colors"
                                                    title="Remover"
                                                >
                                                    <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="1.5"><path strokeLinecap="round" strokeLinejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                ))
                            ) : (
                                <tr>
                                    <td colSpan={5} className="px-6 py-12 text-center text-bark-400">
                                        Nenhuma campanha cadastrada. Comece criando uma!
                                    </td>
                                </tr>
                            )}
                        </tbody>
                    </table>
                </div>
            </Card>
        </AdminLayout>
    );
}
