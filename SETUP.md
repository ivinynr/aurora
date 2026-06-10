# Como rodar o projeto Aurora

## Pré-requisitos

- PHP 8.3+
- Composer
- Node.js 18+
- Docker e Docker Compose

## 1. Clonar o repositório

```bash
git clone https://github.com/skycavalcant/aurora.git
cd aurora
```

## 2. Subir o banco de dados (MySQL via Docker)

```bash
docker compose up -d
```

Isso cria um container `aurora-mysql` com as seguintes configurações:

| Item     | Valor              |
|----------|--------------------|
| Imagem   | MySQL 8.0          |
| Porta    | 3307 (host) → 3306 (container) |
| Banco    | aurora             |
| Usuário  | root               |
| Senha    | root               |
| Charset  | utf8mb4            |

Para verificar se o container está rodando:

```bash
docker ps
```

Para acessar o MySQL pelo terminal:

```bash
docker exec -it aurora-mysql mysql -u root -proot aurora
```

## 3. Configurar o ambiente

```bash
cp .env.example .env
```

Edite o `.env` e configure a conexão com o banco:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3307
DB_DATABASE=aurora
DB_USERNAME=root
DB_PASSWORD=root
```

Gere a chave da aplicação:

```bash
php artisan key:generate
```

## 4. Instalar dependências

```bash
composer install
npm install
```

## 5. Rodar as migrations

```bash
php artisan migrate
```

## 6. Rodar o projeto

O jeito mais rápido é usar o comando que sobe tudo de uma vez:

```bash
composer dev
```

Ou, se preferir rodar separadamente em terminais diferentes:

```bash
# Terminal 1 - Backend
php artisan serve

# Terminal 2 - Frontend (Vite)
npm run dev
```

O sistema estará disponível em: http://localhost:8000

## Comandos úteis

| Comando            | O que faz                              |
|--------------------|----------------------------------------|
| `composer dev`     | Sobe server + queue + logs + vite      |
| `composer test`    | Roda os testes                         |
| `composer setup`   | Instalação completa (deps + migrate + build) |
| `docker compose up -d`   | Sobe o banco MySQL                |
| `docker compose down`    | Para o banco MySQL                |
| `docker compose down -v` | Para o banco e apaga os dados     |
