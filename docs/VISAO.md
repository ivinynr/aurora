# Documento de Visão — Aurora

> Plataforma de doações para instituições sociais, com pagamento via PIX integrado à API ConfraPix.

---

## 1. Problema

Instituições sociais (ONGs, projetos comunitários, abrigos) dependem de doações para existir,
mas esbarram em três obstáculos concretos:

1. **Falta de um canal próprio e confiável de arrecadação.** Muitas dependem de transferências
   informais (chave PIX no Instagram, grupo de WhatsApp), sem rastreio, sem transparência e sem
   prestação de contas para o doador.
2. **Atrito no momento de doar.** O doador decide ajudar por impulso, mas desiste diante de
   cadastros longos, redirecionamentos para checkouts externos ou meios de pagamento lentos.
3. **Ausência de transparência sobre o impacto.** O doador não sabe quanto a campanha já arrecadou,
   qual a meta, nem o que está sendo feito com o dinheiro — o que reduz a confiança e a recorrência.

**Resumo do problema:** não existe, para a instituição social de pequeno e médio porte, uma forma
simples de **publicar campanhas, receber doações via PIX com baixa fricção e prestar contas de
forma transparente** — tudo em um só lugar.

---

## 2. Visão da solução

O **Aurora** é uma plataforma web onde instituições sociais publicam campanhas e recebem doações
via PIX de forma instantânea, transparente e sem fricção.

> Para **doadores** que querem ajudar uma causa de forma rápida e confiável,
> o **Aurora** é uma **plataforma de doações** que permite doar via PIX em poucos cliques,
> acompanhando o quanto cada campanha já arrecadou.
> Diferente de transferências informais por chave PIX avulsa,
> o Aurora **registra cada doação, confirma o pagamento e dá visibilidade ao impacto.**

### Por que PIX (ConfraPix) e não checkout online (ConfraOnline)

Doação é um ato de impulso e, em geral, de baixo valor. A integração foi feita com **ConfraPix**
porque:

- **Baixa fricção:** o doador lê o QR Code na própria tela e paga — sem sair do site, sem cadastro
  de cartão.
- **Confirmação quase instantânea:** o dinheiro cai na hora, ao contrário de cartão (análise
  antifraude) ou boleto (compensação de dias).
- **Taxa mínima:** o valor cheio da doação chega à instituição — relevante para ONGs.
- **Adequado a valores baixos:** sem mínimos e regras de antifraude de cartão.

ConfraOnline (checkout/link com cartão e boleto) faria sentido para e-commerce ou vendas de maior
ticket, mas adicionaria atrito e custo desnecessários ao caso de uso de doação.

---

## 3. Público-alvo

| Perfil | Necessidade | Como o Aurora atende |
|--------|-------------|----------------------|
| **Doador** | Doar rápido, com confiança e visibilidade do impacto | Doação via PIX em poucos passos + barra de progresso da campanha |
| **Instituição** | Arrecadar de forma organizada e transparente | Cadastro de campanhas, recebimento via PIX, histórico de doações |
| **Administrador** | Gerir instituições, campanhas e acompanhar resultados | Painel admin com dashboard, gestão de instituições e doações |

---

## 4. Escopo do MVP (o que a plataforma entrega)

### Site público
- Home com campanhas em destaque e estatísticas de impacto
- Listagem e página de cada instituição
- Página de campanha com meta, valor arrecadado e barra de progresso
- **Fluxo de doação completo:** formulário → geração de cobrança PIX → tela de pagamento (QR Code)
  → confirmação → tela de sucesso

### Pagamento (PIX via ConfraPix)
- Geração de cobrança PIX com QR Code e código copia-e-cola (`POST /transaction-ec/store`)
- Confirmação do pagamento por consulta à API (`GET /transaction-ec/show/:id`) e por **webhook**
  automático (`POST /webhooks/confrapix`)
- Cancelamento/estorno de doações pelo painel admin (`PUT /transaction-ec/cancel/:id`)
- Token de acesso protegido por variável de ambiente; webhook protegido por segredo compartilhado

### Painel administrativo (protegido por autenticação + perfil)
- Dashboard com indicadores agregados
- Gestão de instituições (CRUD)
- Acompanhamento de doações

---

## 5. Arquitetura (visão técnica)

