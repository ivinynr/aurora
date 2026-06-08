# DoeJP — Documentação do Projeto

> Plataforma de arrecadação beneficente que conecta **instituições** e **doadores**
> através de **campanhas** com pagamento via PIX (gateway **ConfraPix**).
>
> Projeto do Hackathon **Confrapag + UNIESP**. Base de código: **Aurora** (Laravel).

Este documento explica **o que o sistema faz**, **como ele está organizado**, **o que foi
ajustado** para atender ao desafio e **como rodar localmente**. Foi escrito para que tanto
a Letícia quanto a equipe consigam retomar o projeto depois sem se perder.

---

## 1. Visão geral

ONGs, igrejas e projetos sociais hoje arrecadam por WhatsApp, Instagram, PIX manual e
planilhas — sem transparência, sem controle e sem prestação de contas. O **DoeJP** resolve
isso com:

- Instituições cadastram **campanhas** (cada campanha tem meta, descrição, imagem).
- Doadores navegam, escolhem uma campanha e doam via **PIX** (QR Code gerado pelo gateway).
- O sistema confirma o pagamento, atualiza a arrecadação e mostra o **progresso** em tempo real.
- A instituição acompanha tudo por um **dashboard** e publica **atualizações** da campanha.

### Perfis de usuário

| Perfil | O que faz |
|--------|-----------|
| **Administrador da Instituição** | Cria/edita/encerra campanhas, vê doações, publica atualizações |
| **Doador** | Navega campanhas, vê detalhes, doa, compartilha |

---

## 2. Stack técnica

| Camada | Tecnologia |
|--------|-----------|
| Backend | **Laravel 13** (PHP 8.3+) |
| Banco | **MySQL 8** (container Docker `aurora-mysql`) |
| Frontend | **Blade + Tailwind CSS 4** |
| Interatividade | **Alpine.js** |
| Pagamentos | **ConfraPix** (com Mock para desenvolvimento) |
| Build assets | **Vite** |

> **Sobre o Laravel:** o desafio menciona "Laravel 12", mas o projeto já estava em
> **Laravel 13**, que é retrocompatível e usa exatamente os mesmos padrões. Manter o 13
> evita um downgrade arriscado sem nenhum ganho — o 13 atende e supera o requisito "12+".

---

## 3. A decisão arquitetural principal: **campanhas como entidade central**

A versão original do Aurora era **centrada na instituição**: cada instituição tinha
`meta` e `valor_arrecadado`, e as doações apontavam direto para a instituição. Ou seja, na
prática **cada instituição era uma única campanha eterna**.

O desafio exige **campanhas** como entidade central. Refatoramos para:

```
Instituição (1) ──< (N) Campanha (1) ──< (N) Doação (1) ──< (N) TransaçãoPagamento
                          │
                          └──< (N) AtualizaçãoCampanha
```

- Uma **instituição** agora é só o perfil da organização (dados de contato, missão).
- A **meta** e o **valor arrecadado** vivem na **campanha**.
- As **doações** pertencem a uma **campanha** (e, por ela, à instituição).
- As **atualizações** (notícias/fotos) pertencem à **campanha**.
- Cada **doação** registra suas **transações de pagamento** (log do gateway).

**Por que isso importa para a banca:** é o que o desafio pede, reflete o mundo real (uma ONG
faz várias campanhas ao longo do tempo) e prepara o terreno para expansões futuras (ranking
de campanhas, campanhas com geolocalização, etc.) sem reescrever o núcleo.

---

## 4. Arquitetura em camadas

O projeto segue **MVC + Service Layer**, com responsabilidades bem separadas (SOLID / Clean Code):

