<#
    ===============================================================
     ClariFi - orquestrador do ambiente (Windows)

       .\clarifi dev      sobe o ambiente completo (um unico comando)
       .\clarifi build    build de producao (assets + imagem Docker)
       .\clarifi help     lista todos os comandos

     Fala direto com o Docker Desktop no Windows - sem depender do
     WSL nem de conversao de caminhos.

     Nota sobre o Windows PowerShell 5.1: a saida de erro de um
     executavel nativo vira ErrorRecord quando redirecionada, o que
     derruba o script sob $ErrorActionPreference = 'Stop'. Por isso
     toda chamada ao docker passa pelos helpers abaixo, que trocam a
     preferencia durante a execucao e conferem o $LASTEXITCODE na mao.
    ===============================================================
#>
[CmdletBinding()]
param(
    [Parameter(Position = 0)]
    [string] $Command = 'help',

    [Parameter(Position = 1, ValueFromRemainingArguments = $true)]
    [string[]] $Rest = @()
)

$ErrorActionPreference = 'Stop'
Set-Location -Path $PSScriptRoot

$AppPort  = if ($env:APP_PORT)  { $env:APP_PORT }  else { '8000' }
$VitePort = if ($env:VITE_PORT) { $env:VITE_PORT } else { '5173' }
$DbPort   = if ($env:DB_PORT_FORWARD) { $env:DB_PORT_FORWARD } else { '5432' }

function Write-Info     { param([string]$Message) Write-Host "==> $Message" -ForegroundColor Cyan }
function Write-Ok       { param([string]$Message) Write-Host "OK  $Message" -ForegroundColor Green }
function Write-Warn     { param([string]$Message) Write-Host "!   $Message" -ForegroundColor Yellow }
function Stop-WithError { param([string]$Message) Write-Host "x   $Message" -ForegroundColor Red; exit 1 }

# Executa o docker mostrando a saida. Retorna o codigo de saida.
#
# Usa Start-Process (e nao "& docker") de proposito: enquanto espera os
# containers, o Compose anexa o stream de logs deles, e esse stream nao
# fecha quando a saida e um pipe - o PowerShell fica preso lendo o pipe
# mesmo depois que o docker ja terminou. Com -NoNewWindow o processo
# escreve direto no console, sem pipe no meio.
function Invoke-Docker {
    param([Parameter(ValueFromRemainingArguments = $true)][string[]] $Arguments)

    $quoted = $Arguments | ForEach-Object {
        if ($_ -match '[\s"]') { '"' + ($_ -replace '"', '\"') + '"' } else { $_ }
    }

    $process = Start-Process -FilePath 'docker' -ArgumentList $quoted -NoNewWindow -Wait -PassThru
    return $process.ExitCode
}

# Igual ao anterior, mas aborta o script se o docker falhar.
function Invoke-DockerOrExit {
    param([Parameter(ValueFromRemainingArguments = $true)][string[]] $Arguments)

    $code = Invoke-Docker @Arguments
    if ($code -ne 0) { exit $code }
}

# Executa o docker em silencio e devolve a saida padrao como texto.
function Get-DockerOutput {
    param([Parameter(ValueFromRemainingArguments = $true)][string[]] $Arguments)

    $previous = $ErrorActionPreference
    $ErrorActionPreference = 'Continue'
    try { $output = & docker @Arguments 2>$null } finally { $ErrorActionPreference = $previous }

    return [pscustomobject]@{
        ExitCode = $LASTEXITCODE
        Output   = ($output | Out-String).Trim()
    }
}

function Assert-Docker {
    if (-not (Get-Command docker -ErrorAction SilentlyContinue)) {
        Stop-WithError 'Docker nao encontrado. Instale o Docker Desktop.'
    }
    if ((Get-DockerOutput compose version).ExitCode -ne 0) {
        Stop-WithError 'Docker Compose v2 nao encontrado.'
    }
    if ((Get-DockerOutput info --format '{{.ServerVersion}}').ExitCode -ne 0) {
        Stop-WithError 'O daemon do Docker nao esta rodando. Abra o Docker Desktop e tente de novo.'
    }
}

function Initialize-EnvFile {
    if (-not (Test-Path '.env')) {
        Write-Info 'criando .env a partir de .env.example'
        Copy-Item '.env.example' '.env'
    }
}

function Invoke-Dev {
    Assert-Docker
    Initialize-EnvFile

    Write-Info 'construindo e subindo os containers (a primeira vez demora)'
    # --wait: o compose so retorna quando todos os servicos estao saudaveis.
    # --progress plain: o modo padrao depende de um terminal de verdade.
    $code = Invoke-Docker compose --progress plain up -d --build --wait --wait-timeout 600
    if ($code -ne 0) {
        Invoke-Docker compose logs --tail=60 | Out-Null
        Stop-WithError 'o ambiente nao ficou pronto a tempo'
    }

    Write-Host ''
    Write-Host 'ClariFi esta no ar' -ForegroundColor Green
    Write-Host "  Aplicacao      http://localhost:$AppPort"
    Write-Host "  Vite (HMR)     http://localhost:$VitePort"
    Write-Host "  Postgres       localhost:$DbPort"
    Write-Host ''
    Write-Host '  Logs           .\clarifi logs'
    Write-Host '  Artisan        .\clarifi artisan <comando>'
    Write-Host '  Parar          .\clarifi down'
    Write-Host ''
}

