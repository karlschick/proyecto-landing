@echo off
REM -------------------------------
REM Script BAT - Mapa completo de STATS
REM -------------------------------

set SALIDA=stats_map.txt

echo Mapa de archivos - STATS > %SALIDA%
echo ======================== >> %SALIDA%
echo Generado: %date% %time% >> %SALIDA%
echo ======================== >> %SALIDA%

REM -------------------------------
REM 1. VISTA PRINCIPAL
REM -------------------------------
echo. >> %SALIDA%
echo [VISTA - STATS] >> %SALIDA%
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
REM 2. CONTROLADORES
REM -------------------------------
echo. >> %SALIDA%
echo [CONTROLADORES] >> %SALIDA%
echo ======================== >> %SALIDA%

set CONTROLADORES=app\Http\Controllers\LandingController.php app\Http\Controllers\Admin\StatController.php app\Http\Controllers\Admin\SettingController.php

for %%f in (%CONTROLADORES%) do (
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

REM -------------------------------
REM 3. MODELO
REM -------------------------------
echo. >> %SALIDA%
echo [MODELO] >> %SALIDA%
echo ======================== >> %SALIDA%

set MODELOS=app\Models\Stat.php app\Models\Setting.php

for %%f in (%MODELOS%) do (
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

REM -------------------------------
REM 4. SERVICIOS
REM -------------------------------
echo. >> %SALIDA%
echo [SERVICIOS] >> %SALIDA%
echo ======================== >> %SALIDA%

set SERVICIOS=app\Services\CacheService.php

for %%f in (%SERVICIOS%) do (
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

REM -------------------------------
REM 5. VISTA ADMIN (si existe panel de edición)
REM -------------------------------
echo. >> %SALIDA%
echo [VISTA ADMIN] >> %SALIDA%
echo ======================== >> %SALIDA%

set VISTAS_ADMIN=resources\views\admin\stats\index.blade.php resources\views\admin\layout.blade.php

for %%f in (%VISTAS_ADMIN%) do (
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

REM -------------------------------
REM 6. RUTAS
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
REM 7. MIGRACIONES
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
REM 8. SEEDERS
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
echo Mapa completado. >> %SALIDA%

echo Listo. Revisa %SALIDA%
pause
