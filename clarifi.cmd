@echo off
rem ============================================================
rem  ClariFi - Launcher para Windows (cmd.exe / PowerShell)
rem
rem  Nao confia no diretorio herdado pelo WSL (quando chamado
rem  via cmd.exe ele inicia no bind-mount do Docker, nao no
rem  projeto). Converte a pasta do projeto para o caminho Unix
rem  com wslpath e invoca o script por caminho absoluto. O
rem  script clarifi se encarrega de entrar no proprio diretorio.
rem
rem  Uso:
rem     .\clarifi.cmd dev     -> sobe o ambiente de desenvolvimento
rem     .\clarifi.cmd build   -> build de producao
rem     .\clarifi.cmd down    -> derruba os containers
rem     .\clarifi.cmd artisan <cmd> [args]
rem ============================================================

setlocal
set "PROJROOT=%~dp0"
set "PROJROOT=%PROJROOT:~0,-1%"

rem Converte o caminho do Windows para o caminho WSL de forma
rem mecanica (C:\Users\... -> /mnt/c/Users/...). NAO usamos
rem "wsl wslpath" porque o Docker Desktop redireciona o caminho
rem para um bind-mount interno (/mnt/wsl/docker-desktop-bind-mounts)
rem que fica VAZIO quando montado nos containers.
set "DRIVE=%PROJROOT:~0,1%"
set "REST=%PROJROOT:~2%"
set "REST=%REST:\=/%"
set "WSLPATH="
for %%d in (a b c d e f g h i j k l m n o p q r s t u v w x y z) do if /i "%DRIVE%"=="%%d" set "WSLPATH=/mnt/%%d/%REST%"

if "%WSLPATH%"=="" (
  echo [erro] Nao foi possivel converter o caminho do projeto: "%PROJROOT%"
  endlocal
  exit /b 1
)

wsl bash "%WSLPATH%/clarifi" %*
endlocal