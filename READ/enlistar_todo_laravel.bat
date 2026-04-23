@echo off
setlocal enabledelayedexpansion

REM ===============================================
REM CONFIGURACIÓN
REM ===============================================

set OUTPUT1=about_map.txt
set OUTPUT2=about_map_2.txt
set OUTPUT3=project_map.txt
set OUTPUT4=project_content.txt
set MAX_SIZE=40000

set "ROOT=%cd%"
for %%I in ("%cd%") do set "APPNAME=%%~nxI"

set "STACK="

echo =====================================
echo Analizando proyecto: !APPNAME!
echo =====================================
echo.

REM ===============================================
REM DETECCIÓN DE STACK
REM ===============================================

echo Detectando stack...

if exist "%ROOT%\composer.json" (
    findstr /i "laravel/framework" "%ROOT%\composer.json" >nul && set "STACK=!STACK!Laravel · "
    findstr /i "livewire/livewire" "%ROOT%\composer.json" >nul && set "STACK=!STACK!Livewire · "
    findstr /i "inertiajs" "%ROOT%\composer.json" >nul && set "STACK=!STACK!Inertia.js · "
)

if exist "%ROOT%\.env" (
    findstr /i "TUYA" "%ROOT%\.env" >nul && set "STACK=!STACK!API Tuya IoT · "
)

if defined STACK (
    set "STACK=!STACK:~0,-3!"
) else (
    set "STACK=No detectado"
)

(
echo Proyecto: !APPNAME!
echo Stack: !STACK!
) > stack.txt

echo ✔ stack.txt generado
echo.

REM ===============================================
REM MAPA COMPLETO (ESTRUCTURA)
REM ===============================================

echo Generando mapa del proyecto...

echo Mapa completo del proyecto > %OUTPUT3%
echo ============================ >> %OUTPUT3%

for /f "delims=" %%f in ('dir /s /b 2^>nul') do (
    set "skip="

    echo %%f | findstr "\\node_modules\\" >nul && set skip=1
    echo %%f | findstr "\\vendor\\" >nul && set skip=1
    echo %%f | findstr "\\.git\\" >nul && set skip=1
    echo %%f | findstr "\\storage\\" >nul && set skip=1

    if not defined skip (
        echo %%f >> %OUTPUT3%
    )
)

echo ✔ project_map.txt generado
echo.

REM ===============================================
REM CONTENIDO COMPLETO DEL PROYECTO
REM ===============================================

echo Generando contenido del proyecto...

echo Contenido completo del proyecto > %OUTPUT4%
echo ================================ >> %OUTPUT4%

REM === Archivos clave ===
call :ADD_FILE "composer.json"
call :ADD_FILE ".env"

REM === Núcleo Laravel ===
for /r "app" %%f in (*) do call :FILTER_AND_ADD "%%f"
for /r "routes" %%f in (*) do call :FILTER_AND_ADD "%%f"
for /r "config" %%f in (*) do call :FILTER_AND_ADD "%%f"
for /r "database" %%f in (*) do call :FILTER_AND_ADD "%%f"
for /r "bootstrap" %%f in (*) do call :FILTER_AND_ADD "%%f"

REM === TODAS LAS VISTAS (recursivo completo con contenido) ===
for /r "resources" %%f in (*.blade.php *.php *.html *.js *.css) do (
    call :FILTER_AND_ADD "%%f"
)

echo ✔ project_content.txt generado
echo.

REM ===============================================
REM ARCHIVOS ESPECÍFICOS (ABOUT)
REM ===============================================

echo Generando archivos ABOUT...

echo [VISTA LANDING] > %OUTPUT1%
call :PROCESS_FILE "resources\views\landing\sections\about.blade.php" "%OUTPUT1%"

echo [VISTA ADMIN] >> %OUTPUT1%
call :PROCESS_FILE "resources\views\admin\about\index.blade.php" "%OUTPUT1%"

echo [SEEDERS] >> %OUTPUT1%
for /r "database\seeders" %%f in (*.php) do call :PROCESS_FILE "%%f" "%OUTPUT1%"

echo [CONTROLADORES] > %OUTPUT2%
for /r "app\Http\Controllers" %%f in (*.php) do call :PROCESS_FILE "%%f" "%OUTPUT2%"

echo [SERVICIOS] >> %OUTPUT2%
for /r "app\Services" %%f in (*.php) do call :PROCESS_FILE "%%f" "%OUTPUT2%"

echo [MODELOS] >> %OUTPUT2%
for /r "app\Models" %%f in (*.php) do call :PROCESS_FILE "%%f" "%OUTPUT2%"

echo ✔ about_map.txt y about_map_2.txt generados
echo.

REM ===============================================
REM FINAL
REM ===============================================

echo =====================================
echo ✔ PROCESO COMPLETADO
echo =====================================
echo Archivos generados:
echo   - stack.txt
echo   - project_map.txt
echo   - project_content.txt
echo   - about_map.txt
echo   - about_map_2.txt
echo =====================================

pause
goto :eof

REM ===============================================
REM FUNCIONES
REM ===============================================

:FILTER_AND_ADD
set "FILE=%~1"

echo %FILE% | findstr "\\vendor\\" >nul && exit /b
echo %FILE% | findstr "\\node_modules\\" >nul && exit /b
echo %FILE% | findstr "\\.git\\" >nul && exit /b
echo %FILE% | findstr "\\storage\\" >nul && exit /b

call :ADD_FILE "%FILE%"
exit /b

:ADD_FILE
set "FILE=%~1"

if not exist "%FILE%" exit /b

echo. >> %OUTPUT4%
echo Archivo: %FILE% >> %OUTPUT4%
echo ----------------------- >> %OUTPUT4%

for %%A in ("%FILE%") do (
    if %%~zA LSS %MAX_SIZE% (
        type "%FILE%" >> %OUTPUT4%
    ) else (
        echo [OMITIDO por tamaño] >> %OUTPUT4%
    )
)

exit /b

:PROCESS_FILE
set "FILE=%~1"
set "OUT=%~2"

if exist "%FILE%" (
    echo Archivo: %FILE% >> %OUT%

    for %%A in ("%FILE%") do (
        if %%~zA LSS %MAX_SIZE% (
            type "%FILE%" >> %OUT%
        ) else (
            echo [OMITIDO por tamaño] >> %OUT%
        )
    )

    echo. >> %OUT%
) else (
    echo NO ENCONTRADO: %FILE% >> %OUT%
)

exit /b
