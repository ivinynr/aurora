import { Link, router } from '@inertiajs/react';
import AdminLayout from '../../../Layouts/AdminLayout';
import Card from '../../../Components/UI/Card';
import Botao from '../../../Components/UI/Botao';
import Badge from '../../../Components/UI/Badge';
import { formatarMoeda } from '../../../Utils/formatacao';

function formatarData(data) {
    return new Date(data).toLocaleString('pt-BR', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' });
}

export default function Show({ doacao }) {
    function cancelar() {
        if (confirm('Tem certeza que deseja cancelar esta doação? Se ela já estiver paga, o estorno será solicitado à ConfraPix.')) {
            router.patch(route('admin.doacoes.cancelar', doacao.id));
        }
    }

    return (
        <AdminLayout titulo="Detalhes da Doação">
            <div className="max-w-2xl">
                <Link href={route('admin.doacoes.index')} className="inline-flex items-center gap-2 text-sm text-bark-500 hover:text-terra-500 transition-colors mb-6">
                    <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="1.5">
                        <path strokeLinecap="round" strokeLinejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                    Voltar
                </Link>

                <Card hover={false} padding="lg">
                    <div className="text-center pb-6 border-b border-cream-200 mb-6">
                        <p className="text-sm text-bark-500">Valor da doação</p>
                        <p className="text-4xl font-extrabold text-terra-500 font-serif mt-1">R$ {formatarMoeda(doacao.valor)}</p>
                    </div>

                    <div className="space-y-4">
                        <div className="flex items-center justify-between py-2 border-b border-cream-100">
                            <span className="text-sm text-bark-500">Doador</span>
                            <span className="text-sm font-semibold text-bark-700">{doacao.nome_exibicao}</span>
                        </div>
                        {doacao.email_doador && (
                            <div className="flex items-center justify-between py-2 border-b border-cream-100">
                                <span className="text-sm text-bark-500">E-mail</span>
                                <span className="text-sm text-bark-700">{doacao.email_doador}</span>
                            </div>
                        )}
                        <div className="flex items-center justify-between py-2 border-b border-cream-100">
                            <span className="text-sm text-bark-500">Campanha</span>
                            <span className="text-sm font-semibold text-bark-700 text-right">{doacao.campanha.titulo}</span>
                        </div>
                        <div className="flex items-center justify-between py-2 border-b border-cream-100">
                            <span className="text-sm text-bark-500">Instituição</span>
                            <span className="text-sm text-bark-700 text-right">{doacao.campanha.instituicao.nome}</span>
                        </div>
                        <div className="flex items-center justify-between py-2 border-b border-cream-100">
                            <span className="text-sm text-bark-500">Situação</span>
                            <Badge cor={doacao.situacao_badge_cor}>{doacao.situacao_label}</Badge>
                        </div>
                        <div className="flex items-center justify-between py-2 border-b border-cream-100">
                            <span className="text-sm text-bark-500">Anônima</span>
                            <span className="text-sm text-bark-700">{doacao.anonimo ? 'Sim' : 'Não'}</span>
                        </div>
                        <div className="flex items-center justify-between py-2 border-b border-cream-100">
                            <span className="text-sm text-bark-500">Data</span>
                            <span className="text-sm text-bark-700">{formatarData(doacao.created_at)}</span>
                        </div>
                        {doacao.transaction_id && (
                            <div className="flex items-center justify-between py-2 border-b border-cream-100">
                                <span className="text-sm text-bark-500">ID da Transação</span>
                                <span className="text-xs font-mono text-bark-400">{doacao.transaction_id}</span>
                            </div>
                        )}
                        {doacao.mensagem && (
                            <div className="py-2">
                                <p className="text-sm text-bark-500 mb-1">Mensagem</p>
                                <p className="text-sm text-bark-700 bg-cream-100 rounded-xl p-4">&quot;{doacao.mensagem}&quot;</p>
                            </div>
                        )}
                    </div>
                </Card>

                {doacao.situacao !== 'cancelada' && (
                    <div className="mt-6">
                        <Botao tipo="button" variante="perigo" onClick={cancelar}>Cancelar doação</Botao>
                    </div>
                )}

                {doacao.transacoes?.length > 0 && (
                    <Card hover={false} padding="lg" className="mt-6">
                        <h2 className="font-serif text-lg font-bold text-bark-800 mb-4">Transações de pagamento</h2>
                        <div className="space-y-3">
                            {doacao.transacoes.map((transacao) => (
                                <div key={transacao.id} className="p-4 rounded-xl bg-cream-100 text-sm">
                                    <div className="flex items-center justify-between mb-1">
                                        <span className="font-mono text-xs text-bark-500">{transacao.transaction_id ?? '—'}</span>
                                        <Badge cor={transacao.situacao === 'confirmada' ? 'sage' : 'honey'}>
                                            {transacao.situacao.charAt(0).toUpperCase() + transacao.situacao.slice(1)}
                                        </Badge>
                                    </div>
                                    <div className="flex items-center justify-between text-xs text-bark-400">
                                        <span>Gateway: {transacao.gateway}</span>
                                        <span>{transacao.pago_em ? `Pago em ${formatarData(transacao.pago_em)}` : `Criada em ${formatarData(transacao.created_at)}`}</span>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </Card>
                )}
            </div>
        </AdminLayout>
    );
}
