import { Link } from '@inertiajs/react';
import AppLayout from '../../../Layouts/AppLayout';
import Card from '../../../Components/UI/Card';
import Stepper from '../../../Components/Doacao/Stepper';

export default function Sucesso({ campanha, doacao }) {
    const agora = new Date();
    const dataFormatada = `${agora.toLocaleDateString('pt-BR')} - ${agora.toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' })}`;

    return (
        <AppLayout titulo="Doação Confirmada">
            <section className="max-w-xl mx-auto px-6 pt-10 pb-24">
                <Stepper etapaAtual={3} />

                <Card hover={false} padding="lg">
                    <div className="text-center mb-8">
                        <div className="w-16 h-16 rounded-full bg-night-800/10 flex items-center justify-center mx-auto mb-4">
                            <svg className="w-8 h-8 text-night-800" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2.5">
                                <path strokeLinecap="round" strokeLinejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <h1 className="font-serif text-xl font-bold text-bark-800 mb-1">Doação realizada com sucesso!</h1>
                        <p className="text-sm text-bark-400">
                            Muito obrigado por sua contribuição. Você acabou de fazer a diferença na vida de alguém. 💛
                        </p>
                    </div>

                    <div className="bg-cream-50 rounded-xl border border-cream-200 p-5 mb-6">
                        <div className="grid grid-cols-2 gap-4">
                            <div>
                                <p className="text-xs text-bark-400">Valor doado</p>
                                <p className="text-lg font-bold text-bark-800">
                                    R$ {Number(doacao.valor).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}
                                </p>
                            </div>
                            <div className="text-right">
                                <p className="text-xs text-bark-400">Data</p>
                                <p className="text-sm font-medium text-bark-600">{dataFormatada}</p>
                            </div>
                        </div>
                    </div>

                    <div className="space-y-2.5 text-sm mb-8">
                        <div className="flex justify-between py-2 border-b border-cream-200">
                            <span className="text-bark-400">Campanha</span>
                            <span className="font-medium text-bark-700 text-right">{campanha.titulo}</span>
                        </div>
                        <div className="flex justify-between py-2 border-b border-cream-200">
                            <span className="text-bark-400">Doador</span>
                            <span className="font-medium text-bark-700">{doacao.nome_exibicao}</span>
                        </div>
                        {doacao.transaction_id && (
                            <div className="flex justify-between py-2 border-b border-cream-200">
                                <span className="text-bark-400">Transação</span>
                                <span className="text-xs font-mono text-bark-400">{doacao.transaction_id}</span>
                            </div>
                        )}
                    </div>

                    <Link
                        href={route('campanhas.show', campanha.slug)}
                        className="block w-full py-3.5 text-sm font-semibold text-white bg-night-800 hover:bg-night-700 rounded-xl transition-colors text-center"
                    >
                        Voltar para a campanha
                    </Link>
                </Card>
            </section>
        </AppLayout>
    );
}
