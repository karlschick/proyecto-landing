@echo off
setlocal enabledelayedexpansion

:: ==============================
:: UBICACION PROYECTO
:: ==============================
cd /d %~dp0..
set ROOT=%CD%
cd /d %~dp0

set STACK=

:: ==============================
:: APP NAME (.env)  <-- 🔥 AÑADIDO
:: ==============================
set APPNAME=

if exist "%ROOT%\.env" (
    for /f "tokens=1,* delims==" %%a in ('findstr /i "^APP_NAME=" "%ROOT%\.env"') do (
        set APPNAME=%%b
    )
)

:: limpiar comillas
if defined APPNAME (
    set APPNAME=!APPNAME:"=!
    set APPNAME=!APPNAME:'=!
) else (
    set APPNAME=No definido
)

:: ==============================
:: Laravel
:: ==============================
for /f "tokens=3" %%a in ('php "%ROOT%\artisan" --version 2^>nul') do (
    set STACK=!STACK!Laravel %%a ·
)

:: ==============================
:: PHP
:: ==============================
for /f %%a in ('php -r "echo PHP_VERSION;"') do (
    set STACK=!STACK!PHP %%a ·
)

:: ==============================
:: MariaDB / MySQL
:: ==============================
for /f "tokens=1" %%a in ('C:\xampp\mysql\bin\mysql.exe -u root -e "SELECT VERSION();" 2^>nul') do (
    set RAWDB=%%a
)

if defined RAWDB (
    for /f "tokens=1,2 delims=." %%a in ("!RAWDB!") do (
        set DBVER=%%a.%%b
    )
    echo !RAWDB! | findstr /i "mariadb" >nul
    if !errorlevel! == 0 (
        set STACK=!STACK!MariaDB !DBVER! ·
    ) else (
        set STACK=!STACK!MySQL !DBVER! ·
    )
)

:: ==============================
:: FRONTEND (package.json)
:: ==============================
if exist "%ROOT%\package.json" (

    findstr /i "tailwindcss" "%ROOT%\package.json" >nul
    if !errorlevel! == 0 set STACK=!STACK!Tailwind CSS ·

    findstr /i "\"vite\"" "%ROOT%\package.json" >nul
    if !errorlevel! == 0 set STACK=!STACK!Vite ·

    findstr /i "alpinejs" "%ROOT%\package.json" >nul
    if !errorlevel! == 0 set STACK=!STACK!Alpine.js ·

    findstr /i "bootstrap" "%ROOT%\package.json" >nul
    if !errorlevel! == 0 set STACK=!STACK!Bootstrap ·

    findstr /i "vue" "%ROOT%\package.json" >nul
    if !errorlevel! == 0 set STACK=!STACK!Vue.js ·

    findstr /i "react" "%ROOT%\package.json" >nul
    if !errorlevel! == 0 set STACK=!STACK!React ·
)

:: ==============================
:: BACKEND (composer.json)
:: ==============================
if exist "%ROOT%\composer.json" (

    findstr /i "livewire/livewire" "%ROOT%\composer.json" >nul
    if !errorlevel! == 0 set STACK=!STACK!Livewire ·

    findstr /i "inertiajs" "%ROOT%\composer.json" >nul
    if !errorlevel! == 0 set STACK=!STACK!Inertia.js ·
)

:: ==============================
:: API TUYA
:: ==============================
if exist "%ROOT%\.env" (
    findstr /i "TUYA" "%ROOT%\.env" >nul
    if !errorlevel! == 0 set STACK=!STACK!API Tuya IoT ·
)

:: ==============================
:: LIMPIAR SEPARADOR FINAL
:: ==============================
if defined STACK (
    set STACK=!STACK:~0,-3!
)

:: ==============================
:: GENERAR ARCHIVO  <-- 🔥 MODIFICADO
:: ==============================
(
echo Nombre del proyecto :
echo !APPNAME!
echo.
echo Desarrollado utilizando el stack tecnologico:
echo !STACK!
) > "%~dp0stack.txt"

echo.
echo ✔ Archivo generado correctamente:
echo %~dp0stack.txt
echo.
echo Contenido:
echo Nombre del proyecto :
echo !APPNAME!
echo.
echo Desarrollado utilizando el stack tecnologico:
echo !STACK!
echo.

pause
