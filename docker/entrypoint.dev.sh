#!/bin/sh
# ---------------------------------------------------------------
#  Entrypoint de desenvolvimento do container PHP.
#
#  Deixa o container auto-suficiente: qualquer pessoa que clone o
#  repositorio consegue subir tudo com um unico comando, sem rodar
#  composer/artisan na mao.
#
#  Os comandos "serve-app" e "queue-worker" disparam o bootstrap;
#  qualquer outro argumento e' executado direto (one-off commands
#  como pint, phpunit, artisan ...).
# ---------------------------------------------------------------
set -e

cd /var/www

log() { printf '\033[0;36m[clarifi]\033[0m %s\n' "$1"; }

wait_for_source() {
    # Bind mounts do Docker Desktop podem demorar a sincronizar.
    i=0
    while [ ! -f artisan ]; do
        [ "$i" -eq 0 ] && log "aguardando sincronizacao do volume..."
        i=$((i + 1))
        [ "$i" -gt 120 ] && { echo "[clarifi] volume nao sincronizou" >&2; exit 1; }
        sleep 1
    done
}

ensure_env() {
    if [ ! -f .env ]; then
        log "criando .env a partir de .env.example"
        cp .env.example .env
    fi
}

ensure_dependencies() {
    if [ ! -f vendor/autoload.php ] || [ composer.lock -nt vendor/.clarifi-install-stamp ]; then
        log "instalando dependencias PHP (composer)"
        composer install --no-interaction --prefer-dist --no-progress
        touch vendor/.clarifi-install-stamp
    fi
}

ensure_app_key() {
    if ! grep -q '^APP_KEY=base64:' .env; then
        log "gerando APP_KEY"
        php artisan key:generate --force --no-interaction
    fi
}

clear_stale_caches() {
    # Um "clarifi build" anterior pode ter deixado config/rotas em cache
    # no bind mount, congelando o ambiente de desenvolvimento.
    log "limpando caches de build anteriores"
    php artisan optimize:clear >/dev/null 2>&1 || true
}

ensure_storage_link() {
    [ -e public/storage ] || php artisan storage:link --no-interaction >/dev/null 2>&1 || true
}

wait_for_database() {
    log "aguardando o banco de dados"
    i=0
    until php -r '
        $dsn = sprintf("pgsql:host=%s;port=%s;dbname=%s", getenv("DB_HOST"), getenv("DB_PORT"), getenv("DB_DATABASE"));
        try { new PDO($dsn, getenv("DB_USERNAME"), getenv("DB_PASSWORD")); exit(0); } catch (Throwable $e) { exit(1); }
    ' 2>/dev/null; do
        i=$((i + 1))
        [ "$i" -gt 60 ] && { echo "[clarifi] banco de dados indisponivel" >&2; exit 1; }
        sleep 2
    done
}

bootstrap() {
    wait_for_source
    ensure_env
    ensure_dependencies
    ensure_app_key
    clear_stale_caches
    ensure_storage_link
    wait_for_database
}

case "$1" in
    serve-app)
        bootstrap
        log "aplicando migrations"
        php artisan migrate --force --no-interaction
        log "servindo em http://0.0.0.0:8000"
        exec php artisan serve --host=0.0.0.0 --port=8000
        ;;
    queue-worker)
        wait_for_source
        ensure_dependencies
        wait_for_database
        exec php artisan queue:work --tries=3 --max-time=3600
        ;;
    *)
        wait_for_source
        exec "$@"
        ;;
esac
