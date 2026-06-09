# Confrapag + UNIESP — Hackathon Fullstack

> Apresentação do CTO Leo D'Lamare  
> **Tema:** Pagamentos que resolvem problemas reais  
> **Datas:** 30/05 lançamento na UNIESP | 13/06 avaliação na Confrapag

---

## Roteiro da apresentação

1. Projetos na Confrapag
2. Tecnologia e meios de pagamento
3. IA na Confrapag
4. Lançamento do desafio

---

## 1. Projetos na Confrapag

### Estruturação e entrega de projetos

> Um projeto bem entregue começa antes do código: problema claro, objetivo definido e escopo possível.

- Clareza do problema antes da solução
- Documento inicial para alinhar expectativa
- Objetivo, escopo e responsáveis definidos
- Prioridades organizadas em entregas menores
- Método para transformar escopo em entrega
- Delivery acompanhado até gerar valor

---

### Como uma ideia vira projeto — Documento de Visão ou TAP

> A necessidade vira um documento inicial que organiza a conversa e reduz ambiguidade.

| Seção | Pergunta guia |
|---|---|
| **Problema** | Qual dor ou oportunidade precisa ser resolvida? |
| **Objetivo** | Qual resultado o projeto precisa gerar? |
| **Escopo inicial** | Público impactado, premissas e restrições. |
| **Impacto do projeto** | Que valor real a entrega precisa produzir? |
| **Entrega / Delivery bem feito** | Como transformar plano em entrega acompanhada? |
| **Evolução** | Como o produto melhora após a primeira entrega? |

---

### Metodologia — Como organizamos o desenvolvimento

> Da ideia para uma sequência clara de prioridades, ciclos e acompanhamento.

1. Backlog e requisitos
2. Priorização por valor
3. Ciclos de desenvolvimento
4. Testes e acompanhamento

---

### Delivery — Entrega por releases

> Entregar menor, aprender mais rápido e evoluir com segurança.

| Release | Descrição |
|---|---|
| **Release 1** | MVP funcional |
| **Release 2** | Melhoria e ajuste de fluxo |
| **Release 3** | Expansão e evolução |

---

## 2. Tecnologia e meios de pagamento

### Visão tecnológica do mercado de pagamentos no Brasil

> Por trás de uma compra simples existe um ecossistema conectado por regras, redes, instituições e tecnologia.

**Participantes do ecossistema:**
- Clientes e estabelecimentos: KYC + LGPD
- Banco, fintech e instituição de pagamento
- Adquirente, subadquirente e gateway
- Bandeira, emissor e recebedor

**Atores do ecossistema de pagamentos:**
- Cliente
- Estabelecimento
- Adquirente
- Banco / Fintech
- Emissor
- Bandeira

---

### Fluxo — Transação de maquineta de cartão de crédito

> Da venda na maquineta até autorização, comprovante e liquidação da transação.

#### Autorização da compra

```
Maquineta (captura cartão e valor)
  → Adquirente (roteia a transação)
  → Bandeira (rede do cartão)
  → Banco emissor (aprova ou recusa)
```

> A resposta volta pelo mesmo caminho até a maquineta imprimir o comprovante.

#### Liquidação da transação aprovada

```
Software de Captura (informa a subadquirente)
  → Subadquirente (realiza a liquidação)
  → Banco Central (recebe informação da liquidação)
```

---

## 3. IA na Confrapag

### Novo paradigma de desenvolvimento

> IA entra como parceira de trabalho: acelera análise, prototipação, código, documentação e compartilhamento de conhecimento.

| Pilar | Descrição |
|---|---|
| **Ferramentas** | Codex, Cursor, GPT, N8N, Figma, Make e Gemini |
| **Conhecimento em Markdown** | Contexto, decisões, padrões e aprendizados compartilhados entre a equipe |
| **Novo paradigma** | Desenvolver conversando com ferramentas, validando com critério humano |

---

## 4. Lançamento do Desafio

### Pagamentos que resolvem problemas reais

> O desafio não é apenas integrar uma API. É pensar em um produto completo: problema, usuário, experiência, pagamento, confirmação e entrega de valor.

| | |
|---|---|
| **Missão** | Criar uma aplicação fullstack que resolva um problema de uma comunidade, instituição, pequeno negócio ou operação comercial. |
| **Meios de pagamento** | Usar **ConfraPix** para Pix e/ou **ConfraOnline** para cartão online, conectando a solução a um fluxo real de cobrança e pagamento. |

> **O melhor projeto demonstra valor real e tem boa arquitetura.**

---

### Ferramentas do Desafio — Gateways de pagamento

> Os gateways delimitam o desafio técnico e conectam o produto dos alunos ao mundo de pagamentos.

| Gateway | Uso |
|---|---|
| **ConfraPix** | Soluções com Pix. Ideal para cobranças, pagamentos instantâneos e experiências com QR / copia e cola. |
| **ConfraOnline** | Pagamentos online com cartão. Ideal para checkout, link de pagamento e venda digital. |

---

### Acesso para integração — Credenciamento e aplicativos

> Use os QR Codes para se autocredenciar, baixar o PagueAssim Empresas e obter o token de integração com os gateways ConfraPix e ConfraOnline.

- **Autocredenciamento:** Configure os gateways corretamente para iniciar a integração.
- **Android / iOS:** Baixe o PagueAssim Empresas para se autocredenciar e obter o token.

---

### Documentação das APIs

| Gateway | URL |
|---|---|
| **ConfraPix** | https://doc.confrapix.com.br |
| **ConfraOnline** | https://doc.confraonline.com.br |

---

## Requisitos — O que o projeto precisa entregar

> O desafio avalia produto, técnica e capacidade de demonstrar uma solução funcional.

- [ ] Documento de Visão
- [ ] Problema definido
- [ ] Frontend e backend
- [ ] Integração com API (ConfraPix ou ConfraOnline)
- [ ] Criação de cobrança / link ou Pix
- [ ] Tela de pagamento
- [ ] Confirmação do pagamento
- [ ] Token protegido
- [ ] Demo final
- [ ] **Delivery: package + documentação**

---

## Demo Day — Apresentação final dos alunos

> A banca precisa entender o problema, o produto, a arquitetura e ver a solução funcionando.

| Parte | O que apresentar |
|---|---|
| **1** | Problema, público-alvo e solução |
| **2** | Fluxo do usuário e arquitetura |
| **3** | Gateways usados e demonstração |
| **4** | Desafios encontrados e próximos passos |

---

## Avaliação — Como os projetos serão avaliados

> Não basta funcionar: precisa resolver um problema, ter boa execução e ser bem apresentado.

| Critério | Descrição |
|---|---|
| Relevância do problema | O problema escolhido é real e relevante? |
| Clareza da solução | A solução resolve de forma clara e objetiva? |
| Uso correto dos gateways | ConfraPix e/ou ConfraOnline integrados corretamente? |
| Qualidade técnica + uso de IA no desenvolvimento | Código bem estruturado, uso de ferramentas de IA? |
| Experiência do usuário | O fluxo é intuitivo e funcional? |
| Completude do MVP | Todos os requisitos foram entregues? |
| Segurança básica | Token protegido, dados sensíveis tratados? |
| Apresentação | Demo claro, banca consegue entender o produto? |
| Impacto social ou comercial | A solução gera valor real? |
