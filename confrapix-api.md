# Confrapix API — Documentação

> API para gestão de transações por Pix do sistema ConfraPix (CONFRAPAG).
> Dúvidas: abrir chamado pelo portal ou contatar o Licenciado Autorizado.

---

## Autenticação

Todas as requisições devem incluir a token no header como **Bearer Token**.

```
Authorization: Bearer <token>
```

> ⚠️ A token deve ser solicitada ao desenvolvedor responsável pelo sistema Confrapix. Para gerar a token, é necessário informar o **CPF/CNPJ do seller** ao qual ela estará vinculada.

---

## Base URL

```
https://api.confrapix.com.br/api
```

---

## Modelo de Dados — Transaction

| Campo | Tipo | Descrição |
|---|---|---|
| `id` | integer | Identificador da transação |
| `uuid` | string | Identificador único universal (128 bits) |
| `transaction_origin_id` | integer | ID da transação estática de origem |
| `endtoend` | string | Identificador único do SPI (Banco Central); preenchido após pagamento |
| `customer_name` | string | Se informado, apenas essa pessoa pode pagar |
| `customer_document` | string | Se informado, apenas essa pessoa pode pagar |
| `description` | string | Descrição que aparece na transação |
| `status` | enum | Situação atual (ver abaixo) |
| `confirmed` | boolean | Se a transação foi paga; em Pix estático, indica se o QR Code está ativo |
| `type` | enum | Tipo da transação (`payment` ou `static`) |
| `payment_type` | enum | Tipo de pagamento (`pix` ou `bankslip`) |
| `amount` | decimal | Valor total da transação |
| `net_amount` | decimal | Valor líquido da transação |
| `discount` | decimal | Desconto da transação |
| `tax_applied` | decimal | Taxa aplicada que define o desconto |
| `callback_url` | string | URL chamada em qualquer atualização (webhook) |
| `captured_in` | dateTime | Data de criação/emissão da transação |
| `expired_in` | dateTime | Data de expiração (enquanto `processing`) |
| `payed_in` | dateTime | Data do pagamento |
| `pix` | object | Dados do Pix (ver abaixo) |
| `bankslip` | object | Dados do BolePix (ver abaixo) |
| `seller` | object | Dados do estabelecimento que criou a transação |

### Status

| Valor | Descrição |
|---|---|
| `processing` | Transação criada, aguardando pagamento ou cancelamento |
| `succeeded` | Transação paga |
| `canceled` | Transação cancelada |
| `error` | Erro ao processar a transação |
| `disable` | Transação desabilitada |

### Objeto `pix`

| Campo | Descrição |
|---|---|
| `url` | URL do QR Code Pix |
| `code` | Código copia e cola |
| `payer_data` | Dados de quem pagou (`cpf`, `nome`, `cnpj`) |
| `receiver_data` | Dados do recebedor (estabelecimento) |

### Objeto `bankslip`

| Campo | Descrição |
|---|---|
| `pix_code` | Código copia e cola |
| `barCodeNumber` | Código de barras |
| `digitableLine` | Linha digitável |
| `payer_data` | Dados de quem pagou (`cpf`, `nome`, `cnpj`) |
| `receiver_data` | Dados do recebedor (estabelecimento) |

---

## Endpoints — Transações

Path base: `/transaction-ec`

---

### POST `/transaction-ec/store` — Criar Pix Dinâmico

Cria uma transação Pix dinâmico. Sempre retorna `type: "payment"` e `payment_type: "pix"`.

**Campos do body:**

| Campo | Tipo | Obrigatório | Descrição |
|---|---|---|---|
| `amount` | decimal | ✅ | Valor total da cobrança |
| `customer_document` | string | ⚠️ condicional | CPF/CNPJ do pagador. Se informado, exige `customer_name` |
| `customer_name` | string | ⚠️ condicional | Nome do pagador. Se informado, exige `customer_document` |
| `description` | string | ❌ | Descrição da transação |
| `expiration_date` | dateTime | ❌ | Data/hora de expiração (`Y-m-d H:i:s`) |
| `callback_url` | string | ❌ | URL de webhook para atualizações |

**Exemplo de body:**

```json
{
  "amount": 10,
  "customer_name": "Customer name example",
  "customer_document": "12312312300",
  "description": "Descrição test",
  "expiration_date": "2025-12-31 23:59:59",
  "callback_url": "https://mydomain-example.com/webhook"
}
```

---

### POST `/transaction-ec/store-static` — Criar Pix Estático

Cria uma transação Pix estático. Sempre retorna `type: "static"`. O valor é inserido pelo pagador no momento do pagamento.

**Campos do body:**

| Campo | Tipo | Obrigatório | Descrição |
|---|---|---|---|
| `callback_url` | string | ❌ | URL de webhook para atualizações |

**Exemplo de body:**

```json
{
  "callback_url": "https://mydomain-example.com/webhook"
}
```

---

### POST `/transaction-ec/store-bankslip` — Criar BolePix

Cria uma transação BolePix. Sempre retorna `type: "payment"` e `payment_type: "bankslip"`.

**Campos do body:**

