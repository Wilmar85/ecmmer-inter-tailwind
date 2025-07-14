@echo off
REM Script para Windows: Detecta la IP local y lanza Vite con esa IP para desarrollo en red

for /f "tokens=2 delims=:" %%a in ('ipconfig ^| findstr /C:"IPv4"') do (
    set "IP=%%a"
    goto :gotip
)
:gotip
set "IP=%IP: =%"
echo Usando IP local: %IP%

set VITE_HOST=%IP%
npm run dev
