# Aurora

Plataforma de doações para instituições sociais. Laravel 13, PHP 8.3, MySQL 8, Tailwind 4, Alpine.js.

## Arquitetura

```
app/
├── Enums/                    # Enums com values(), label(), opcoes()
├── Http/
│   ├── Controllers/
│   │   ├── Admin/            # Painel administrativo (protegido por VerificarAdmin)
│   │   ├── Auth/             # Login/logout
│   │   └── Site/             # Paginas publicas (home, instituicoes, doacao)
│   ├── Middleware/            # VerificarAdmin
│   └── Requests/             # FormRequests (validacao isolada do controller)
├── Models/                   # Eloquent com relacionamentos tipados
├── Providers/                # AppServiceProvider, PagamentoServiceProvider
└── Services/
    ├── DashboardService.php  # Agregacao de dados do painel admin
    ├── DoacaoService.php     # Registrar, confirmar, listar, estatisticas
    ├── InstituicaoService.php # CRUD, busca, listagem, cidades
    └── Pagamento/
        ├── PagamentoServiceInterface.php  # Contrato
        ├── ConfraPixService.php           # Implementacao real (ConfraPix API)
        └── MockPagamentoService.php       # Mock para dev sem token
```

## Regras de Arquitetura

### Separacao de responsabilidades

| Camada | Responsabilidade | Proibido |
|--------|-----------------|----------|
| **Controller** | Receber request, chamar service, retornar view/redirect | Logica de negocio, queries diretas, preparacao de dados |
| **Service** | Toda logica de negocio, queries, calculos, transacoes | Acessar request, retornar views, manipular sessao |
| **FormRequest** | Validacao de entrada, mensagens de erro, authorize | Logica de negocio, queries complexas |
| **Model** | Relacionamentos, casts, scopes, metodos de dominio simples | Conhecer rotas, montar URLs, queries de listagem |
| **Enum** | Constantes tipadas com label(), values(), opcoes() | Metodos sem uso real, labels como slug |
| **View** | Renderizar dados prontos, usar componentes | Preparar dados, logica de negocio, queries |

### Controller: so orquestra

```php
// CERTO
public function store(DoacaoRequest $request, string $slug): View
{
    $instituicao = Instituicao::where('slug', $slug)->where('ativa', true)->firstOrFail();
    $doacao = $this->doacaoService->registrar($instituicao, $request->validated());
    $pagamento = $this->pagamentoService->gerarCobrancaPix(...);
    return view('site.doacao.pagamento', compact('instituicao', 'doacao', 'pagamento'));
}

// ERRADO — logica no controller
public function store(Request $request, string $slug): View
{
    $request->validate([...]); // validacao vai no FormRequest
    $doacao = Doacao::create([...]); // criacao vai no Service
    $doacao->instituicao->increment('valor_arrecadado', $doacao->valor); // regra vai no Service
}
```

### Service: toda logica aqui

- Recebe dados primitivos (arrays, models, scalars), nunca o Request
- Retorna Models, Collections ou arrays tipados
- Usa DB::transaction() para operacoes compostas
- Um service por entidade principal (DoacaoService, InstituicaoService)
- Services podem injetar outros services (DashboardService injeta DoacaoService)

### FormRequest: validacao isolada

- Um FormRequest por formulario (DoacaoRequest, InstituicaoRequest)
- Sempre declarar attributes() com labels em portugues com acentos
- Usar messages() para mensagens humanizadas quando necessario
- Usar Rule::in(MeuEnum::values()) para campos com enum

### Model: dominio puro

- Sempre tipar relacionamentos (BelongsTo, HasMany, etc.)
- Casts explícitos para decimals, booleans, enums
- Metodos de dominio simples (percentualArrecadado, nomeExibicao, ehAdmin)
- Nunca acessar rotas ou montar URLs no model

### Enum: padrao obrigatorio

```php
enum MinhaEnum: string
{
    case VALOR = 'valor';

    public function label(): string { return match($this) { ... }; }
    public static function values(): array { return array_column(self::cases(), 'value'); }
    public static function opcoes(): array { ... }
}
```

- label() retorna texto formatado para humanos ("Confirmada"), nunca slug
- Nao criar metodos ehX() sem uso real

## Banco de Dados

- **Motor**: MySQL 8.0, porta 3307 (container aurora-mysql)
- **Banco**: aurora
- **Credenciais dev**: root / root
- Colunas de tipo/situacao: `string('campo', 50)`, nunca `enum(...)`
- Sempre criar `$table->index()` para colunas usadas em where/orderBy/groupBy
- Usar `if (!Schema::hasTable(...))` antes de Schema::create()
- Nunca alterar migrations ja executadas — criar novas

### Tabelas

| Tabela | Model | Indices |
|--------|-------|---------|
| users | User | email (unique), tipo |
| institutions | Instituicao (SoftDeletes) | slug (unique), cidade, estado, ativa |
| donations | Doacao | situacao, [instituicao_id, situacao], transaction_id (unique) |
| institution_updates | AtualizacaoInstituicao | instituicao_id (FK) |