| Camada | Responsabilidade | Não pode |
|--------|------------------|----------|
| **Controller** | Recebe request, chama service, devolve view/redirect | Lógica de negócio, queries diretas |
| **Service** | Toda a lógica de negócio, queries, transações | Acessar request, devolver views |
| **FormRequest** | Validação de entrada e mensagens | Lógica de negócio |
| **Model** | Relacionamentos, casts, scopes, métodos de domínio | Conhecer rotas, montar URLs |
| **Enum** | Constantes tipadas com `label()`, `values()`, `opcoes()` | Métodos sem uso |
| **View** | Renderizar dados prontos | Preparar dados, queries |

```
app/
├── Enums/
│   ├── SituacaoCampanha.php      # rascunho | ativa | encerrada
│   ├── SituacaoDoacao.php        # pendente | confirmada | expirada | cancelada
│   └── TipoUsuario.php           # administrador | doador
├── Http/
│   ├── Controllers/
│   │   ├── Admin/                # Painel (protegido por VerificarAdmin)
│   │   ├── Auth/                 # Login/logout
│   │   └── Site/                 # Páginas públicas
│   ├── Middleware/VerificarAdmin.php
│   └── Requests/                 # Validação isolada (CampanhaRequest, DoacaoRequest...)
├── Models/                       # Campanha, Instituicao, Doacao, AtualizacaoCampanha, TransacaoPagamento, User
├── Providers/                    # AppServiceProvider, PagamentoServiceProvider
└── Services/
    ├── CampanhaService.php       # CRUD e listagens de campanhas
    ├── DoacaoService.php         # Registrar/confirmar doações
    ├── DashboardService.php      # Agregação de métricas do painel
    ├── InstituicaoService.php    # CRUD de instituições
    └── Pagamento/
        ├── PagamentoServiceInterface.php   # Contrato do gateway
        ├── ConfraPixService.php            # Implementação real (ConfraPix API)
        └── MockPagamentoService.php        # Mock p/ dev (confirma na hora)
```

---

## 5. Modelo de dados

| Tabela | Model | Campos principais |
|--------|-------|-------------------|
| `users` | `User` | name, email, password, **tipo** (administrador/doador), telefone, avatar |
| `institutions` | `Instituicao` *(SoftDeletes)* | nome, slug, descricao, missao, logo, contato, chave_pix, cidade/estado, ativa |
| `campaigns` | `Campanha` *(SoftDeletes)* | instituicao_id, titulo, slug, resumo, descricao, imagem, video_url, **meta**, **valor_arrecadado**, **situacao**, **destaque**, data_inicio, data_fim |
| `donations` | `Doacao` | **campanha_id**, user_id, nome_doador, email_doador, valor, transaction_id, situacao, anonimo, mensagem |
| `campaign_updates` | `AtualizacaoCampanha` | campanha_id, titulo, descricao, imagem |
| `payment_transactions` | `TransacaoPagamento` | doacao_id, gateway, transaction_id, valor, status, qr_code, qr_code_text, expira_em, pago_em, payload(json) |

**Índices importantes:** `campaigns(situacao)`, `campaigns(destaque)`, `campaigns(instituicao_id, situacao)`,
`donations(situacao)`, `donations(campanha_id, situacao)`, `donations.transaction_id` (unique),
`payment_transactions(transaction_id)`, `payment_transactions(status)`.

> Convenção do projeto: **tabela em inglês** (plural), **model e colunas de FK em português**
> (`campanha_id`, `instituicao_id`). Colunas de tipo/situação são `string(50)`, nunca `enum()` do MySQL.

---

## 6. Pagamento via ConfraPix

A integração de pagamento é abstraída por uma **interface**, então o sistema funciona com ou
sem token configurado:

- **`PagamentoServiceInterface`** — o contrato (`gerarCobrancaPix`, `consultarPagamento`).
- **`ConfraPixService`** — chama a API real da ConfraPix (usado quando `CONFRAPIX_TOKEN` está setado).
- **`MockPagamentoService`** — gera um QR Code fake e confirma na hora (usado em dev / na demo).
- O binding fica em `PagamentoServiceProvider`; a config em `config/services.php`.

