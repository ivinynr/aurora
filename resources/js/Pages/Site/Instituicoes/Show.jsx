import { Link } from '@inertiajs/react';
import AppLayout from '../../../Layouts/AppLayout';
import Badge from '../../../Components/UI/Badge';
import Carrossel from '../../../Components/Instituicao/Carrossel';
import CampanhaCard from '../../../Components/Campanha/Card';
import InstituicaoCard from '../../../Components/Instituicao/Card';

export default function Show({ instituicao, relacionadas }) {
    const temCampanhas = instituicao.campanhas?.length > 0;
    const primeiraCampanha = instituicao.campanhas?.[0];
    const temContato = instituicao.telefone || instituicao.email || instituicao.instagram || instituicao.website;

    return (
        <AppLayout titulo={`${instituicao.nome} — Aurora`}>
            <section className="bg-cream-100 py-10 lg:py-14">
                <div className="max-w-7xl mx-auto px-6">
                    <Link href={route('instituicoes.index')} className="inline-flex items-center gap-1.5 text-sm text-bark-400 hover:text-bark-600 transition-colors mb-6">
                        &larr; Todas as instituições
                    </Link>

                    <div className="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
                        <Carrossel fotos={instituicao.fotos_urls} nome={instituicao.nome} logoUrl={instituicao.logo_url} />

                        <div className="flex flex-col justify-center">
                            {instituicao.segmento_label && (
                                <div className="mb-3">
                                    <Badge cor={instituicao.segmento_cor}>{instituicao.segmento_label}</Badge>
                                </div>
                            )}

                            <h1 className="font-serif text-2xl lg:text-4xl font-bold text-bark-800 leading-tight">
                                {instituicao.nome}
                            </h1>

                            {instituicao.cidade && (
                                <p className="text-sm text-bark-400 mt-2">{instituicao.cidade}, {instituicao.estado}</p>
                            )}

                            {instituicao.missao && (
                                <p className="text-bark-600 leading-relaxed mt-4">{instituicao.missao}</p>
                            )}

                            {temCampanhas && (
                                <div className="mt-6">
                                    <Link
                                        href={route('doacao.create', primeiraCampanha.slug)}
                                        className="inline-flex items-center gap-2 bg-rosa-500 hover:bg-rosa-600 text-white rounded-xl px-7 py-3.5 text-sm font-semibold transition-colors"
                                    >
                                        <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2">
                                            <path strokeLinecap="round" strokeLinejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                        </svg>
                                        Fazer doação
                                    </Link>
                                </div>
                            )}

                            <p className="text-xs text-bark-300 leading-relaxed mt-4 max-w-md">
                                * Sua doação será feita através da plataforma. Não retemos nenhum valor da sua doação,
                                nem seus dados pessoais. Atuamos conectando quem se importa, com quem faz.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <section className="max-w-7xl mx-auto px-6 py-12 space-y-10">
                <div className="max-w-3xl">
                    <h2 className="font-serif text-xl font-bold text-bark-800 mb-4">Sobre a instituição</h2>
                    <div className="text-bark-600 leading-relaxed text-[15px] space-y-4 font-light whitespace-pre-line">
                        {instituicao.descricao}
                    </div>
                </div>

                <div className="flex flex-wrap items-start gap-8">
                    {instituicao.website && (
                        <a
                            href={instituicao.website}
                            target="_blank"
                            rel="noopener"
                            className="inline-flex items-center gap-2 bg-cream-200 hover:bg-cream-300 text-bark-700 rounded-xl px-5 py-2.5 text-sm font-medium transition-colors"
                        >
                            <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="1.5">
                                <path strokeLinecap="round" strokeLinejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                            </svg>
                            Visitar site da instituição
                        </a>
                    )}

                    {instituicao.selos?.length > 0 && (
                        <div>
                            <p className="text-xs text-bark-300 uppercase tracking-wider font-semibold mb-2">Reconhecimentos</p>
                            <div className="flex flex-wrap gap-2">
                                {instituicao.selos.map((selo, indice) => (
                                    <Badge key={indice} cor="sage">{selo.nome}</Badge>
                                ))}
                            </div>
                        </div>
                    )}
                </div>

                {temCampanhas && (
                    <div>
                        <Link
                            href={route('doacao.create', primeiraCampanha.slug)}
                            className="inline-flex items-center gap-2 bg-rosa-500 hover:bg-rosa-600 text-white rounded-xl px-7 py-3.5 text-sm font-semibold transition-colors"
                        >
                            <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="2">
                                <path strokeLinecap="round" strokeLinejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                            Fazer doação
                        </Link>
                    </div>
                )}

                {temCampanhas && (
                    <div className="border-t border-cream-200 pt-10">
                        <h2 className="font-serif text-xl font-bold text-bark-800 mb-5">Campanhas</h2>
                        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            {instituicao.campanhas.map((campanha) => (
                                <CampanhaCard key={campanha.id} campanha={campanha} />
                            ))}
                        </div>
                    </div>
                )}

                {temContato && (
                    <div className="border-t border-cream-200 pt-10">
                        <h2 className="font-serif text-xl font-bold text-bark-800 mb-4">Contato</h2>
                        <div className="flex flex-wrap gap-6 text-sm text-bark-600">
                            {instituicao.telefone && (
                                <div className="flex items-center gap-2">
                                    <svg className="w-4 h-4 text-bark-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="1.5">
                                        <path strokeLinecap="round" strokeLinejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/>
                                    </svg>
                                    <span>{instituicao.telefone}</span>
                                </div>
                            )}
                            {instituicao.email && (
                                <div className="flex items-center gap-2">
                                    <svg className="w-4 h-4 text-bark-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="1.5">
                                        <path strokeLinecap="round" strokeLinejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                                    </svg>
                                    <span>{instituicao.email}</span>
                                </div>
                            )}
                            {instituicao.instagram && (
                                <div className="flex items-center gap-2">
                                    <svg className="w-4 h-4 text-bark-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth="1.5">
                                        <path strokeLinecap="round" strokeLinejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z"/>
                                        <path strokeLinecap="round" strokeLinejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z"/>
                                    </svg>
                                    <span>{instituicao.instagram}</span>
                                </div>
                            )}
                        </div>
                    </div>
                )}

                {relacionadas?.length > 0 && (
                    <div className="border-t border-cream-200 pt-10">
                        <h2 className="font-serif text-xl font-bold text-bark-800 mb-5">Instituições do mesmo segmento</h2>
                        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                            {relacionadas.map((rel) => (
                                <InstituicaoCard key={rel.id} instituicao={rel} />
                            ))}
                        </div>
                    </div>
                )}
            </section>
        </AppLayout>
    );
}
