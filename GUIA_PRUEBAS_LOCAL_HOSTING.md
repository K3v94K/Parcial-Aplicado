# Guia de pruebas local y hosting

Esta guia explica como probar el proyecto en dos escenarios:

1. API y base de datos en XAMPP local.
2. API y base de datos publicadas en hosting.

## 1. Preparar base de datos local

1. Abrir XAMPP.
2. Iniciar `Apache` y `MySQL`.
3. Entrar a phpMyAdmin:

```text
http://localhost/phpmyadmin
```

4. Importar el script:

```text
AA13032Clave2.sql
```

El script crea la base de datos:

```text
p3_aa13032_salud
```

## 2. Configurar conexion local de la API

La conexion local esta en:

```text
APIAA13032/src/configuracion/ConexionBaseDatos.php
```

La API usa valores locales por defecto cuando no existen variables de entorno:

```text
DB_HOST=127.0.0.1
DB_PORT=3306
DB_NAME=p3_aa13032_salud
DB_USER=root
DB_PASSWORD=
```

## 3. Levantar API local

Desde PowerShell:

```powershell
cd C:\ruta-del-proyecto\APIAA13032
C:\xampp\php\php.exe -S 0.0.0.0:8088 -t public
```

Usar `0.0.0.0` permite que un telefono fisico en la misma red pueda acceder a la API.

## 4. Probar API local

En navegador de la computadora:

```text
http://127.0.0.1:8088/
http://127.0.0.1:8088/hospitales
http://127.0.0.1:8088/doctores
```

En telefono fisico, usar la IP local de la computadora. Ejemplo:

```text
http://192.168.1.100:8088/
```

La IP local se obtiene con:

```powershell
ipconfig
```

## 5. Configurar Android para pruebas locales

La URL de la API esta en:

```text
P3Clave2Practico-AA13032/app/src/main/java/sv/ues/aa13032/medcontrol/datos/remoto/ClienteApi.kt
```

El archivo contiene:

```kotlin
private const val URL_LOCAL_EMULADOR = "http://10.0.2.2:8088/"
private const val URL_LOCAL_TELEFONO = "http://192.168.1.100:8088/"
private const val URL_HOSTING = "https://reemplazar-con-url-del-hosting/"
private const val URL_BASE = URL_LOCAL_TELEFONO
```

Para emulador Android:

```kotlin
private const val URL_BASE = URL_LOCAL_EMULADOR
```

Para telefono fisico:

```kotlin
private const val URL_BASE = URL_LOCAL_TELEFONO
```

Si el telefono fisico no conecta:

- Confirmar que telefono y computadora estan en la misma red WiFi.
- Levantar la API con `0.0.0.0:8088`.
- Permitir PHP en el Firewall de Windows para redes privadas.
- Probar la URL desde el navegador del telefono.

## 6. Configurar API para hosting

La API no necesita credenciales escritas directamente en el codigo. En Render se deben crear variables de entorno.

Variables para la base MySQL en Filess.io:

```text
DB_HOST=43iy8s.h.filess.io
DB_PORT=61002
DB_NAME=Hospitales_Doctores_goodboxbit
DB_USER=Hospitales_Doctores_goodboxbit
DB_PASSWORD=colocar_clave_en_render
```

La clave real se coloca solamente en el panel de Render, no en GitHub.

La base remota ya debe tener importado `AA13032Clave2.sql`.

En Render, crear un Web Service usando Docker:

```text
Root Directory: APIAA13032
Runtime: Docker
```

El archivo `APIAA13032/Dockerfile` instala las dependencias con Composer y levanta la API usando el puerto asignado por Render.

Pasos en Render:

1. Entrar a `https://dashboard.render.com`.
2. Seleccionar `New` y luego `Web Service`.
3. Conectar el repositorio de GitHub `K3v94K/Parcial-Aplicado`.
4. Seleccionar la rama `main`.
5. Colocar `APIAA13032` en `Root Directory`.
6. Seleccionar `Docker` como runtime.
7. Agregar las variables de entorno `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER` y `DB_PASSWORD`.
8. Crear el servicio y esperar que el deploy finalice.

Cuando Render entregue la URL publica, probar:

```text
https://url-del-servicio.onrender.com/
https://url-del-servicio.onrender.com/hospitales
https://url-del-servicio.onrender.com/doctores
```

## 7. Configurar Android para hosting

En `ClienteApi.kt`, reemplazar:

```kotlin
private const val URL_HOSTING = "https://reemplazar-con-url-del-hosting/"
```

por la URL real de la API publicada. Ejemplo:

```kotlin
private const val URL_HOSTING = "https://mi-api-publicada.com/"
```

Luego cambiar:

```kotlin
private const val URL_BASE = URL_HOSTING
```

La URL debe terminar con `/`.

## 8. Pruebas recomendadas

Probar en este orden:

1. Abrir ruta principal de la API.
2. Listar hospitales.
3. Registrar hospital desde Android.
4. Buscar hospital por nombre desde Android.
5. Registrar doctor seleccionando hospital del dropdown.
6. Listar doctores y confirmar que se muestra el nombre del hospital.
7. Confirmar registros en phpMyAdmin o panel de base de datos remota.