**Por que assim:** dá pra demonstrar todo o fluxo de doação sem depender da disponibilidade da
API externa, e trocar para produção é só preencher o token no `.env`. Toda cobrança gera um
registro em `payment_transactions` para auditoria e transparência.

### Fluxo de doação

```
1. Doador escolhe a campanha e o valor
2. Service registra a Doação (pendente) e pede a cobrança PIX ao gateway
3. Cria o registro em payment_transactions com o QR Code
4. Tela exibe QR Code + copia-e-cola
5. Sistema consulta/confirma o pagamento
6. Doação vira "confirmada" e a campanha tem o valor_arrecadado incrementado (em transação)
7. Tela de sucesso
```

---

## 6.1. Identidade visual — paleta "Azul Confiança"

O sistema usa **Blade + Tailwind 4 + Alpine.js**. Todo o tema de cores é definido por
**tokens** em `resources/css/app.css` (bloco `@theme`), então a identidade visual inteira é
trocada num único arquivo, sem mexer view por view.

A paleta foi escolhida para transmitir **confiança e vontade de ajudar** (essencial numa
plataforma de pagamentos/doações):

| Papel | Cor | Onde aparece |
|-------|-----|--------------|
| Primário | Azul `#1D4ED8` | Botões, links, foco |
| Profundo | Navy `#1E3A8A` | Hero, faixas, títulos |
| Apoio | Teal `#0D9488` | Barras de progresso, sucesso |
| Acento (CTA) | Âmbar `#D97706`/`#F59E0B` | Botão "Doar", destaques |
| Neutros | Slate / cinza-gelo | Textos e fundos |

> Por compatibilidade, os **nomes** dos tokens foram mantidos (`terra`, `night`, `sage`,
> `honey`, `rosa`, `bark`, `cream`) — só os valores hex mudaram. Assim `terra-500` hoje é
> azul, `sage` é teal, etc.

**Imagens temáticas:** o seeder usa imagens por palavra-chave (loremflickr: crianças, comida,
animais, educação, idosos) e logos gerados na cor da marca (ui-avatars). Os models têm
`imagemUrl()`/`logoUrl()` que aceitam tanto upload local quanto URL externa, então é fácil
trocar por fotos próprias depois.

## 7. Segurança

- **Token do gateway** fica só no backend (`.env` / `config`), nunca no frontend.
- **Validação de inputs** via FormRequests dedicados.
- **CSRF** em todos os formulários (padrão Laravel).
- **Rate limiting** no endpoint de doação (evita abuso na geração de cobranças).
- **Log de transações** em `payment_transactions` (auditoria e prestação de contas).

---

## 8. Como rodar

Há duas formas. Use a que preferir.

### Opção A — Tudo no Docker (mais simples, porta fixa) ⭐

Sobe o **site + banco** em containers. Não precisa de PHP/Node instalados na máquina.

```bash
docker compose up -d --build
```

- **Site:** http://localhost:8001
- **Banco (MySQL):** container `aurora-mysql` (porta 3308 no host, para inspeção)

O container do app (`aurora-app`) instala dependências, compila os assets, roda as migrations
e, **se o banco estiver vazio**, semeia os dados de demonstração — tudo automático pelo
`docker/entrypoint.sh`. Logs: `docker compose logs -f app`.

> O container usa o arquivo **`.env.docker`** (montado por cima do `.env`), que aponta o banco
> para o serviço interno `mysql:3306`. O `.env` local continua intacto para a Opção B.

### Opção B — App local + só o banco no Docker

```bash
docker compose up -d mysql          # só o banco (porta 3308)
composer install
npm install                          # se der erro de permissão de cache: npm install --cache /tmp/npmcache
cp .env.example .env                 # já aponta para MySQL na porta 3308
php artisan key:generate
php artisan migrate:fresh --seed
php artisan storage:link
php artisan serve                    # http://localhost:8000
npm run dev                          # opcional (HMR); sem ele, rode "npm run build" uma vez
```

