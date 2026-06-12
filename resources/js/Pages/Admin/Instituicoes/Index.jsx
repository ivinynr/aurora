import { Link, router } from '@inertiajs/react';
import AdminLayout from '../../../Layouts/AdminLayout';
import Card from '../../../Components/UI/Card';
import Botao from '../../../Components/UI/Botao';
import Badge from '../../../Components/UI/Badge';

function remover(instituicao) {
    if (confirm('Tem certeza que deseja remover esta instituição?')) {
        router.delete(route('admin.instituicoes.destroy', instituicao.id));
    }
}

export default function Index({ instituicoes }) {
    return (
        <AdminLayout titulo="Instituições">
            <div className="flex items-center justify-between mb-6">
                <p className="text-sm text-bark-500">{instituicoes.length} instituições cadastradas</p>
                <Botao variante="primario" href={route('admin.instituicoes.create')}>
                    <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="1.5">
                        <path strokeLinecap="round" strokeLinejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Nova Instituição
                </Botao>
            </div>

            <Card hover={false} padding="none">
                <div className="overflow-x-auto">
                    <table className="w-full">
                        <thead>
                            <tr className="border-b border-cream-200">
                                <th className="text-left text-xs font-semibold text-bark-500 uppercase tracking-wider px-6 py-4">Instituição</th>
                                <th className="text-left text-xs font-semibold text-bark-500 uppercase tracking-wider px-6 py-4">Cidade</th>
                                <th className="text-center text-xs font-semibold text-bark-500 uppercase tracking-wider px-6 py-4">Campanhas</th>
                                <th className="text-center text-xs font-semibold text-bark-500 uppercase tracking-wider px-6 py-4">Situação</th>
                                <th className="text-right text-xs font-semibold text-bark-500 uppercase tracking-wider px-6 py-4">Ações</th>
                            </tr>
                        </thead>
                        <tbody className="divide-y divide-cream-200">
                            {instituicoes.length > 0 ? (
                                instituicoes.map((instituicao) => (
                                    <tr key={instituicao.id} className="hover:bg-cream-100 transition-colors">
                                        <td className="px-6 py-4">
                                            <div className="flex items-center gap-3">
                                                <div className="w-10 h-10 rounded-xl bg-terra-50 flex items-center justify-center text-terra-500 font-bold text-sm shrink-0">
                                                    {instituicao.nome.substring(0, 2).toUpperCase()}
                                                </div>
                                                <div>
                                                    <p className="text-sm font-semibold text-bark-700">{instituicao.nome}</p>
                                                    <p className="text-xs text-bark-400">{instituicao.email ?? '—'}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td className="px-6 py-4 text-sm text-bark-500">{instituicao.cidade ?? '—'}</td>
                                        <td className="px-6 py-4 text-sm font-semibold text-bark-700 text-center">{instituicao.campanhas_count ?? 0}</td>
                                        <td className="px-6 py-4 text-center">
                                            {instituicao.ativa ? (
                                                <Badge cor="sage">Ativa</Badge>
                                            ) : (
                                                <Badge cor="slate">Inativa</Badge>
                                            )}
                                        </td>
                                        <td className="px-6 py-4 text-right">
                                            <div className="flex items-center justify-end gap-2">
                                                <Link
                                                    href={route('admin.instituicoes.edit', instituicao.id)}
                                                    className="p-2 rounded-lg text-bark-400 hover:text-terra-500 hover:bg-terra-50 transition-colors"
                                                    title="Editar"
                                                >
                                                    <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="1.5">
                                                        <path strokeLinecap="round" strokeLinejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </Link>
                                                <button
                                                    type="button"
                                                    onClick={() => remover(instituicao)}
                                                    className="p-2 rounded-lg text-bark-400 hover:text-terra-600 hover:bg-terra-50 transition-colors"
                                                    title="Remover"
                                                >
                                                    <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="1.5">
                                                        <path strokeLinecap="round" strokeLinejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                ))
                            ) : (
                                <tr>
                                    <td colSpan={5} className="px-6 py-12 text-center text-bark-400">
                                        Nenhuma instituição cadastrada. Comece adicionando uma!
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
