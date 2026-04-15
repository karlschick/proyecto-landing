@echo off
REM -------------------------------
REM Script BAT para listar archivos y su contenido
REM -------------------------------

REM Carpeta a buscar
set CARPETA=app

REM Extensión de archivos a capturar
set EXT=php

REM Archivo de salida
set SALIDA=listado.txt

REM Limpiar archivo de salida
echo Listado de archivos > %SALIDA%
echo ======================== >> %SALIDA%

REM -------------------------------
REM 1️⃣ Listar archivos en carpeta APP recursivamente
REM -------------------------------
for /r %CARPETA% %%f in (*.%EXT%) do (
    echo Archivo: %%f >> %SALIDA%
    echo ----------------------- >> %SALIDA%
    type "%%f" >> %SALIDA%
    echo. >> %SALIDA%
    echo ======================== >> %SALIDA%
)

REM -------------------------------
REM 3️⃣ Listar archivos en resources/views recursivamente
REM -------------------------------
set VIEWS=resources\views

for /r %VIEWS% %%f in (*) do (
    echo Archivo: %%f >> %SALIDA%
    echo ----------------------- >> %SALIDA%
    type "%%f" >> %SALIDA%
    echo. >> %SALIDA%
    echo ======================== >> %SALIDA%
)

REM -------------------------------
REM 2️⃣ Listar archivos específicos fuera de APP
REM -------------------------------
set ESPECIFICOS=.env composer.json

for %%f in (%ESPECIFICOS%) do (
    if exist %%f (
        echo Archivo: %%f >> %SALIDA%
        echo ----------------------- >> %SALIDA%
        type "%%f" >> %SALIDA%
        echo. >> %SALIDA%
        echo ======================== >> %SALIDA%
    )
)

echo Listado completado. Revisa %SALIDA%
pause