### Acessos
- **Login admin:** `admin@aurora.org.br` / senha `password`
- **Banco (inspeção):** host `127.0.0.1`, porta `3308`, user `root`, senha `root`, db `aurora`

> **Portas:** o `docker-compose.yml` original mapeava o banco na **3307**, mas nesta máquina ela
> já estava ocupada por outro container — mudamos para **3308**. O site dockerizado usa a **8001**
> (a 8000 fica para o `php artisan serve` local da Opção B).

---

## 9. Checklist do MVP (status)

Legenda: ✅ feito · 🔄 em andamento · ⬜ pendente

### Infraestrutura
- ✅ MySQL 8 no Docker (porta 3308) + `.env` configurado
- ✅ Migrations reestruturadas para o modelo campaign-centric

### Modelagem (migrations + models)
- ✅ `users`, `institutions`, `campaigns`, `donations`, `campaign_updates`, `payment_transactions`
- ✅ Models: `Campanha`, `Instituicao`, `Doacao`, `AtualizacaoCampanha`, `TransacaoPagamento`, `User`
- ✅ Enums: `SituacaoCampanha`, `SituacaoDoacao`, `TipoUsuario`

### Camada de serviço
- ✅ `CampanhaService`, `DoacaoService`, `DashboardService`, `InstituicaoService`
- ✅ Integração de pagamento com registro em `payment_transactions` + QR Code real (mock)

### Telas (MVP obrigatório)
- ✅ Landing page (campanhas em destaque, como funciona, selos de confiança, impacto)
- ✅ Listagem de campanhas com busca (imagem, título, resumo, meta, arrecadado, %)
- ✅ Página da campanha (info completa, barra de progresso, atualizações, apoiadores, compartilhar)
- ✅ Fluxo de doação (valor → QR Code PIX → confirmação → arrecadação)
- ✅ Dashboard da instituição (total arrecadado, nº campanhas, nº doadores, últimas doações, ranking)
- ✅ Publicação de atualizações (no formulário de edição da campanha)
- ✅ Identidade visual "Azul Confiança" + imagens temáticas

### Qualidade
- ✅ Seeders com dados de demonstração (6 instituições, 8 campanhas, ~114 doações + transações)
- ✅ Smoke test das páginas principais (público + admin + fluxo de doação) — todas 200
- ✅ Suíte de testes (`composer test`) passando

> **MVP completo.** Checklist atualizado em 08/06/2026.

---

## 10. Funcionalidades futuras (arquitetura já preparada)

Não entram no MVP, mas o modelo de dados já comporta:

- **Prestação de contas** (relatórios de uso por campanha)
- **Doações recorrentes** (assinatura)
- **Pagamento por cartão** (basta uma nova implementação de `PagamentoServiceInterface`)
- **Ranking de campanhas** (já temos `valor_arrecadado` e `destaque`)
- **Empresas patrocinadoras**
- **Geolocalização de campanhas** (instituição já tem cidade/estado)
- **App mobile** (a lógica está nos Services, fácil expor via API)

---

## 11. Glossário de decisões (resumo para a banca)

| Decisão | Por quê |
|---------|---------|
| Campanha como entidade central | Exigência do desafio + reflete o mundo real + escalável |
| Service Layer | Lógica isolada, testável e reutilizável (web hoje, API amanhã) |
| Interface de pagamento + Mock | Demo sem depender da API externa; produção é só trocar o token |
| Tabela `payment_transactions` | Transparência, auditoria e prestação de contas |
| `string(50)` em vez de `enum()` no MySQL | Evolução do schema sem migration de ALTER custosa |
| Manter Laravel 13 | Retrocompatível com "12+", zero retrabalho |
| MySQL no Docker, app local | Banco isolado e reproduzível sem instalar MySQL na máquina |
