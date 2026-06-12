import { Link, router, useForm } from '@inertiajs/react';
import AdminLayout from '../../../Layouts/AdminLayout';
import Card from '../../../Components/UI/Card';
import Input from '../../../Components/UI/Input';
import Botao from '../../../Components/UI/Botao';
import Alerta from '../../../Components/UI/Alerta';
import { tempoRelativo } from '../../../Utils/tempo';

function AtualizacoesCampanha({ campanha }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        titulo: '',
        descricao: '',
        imagem: null,
    });

    function submeter(e) {
        e.preventDefault();
        post(route('admin.atualizacoes.store', campanha.id), {
            forceFormData: true,
            onSuccess: () => reset(),
        });
    }

    function remover(atualizacao) {
        if (confirm('Tem certeza que deseja remover esta atualização?')) {
            router.delete(route('admin.atualizacoes.destroy', atualizacao.id));
        }
    }

    return (
        <Card hover={false} padding="lg" className="mt-6">
            <h2 className="font-serif text-lg font-bold text-bark-800 mb-6">Atualizações da campanha</h2>

            <form onSubmit={submeter} className="space-y-4 mb-6 p-4 rounded-xl bg-cream-100">
                <Input
                    label="Título"
                    nome="titulo"
                    obrigatorio
                    placeholder="Título da atualização"
                    valor={data.titulo}
                    onChange={(e) => setData('titulo', e.target.value)}
                    erro={errors.titulo}
                />
                <Input
                    label="Descrição"
                    nome="descricao"
                    tipo="textarea"
                    obrigatorio
                    placeholder="O que aconteceu desde a última atualização?"
                    valor={data.descricao}
                    onChange={(e) => setData('descricao', e.target.value)}
                    erro={errors.descricao}
                />
                <div>
                    <label className="block text-sm font-medium text-bark-700 mb-1.5">Imagem (opcional)</label>
                    <input
                        type="file"
                        accept="image/*"
                        onChange={(e) => setData('imagem', e.target.files[0] ?? null)}
                        className="block w-full text-sm text-bark-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-terra-50 file:text-terra-600 hover:file:bg-terra-100"
                    />
                    {errors.imagem && <p className="text-xs text-terra-500 font-medium mt-1">{errors.imagem}</p>}
                </div>
                <Botao variante="primario" tipo="submit" disabled={processing}>Publicar atualização</Botao>
            </form>

            {campanha.atualizacoes?.length > 0 ? (
                <div className="space-y-3">
                    {campanha.atualizacoes.map((atualizacao) => (
                        <div key={atualizacao.id} className="flex items-start gap-3 p-3 rounded-xl bg-cream-100">
                            {atualizacao.imagem_url && (
                                <img src={atualizacao.imagem_url} className="w-14 h-14 rounded-lg object-cover shrink-0" />
                            )}
                            <div className="flex-1 min-w-0">
                                <p className="text-sm font-semibold text-bark-700">{atualizacao.titulo}</p>
                                <p className="text-sm text-bark-500 mt-0.5">{atualizacao.descricao}</p>
                                <p className="text-xs text-bark-400 mt-1">{tempoRelativo(atualizacao.created_at)}</p>
                            </div>
                            <button
                                type="button"
                                onClick={() => remover(atualizacao)}
                                className="p-2 rounded-lg text-bark-400 hover:text-terra-600 hover:bg-terra-50 transition-colors shrink-0"
                                title="Remover"
                            >
                                <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="1.5"><path strokeLinecap="round" strokeLinejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    ))}
                </div>
            ) : (
                <p className="text-sm text-bark-400 text-center py-4">Nenhuma atualização publicada ainda.</p>
            )}
        </Card>
    );
}

