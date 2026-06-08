#!/bin/bash
set -e

echo "==> Instalando dependencias PHP (composer)..."
composer install --no-interaction --prefer-dist

echo "==> Instalando dependencias Node e compilando assets (vite build)..."
npm install
npm run build

grep -q "APP_KEY=base64:" .env || php artisan key:generate --no-interaction

echo "==> Rodando migrations..."
php artisan migrate --force
php artisan storage:link || true

# Semeia dados de demonstracao apenas se o banco estiver vazio
USERS=$(php artisan tinker --execute="echo \App\Models\User::count();" 2>/dev/null | tail -n1 | tr -dc '0-9')
if [ -z "$USERS" ] || [ "$USERS" = "0" ]; then
  echo "==> Banco vazio: semeando dados de demonstracao..."
  php artisan db:seed --force || true
fi

echo "==> Site no ar! Acesse http://localhost:8001"
php artisan serve --host=0.0.0.0 --port=8000
