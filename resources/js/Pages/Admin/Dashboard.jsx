import { Link } from '@inertiajs/react';
import AdminLayout from '../../Layouts/AdminLayout';
import StatCard from '../../Components/UI/StatCard';
import Card from '../../Components/UI/Card';
import BarraProgresso from '../../Components/UI/BarraProgresso';
import { tempoRelativo } from '../../Utils/tempo';

export default function Dashboard({ resumo, doacoesRecentes, campanhasMaisArrecadadas }) {
    return (
        <AdminLayout titulo="Dashboard">
            <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-8">
                <StatCard
                    titulo="Total Arrecadado"
                    valor={`R$ ${Number(resumo.total_doado).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`}
                    icone="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                    cor="sage"
                />
                <StatCard
                    titulo="Campanhas Ativas"
                    valor={`${resumo.campanhas_ativas} / ${resumo.total_campanhas}`}
                    icone="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"
                    cor="terra"
                />
                <StatCard
                    titulo="Total de Doações"
                    valor={resumo.total_doacoes}
                    icone="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                    cor="terra"
                />
                <StatCard
                    titulo="Doadores Únicos"
                    valor={resumo.total_doadores}
                    icone="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"
                    cor="honey"
                />
            </div>

            <div className="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
                <div className="lg:col-span-2">
                    <Card hover={false} padding="none">
                        <div className="p-6 border-b border-cream-200 flex items-center justify-between">
                            <h2 className="font-serif text-lg font-bold text-bark-800">Doações Recentes</h2>
                            <Link href={route('admin.doacoes.index')} className="text-sm text-terra-500 hover:text-terra-600 font-medium">
                                Ver todas
                            </Link>
                        </div>

                        <div className="divide-y divide-cream-200">
                            {doacoesRecentes.length > 0 ? (
                                doacoesRecentes.map((doacao) => (
                                    <div key={doacao.id} className="px-6 py-4 flex items-center gap-4 hover:bg-cream-100 transition-colors">
                                        <div className={`w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold shrink-0 ${
                                            doacao.anonimo ? 'bg-cream-200 text-bark-400' : 'bg-terra-50 text-terra-500'
                                        }`}>
                                            {doacao.nome_exibicao.substring(0, 1).toUpperCase()}
                                        </div>
                                        <div className="flex-1 min-w-0">
                                            <p className="text-sm font-semibold text-bark-700 truncate">{doacao.nome_exibicao}</p>
                                            <p className="text-xs text-bark-400 truncate">{doacao.campanha.titulo} &bull; {tempoRelativo(doacao.created_at)}</p>
                                        </div>
                                        <span className="text-sm font-bold text-sage-500">
                                            R$ {Number(doacao.valor).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}
                                        </span>
                                    </div>
                                ))
                            ) : (
                                <div className="px-6 py-12 text-center text-bark-400">
                                    <p>Nenhuma doação recente.</p>
                                </div>
                            )}
                        </div>
                    </Card>
                </div>

                <div>
                    <Card hover={false} padding="none">
                        <div className="p-6 border-b border-cream-200">
                            <h2 className="font-serif text-lg font-bold text-bark-800">Top Campanhas</h2>
                        </div>

                        <div className="p-4 space-y-3">
                            {campanhasMaisArrecadadas.length > 0 ? (
                                campanhasMaisArrecadadas.map((campanha) => (
                                    <div key={campanha.id} className="p-3 rounded-xl bg-cream-100">
                                        <div className="flex items-center justify-between mb-1">
                                            <span className="text-sm font-semibold text-bark-700 truncate">{campanha.titulo}</span>
                                            <span className="text-xs font-bold text-terra-500 shrink-0 ml-2">
                                                R$ {Number(campanha.valor_arrecadado).toLocaleString('pt-BR', { minimumFractionDigits: 0, maximumFractionDigits: 0 })}
                                            </span>
                                        </div>
                                        <p className="text-xs text-bark-400 mb-2 truncate">{campanha.instituicao.nome}</p>
                                        {campanha.meta > 0 && (
                                            <BarraProgresso percentual={campanha.percentual_arrecadado} tamanho="sm" />
                                        )}
                                    </div>
                                ))
                            ) : (
                                <p className="text-sm text-bark-400 text-center py-4">Nenhuma campanha com arrecadação ainda.</p>
                            )}
                        </div>
                    </Card>
                </div>
            </div>
        </AdminLayout>
    );
}