export default function Form({ campanha, instituicoes, situacoes }) {
    const editando = !!campanha;

    const { data, setData, post, processing, errors } = useForm({
        instituicao_id: campanha?.instituicao_id ?? '',
        titulo: campanha?.titulo ?? '',
        resumo: campanha?.resumo ?? '',
        descricao: campanha?.descricao ?? '',
        meta: campanha?.meta ?? '',
        situacao: campanha?.situacao ?? 'rascunho',
        video_url: campanha?.video_url ?? '',
        imagem: null,
        data_inicio: campanha?.data_inicio ? campanha.data_inicio.substring(0, 10) : '',
        data_fim: campanha?.data_fim ? campanha.data_fim.substring(0, 10) : '',
        destaque: campanha?.destaque ?? false,
    });

    function submeter(e) {
        e.preventDefault();

        const opcoes = { forceFormData: true };

        if (editando) {
            post(route('admin.campanhas.update', campanha.id), {
                ...opcoes,
                data: { ...data, _method: 'put' },
            });
        } else {
            post(route('admin.campanhas.store'), opcoes);
        }
    }

    return (
        <AdminLayout titulo={editando ? 'Editar Campanha' : 'Nova Campanha'}>
            <div className="max-w-3xl">
                <Link href={route('admin.campanhas.index')} className="inline-flex items-center gap-2 text-sm text-bark-500 hover:text-terra-500 transition-colors mb-6">
                    <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="1.5">
                        <path strokeLinecap="round" strokeLinejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                    Voltar
                </Link>

                {Object.keys(errors).length > 0 && (
                    <div className="mb-6">
                        <Alerta tipo="erro">Corrija os erros abaixo para continuar.</Alerta>
                    </div>
                )}

                <form onSubmit={submeter}>
                    <Card hover={false} padding="lg">
                        <h2 className="font-serif text-lg font-bold text-bark-800 mb-6">Informações da Campanha</h2>

                        <div className="space-y-5">
                            <div>
                                <label htmlFor="instituicao_id" className="block text-sm font-medium text-bark-700 mb-1.5">
                                    Instituição<span className="text-terra-400">*</span>
                                </label>
                                <select
                                    id="instituicao_id"
                                    value={data.instituicao_id}
                                    onChange={(e) => setData('instituicao_id', e.target.value)}
                                    className="block w-full px-4 py-3 rounded-xl border border-cream-300 bg-white text-sm text-bark-800 focus:border-terra-300 focus:ring-2 focus:ring-terra-100 transition-colors"
                                >
                                    <option value="">— Selecione —</option>
                                    {instituicoes.map((instituicao) => (
                                        <option key={instituicao.id} value={instituicao.id}>{instituicao.nome}</option>
                                    ))}
                                </select>
                                {errors.instituicao_id && <p className="text-xs text-terra-500 font-medium mt-1">{errors.instituicao_id}</p>}
                            </div>

                            <Input
                                label="Título" nome="titulo" obrigatorio placeholder="Título da campanha"
                                valor={data.titulo} onChange={(e) => setData('titulo', e.target.value)} erro={errors.titulo}
                            />
                            <Input
                                label="Resumo" nome="resumo" obrigatorio placeholder="Resumo curto exibido nos cards"
                                valor={data.resumo} onChange={(e) => setData('resumo', e.target.value)} erro={errors.resumo}
                            />
                            <Input
                                label="Descrição" nome="descricao" tipo="textarea" obrigatorio
                                placeholder="Descreva a campanha, seus objetivos e como a doação será usada..."
                                valor={data.descricao} onChange={(e) => setData('descricao', e.target.value)} erro={errors.descricao}
                            />

                            <div className="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <Input
                                    label="Meta (R$)" nome="meta" tipo="number" obrigatorio placeholder="0,00" step="0.01" min="0"
                                    valor={data.meta} onChange={(e) => setData('meta', e.target.value)} erro={errors.meta}
                                />
                                <div>
                                    <label htmlFor="situacao" className="block text-sm font-medium text-bark-700 mb-1.5">
                                        Situação<span className="text-terra-400">*</span>
                                    </label>
                                    <select
                                        id="situacao"
                                        value={data.situacao}
                                        onChange={(e) => setData('situacao', e.target.value)}
                                        className="block w-full px-4 py-3 rounded-xl border border-cream-300 bg-white text-sm text-bark-800 focus:border-terra-300 focus:ring-2 focus:ring-terra-100 transition-colors"
                                    >
                                        {situacoes.map((opcao) => (
                                            <option key={opcao.valor} value={opcao.valor}>{opcao.label}</option>
                                        ))}
                                    </select>
                                    {errors.situacao && <p className="text-xs text-terra-500 font-medium mt-1">{errors.situacao}</p>}
                                </div>
                            </div>

                            <Input
                                label="Vídeo (YouTube)" nome="video_url" tipo="url" placeholder="https://youtube.com/watch?v=..."
                                valor={data.video_url} onChange={(e) => setData('video_url', e.target.value)} erro={errors.video_url}
                            />

                            <div className="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <Input
                                    label="Data de início" nome="data_inicio" tipo="date"
                                    valor={data.data_inicio} onChange={(e) => setData('data_inicio', e.target.value)} erro={errors.data_inicio}
                                />
                                <Input
                                    label="Data de término" nome="data_fim" tipo="date"
                                    valor={data.data_fim} onChange={(e) => setData('data_fim', e.target.value)} erro={errors.data_fim}
                                />
                            </div>
                        </div>
                    </Card>

                    <Card hover={false} padding="lg" className="mt-6">
                        <h2 className="font-serif text-lg font-bold text-bark-800 mb-6">Imagem e Destaque</h2>

                        <div className="space-y-5">
                            <div>
                                <label className="block text-sm font-medium text-bark-700 mb-1.5">Imagem da campanha</label>
                                {editando && campanha.imagem_url && (
                                    <div className="mb-3 w-32 h-20 rounded-xl overflow-hidden bg-cream-200">
                                        <img src={campanha.imagem_url} className="w-full h-full object-cover" />
                                    </div>
                                )}
                                <input
                                    type="file"
                                    accept="image/*"
                                    onChange={(e) => setData('imagem', e.target.files[0] ?? null)}
                                    className="block w-full text-sm text-bark-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-terra-50 file:text-terra-600 hover:file:bg-terra-100"
                                />
                                <p className="text-xs text-bark-400 mt-1.5">JPG, PNG ou WebP. Máximo 2MB.</p>
                                {errors.imagem && <p className="text-xs text-terra-500 font-medium mt-1">{errors.imagem}</p>}
                            </div>

                            <div className="flex items-center justify-between p-4 rounded-xl bg-cream-100">
                                <div>
                                    <p className="text-sm font-medium text-bark-700">Campanha em destaque</p>
                                    <p className="text-xs text-bark-400 mt-0.5">Campanhas em destaque aparecem na home</p>
                                </div>
                                <label className="relative inline-flex items-center cursor-pointer">
                                    <input
                                        type="checkbox"
                                        checked={data.destaque}
                                        onChange={(e) => setData('destaque', e.target.checked)}
                                        className="sr-only peer"
                                    />
                                    <div className="w-11 h-6 bg-bark-300 peer-focus:ring-2 peer-focus:ring-terra-100 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-terra-500"></div>
                                </label>
                            </div>
                        </div>
                    </Card>

                    <div className="mt-6 flex items-center gap-4">
                        <Botao variante="primario" tamanho="lg" tipo="submit" disabled={processing}>
                            {editando ? 'Salvar Alterações' : 'Criar Campanha'}
                        </Botao>
                        <Link href={route('admin.campanhas.index')} className="text-sm text-bark-500 hover:text-bark-700">
                            Cancelar
                        </Link>
                    </div>
                </form>

                {editando && <AtualizacoesCampanha campanha={campanha} />}
            </div>
        </AdminLayout>
    );
}