| Campo | Tipo | Obrigatório | Descrição |
|---|---|---|---|
| `amount` | decimal | ✅ | Valor total |
| `expiration_date` | date | ✅ | Data de vencimento (`Y-m-d`) |
| `limit_date` | date | ✅ | Data limite de pagamento (`Y-m-d`) |
| `customer_name` | string | ✅ | Nome do cliente |
| `customer_document` | string | ✅ | CPF/CNPJ do cliente |
| `customer_cep` | string | ✅ | CEP do cliente |
| `customer_state` | string | ✅ | UF do cliente (2 caracteres) |
| `customer_city` | string | ✅ | Cidade do cliente |
| `customer_neighborhood` | string | ✅ | Bairro do cliente |
| `customer_street` | string | ✅ | Rua do cliente |
| `customer_number` | string | ✅ | Número do endereço |
| `customer_complement` | string | ❌ | Complemento do endereço |
| `amount_interest` | decimal | ❌ | % de juros após vencimento |
| `amount_fine` | decimal | ❌ | % de multa após vencimento |
| `amount_discount` | decimal | ❌ | % de desconto até o vencimento |
| `description` | string | ❌ | Descrição da transação |
| `callback_url` | string | ❌ | URL de webhook para atualizações |

**Exemplo de body:**

```json
{
  "amount": 10,
  "expiration_date": "2025-12-20",
  "limit_date": "2025-12-30",
  "customer_name": "João da Silva",
  "customer_document": "98765432100",
  "customer_cep": "58000000",
  "customer_state": "PB",
  "customer_city": "João Pessoa",
  "customer_neighborhood": "Centro",
  "customer_street": "Rua das Flores",
  "customer_number": "123",
  "customer_complement": "Apto 202",
  "amount_interest": 2.50,
  "amount_fine": 1.00,
  "amount_discount": 5.00,
  "callback_url": "https://minhaapi.com/webhook",
  "description": "Pagamento referente ao pedido #1234"
}
```

---

### GET `/transaction-ec/index` — Listar Transações

Lista as transações da hierarquia dentro do período especificado. Padrão: página 1, 10 registros por página.

**Query params:**

| Parâmetro | Exemplo | Descrição |
|---|---|---|
| `id` | `1` | ID da transação |
| `uuid` | `xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx` | UUID da transação |
| `transaction_origin_id` | `2` | ID da transação estática de origem |
| `type` | `payment` | Tipo: `payment` ou `static` |
| `status` | `processing` | Status: `processing`, `failed`, `succeeded`, `canceled` |
| `confirmed` | `1` | `1` = paga, `0` = não paga |
| `customer_name` | `João` | Nome do pagador |
| `customer_document` | `12345678900` | Documento do pagador |
| `amount_min` | `1` | Valor mínimo da transação |
| `amount_max` | `100` | Valor máximo da transação |
| `captured_in_start` | `2025-06-01 0:00:00` | Início do período de captura |
| `captured_in_end` | `2025-06-30 23:59:59` | Fim do período de captura |
| `payed_in_start` | `2024-01-01 00:00:00` | Início do período de pagamento |
| `payed_in_end` | `2024-12-31 23:59:59` | Fim do período de pagamento |
| `page` | `1` | Página da listagem |
| `per_page` | `10` | Quantidade de registros por página |

**Exemplo:**

```
GET /transaction-ec/index?page=1&per_page=10&status=succeeded
```

---

### GET `/transaction-ec/show/:transaction_id` — Buscar Transação

Busca os detalhes de uma transação (Pix ou BolePix) da hierarquia pelo ID.

**Path variable:**

| Parâmetro | Descrição |
|---|---|
| `transaction_id` | ID da transação |

---

### PUT `/transaction-ec/cancel/:transaction_id` — Cancelar Transação

Cancela transações de qualquer tipo (`pix dinâmico`, `pix estático`, `bolepix`) com status `processing`. Também permite cancelar dentro de **24h após o pagamento**, realizando reembolso.

O status da transação é atualizado de forma **assíncrona** via webhook após o cancelamento.

> ⚠️ O cancelamento de Pix dinâmicos está disponível **apenas para estabelecimentos vinculados ao fornecedor MTbank**. Para outros fornecedores, o reembolso deve ser feito via cash-out no portal Confrapulse.

**Path variable:**

| Parâmetro | Descrição |
|---|---|
| `transaction_id` | ID da transação a cancelar |

---

## Webhook — Callback de Transação

Quando ocorrer qualquer atualização em uma transação, a `callback_url` cadastrada na criação será chamada via **POST**.

> ⚠️ O callback só ocorre se `callback_url` for fornecida no payload de criação da transação.

**Payload enviado (Pix):**

```json
{
  "id": 1,
  "uuid": "****",
  "customer_name": null,
  "customer_document": null,
  "description": null,
  "payment_type": "pix",
  "status": "processing",
  "confirmed": false,
  "amount": "10.0000",
  "net_amount": "0.0000",
  "discount": "0.0000",
  "callback_url": "https://exemplo.com",
  "expired_in": "2025-05-19 15:51:00",
  "captured_in": "2025-04-24 14:35:47",
  "payed_in": null,
  "type": "payment",
  "seller_document": "***********",
  "pix": {
    "url": "https://qr.example.com/pix/****",
    "txid": "***************",
    "code": "***",
    "endtoend_id": "***********",
    "payer_data": {
      "cpf": "***********",
      "nome": "Cliente Exemplo",
      "cnpj": ""
    }
  }
}
```

> Para transações BolePix, o objeto `pix` é substituído por `bankslip` com os campos `pix_code`, `barCodeNumber`, `digitableLine` e `payer_data`.

---

## Endpoint Utilitário

### GET `/` — Versão da API

Retorna a versão atual do Confrapix. Pode ser usado para testar a conectividade com a URL base.

```
GET https://api.confrapix.com.br/api
```
