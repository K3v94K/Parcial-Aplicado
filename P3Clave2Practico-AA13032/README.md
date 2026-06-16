# P3Clave2Practico-AA13032

Aplicacion Android en Kotlin para consumir la API `APIAA13032`.

## Identidad

- Nombre visible: `MedControl AA13032`
- Paquete: `sv.ues.aa13032.medcontrol`
- Estilo: interfaz medica moderna con azul, teal, tarjetas y formularios limpios.

## Pantallas incluidas

- `ActividadPrincipal`: dashboard con accesos rapidos.
- `RegistroHospitalActivity`: registra hospitales mediante `POST /hospitales`.
- `BusquedaHospitalActivity`: consulta hospitales mediante `GET /hospitales/{id}`.
- `RegistroDoctorActivity`: registra doctores mediante `POST /doctores`.
- `ListadoDoctoresActivity`: lista doctores mediante `GET /doctores`.

## URL local de la API

La clase `ClienteApi` permite cambiar entre:

```text
URL_LOCAL_EMULADOR
URL_LOCAL_TELEFONO
URL_HOSTING
```

El archivo esta en:

```text
app/src/main/java/sv/ues/aa13032/medcontrol/datos/remoto/ClienteApi.kt
```

La guia completa de configuracion local y hosting esta en:

```text
../GUIA_PRUEBAS_LOCAL_HOSTING.md
```

## Recomendacion de prueba

1. Abrir esta carpeta en Android Studio.
2. Sincronizar Gradle.
3. Levantar la API local.
4. Ejecutar la app en emulador.
5. Probar registrar hospital, buscar hospital, registrar doctor y listar doctores.

## Solucion de sincronizacion

El proyecto usa Gradle Wrapper con Gradle `8.9` para evitar conflictos con Gradle `9.0`.

Si Android Studio indica que no encuentra el SDK, abrir:

```text
File > Settings > Languages & Frameworks > Android SDK
```

Luego instalar o seleccionar un SDK local. Android Studio creara el archivo `local.properties` con una ruta similar a:

```text
sdk.dir=C\:\\Users\\kevin\\AppData\\Local\\Android\\Sdk
```

Ese archivo es local del equipo y no se sube al repositorio.