function Confirm-Up {
    Assert-Docker
    $result = Get-DockerOutput compose ps -q app
    if ([string]::IsNullOrWhiteSpace($result.Output)) { Invoke-Dev }
}

function Invoke-Build {
    Assert-Docker
    Initialize-EnvFile

    Write-Info 'compilando os ativos de frontend (Vite)'
    Invoke-DockerOrExit compose --progress plain run --rm --no-deps --entrypoint sh vite -c 'npm ci --no-audit --no-fund && npm run build'

    Write-Info 'construindo a imagem de producao (clarifi:local)'
    Invoke-DockerOrExit build --progress plain --target production --tag clarifi:local .

    Write-Host ''
    Write-Ok 'build concluido'
    Write-Host '  Assets         public/build'
    Write-Host '  Imagem         clarifi:local  (porta 8080)'
    Write-Host '  Executar       docker run --rm -p 8080:8080 --env-file .env clarifi:local'
    Write-Host ''
    Write-Warn "o cache de config/rotas nao e gerado no bind mount: rode 'php artisan optimize' no deploy"
}

function Show-Help {
    Write-Host @"
ClariFi - comandos disponiveis

  Ambiente
    dev                 sobe o ambiente completo de desenvolvimento
    down                para e remove os containers
    stop                apenas para os containers (mantem o estado)
    restart             reinicia os containers
    reset               destroi containers e volumes e sobe do zero
    ps                  mostra o estado dos containers
    logs [servico]      acompanha os logs (padrao: todos)

  Build e qualidade
    build               compila os assets e a imagem de producao
    test [args]         roda a suite de testes (php artisan test)
    lint                formata o codigo com o Pint
    lint --check        falha se houver codigo fora do padrao (usado no CI)

  Atalhos
    artisan <args>      php artisan dentro do container
    composer <args>     composer dentro do container
    npm <args>          npm dentro do container do Vite
    shell [servico]     abre um shell (padrao: app)
    migrate [args]      php artisan migrate
    fresh               php artisan migrate:fresh (apaga os dados)
"@
}

switch ($Command.ToLowerInvariant()) {
    { $_ -in 'dev', 'up' } { Invoke-Dev; break }

    'build' { Invoke-Build; break }

    'down' { Assert-Docker; Write-Info 'removendo os containers'; Invoke-DockerOrExit compose --progress plain down; break }

    'stop' { Assert-Docker; Write-Info 'parando os containers'; Invoke-DockerOrExit compose --progress plain stop; break }

    'restart' { Assert-Docker; Invoke-DockerOrExit compose --progress plain restart; Write-Ok 'containers reiniciados'; break }

    'reset' {
        Assert-Docker
        Write-Warn 'isso apaga o banco de dados e as dependencias instaladas'
        Invoke-DockerOrExit compose --progress plain down --volumes --remove-orphans
        Invoke-Dev
        break
    }

    'ps' { Assert-Docker; Invoke-DockerOrExit compose ps; break }

    'logs' { Assert-Docker; Invoke-DockerOrExit compose logs -f --tail=100 @Rest; break }

    'shell' {
        Confirm-Up
        $service = if ($Rest.Count -gt 0) { $Rest[0] } else { 'app' }
        Invoke-DockerOrExit compose exec $service sh
        break
    }

    'artisan'  { Confirm-Up; Invoke-DockerOrExit compose exec app php artisan @Rest; break }

    'composer' { Confirm-Up; Invoke-DockerOrExit compose exec app composer @Rest; break }

    'npm'      { Confirm-Up; Invoke-DockerOrExit compose exec vite npm @Rest; break }

    'migrate'  { Confirm-Up; Invoke-DockerOrExit compose exec app php artisan migrate @Rest; break }

    'fresh'    { Confirm-Up; Invoke-DockerOrExit compose exec app php artisan migrate:fresh; break }

    'test' {
        Confirm-Up
        Write-Info 'executando a suite de testes'
        Invoke-DockerOrExit compose exec -T app php artisan test @Rest
        break
    }

    'lint' {
        Confirm-Up
        if ($Rest.Count -gt 0 -and $Rest[0] -eq '--check') {
            Write-Info 'verificando o estilo do codigo (Pint)'
            Invoke-DockerOrExit compose exec -T app vendor/bin/pint --test
        }
        else {
            Write-Info 'formatando o codigo (Pint)'
            Invoke-DockerOrExit compose exec -T app vendor/bin/pint
        }
        break
    }

    { $_ -in 'help', '-h', '--help' } { Show-Help; break }

    default {
        Write-Host "comando desconhecido: $Command" -ForegroundColor Red
        Write-Host ''
        Show-Help
        exit 1
    }
}
