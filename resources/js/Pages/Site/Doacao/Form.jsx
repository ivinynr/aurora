import { useState } from 'react';
import { useForm } from '@inertiajs/react';
import { motion } from 'framer-motion';
import { ArrowRight } from 'lucide-react';
import AppLayout from '../../../Layouts/AppLayout';
import Card from '../../../Components/UI/Card';
import Input from '../../../Components/UI/Input';
import Alerta from '../../../Components/UI/Alerta';
import Stepper from '../../../Components/Doacao/Stepper';
import { fadeUp, hoverTap } from '../../../Utils/animacoes';

const VALORES_SUGERIDOS = [10, 20, 50, 100];

export default function Form({ campanha }) {
    const [custom, setCustom] = useState(false);
    const { data, setData, post, processing, errors } = useForm({
        valor: '',
        nome_doador: '',
        email_doador: '',
        anonimo: false,
        mensagem: '',
    });

    function escolher(valor) {
        setData('valor', valor);
        setCustom(false);
    }

    function submit(e) {
        e.preventDefault();
        post(route('doacao.store', campanha.slug));
    }

    const temErros = Object.keys(errors).length > 0;

    return (
        <AppLayout titulo={`Doar para ${campanha.titulo}`}>
            <section className="max-w-xl mx-auto px-6 pt-10 pb-24">
                <Stepper etapaAtual={1} />

                <motion.div initial="hidden" animate="show" variants={fadeUp}>
                <Card hover={false} padding="lg">
                    <div className="text-center mb-8">
                        <p className="text-xs font-medium text-terra-500 mb-2">{campanha.titulo}</p>
                        <h1 className="font-serif text-xl font-bold text-bark-800">Escolha o valor da doação</h1>
                    </div>

                    {temErros && (
                        <div className="mb-6">
                            <Alerta tipo="erro">Corrija os erros abaixo para continuar.</Alerta>
                        </div>
                    )}

                    <form onSubmit={submit}>
                        <div className="space-y-6">
                            <div>
                                <div className="flex flex-wrap gap-2 justify-center mb-4">
                                    {VALORES_SUGERIDOS.map((v) => (
                                        <button
                                            key={v}
                                            type="button"
                                            onClick={() => escolher(v)}
                                            className={`px-5 py-2.5 rounded-full border text-sm font-semibold transition-all cursor-pointer ${
                                                String(data.valor) === String(v) && !custom
                                                    ? 'border-night-800 bg-night-800 text-white'
                                                    : 'border-cream-300 text-bark-600 hover:border-night-700'
                                            }`}
                                        >
                                            R$ {v}
                                        </button>
                                    ))}
                                    <button
                                        type="button"
                                        onClick={() => {
                                            setCustom(true);
                                            setData('valor', '');
                                        }}
                                        className={`px-5 py-2.5 rounded-full border text-sm font-semibold transition-all cursor-pointer ${
                                            custom ? 'border-night-800 bg-night-800 text-white' : 'border-cream-300 text-bark-600 hover:border-night-700'
                                        }`}
                                    >
                                        Outro valor
                                    </button>
                                </div>

                                {custom && (
                                    <div className="relative">
                                        <span className="absolute left-4 top-1/2 -translate-y-1/2 text-bark-400 text-sm font-medium">R$</span>
                                        <input
                                            type="number"
                                            autoFocus
                                            value={data.valor}
                                            onChange={(e) => setData('valor', e.target.value)}
                                            placeholder="Digite o valor"
                                            min="5"
                                            step="0.01"
                                            className="w-full pl-10 pr-4 py-3 rounded-xl border border-cream-300 text-sm font-semibold text-bark-800 focus:border-night-700 focus:ring-2 focus:ring-night-800/10 transition-colors"
                                        />
                                    </div>
                                )}

                                {errors.valor && <p className="text-xs text-terra-500 mt-2 text-center">{errors.valor}</p>}
                            </div>

                            <div className="border-t border-cream-200"></div>

                            <div className="space-y-4">
                                <Input
                                    label="Seu nome"
                                    nome="nome_doador"
                                    placeholder="Como você quer ser identificado"
                                    obrigatorio
                                    valor={data.nome_doador}
                                    onChange={(e) => setData('nome_doador', e.target.value)}
                                    erro={errors.nome_doador}
                                />
                                <Input
                                    label="E-mail (opcional)"
                                    nome="email_doador"
                                    tipo="email"
                                    placeholder="Para receber o comprovante"
                                    valor={data.email_doador}
                                    onChange={(e) => setData('email_doador', e.target.value)}
                                    erro={errors.email_doador}
                                />

                                <div className="flex items-center justify-between py-3 px-4 rounded-xl bg-cream-50 border border-cream-200">
                                    <div>
                                        <p className="text-sm font-medium text-bark-700">Doação anônima</p>
                                        <p className="text-xs text-bark-400">Seu nome não aparecerá publicamente</p>
                                    </div>
                                    <label className="relative inline-flex items-center cursor-pointer">
                                        <input
                                            type="checkbox"
                                            checked={data.anonimo}
                                            onChange={(e) => setData('anonimo', e.target.checked)}
                                            className="sr-only peer"
                                        />
                                        <div className="w-10 h-5 bg-cream-300 rounded-full peer peer-checked:bg-night-800 peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                                    </label>
                                </div>

                                <Input
                                    label="Mensagem (opcional)"
                                    nome="mensagem"
                                    tipo="textarea"
                                    placeholder="Deixe uma mensagem de apoio..."
                                    valor={data.mensagem}
                                    onChange={(e) => setData('mensagem', e.target.value)}
                                    erro={errors.mensagem}
                                />
                            </div>

                            <motion.button
                                {...hoverTap}
                                type="submit"
                                disabled={processing}
                                className="w-full inline-flex items-center justify-center gap-2 py-3.5 text-sm font-semibold text-white bg-night-800 hover:bg-night-700 rounded-xl transition-colors disabled:opacity-50"
                            >
                                Continuar
                                <ArrowRight className="w-4 h-4" strokeWidth={2} />
                            </motion.button>
                        </div>
                    </form>
                </Card>
                </motion.div>

            </section>
        </AppLayout>
    );
}
