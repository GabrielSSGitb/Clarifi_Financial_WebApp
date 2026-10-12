@echo off
rem ============================================================
rem  ClariFi - launcher para Windows (cmd.exe / PowerShell)
rem
rem  Delega para o clarifi.ps1, que fala direto com o Docker
rem  Desktop no Windows. No PowerShell basta digitar
rem  ".\clarifi dev": o PATHEXT resolve para este arquivo.
rem
rem     .\clarifi dev     sobe o ambiente de desenvolvimento
rem     .\clarifi build   build de producao
rem     .\clarifi help    lista todos os comandos
rem ============================================================
setlocal
powershell -NoLogo -NoProfile -ExecutionPolicy Bypass -File "%~dp0clarifi.ps1" %*
exit /b %ERRORLEVEL%
