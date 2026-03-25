@echo off
REM -------------------------------
REM Script BAT - Mapa completo del HERO
REM -------------------------------

set SALIDA=hero_map.txt

echo Mapa de archivos - HERO > %SALIDA%
echo ======================== >> %SALIDA%
echo Generado: %date% %time% >> %SALIDA%
echo ======================== >> %SALIDA%

REM -------------------------------
REM 1. CONTROLADORES
REM -------------------------------
echo. >> %SALIDA%
echo [CONTROLADORES] >> %SALIDA%
echo ======================== >> %SALIDA%

set CONTROLADORES=app\Http\Controllers\LandingController.php app\Http\Controllers\Admin\HeroController.php app\Http\Controllers\Admin\SettingController.php

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
REM 2. MODELO
REM -------------------------------
echo. >> %SALIDA%
echo [MODELO] >> %SALIDA%
echo ======================== >> %SALIDA%

set MODELOS=app\Models\Setting.php

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
REM 3. SERVICIOS
REM -------------------------------
echo. >> %SALIDA%
echo [SERVICIOS] >> %SALIDA%
echo ======================== >> %SALIDA%

set SERVICIOS=app\Services\CacheService.php app\Services\ImageUploadService.php

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
REM 4. VISTAS
REM -------------------------------
echo. >> %SALIDA%
echo [VISTAS] >> %SALIDA%
echo ======================== >> %SALIDA%

set VISTAS=resources\views\landing\sections\hero.blade.php resources\views\admin\hero\index.blade.php

for %%f in (%VISTAS%) do (
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
REM 5. RUTAS
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
REM 6. MIGRACIONES
REM -------------------------------
echo. >> %SALIDA%
echo [MIGRACIONES] >> %SALIDA%
echo ======================== >> %SALIDA%

for /r database\migrations %%f in (*setting*) do (
    echo Archivo: %%f >> %SALIDA%
    echo ----------------------- >> %SALIDA%
    type "%%f" >> %SALIDA%
    echo. >> %SALIDA%
    echo ======================== >> %SALIDA%
)

echo. >> %SALIDA%
echo Mapa completado. >> %SALIDA%

echo Listo. Revisa %SALIDA%
pause
