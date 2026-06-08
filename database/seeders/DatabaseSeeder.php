<?php

namespace Database\Seeders;

use App\Enums\SituacaoCampanha;
use App\Enums\SituacaoDoacao;
use App\Enums\TipoUsuario;
use App\Models\Campanha;
use App\Models\Doacao;
use App\Models\Instituicao;
use App\Models\TransacaoPagamento;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /** Imagem temática por palavra-chave (deterministica via lock). */
    private function imagem(string $keywords, int $lock): string
    {
        return "https://loremflickr.com/800/500/{$keywords}?lock={$lock}";
    }

    /** Logo gerado a partir do nome, na cor da marca. */
    private function logo(string $nome): string
    {
        return 'https://ui-avatars.com/api/?name='.urlencode($nome)
            .'&background=1D4ED8&color=ffffff&size=256&bold=true&format=png';
    }

    public function run(): void
    {
        $admin = User::create([
            'name' => 'Administrador Aurora',
            'email' => 'admin@aurora.org.br',
            'password' => Hash::make('password'),
            'tipo' => TipoUsuario::ADMINISTRADOR->value,
        ]);

        $doadores = collect([
            ['name' => 'Maria Silva', 'email' => 'maria@email.com'],
            ['name' => 'João Santos', 'email' => 'joao@email.com'],
            ['name' => 'Ana Oliveira', 'email' => 'ana@email.com'],
            ['name' => 'Pedro Costa', 'email' => 'pedro@email.com'],
            ['name' => 'Carla Souza', 'email' => 'carla@email.com'],
            ['name' => 'Lucas Ferreira', 'email' => 'lucas@email.com'],
            ['name' => 'Beatriz Lima', 'email' => 'beatriz@email.com'],
            ['name' => 'Rafael Pereira', 'email' => 'rafael@email.com'],
        ])->map(fn ($d) => User::create([
            ...$d,
            'password' => Hash::make('password'),
            'tipo' => TipoUsuario::DOADOR->value,
        ]));

        // Instituições com suas campanhas
        $dados = [
            [
                'instituicao' => [
                    'nome' => 'Casa da Criança Feliz',
                    'descricao' => "Acolhemos e cuidamos de crianças em situação de vulnerabilidade social em João Pessoa.\n\nOferecemos educação, alimentação, apoio psicológico e muito carinho para mais de 150 crianças todos os dias.",
                    'missao' => 'Transformar vidas infantis através do amor e da educação',
                    'cidade' => 'João Pessoa', 'estado' => 'PB',
                    'telefone' => '(83) 99999-0001', 'email' => 'contato@casacriancafeliz.org.br',
                    'instagram' => '@casacriancafeliz', 'chave_pix' => 'contato@casacriancafeliz.org.br',
                ],
                'campanhas' => [
                    ['titulo' => 'Volta às aulas: kits escolares para 150 crianças', 'resumo' => 'Garanta material escolar completo para nossas crianças começarem o ano letivo.', 'meta' => 15000, 'destaque' => true, 'kw' => 'children,school', 'video_url' => 'https://www.youtube.com/watch?v=ScMzIvxBSi4'],
                    ['titulo' => 'Reforma da brinquedoteca', 'resumo' => 'Vamos reformar o espaço de brincar e aprender das crianças.', 'meta' => 9000, 'kw' => 'children,playground'],
                ],
            ],
            [
                'instituicao' => [
                    'nome' => 'ONG Mãos que Alimentam',
                    'descricao' => "Distribuímos alimentos e cestas básicas para famílias em insegurança alimentar na Grande João Pessoa.\n\nJá beneficiamos mais de 2.000 famílias com a ajuda de doadores como você.",
                    'missao' => 'Nenhuma família sem comida na mesa',
                    'cidade' => 'João Pessoa', 'estado' => 'PB',
                    'telefone' => '(83) 99999-0002', 'email' => 'contato@maosquealimentam.org.br',
                    'instagram' => '@maosquealimentam', 'chave_pix' => '12.345.678/0001-90',
                ],
                'campanhas' => [
                    ['titulo' => '500 cestas básicas para o inverno', 'resumo' => 'Cada R$ 80 monta uma cesta básica completa para uma família.', 'meta' => 40000, 'destaque' => true, 'kw' => 'food,groceries'],
                ],
            ],
            [
                'instituicao' => [
                    'nome' => 'Instituto Vida Animal',
                    'descricao' => "Resgatamos, tratamos e encontramos lares para animais abandonados na Paraíba.\n\nMantemos um abrigo com capacidade para 200 animais e já realizamos mais de 500 adoções.",
                    'missao' => 'Todo animal merece uma segunda chance',
                    'cidade' => 'Cabedelo', 'estado' => 'PB',
                    'telefone' => '(83) 99999-0003', 'email' => 'contato@vidaanimal.org.br',
                    'instagram' => '@vidaanimal_pb', 'chave_pix' => '(83) 99999-0003',
                ],
                'campanhas' => [
                    ['titulo' => 'Castração de 100 animais de rua', 'resumo' => 'Controle populacional com amor: cada castração custa cerca de R$ 150.', 'meta' => 15000, 'destaque' => true, 'kw' => 'dog,shelter'],
                    ['titulo' => 'Ração para o abrigo', 'resumo' => 'Ajude a alimentar os 200 animais que vivem no nosso abrigo.', 'meta' => 12000, 'kw' => 'cat,rescue'],
                ],
            ],
            [
                'instituicao' => [
                    'nome' => 'Projeto Educar para Transformar',
                    'descricao' => "Oferecemos reforço escolar e atividades culturais para jovens de comunidades periféricas.\n\nAtendemos 300 jovens com aulas de reforço, informática e oficinas de arte.",
                    'missao' => 'Educação é a ponte para o futuro',
                    'cidade' => 'Bayeux', 'estado' => 'PB',
                    'telefone' => '(83) 99999-0004', 'email' => 'contato@educarparatransformar.org.br',
                    'instagram' => '@educaretransformar', 'chave_pix' => 'contato@educarparatransformar.org.br',
                ],
                'campanhas' => [
                    ['titulo' => 'Laboratório de informática para jovens', 'resumo' => 'Compra de 10 computadores para nossas aulas de tecnologia.', 'meta' => 20000, 'kw' => 'classroom,computer'],
                ],
            ],
            [
                'instituicao' => [
                    'nome' => 'Lar São Francisco de Assis',
                    'descricao' => "Abrigo para idosos em situação de abandono.\n\nCuidamos de 45 idosos com moradia, alimentação, acompanhamento médico e atividades de lazer.",
                    'missao' => 'Dignidade e carinho na terceira idade',
                    'cidade' => 'Santa Rita', 'estado' => 'PB',
                    'telefone' => '(83) 99999-0005', 'email' => 'contato@larsaofrancisco.org.br',
                    'instagram' => '@larsaofrancisco', 'chave_pix' => '98.765.432/0001-10',
                ],
                'campanhas' => [
                    ['titulo' => 'Medicamentos para nossos idosos', 'resumo' => 'Garanta os remédios mensais dos 45 idosos do lar.', 'meta' => 10000, 'kw' => 'elderly,care'],
                ],
            ],
            [
                'instituicao' => [
                    'nome' => 'Associação Mulheres Guerreiras',
                    'descricao' => "Apoiamos mulheres vítimas de violência doméstica.\n\nOferecemos acolhimento, assessoria jurídica, capacitação profissional e acompanhamento psicológico.",
                    'missao' => 'Mulheres livres, fortes e independentes',
                    'cidade' => 'João Pessoa', 'estado' => 'PB',
                    'telefone' => '(83) 99999-0006', 'email' => 'contato@mulheresguerreiras.org.br',
                    'instagram' => '@mulheresguerreiras_jp', 'chave_pix' => 'contato@mulheresguerreiras.org.br',
                ],
                'campanhas' => [
                    ['titulo' => 'Curso de capacitação profissional', 'resumo' => 'Ajude mulheres a recomeçarem com autonomia financeira.', 'meta' => 8000, 'kw' => 'women,community'],
                ],
            ],
        ];

        $nomes = ['Maria Silva', 'João Santos', 'Ana Oliveira', 'Pedro Costa', 'Carla Souza', 'Lucas Ferreira', 'Beatriz Lima', 'Rafael Pereira', 'Fernando Alves', 'Juliana Rocha', 'Marcos Vieira', 'Patrícia Dias', 'Roberto Nunes', 'Camila Barbosa', 'Thiago Mendes'];
        $valores = [10, 15, 20, 25, 30, 50, 75, 100, 150, 200, 250, 500];
        $mensagens = [
            'Que Deus abençoe essa iniciativa!', 'Fico feliz em poder ajudar!',
            'Força, estamos juntos!', 'Contribuindo com amor ❤️',
            'Juntos somos mais fortes!', 'Parabéns pelo trabalho incrível!',
            'Vocês fazem a diferença!', 'Continuem firmes nessa missão!',
        ];

        $lock = 10;

        foreach ($dados as $bloco) {
            $instituicao = Instituicao::create([
                ...$bloco['instituicao'],
                'slug' => Str::slug($bloco['instituicao']['nome']),
                'logo' => $this->logo($bloco['instituicao']['nome']),
                'user_id' => $admin->id,
            ]);

            foreach ($bloco['campanhas'] as $c) {
                $campanha = Campanha::create([
                    'instituicao_id' => $instituicao->id,
                    'titulo' => $c['titulo'],
                    'slug' => Str::slug($c['titulo']),
                    'resumo' => $c['resumo'],
                    'descricao' => $c['resumo']."\n\n".$bloco['instituicao']['descricao'],
                    'imagem' => $this->imagem($c['kw'], $lock++),
                    'video_url' => $c['video_url'] ?? null,
                    'meta' => $c['meta'],
                    'valor_arrecadado' => 0,
                    'situacao' => SituacaoCampanha::ATIVA->value,
                    'destaque' => $c['destaque'] ?? false,
                    'data_inicio' => now()->subDays(rand(20, 60)),
                ]);

                $total = 0;
                $numDoacoes = rand(8, 20);

                for ($i = 0; $i < $numDoacoes; $i++) {
                    $anonimo = rand(1, 10) <= 2;
                    $doador = $doadores->random();
                    $valor = $valores[array_rand($valores)];
                    $transactionId = 'TXN'.strtoupper(Str::random(12));
                    $criadoEm = now()->subDays(rand(1, 45))->subHours(rand(0, 23));

                    $doacao = Doacao::create([
                        'campanha_id' => $campanha->id,
                        'user_id' => $doador->id,
                        'nome_doador' => $anonimo ? 'Anônimo' : $nomes[array_rand($nomes)],
                        'email_doador' => $doador->email,
                        'valor' => $valor,
                        'transaction_id' => $transactionId,
                        'situacao' => SituacaoDoacao::CONFIRMADA->value,
                        'anonimo' => $anonimo,
                        'mensagem' => rand(1, 3) === 1 ? $mensagens[array_rand($mensagens)] : null,
                        'created_at' => $criadoEm,
                        'updated_at' => $criadoEm,
                    ]);

                    TransacaoPagamento::create([
                        'doacao_id' => $doacao->id,
                        'gateway' => 'mock',
                        'transaction_id' => $transactionId,
                        'valor' => $valor,
                        'status' => SituacaoDoacao::CONFIRMADA->value,
                        'pago_em' => $criadoEm,
                        'created_at' => $criadoEm,
                        'updated_at' => $criadoEm,
                    ]);

                    $total += $valor;
                }

                $campanha->update(['valor_arrecadado' => $total]);
            }
        }

        // Atualizações em algumas campanhas
        $atualizacoes = [
            ['titulo' => 'Primeiros kits entregues!', 'descricao' => 'Já entregamos os primeiros 40 kits escolares. As crianças ficaram radiantes! Obrigado a todos que doaram.'],
            ['titulo' => '200 cestas entregues!', 'descricao' => 'Entregamos 200 cestas básicas para famílias do Roger e Varadouro. As entregas continuam esta semana!'],
            ['titulo' => '30 animais castrados este mês', 'descricao' => 'Graças às doações, castramos 30 animais de rua este mês. Cada castração custa em média R$ 150.'],
        ];

        Campanha::query()->take(3)->get()->each(function ($campanha, $i) use ($atualizacoes) {
            $campanha->atualizacoes()->create([
                ...$atualizacoes[$i],
                'created_at' => now()->subDays(rand(2, 15)),
            ]);
        });
    }
}
