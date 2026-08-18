#!/usr/bin/env bash
set -e

# Render injeta a porta em $PORT (local usa 80)
: "${PORT:=80}"
sed -ri "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf
sed -ri "s/:80>/:${PORT}>/" /etc/apache2/sites-available/000-default.conf

# banco: migra e popula com dados ficticios (seeder e idempotente)
php artisan migrate --force
php artisan db:seed --force

# cache de producao
php artisan config:cache
php artisan route:cache
php artisan view:cache

exec apache2-foreground
