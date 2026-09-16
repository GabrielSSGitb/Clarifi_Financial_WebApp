@echo off
rem ============================================================
rem  ClariFi - Launcher para Windows (cmd.exe / PowerShell)
rem  Traduz o caminho Windows -> caminho WSL e executa o script
rem  bash (clarifi), que depende do Docker rodando no WSL.
rem
rem  Uso:
rem     .\clarifi.cmd dev     -> sobe o ambiente de desenvolvimento
rem     .\clarifi.cmd build   -> build de producao
rem     .\clarifi.cmd down    -> derruba os containers
rem     .\clarifi.cmd artisan <cmd> [args]
rem ============================================================

setlocal EnableDelayedExpansion
set "PROJROOT=%~dp0"

rem Converte o caminho Windows para o equivalente no WSL
for /f "usebackq delims=" %%p in (`wsl wslpath -u "!PROJROOT!"`) do set "WSLDIR=%%p"

rem Remove barra final, se houver
if not "!WSLDIR:~-1!"=="\" set "WSLDIR=!WSLDIR!"

rem Chama o script bash com os argumentos repassados
wsl bash -lc "cd '!WSLDIR!' && ./clarifi %*"
endlocal
