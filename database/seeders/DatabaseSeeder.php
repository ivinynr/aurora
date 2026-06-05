<?php

namespace Database\Seeders;

use App\Enums\SituacaoDoacao;
use App\Enums\TipoUsuario;
use App\Models\AtualizacaoInstituicao;
use App\Models\Doacao;
use App\Models\Instituicao;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
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

        $instituicoes = [
            [
                'nome' => 'Casa da Criança Feliz',
                'slug' => 'casa-da-crianca-feliz',
                'descricao' => 'Acolhimento e desenvolvimento integral de crianças em situação de vulnerabilidade social em João Pessoa. Oferecemos educação, alimentação e cuidados para mais de 150 crianças.',
                'missao' => 'Transformar vidas infantis através do amor e educação',
                'meta' => 0,
                'valor_arrecadado' => 8750.00,
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'cidade' => 'João Pessoa',
                'estado' => 'PB',
                'telefone' => '(83) 99999-0001',
                'email' => 'contato@casacriancafeliz.org.br',
                'instagram' => '@casacriancafeliz',
                'chave_pix' => 'contato@casacriancafeliz.org.br',
            ],
            [
                'nome' => 'ONG Mãos que Alimentam',
                'slug' => 'ong-maos-que-alimentam',
                'descricao' => 'Distribuição de alimentos e cestas básicas para famílias em situação de insegurança alimentar na Grande João Pessoa. Já beneficiamos mais de 2.000 famílias.',
                'missao' => 'Nenhuma família sem comida na mesa',
                'meta' => 0,
                'valor_arrecadado' => 18300.00,
                'cidade' => 'João Pessoa',
                'estado' => 'PB',
                'telefone' => '(83) 99999-0002',
                'email' => 'contato@maosquealimentam.org.br',
                'instagram' => '@maosquealimentam',
                'chave_pix' => '12.345.678/0001-90',
            ],
            [
                'nome' => 'Instituto Vida Animal',
                'slug' => 'instituto-vida-animal',
                'descricao' => 'Resgate, tratamento e adoção de animais abandonados na Paraíba. Mantemos um abrigo com capacidade para 200 animais e já realizamos mais de 500 adoções.',
                'missao' => 'Todo animal merece uma segunda chance',
                'meta' => 0,
                'valor_arrecadado' => 12450.00,
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'cidade' => 'Cabedelo',
                'estado' => 'PB',
                'telefone' => '(83) 99999-0003',
                'email' => 'contato@vidaanimal.org.br',
                'instagram' => '@vidaanimal_pb',
                'chave_pix' => '(83) 99999-0003',
            ],
            [
                'nome' => 'Projeto Educar para Transformar',
                'slug' => 'projeto-educar-para-transformar',
                'descricao' => 'Reforço escolar e atividades culturais para jovens de comunidades periféricas. Atendemos 300 jovens com aulas de reforço, informática e oficinas de arte.',
                'missao' => 'Educação é a ponte para o futuro',
                'meta' => 0,
                'valor_arrecadado' => 6800.00,
                'cidade' => 'Bayeux',
                'estado' => 'PB',
                'telefone' => '(83) 99999-0004',
                'email' => 'contato@educarparatransformar.org.br',
                'instagram' => '@educaretransformar',
                'chave_pix' => 'contato@educarparatransformar.org.br',
            ],
            [
                'nome' => 'Lar São Francisco de Assis',
                'slug' => 'lar-sao-francisco-de-assis',
                'descricao' => 'Abrigo para idosos em situação de abandono. Cuidamos de 45 idosos com moradia, alimentação, acompanhamento médico e atividades de lazer.',
                'missao' => 'Dignidade e carinho na terceira idade',
                'meta' => 0,
                'valor_arrecadado' => 4200.00,
                'cidade' => 'Santa Rita',
                'estado' => 'PB',
                'telefone' => '(83) 99999-0005',
                'email' => 'contato@larsaofrancisco.org.br',
                'instagram' => '@larsaofrancisco',
                'chave_pix' => '98.765.432/0001-10',
            ],
            [
                'nome' => 'Associação Mulheres Guerreiras',
                'slug' => 'associacao-mulheres-guerreiras',
                'descricao' => 'Apoio a mulheres vítimas de violência doméstica. Oferecemos acolhimento, assessoria jurídica, capacitação profissional e acompanhamento psicológico.',
                'missao' => 'Mulheres livres, fortes e independentes',
                'meta' => 0,
                'valor_arrecadado' => 3500.00,
                'cidade' => 'João Pessoa',
                'estado' => 'PB',
                'telefone' => '(83) 99999-0006',
                'email' => 'contato@mulheresguerreiras.org.br',
                'instagram' => '@mulheresguerreiras_jp',
                'chave_pix' => 'contato@mulheresguerreiras.org.br',
            ],
        ];

        $instModels = collect($instituicoes)->map(fn ($inst) => Instituicao::create([
            ...$inst,
            'user_id' => $admin->id,
        ]));

        $nomes = ['Maria Silva', 'João Santos', 'Ana Oliveira', 'Pedro Costa', 'Carla Souza', 'Lucas Ferreira', 'Beatriz Lima', 'Rafael Pereira', 'Fernando Alves', 'Juliana Rocha', 'Marcos Vieira', 'Patrícia Dias', 'Roberto Nunes', 'Camila Barbosa', 'Thiago Mendes'];
        $valores = [10, 15, 20, 25, 30, 50, 75, 100, 150, 200, 250, 500];
        $mensagens = [
            'Que Deus abençoe essa iniciativa!',
            'Fico feliz em poder ajudar!',
            'Força, estamos juntos!',
            'Contribuindo com amor ❤️',
            'Juntos somos mais fortes!',
            'Parabéns pelo trabalho incrível!',
            'Vocês fazem a diferença!',
            'Continuem firmes nessa missão!',
        ];

        foreach ($instModels as $instituicao) {
            $numDoacoes = rand(10, 25);

            for ($i = 0; $i < $numDoacoes; $i++) {
                $anonimo = rand(1, 10) <= 2;
                $doador = $doadores->random();

                Doacao::create([
                    'instituicao_id' => $instituicao->id,
                    'user_id' => $doador->id,
                    'nome_doador' => $anonimo ? 'Anônimo' : $nomes[array_rand($nomes)],
                    'email_doador' => $doador->email,
                    'valor' => $valores[array_rand($valores)],
                    'transaction_id' => 'TXN' . strtoupper(Str::random(12)),
                    'situacao' => SituacaoDoacao::CONFIRMADA->value,
                    'anonimo' => $anonimo,
                    'mensagem' => rand(1, 3) === 1 ? $mensagens[array_rand($mensagens)] : null,
                    'created_at' => now()->subDays(rand(1, 45))->subHours(rand(0, 23)),
                ]);
            }
        }

        $atualizacoes = [
            ['instituicao_id' => $instModels[0]->id, 'titulo' => 'Festa junina das crianças!', 'descricao' => 'Realizamos uma linda festa junina para as 150 crianças. Tivemos comidas típicas, brincadeiras e muita alegria. Obrigado a todos que contribuíram!'],
            ['instituicao_id' => $instModels[1]->id, 'titulo' => '200 cestas entregues!', 'descricao' => 'Já entregamos 200 cestas básicas para famílias do Roger e Varadouro. As entregas continuam esta semana!'],
            ['instituicao_id' => $instModels[1]->id, 'titulo' => 'Parceria com supermercado local', 'descricao' => 'Fechamos parceria com o Supermercado Bemais que vai doar mais 50 cestas! A solidariedade pessoense é incrível.'],
            ['instituicao_id' => $instModels[2]->id, 'titulo' => '30 animais castrados este mês', 'descricao' => 'Graças às doações, conseguimos castrar 30 animais de rua este mês. Cada castração custa em média R$ 150.'],
            ['instituicao_id' => $instModels[3]->id, 'titulo' => 'Novos computadores na sala de informática', 'descricao' => 'Compramos 5 computadores novos para a sala de informática. Agora 300 jovens têm acesso à tecnologia!'],
            ['instituicao_id' => $instModels[4]->id, 'titulo' => 'Aniversariantes do mês', 'descricao' => 'Comemoramos os aniversários de 8 idosos este mês. Bolo, música e muito carinho!'],
        ];

        foreach ($atualizacoes as $att) {
            AtualizacaoInstituicao::create($att);
        }
    }
}
