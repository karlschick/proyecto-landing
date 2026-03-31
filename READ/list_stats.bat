@echo off
REM -----------------------------------------------
REM Script BAT - Mapa completo de STATS
REM Genera dos archivos para evitar truncado:
REM   stats_map.txt   → vistas, rutas, migraciones, seeders
REM   stats_map_2.txt → controladores, servicios, modelo, _form
REM -----------------------------------------------

REM ===============================================
REM ARCHIVO 1: stats_map.txt
REM ===============================================

set SALIDA=stats_map.txt

echo Mapa de archivos - STATS (Parte 1) > %SALIDA%
echo ======================== >> %SALIDA%
echo Generado: %date% %time% >> %SALIDA%
echo ======================== >> %SALIDA%

REM -------------------------------
REM 1. VISTA LANDING
REM -------------------------------
echo. >> %SALIDA%
echo [VISTA - LANDING STATS] >> %SALIDA%
echo ======================== >> %SALIDA%

if exist resources\views\landing\sections\stats.blade.php (
    echo Archivo: resources\views\landing\sections\stats.blade.php >> %SALIDA%
    echo ----------------------- >> %SALIDA%
    type "resources\views\landing\sections\stats.blade.php" >> %SALIDA%
    echo. >> %SALIDA%
    echo ======================== >> %SALIDA%
) else (
    echo NO ENCONTRADO: resources\views\landing\sections\stats.blade.php >> %SALIDA%
    echo ======================== >> %SALIDA%
)

REM -------------------------------
REM 2. VISTA ADMIN INDEX
REM -------------------------------
echo. >> %SALIDA%
echo [VISTA ADMIN - INDEX] >> %SALIDA%
echo ======================== >> %SALIDA%

if exist resources\views\admin\stats\index.blade.php (
    echo Archivo: resources\views\admin\stats\index.blade.php >> %SALIDA%
    echo ----------------------- >> %SALIDA%
    type "resources\views\admin\stats\index.blade.php" >> %SALIDA%
    echo. >> %SALIDA%
    echo ======================== >> %SALIDA%
) else (
    echo NO ENCONTRADO: resources\views\admin\stats\index.blade.php >> %SALIDA%
    echo ======================== >> %SALIDA%
)

REM -------------------------------
REM 3. RUTAS
REM -------------------------------
echo. >> %SALIDA%
echo [RUTAS] >> %SALIDA%
echo ======================== >> %SALIDA%

if exist routes\web.php (
    echo Archivo: routes\web.php >> %SALIDA%
    echo ----------------------- >> %SALIDA%
    type "routes\web.php" >> %SALIDA%
    echo. >> %SALIDA%
    echo ======================== >> %SALIDA%
) else (
    echo NO ENCONTRADO: routes\web.php >> %SALIDA%
    echo ======================== >> %SALIDA%
)

REM -------------------------------
REM 4. MIGRACIONES
REM -------------------------------
echo. >> %SALIDA%
echo [MIGRACIONES] >> %SALIDA%
echo ======================== >> %SALIDA%

for /r database\migrations %%f in (*stat*) do (
    echo Archivo: %%f >> %SALIDA%
    echo ----------------------- >> %SALIDA%
    type "%%f" >> %SALIDA%
    echo. >> %SALIDA%
    echo ======================== >> %SALIDA%
)

REM -------------------------------
REM 5. SEEDERS
REM -------------------------------
echo. >> %SALIDA%
echo [SEEDERS] >> %SALIDA%
echo ======================== >> %SALIDA%

set SEEDERS=database\seeders\StatSeeder.php database\seeders\DatabaseSeeder.php

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
REM ARCHIVO 2: stats_map_2.txt
REM ===============================================

set SALIDA2=stats_map_2.txt

echo Mapa de archivos - STATS (Parte 2) > %SALIDA2%
echo ======================== >> %SALIDA2%
echo Generado: %date% %time% >> %SALIDA2%
echo ======================== >> %SALIDA2%

REM -------------------------------
REM 1. FORM PARTIAL
REM -------------------------------
echo. >> %SALIDA2%
echo [VISTA ADMIN - FORM PARTIAL] >> %SALIDA2%
echo ======================== >> %SALIDA2%

if exist resources\views\admin\stats\_form.blade.php (
    echo Archivo: resources\views\admin\stats\_form.blade.php >> %SALIDA2%
    echo ----------------------- >> %SALIDA2%
    type "resources\views\admin\stats\_form.blade.php" >> %SALIDA2%
    echo. >> %SALIDA2%
    echo ======================== >> %SALIDA2%
) else (
    echo NO ENCONTRADO: resources\views\admin\stats\_form.blade.php >> %SALIDA2%
    echo ======================== >> %SALIDA2%
)

REM -------------------------------
REM 2. CONTROLADORES
REM -------------------------------
echo. >> %SALIDA2%
echo [CONTROLADORES] >> %SALIDA2%
echo ======================== >> %SALIDA2%

set CONTROLADORES=app\Http\Controllers\LandingController.php app\Http\Controllers\Admin\StatController.php

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
REM 3. CACHE SERVICE
REM -------------------------------
echo. >> %SALIDA2%
echo [SERVICIOS] >> %SALIDA2%
echo ======================== >> %SALIDA2%

if exist app\Services\CacheService.php (
    echo Archivo: app\Services\CacheService.php >> %SALIDA2%
    echo ----------------------- >> %SALIDA2%
    type "app\Services\CacheService.php" >> %SALIDA2%
    echo. >> %SALIDA2%
    echo ======================== >> %SALIDA2%
) else (
    echo NO ENCONTRADO: app\Services\CacheService.php >> %SALIDA2%
    echo ======================== >> %SALIDA2%
)

REM -------------------------------
REM 4. MODELO
REM -------------------------------
echo. >> %SALIDA2%
echo [MODELO] >> %SALIDA2%
echo ======================== >> %SALIDA2%

if exist app\Models\Stat.php (
    echo Archivo: app\Models\Stat.php >> %SALIDA2%
    echo ----------------------- >> %SALIDA2%
    type "app\Models\Stat.php" >> %SALIDA2%
    echo. >> %SALIDA2%
    echo ======================== >> %SALIDA2%
) else (
    echo NO ENCONTRADO: app\Models\Stat.php >> %SALIDA2%
    echo ======================== >> %SALIDA2%
)

echo. >> %SALIDA2%
echo Parte 2 completada. >> %SALIDA2%

echo.
echo ================================
echo Listo. Se generaron dos archivos:
echo   - stats_map.txt   (vistas, rutas, migraciones, seeders)
echo   - stats_map_2.txt (controladores, servicios, modelo)
echo ================================
pause
