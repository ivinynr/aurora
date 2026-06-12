import { Link, useForm } from '@inertiajs/react';
import AdminLayout from '../../../Layouts/AdminLayout';
import Card from '../../../Components/UI/Card';
import Input from '../../../Components/UI/Input';
import Botao from '../../../Components/UI/Botao';
import Alerta from '../../../Components/UI/Alerta';

export default function Form({ instituicao, segmentos }) {
    const editando = !!instituicao;

    const { data, setData, post, processing, errors } = useForm({
        nome: instituicao?.nome ?? '',
        missao: instituicao?.missao ?? '',
        descricao: instituicao?.descricao ?? '',
        chave_pix: instituicao?.chave_pix ?? '',
        segmento: instituicao?.segmento ?? '',
        telefone: instituicao?.telefone ?? '',
        email: instituicao?.email ?? '',
        instagram: instituicao?.instagram ?? '',
        website: instituicao?.website ?? '',
        endereco: instituicao?.endereco ?? '',
        cidade: instituicao?.cidade ?? '',
        estado: instituicao?.estado ?? '',
        imagem: null,
        fotos: [],
        selos: (instituicao?.selos ?? []).map((selo) => selo.nome),
        ativa: instituicao?.ativa ?? true,
    });

    function adicionarSelo() {
        setData('selos', [...data.selos, '']);
    }

    function atualizarSelo(indice, valor) {
        const novosSelos = [...data.selos];
        novosSelos[indice] = valor;
        setData('selos', novosSelos);
    }

    function removerSelo(indice) {
        setData('selos', data.selos.filter((_, i) => i !== indice));
    }

    function submeter(e) {
        e.preventDefault();

        const opcoes = { forceFormData: true };

        if (editando) {
            post(route('admin.instituicoes.update', instituicao.id), {
                ...opcoes,
                data: { ...data, _method: 'put' },
            });
        } else {
            post(route('admin.instituicoes.store'), opcoes);
        }
    }

    return (
        <AdminLayout titulo={editando ? 'Editar Instituição' : 'Nova Instituição'}>
            <div className="max-w-3xl">
                <Link href={route('admin.instituicoes.index')} className="inline-flex items-center gap-2 text-sm text-bark-500 hover:text-terra-500 transition-colors mb-6">
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
                        <h2 className="font-serif text-lg font-bold text-bark-800 mb-6">Informações da Instituição</h2>

                        <div className="space-y-5">
                            <Input
                                label="Nome" nome="nome" obrigatorio placeholder="Nome da instituição"
                                valor={data.nome} onChange={(e) => setData('nome', e.target.value)} erro={errors.nome}
                            />
                            <Input
                                label="Missão" nome="missao" placeholder="Frase curta que define a missão (ex: Transformar vidas através da educação)"
                                valor={data.missao} onChange={(e) => setData('missao', e.target.value)} erro={errors.missao}
                            />
                            <Input
                                label="Descrição" nome="descricao" tipo="textarea" obrigatorio
                                placeholder="Descreva a instituição, o trabalho que realiza e o impacto social..."
                                valor={data.descricao} onChange={(e) => setData('descricao', e.target.value)} erro={errors.descricao}
                            />
                            <Input
                                label="Chave PIX" nome="chave_pix" placeholder="E-mail, CPF/CNPJ ou telefone" dica="Usada como referência da instituição."
                                valor={data.chave_pix} onChange={(e) => setData('chave_pix', e.target.value)} erro={errors.chave_pix}
                            />

                            <div>
                                <label htmlFor="segmento" className="block text-sm font-medium text-bark-700 mb-1.5">Segmento</label>
                                <select
                                    id="segmento"
                                    value={data.segmento}
                                    onChange={(e) => setData('segmento', e.target.value)}
                                    className="block w-full px-4 py-3 rounded-xl border border-cream-300 bg-white text-sm text-bark-800 focus:border-terra-300 focus:ring-2 focus:ring-terra-100 transition-colors"
                                >
                                    <option value="">— Selecione —</option>
                                    {segmentos.map((opcao) => (
                                        <option key={opcao.valor} value={opcao.valor}>{opcao.label}</option>
                                    ))}
                                </select>
                                {errors.segmento && <p className="text-xs text-terra-500 font-medium mt-1">{errors.segmento}</p>}
                            </div>
                        </div>
                    </Card>

                    <Card hover={false} padding="lg" className="mt-6">
                        <h2 className="font-serif text-lg font-bold text-bark-800 mb-6">Contato e Localização</h2>

                        <div className="space-y-5">
                            <div className="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <Input
                                    label="Telefone" nome="telefone" placeholder="(83) 99999-0000"
                                    valor={data.telefone} onChange={(e) => setData('telefone', e.target.value)} erro={errors.telefone}
                                />
                                <Input
                                    label="E-mail" nome="email" tipo="email" placeholder="contato@instituicao.org.br"
                                    valor={data.email} onChange={(e) => setData('email', e.target.value)} erro={errors.email}
                                />
                            </div>
                            <div className="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <Input
                                    label="Instagram" nome="instagram" placeholder="@perfil"
                                    valor={data.instagram} onChange={(e) => setData('instagram', e.target.value)} erro={errors.instagram}
                                />
                                <Input
                                    label="Website" nome="website" placeholder="https://..."
                                    valor={data.website} onChange={(e) => setData('website', e.target.value)} erro={errors.website}
                                />
                            </div>
                            <Input
                                label="Endereço" nome="endereco" placeholder="Rua, número, bairro"
                                valor={data.endereco} onChange={(e) => setData('endereco', e.target.value)} erro={errors.endereco}
                            />
                            <div className="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <Input
                                    label="Cidade" nome="cidade" placeholder="João Pessoa"
                                    valor={data.cidade} onChange={(e) => setData('cidade', e.target.value)} erro={errors.cidade}
                                />
                                <Input
                                    label="Estado" nome="estado" placeholder="PB"
                                    valor={data.estado} onChange={(e) => setData('estado', e.target.value)} erro={errors.estado}
                                />
                            </div>
                        </div>
                    </Card>

                    <Card hover={false} padding="lg" className="mt-6">
                        <h2 className="font-serif text-lg font-bold text-bark-800 mb-6">Imagem e Situação</h2>

                        <div className="space-y-5">
                            <div>
                                <label className="block text-sm font-medium text-bark-700 mb-1.5">Imagem da instituição</label>
                                {editando && instituicao.logo_url && (
                                    <div className="mb-3 w-24 h-24 rounded-xl overflow-hidden bg-cream-200">
                                        <img src={instituicao.logo_url} className="w-full h-full object-cover" />
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

                            <div>
                                <label className="block text-sm font-medium text-bark-700 mb-1.5">Fotos da instituição</label>
                                {editando && instituicao.fotos_urls?.length > 0 && (
                                    <div className="flex gap-2 flex-wrap mb-3">
                                        {instituicao.fotos_urls.map((foto, indice) => (
                                            <div key={indice} className="w-20 h-20 rounded-xl overflow-hidden bg-cream-200">
                                                <img src={foto} className="w-full h-full object-cover" />
                                            </div>
                                        ))}
                                    </div>
                                )}
                                <input
                                    type="file"
                                    accept="image/*"
                                    multiple
                                    onChange={(e) => setData('fotos', Array.from(e.target.files ?? []))}
                                    className="block w-full text-sm text-bark-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-terra-50 file:text-terra-600 hover:file:bg-terra-100"
                                />
                                <p className="text-xs text-bark-400 mt-1.5">JPG, PNG ou WebP. Máximo 2MB por imagem. Múltiplas imagens.</p>
                                {errors.fotos && <p className="text-xs text-terra-500 font-medium mt-1">{errors.fotos}</p>}
                                {errors['fotos.*'] && <p className="text-xs text-terra-500 font-medium mt-1">{errors['fotos.*']}</p>}
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-bark-700 mb-1.5">Selos / Reconhecimentos</label>
                                {data.selos.map((selo, indice) => (
                                    <div key={indice} className="flex gap-2 mb-2">
                                        <input
                                            type="text"
                                            value={selo}
                                            onChange={(e) => atualizarSelo(indice, e.target.value)}
                                            placeholder="Ex: Selo UNESCO, Utilidade Pública..."
                                            className="flex-1 px-4 py-2.5 rounded-xl border border-cream-300 bg-white text-sm text-bark-800 placeholder:text-bark-300 focus:border-terra-300 focus:ring-2 focus:ring-terra-100 transition-colors"
                                        />
                                        <button
                                            type="button"
                                            onClick={() => removerSelo(indice)}
                                            className="px-3 py-2 rounded-xl text-sm text-red-500 hover:bg-red-50 transition-colors"
                                        >
                                            Remover
                                        </button>
                                    </div>
                                ))}
                                <button
                                    type="button"
                                    onClick={adicionarSelo}
                                    className="text-sm text-terra-500 hover:text-terra-600 font-medium transition-colors"
                                >
                                    + Adicionar selo
                                </button>
                                {errors['selos.*'] && <p className="text-xs text-terra-500 font-medium mt-1">{errors['selos.*']}</p>}
                            </div>

                            <div className="flex items-center justify-between p-4 rounded-xl bg-cream-100">
                                <div>
                                    <p className="text-sm font-medium text-bark-700">Instituição ativa</p>
                                    <p className="text-xs text-bark-400 mt-0.5">Instituições inativas não aparecem no site</p>
                                </div>
                                <label className="relative inline-flex items-center cursor-pointer">
                                    <input
                                        type="checkbox"
                                        checked={data.ativa}
                                        onChange={(e) => setData('ativa', e.target.checked)}
                                        className="sr-only peer"
                                    />
                                    <div className="w-11 h-6 bg-bark-300 peer-focus:ring-2 peer-focus:ring-terra-100 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-terra-500"></div>
                                </label>
                            </div>
                        </div>
                    </Card>

                    <div className="mt-6 flex items-center gap-4">
                        <Botao variante="primario" tamanho="lg" tipo="submit" disabled={processing}>
                            {editando ? 'Salvar Alterações' : 'Cadastrar Instituição'}
                        </Botao>
                        <Link href={route('admin.instituicoes.index')} className="text-sm text-bark-500 hover:text-bark-700">
                            Cancelar
                        </Link>
                    </div>
                </form>
            </div>
        </AdminLayout>
    );
}
