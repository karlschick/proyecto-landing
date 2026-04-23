@echo off
REM -----------------------------------------------
REM Script BAT - Mapa completo de ABOUT (Nosotros)
REM Genera dos archivos para evitar truncado:
REM   about_map.txt   → vistas landing + admin, seeders
REM   about_map_2.txt → controladores, servicios, modelo Setting
REM
REM NOTA: rutas y migraciones se omiten por ser archivos
REM grandes que causan truncado. Usar list_hero.bat si se necesitan.
REM -----------------------------------------------

REM ===============================================
REM ARCHIVO 1: about_map.txt
REM ===============================================

set SALIDA=about_map.txt

echo Mapa de archivos - ABOUT (Parte 1) > %SALIDA%
echo ======================== >> %SALIDA%
echo Generado: %date% %time% >> %SALIDA%
echo ======================== >> %SALIDA%

REM -------------------------------
REM 1. VISTA LANDING
REM -------------------------------
echo. >> %SALIDA%
echo [VISTA - LANDING ABOUT] >> %SALIDA%
echo ======================== >> %SALIDA%

if exist resources\views\landing\sections\about.blade.php (
    echo Archivo: resources\views\landing\sections\about.blade.php >> %SALIDA%
    echo ----------------------- >> %SALIDA%
    type "resources\views\landing\sections\about.blade.php" >> %SALIDA%
    echo. >> %SALIDA%
    echo ======================== >> %SALIDA%
) else (
    echo NO ENCONTRADO: resources\views\landing\sections\about.blade.php >> %SALIDA%
    echo ======================== >> %SALIDA%
)

REM -------------------------------
REM 2. VISTA ADMIN
REM -------------------------------
echo. >> %SALIDA%
echo [VISTA ADMIN - ABOUT] >> %SALIDA%
echo ======================== >> %SALIDA%

if exist resources\views\admin\about\index.blade.php (
    echo Archivo: resources\views\admin\about\index.blade.php >> %SALIDA%
    echo ----------------------- >> %SALIDA%
    type "resources\views\admin\about\index.blade.php" >> %SALIDA%
    echo. >> %SALIDA%
    echo ======================== >> %SALIDA%
) else (
    echo NO ENCONTRADO: resources\views\admin\about\index.blade.php >> %SALIDA%
    echo ======================== >> %SALIDA%
)

REM -------------------------------
REM 3. SEEDERS
REM -------------------------------
echo. >> %SALIDA%
echo [SEEDERS] >> %SALIDA%
echo ======================== >> %SALIDA%

set SEEDERS=database\seeders\SettingSeeder.php database\seeders\DatabaseSeeder.php

for %%f in (%SEEDERS%) do (
    if exist %%f (
        echo Archivo: %%f >> %SALIDA%
        echo ----------------------- >> %SALIDA%
        type "%%f" >> %SALIDA%
        echo. >> %SALIDA%
        echo ======================== >> %SALIDA%
    ) else (
        echo NO ENCONTRADO: %%f >> %SALIDA%
        echo ======================== >> %SALIDA%
    )
)

echo. >> %SALIDA%
echo Parte 1 completada. >> %SALIDA%


REM ===============================================
REM ARCHIVO 2: about_map_2.txt
REM ===============================================

set SALIDA2=about_map_2.txt

echo Mapa de archivos - ABOUT (Parte 2) > %SALIDA2%
echo ======================== >> %SALIDA2%
echo Generado: %date% %time% >> %SALIDA2%
echo ======================== >> %SALIDA2%

REM -------------------------------
REM 1. CONTROLADORES
REM -------------------------------
echo. >> %SALIDA2%
echo [CONTROLADORES] >> %SALIDA2%
echo ======================== >> %SALIDA2%

set CONTROLADORES=app\Http\Controllers\LandingController.php app\Http\Controllers\Admin\AboutController.php

for %%f in (%CONTROLADORES%) do (
    if exist %%f (
        echo Archivo: %%f >> %SALIDA2%
        echo ----------------------- >> %SALIDA2%
        type "%%f" >> %SALIDA2%
        echo. >> %SALIDA2%
        echo ======================== >> %SALIDA2%
    ) else (
        echo NO ENCONTRADO: %%f >> %SALIDA2%
        echo ======================== >> %SALIDA2%
    )
)

REM -------------------------------
REM 2. SERVICIOS
REM -------------------------------
echo. >> %SALIDA2%
echo [SERVICIOS] >> %SALIDA2%
echo ======================== >> %SALIDA2%

set SERVICIOS=app\Services\CacheService.php app\Services\ImageUploadService.php

for %%f in (%SERVICIOS%) do (
    if exist %%f (
        echo Archivo: %%f >> %SALIDA2%
        echo ----------------------- >> %SALIDA2%
        type "%%f" >> %SALIDA2%
        echo. >> %SALIDA2%
        echo ======================== >> %SALIDA2%
    ) else (
        echo NO ENCONTRADO: %%f >> %SALIDA2%
        echo ======================== >> %SALIDA2%
    )
)

REM -------------------------------
REM 3. MODELO Setting
REM -------------------------------
echo. >> %SALIDA2%
echo [MODELO] >> %SALIDA2%
echo ======================== >> %SALIDA2%

if exist app\Models\Setting.php (
    echo Archivo: app\Models\Setting.php >> %SALIDA2%
    echo ----------------------- >> %SALIDA2%
    type "app\Models\Setting.php" >> %SALIDA2%
    echo. >> %SALIDA2%
    echo ======================== >> %SALIDA2%
) else (
    echo NO ENCONTRADO: app\Models\Setting.php >> %SALIDA2%
    echo ======================== >> %SALIDA2%
)

echo. >> %SALIDA2%
echo Parte 2 completada. >> %SALIDA2%

echo.
echo ================================
echo Listo. Se generaron dos archivos:
echo   - about_map.txt   (vistas landing+admin, seeders)
echo   - about_map_2.txt (controladores, servicios, modelo)
echo ================================
pause
