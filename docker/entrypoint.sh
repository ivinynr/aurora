#!/bin/bash
set -e

# Remove arquivo do Vite dev server (gerado pelo npm run dev local)
# Sem isso, o Laravel tenta carregar assets de localhost:5175 e a pagina fica em branco
rm -f public/hot

echo "==> Instalando dependencias PHP (composer)..."
composer install --no-interaction --prefer-dist --optimize-autoloader

echo "==> Instalando dependencias Node..."
npm install --silent

grep -q "APP_KEY=base64:" .env || php artisan key:generate --no-interaction

echo "==> Rodando migrations..."
php artisan migrate --force

php artisan storage:link 2>/dev/null || true

# Semeia dados apenas se o banco estiver vazio
USERS=$(php artisan tinker --execute="echo \App\Models\User::count();" 2>/dev/null | tail -n1 | tr -dc '0-9')
if [ -z "$USERS" ] || [ "$USERS" = "0" ]; then
  echo "==> Banco vazio: semeando dados de demonstracao..."
  php artisan db:seed --force || true
fi

echo ""
echo "========================================="
echo "  Aurora no ar! Acesse http://localhost:8001"
echo "========================================="
echo ""

exec /usr/bin/supervisord -c /var/www/docker/supervisord.conf
