# ClariFi

Aplicação web de controle financeiro pessoal (receitas, despesas, investimentos,
planejamento futuro, histórico e calendário), construída com Laravel 11, Blade,
Tailwind CSS v4 e Vite.

---

## Subindo o ambiente

Pré-requisito único: **Docker Desktop** rodando. PHP, Composer, Node e Postgres
ficam todos dentro dos containers — não é preciso instalar nada na máquina.

```bash
# Windows (PowerShell ou cmd)
.\clarifi dev

# Linux / macOS / WSL
./clarifi dev
```

O comando cuida de tudo: cria o `.env` a partir do `.env.example`, constrói as
imagens, instala as dependências PHP e JS, gera o `APP_KEY`, aplica as migrations
e só devolve o terminal quando a aplicação responde.

| Serviço | Endereço |
|---|---|
| Aplicação | http://localhost:8000 |
| Vite (HMR) | http://localhost:5173 |
| Postgres | localhost:5432 |

As portas podem ser trocadas via `APP_PORT`, `VITE_PORT` e `DB_PORT_FORWARD` no `.env`.

## Build de produção

```bash
./clarifi build
```

Compila os ativos de frontend (`public/build`) e constrói a imagem de produção
`clarifi:local`, servida pelo [FrankenPHP](https://frankenphp.dev) na porta 8080:

```bash
docker run --rm -p 8080:8080 --env-file .env clarifi:local
```

## Comandos

| Comando | O que faz |
|---|---|
| `clarifi dev` | sobe o ambiente completo de desenvolvimento |
| `clarifi build` | compila os assets e a imagem de produção |
| `clarifi down` | para e remove os containers |
| `clarifi stop` | para os containers mantendo o estado |
| `clarifi restart` | reinicia os containers |
| `clarifi reset` | destrói containers **e volumes** e sobe do zero |
| `clarifi ps` | estado dos containers |
| `clarifi logs [serviço]` | acompanha os logs |
| `clarifi test [args]` | roda a suíte de testes |
| `clarifi lint` | formata o código com o Pint |
| `clarifi lint --check` | falha se houver código fora do padrão (usado no CI) |
| `clarifi artisan <args>` | `php artisan` dentro do container |
| `clarifi composer <args>` | `composer` dentro do container |
| `clarifi npm <args>` | `npm` dentro do container do Vite |
| `clarifi shell [serviço]` | abre um shell (padrão: `app`) |
| `clarifi migrate [args]` | aplica migrations |
| `clarifi fresh` | `migrate:fresh` (apaga os dados) |

## Arquitetura do ambiente

```
docker-compose.yml       app (PHP 8.4) + vite (Node 24) + pgsql (Postgres 16)
Dockerfile               base -> dev -> assets -> production (multi-stage)
docker/entrypoint.dev.sh bootstrap do container PHP (deps, chave, migrations)
docker/entrypoint.node.sh bootstrap do container Node (npm ci + vite dev)
clarifi / clarifi.ps1    orquestradores (bash e PowerShell)
```

Dois detalhes importantes:

- `vendor/` e `node_modules/` ficam em **volumes nomeados**, separados do host.
  Os binários nativos do Windows não são compatíveis com os containers Linux, e
  essa separação evita o conflito — o que estiver instalado no host continua
  disponível para a IDE.
- O cache de configuração e rotas do Laravel **nunca** é gravado no bind mount.
  Ele é gerado apenas dentro da imagem de produção; no ambiente de dev o
  entrypoint roda `optimize:clear` a cada boot.

## CI/CD

Workflows em `.github/workflows`:

| Workflow | Quando roda | O que faz |
|---|---|---|
| `ci.yml` | push em `main`/`master`/`develop`, tags `v*` e todo PR | Pint, PHPUnit sobre Postgres, build do Vite e build da imagem Docker |
| `environment.yml` | mudanças no Docker/compose/launchers | sobe o ambiente com `./clarifi dev` e valida aplicação, Vite e testes |

A imagem de produção é publicada no **GitHub Container Registry** em
`ghcr.io/<owner>/<repo>` nos pushes para o branch padrão e em tags `v*`
(em pull requests ela é apenas construída, nunca publicada). O publish usa o
`GITHUB_TOKEN` — não é preciso configurar nenhum secret.

`dependabot.yml` acompanha atualizações de Composer, npm, GitHub Actions e Docker.

## Stack

| Camada | Tecnologia |
|---|---|
| Backend | PHP 8.4, Laravel 11 |
| Autenticação | Laravel Fortify (login, registro, 2FA, passkeys) |
| Frontend | Blade, Tailwind CSS v4, Flowbite, Vite 8 |
| Gráficos | Chart.js 4 |
| Exportação | maatwebsite/excel (XLSX) e CSV nativo |
| Banco | PostgreSQL 16 |
| Formatação | Laravel Pint |
| Testes | PHPUnit 11 |