**Stack:** Laravel 13 · PHP 8.3 · MySQL 8 · Tailwind 4 · Alpine.js

```
Doador → Site (Blade/Tailwind)
            │
            ▼
   DoacaoController ── DoacaoService ──────────► MySQL (campanhas, doações, transações)
            │
            ▼
   PagamentoServiceInterface
            │
   ┌────────┴─────────┐
   ▼                  ▼
ConfraPixService   MockPagamentoService
(produção, token)  (dev, sem token)
   │
   ▼
API ConfraPix (cobrança PIX + consulta)
```

### Modelo de domínio

```
Instituição ──1:N──► Campanha ──1:N──► Doação ──1:1──► TransacaoPagamento
```

- **Instituição** — entidade social (nome, missão, contato, cidade/estado, chave PIX)
- **Campanha** — arrecadação de uma instituição (meta, valor arrecadado, situação, destaque)
- **Doação** — registro do doador (nome, valor, anônimo, mensagem, situação)
- **TransacaoPagamento** — dados da cobrança PIX (transaction_id, QR Code, status, expiração)

### Estados

- **Campanha:** rascunho · ativa · encerrada
- **Doação / Transação:** pendente · confirmada · expirada · cancelada
- **Usuário:** administrador · doador

### Decisões de arquitetura
- **Controller só orquestra**; toda lógica de negócio vive nos **Services**; validação isolada em
  **FormRequests**.
- **Pagamento atrás de uma interface** (`PagamentoServiceInterface`): o `PagamentoServiceProvider`
  injeta `ConfraPixService` quando há token, ou `MockPagamentoService` em desenvolvimento — sem
  alterar nenhuma linha de controller.
- **Token nunca no código:** lido de `CONFRAPIX_TOKEN` via `config/services.php` e enviado com
  `Http::withToken()`.

---

## 6. Fluxo de doação (passo a passo)

1. Doador acessa a campanha e clica em **Doar**.
2. Preenche o formulário (`DoacaoRequest` valida os dados).
3. `DoacaoService::registrar()` cria a doação como **pendente**.
4. `ConfraPixService::gerarCobrancaPix()` chama a API ConfraPix e devolve QR Code + copia-e-cola.
5. A doação recebe a cobrança (`registrarCobranca`) e o doador vê a **tela de pagamento**.
6. Doador paga via PIX; ao confirmar, `consultarPagamento()` verifica o status na ConfraPix.
7. `DoacaoService::confirmar()` marca a doação como **confirmada**, soma ao valor arrecadado da
   campanha e atualiza a transação — tudo em transação de banco.
8. Doador vê a **tela de sucesso**.

---

## 7. Como o projeto atende ao desafio

| Requisito do desafio | Onde está |
|----------------------|-----------|
| Documento de Visão | este documento |
| Problema definido | seção 1 |
| Frontend e backend | Laravel + Blade/Tailwind/Alpine |
| Integração com API (ConfraPix) | `app/Services/Pagamento/ConfraPixService.php` |
| Criação de cobrança PIX | `gerarCobrancaPix()` → `POST /transaction-ec/store` |
| Tela de pagamento | `resources/views/site/doacao/pagamento.blade.php` (QR Code) |
| Confirmação do pagamento | `consultarPagamento()` (polling) + webhook `POST /webhooks/confrapix` |
| Token protegido | `env('CONFRAPIX_TOKEN')` via `config/services.php` |

---

## 8. Configuração da integração

```env
# .env
CONFRAPIX_URL=https://api.confrapix.com.br/api
CONFRAPIX_TOKEN=<seu-token-aqui>
CONFRAPIX_WEBHOOK_SECRET=<segredo-para-validar-o-webhook>
```

Com token configurado, a aplicação usa a integração real (`ConfraPixService`).
Sem token, usa `MockPagamentoService`, que confirma a doação imediatamente — útil para
desenvolvimento e demonstração sem credenciais.

O webhook (`POST /webhooks/confrapix`) só é registrado na ConfraPix quando a aplicação está
publicamente acessível (em `localhost` a API não conseguiria nos chamar de volta); nesse caso a
confirmação acontece pelo botão "Já paguei" (polling). Para testar a conectividade com a API:
`php artisan confrapix:ping`.