## Rotas

```
GET  /                                → Site\HomeController (invokable)
GET  /instituicoes                    → Site\InstituicaoController@index
GET  /instituicoes/{slug}             → Site\InstituicaoController@show
GET  /doar/{slug}                     → Site\DoacaoController@create
POST /doar/{slug}                     → Site\DoacaoController@store
GET  /doar/{slug}/{id}/confirmar      → Site\DoacaoController@confirmar
GET  /doar/{slug}/{id}/sucesso        → Site\DoacaoController@sucesso

GET  /login                           → Auth\LoginController@create
POST /login                           → Auth\LoginController@store
POST /logout                          → Auth\LoginController@destroy

# Admin (middleware: auth + VerificarAdmin)
GET  /admin                           → Admin\DashboardController (invokable)
     /admin/instituicoes              → Admin\InstituicaoController (resource)
GET  /admin/doacoes                   → Admin\DoacaoController@index
GET  /admin/doacoes/{doacao}          → Admin\DoacaoController@show
```

## Views e Componentes

### Layouts
- `<x-layout.app>` — Layout publico (navbar + footer). Props: titulo, descricao
- `<x-layout.admin>` — Layout admin (sidebar + header). Props: titulo
- `<x-layout.navbar>` — Navegacao publica
- `<x-layout.footer>` — Rodape
- `<x-layout.logo>` — Logo SVG. Props: tamanho (sm|md|lg|xl), cor (escuro|claro)

### UI (reutilizaveis)
- `<x-ui.botao>` — Botao estilizado
- `<x-ui.input>` — Campo de formulario
- `<x-ui.card>` — Card wrapper
- `<x-ui.badge>` — Badge de status
- `<x-ui.alerta>` — Mensagem de alerta
- `<x-ui.stat-card>` — Card de estatistica
- `<x-ui.barra-progresso>` — Barra de progresso

### Feature
- `<x-instituicao.card>` — Card de instituicao (listagem)
- `<x-instituicao.mural-apoiadores>` — Mural de apoiadores
- `<x-doacao.stepper>` — Stepper do fluxo de doacao

### Regras de views
- Formularios usam `form.blade.php` como nome
- Modais vao em `partials/_nome-modal.blade.php`
- Nunca usar @extends/@section com componentes Blade
- Reutilizar componentes existentes antes de criar novos

## Paleta de Cores (Tailwind)

| Token | Hex | Uso |
|-------|-----|-----|
| cream-50..300 | #FDF7F7..#DEC8CD | Fundos claros, bordas suaves |
| bark-50..900 | #F7F3EF..#2A211A | Textos, fundos neutros |
| terra-50..600 | #FDF5F0..#8B4F3B | Acentos quentes (admin) |
| sage-50..500 | #F4F6F2..#5F6F54 | Verdes suaves |
| honey-50..400 | #FDF8EC..#B8903A | Amarelos/dourados |
| night-700..800 | #24402F..#1A3028 | Verde escuro (hero, faixa impacto) |
| rosa-300..600 | #E8A0BF..#A83F56 | Rosa/rose (CTA, destaques, acento) |

## Pagamento (PIX)

- Interface: `PagamentoServiceInterface`
- Producao: `ConfraPixService` (quando CONFRAPIX_TOKEN configurado)
- Dev: `MockPagamentoService` (confirma imediatamente)
- Binding em `PagamentoServiceProvider`
- Config em `config/services.php` → confrapix.url, confrapix.token

## Comandos

```bash
composer dev        # Sobe tudo: server (8000) + queue + logs + vite (5173)
composer test       # Roda testes
composer setup      # Instalacao completa (deps + migrate + build)
php artisan serve   # Apenas o server Laravel
npm run dev         # Apenas o Vite
```

## Regras de Codigo

1. **Idioma**: nomes de classes, metodos e variaveis em portugues (camelCase). Estruturas do framework em ingles (Controller, Service, etc.)
2. **Imports no topo**: nunca no meio do codigo. Novos imports vao no final do bloco existente
3. **Sem DB:: inline**: centralizar queries em Services ou Models
4. **Reutilizar antes de criar**: verificar componentes, services e metodos existentes
5. **Preservar acentos**: labels, attributes e mensagens mantêm acentuação ("Situação", nunca "Situacao")
6. **Nao reordenar imports existentes**: adicionar novos no final do bloco
7. **Nao remover linhas em branco existentes**: manter espacamento original
8. **Mensagens de erro completas**: explicar O QUE nao pode ser feito e POR QUE
9. **Arquivos: nome seguro**: usar hashName() ou UUID para uploads
10. **Arquivos: validar por MIME**: usar mimes + extensions, nao apenas extensao
11. **SoftDeletes = preservar arquivo**: nao deletar arquivo fisico no destroy
