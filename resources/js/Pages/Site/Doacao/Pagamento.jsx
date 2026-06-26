import { useState } from 'react';
import { Link } from '@inertiajs/react';
import { motion } from 'framer-motion';
import { QrCode, Copy, Check } from 'lucide-react';
import AppLayout from '../../../Layouts/AppLayout';
import Card from '../../../Components/UI/Card';
import Stepper from '../../../Components/Doacao/Stepper';
import { fadeUp, hoverTap } from '../../../Utils/animacoes';

const MotionLink = motion.create(Link);

export default function Pagamento({ campanha, doacao, pagamento }) {
    const [copiado, setCopiado] = useState(false);

    function copiarCodigo() {
        navigator.clipboard.writeText(pagamento.qr_code_text);
        setCopiado(true);
        setTimeout(() => setCopiado(false), 2000);
    }

    return (
        <AppLayout titulo="Pagamento PIX">
            <section className="max-w-xl mx-auto px-6 pt-10 pb-24">
                <Stepper etapaAtual={2} />

                <motion.div initial="hidden" animate="show" variants={fadeUp}>
                <Card hover={false} padding="lg">
                    <div className="flex items-start justify-between mb-6">
                        <div>
                            <h1 className="font-serif text-xl font-bold text-bark-800 mb-1">Pagamento via PIX</h1>
                            <p className="text-sm text-bark-400">Abra o app do banco e escaneie o QR Code.</p>
                        </div>
                        <div className="flex items-center gap-1.5 text-bark-500">
                            <QrCode className="w-5 h-5" strokeWidth={1.8} />
                            <span className="text-xs font-semibold uppercase tracking-wider">pix</span>
                        </div>
                    </div>

                    <div className="mb-6">
                        <p className="text-xs text-bark-400">Valor da doação</p>
                        <p className="text-2xl font-bold text-terra-500">
                            R$ {Number(doacao.valor).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}
                        </p>
                    </div>

                    <div className="w-56 h-56 mx-auto mb-6 bg-white rounded-xl border border-cream-200 flex items-center justify-center p-3">
                        {pagamento.qr_code_src ? (
                            <img src={pagamento.qr_code_src} alt="QR Code PIX" className="w-full h-full object-contain" />
                        ) : (
                            <div className="text-center">
                                <span className="text-sm text-bark-300">QR Code PIX</span>
                            </div>
                        )}
                    </div>

                    {pagamento.qr_code_text && (
                        <div className="mb-6">
                            <div className="flex items-center gap-2 bg-cream-50 rounded-xl p-2.5 border border-cream-200">
                                <input
                                    type="text"
                                    value={pagamento.qr_code_text}
                                    readOnly
                                    className="flex-1 bg-transparent text-xs text-bark-500 font-mono truncate border-0 focus:ring-0 p-0"
                                />
                                <motion.button
                                    {...hoverTap}
                                    type="button"
                                    onClick={copiarCodigo}
                                    className={`shrink-0 inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors ${
                                        copiado ? 'bg-sage-100 text-sage-500' : 'bg-night-800 text-white hover:bg-night-700'
                                    }`}
                                >
                                    {copiado ? <Check className="w-3.5 h-3.5" strokeWidth={2.5} /> : <Copy className="w-3.5 h-3.5" strokeWidth={2} />}
                                    {copiado ? 'Copiado!' : 'Copiar código'}
                                </motion.button>
                            </div>
                        </div>
                    )}

                    <p className="text-xs text-bark-300 text-right mb-6">Powered by Confrapag</p>

                    <div className="space-y-3">
                        <MotionLink
                            {...hoverTap}
                            href={route('doacao.confirmar', [campanha.slug, doacao.id])}
                            className="block w-full py-3.5 text-sm font-semibold text-white bg-night-800 hover:bg-night-700 rounded-xl transition-colors text-center"
                        >
                            Já paguei, verificar
                        </MotionLink>
                        <Link
                            href={route('campanhas.show', campanha.slug)}
                            className="block w-full py-3 text-sm font-medium text-bark-400 hover:text-bark-600 text-center transition-colors"
                        >
                            Cancelar doação
                        </Link>
                    </div>
                </Card>
                </motion.div>
            </section>
        </AppLayout>
    );
}
