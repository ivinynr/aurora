# Tasks — DoeJP

Controle do que **já foi feito** e do que **falta fazer** na adequação do projeto ao desafio
do Hackathon (Confrapag + UNIESP). Detalhes técnicos e o "porquê" de cada decisão estão no
[`DOCUMENTACAO.md`](./DOCUMENTACAO.md).

Legenda: ✅ feito · 🔄 em andamento · ⬜ a fazer

Branch de trabalho: **`leticia-dev`**

---

## Contexto da reforma

O projeto base (**Aurora**) era *centrado na instituição* (cada instituição = uma campanha
única). O desafio exige **campanhas** como entidade central. Estamos refatorando para:
`Instituição → várias Campanhas → Doações → Transações de pagamento`, mantendo a stack
**Laravel 13 + MySQL 8 (Docker) + Blade/Tailwind 4 + Alpine.js** e o gateway **ConfraPix**.

---

## ✅ Concluído

### 1. Infraestrutura
- ✅ MySQL 8 no Docker subindo isolado (`docker compose up -d mysql`), porta **3308**
  (a 3307 estava ocupada por outro container da máquina).
- ✅ `.env` e `.env.example` configurados para MySQL + ConfraPix + locale `pt_BR`; `APP_NAME=DoeJP`.
- ✅ `composer install` e `npm install` executados; `APP_KEY` gerada.

### 2. Banco de dados (migrations)
- ✅ `institutions` virou só o perfil da organização (removidos `meta` e `valor_arrecadado`;
  `imagem` → `logo`).
- ✅ Nova tabela **`campaigns`** (entidade central): meta, valor_arrecadado, situação,
  destaque, datas, vídeo.
- ✅ `donations` passou a referenciar **`campanha_id`** (antes `instituicao_id`).
- ✅ `institution_updates` → **`campaign_updates`** (atualização agora pertence à campanha).
- ✅ Nova tabela **`payment_transactions`** (log de cobranças do gateway).
- ✅ `migrate:fresh` rodando sem erros (9 migrations).

### 3. Models e Enums
- ✅ Novos models: `Campanha`, `AtualizacaoCampanha`, `TransacaoPagamento`.
- ✅ Ajustados: `Instituicao` (relação `campanhas` + agregados), `Doacao` (relação `campanha`
  + `transacoes`).
- ✅ Novo enum `SituacaoCampanha` (rascunho/ativa/encerrada).

### 4. Camada de serviço
- ✅ `CampanhaService` (destaques, listagem, busca por slug, CRUD, encerrar, slug único).
- ✅ `DoacaoService` (registrar por campanha, gravar cobrança PIX, confirmar incrementando a
  campanha, estatísticas).
- ✅ `DashboardService` (resumo com nº de campanhas, gráfico por dia, ranking de campanhas).
- ✅ `InstituicaoService` ajustado ao novo modelo.

---

### 5. Controllers, Requests e Rotas  ✅
- ✅ Site: `CampanhaController` (index + show), `DoacaoController` por campanha, Home com destaques.
- ✅ Admin: `CampanhaController` (resource + encerrar), `AtualizacaoController`, dashboard e doações ajustados.
- ✅ `CampanhaRequest` e `AtualizacaoRequest`; `DoacaoRequest`/`InstituicaoRequest` revisados.
- ✅ Rotas reescritas para campanhas (`/campanhas`, `/campanhas/{slug}`, `/doar/{slug}`...).
- ✅ **Rate limiting** no POST de doação (`throttle:6,1`).

### 6. Views e componentes  ✅
- ✅ Landing page (destaques, como funciona, selos de confiança, impacto, últimas doações).
- ✅ Listagem de campanhas + componente `x-campanha.card`.
- ✅ Página da campanha (progresso, atualizações, apoiadores, compartilhar).
- ✅ Fluxo de doação (valor → QR Code PIX real → confirmação → sucesso).
- ✅ Dashboard com ranking de campanhas + doações recentes.
- ✅ CRUD admin de campanhas e publicação de atualizações.
- ✅ Nova identidade visual "Azul Confiança" (paleta tokenizada) + imagens temáticas.

### 7. Dados e validação final  ✅
- ✅ Seeder com dados de demonstração: 6 instituições, 8 campanhas (3 em destaque), ~114 doações + transações, atualizações.
- ✅ `migrate:fresh --seed` + `npm run build` rodando sem erros.
- ✅ Smoke test: todas as páginas públicas 200; admin protegido; fluxo de doação ponta a ponta OK.
- ✅ `composer test` passando; código formatado com Pint.

---

## Como rodar (resumo)

**Tudo no Docker (recomendado):**
```bash
docker compose up -d --build      # site em http://localhost:8001 (banco sobe junto)
```

**App local + banco no Docker:**
```bash
docker compose up -d mysql        # banco na porta 3308
composer install && npm install   # se usar cache próprio: npm install --cache /tmp/npmcache
cp .env.example .env && php artisan key:generate
php artisan migrate:fresh --seed && php artisan storage:link
php artisan serve  +  npm run dev # site em http://localhost:8000
```
**Login admin:** `admin@aurora.org.br` / `password`

---

## Próximos passos (pós-MVP, se quiser evoluir)
1. Multi-tenant: cada admin enxergar só as campanhas da sua instituição.
2. Webhook do ConfraPix para confirmação automática de pagamento (hoje é por consulta).
3. Prestação de contas (relatórios de uso por campanha) e gráfico temporal no dashboard.

---

## Funcionalidades futuras (fora do MVP, arquitetura já preparada)
Prestação de contas · doações recorrentes · pagamento por cartão · ranking de campanhas ·
empresas patrocinadoras · geolocalização · app mobile (lógica já isolada em Services).

---

_Última atualização (08/06/2026): **MVP completo** — refatoração para campanhas, nova paleta
"Azul Confiança", fluxo de doação validado ponta a ponta e testes passando._
