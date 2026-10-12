#!/bin/sh
# ---------------------------------------------------------------
#  Entrypoint do container Node (Vite dev server).
#  Reinstala as dependencias apenas quando o package-lock muda.
# ---------------------------------------------------------------
set -e

cd /var/www

log() { printf '\033[0;36m[clarifi/vite]\033[0m %s\n' "$1"; }

i=0
while [ ! -f package.json ]; do
    [ "$i" -eq 0 ] && log "aguardando sincronizacao do volume..."
    i=$((i + 1))
    [ "$i" -gt 120 ] && { echo "[clarifi/vite] volume nao sincronizou" >&2; exit 1; }
    sleep 1
done

if [ ! -d node_modules/.bin ] || [ package-lock.json -nt node_modules/.clarifi-install-stamp ]; then
    log "instalando dependencias de frontend (npm ci)"
    npm ci --no-audit --no-fund
    touch node_modules/.clarifi-install-stamp
fi

log "iniciando Vite dev server"
exec npm run dev -- --host 0.0.0.0
