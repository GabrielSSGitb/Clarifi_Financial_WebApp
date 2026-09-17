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
for /f "usebackq delims=" %%p in (`wsl wslpath -u "%PROJROOT%"`) do set "WSLPATH=%%p"
wsl bash "%WSLPATH%/clarifi" %*
endlocal