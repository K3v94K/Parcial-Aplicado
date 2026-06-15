# Instrucciones para Codex  
## Evaluado Parcial 3 Práctico – API REST Slim + Android Kotlin  
### Carnet: AA13032

---

## 1. Contexto general del evaluado

Estoy desarrollando un proyecto académico individual para la materia Programación de Dispositivos Móviles.

El proyecto consiste en crear una solución completa con:

1. **Backend separado** mediante una API REST desarrollada en **PHP usando Slim Framework**.
2. **Base de datos MySQL**.
3. **Frontend Android** desarrollado en **Kotlin**.
4. Consumo de la API desde Android usando formato **JSON**, preferiblemente con **Retrofit2**.
5. Entrega de código fuente, script SQL, proyecto Android, API publicada en hosting y reporte técnico.

El sistema debe permitir gestionar información de **Hospitales** y **Doctores**.

---

## 2. Regla principal de uso de Codex

Codex debe actuar como **tutor técnico, revisor y asistente de depuración**, no como reemplazo del estudiante.

No debe generar el proyecto completo de una sola vez ni producir una solución final lista para entregar sin explicación.

### Reglas obligatorias para Codex

1. Explicar primero qué se va a hacer.
2. Trabajar por fases.
3. Pedir archivos actuales antes de modificar o sugerir correcciones específicas.
4. No generar soluciones completas de golpe.
5. No mezclar backend y frontend.
6. Mantener una arquitectura por capas.
7. Explicar cada cambio importante.
8. Priorizar código claro, entendible y defendible.
9. Mantener nombres personalizados usando el carnet **AA13032**.
10. Ayudar a que el proyecto tenga identidad propia y no parezca una plantilla genérica.
11. No ayudar a ocultar uso de IA ni a evadir revisiones académicas.
12. Ayudar a documentar decisiones técnicas propias.

---

## 3. Nombres oficiales de entrega

Usar los siguientes nombres en todo el proyecto:

| Elemento | Nombre |
|---|---|
| Archivo comprimido final | `EjercicioP3AA13032-CLAVE2.zip` |
| Documento Word | `AA13032_ReporteLAB3CLAVE2.docx` |
| Carpeta de la API | `APIAA13032` |
| Script SQL | `AA13032Clave2.sql` |
| Carpeta del proyecto Android | `P3Clave2Practico-AA13032` |

---

## 4. Identidad propuesta del proyecto

Para diferenciar la aplicación de una plantilla genérica, se usará una identidad propia.

### Nombre sugerido de la app

`MedControl AA13032`

### Paquete Android sugerido

`sv.ues.aa13032.medcontrol`

### Base de datos sugerida

`p3_aa13032_salud`

### Estilo visual sugerido

- Tema relacionado con salud.
- Pantallas limpias.
- Formularios ordenados por secciones.
- Mensajes personalizados.
- Tarjetas para visualizar doctores y hospitales.
- Evitar nombres genéricos como `AppTest`, `DemoApp`, `MainApi`, `ExampleActivity`.

---

## 5. Arquitectura general obligatoria

El proyecto debe estar separado en dos partes principales:

```text
Proyecto completo
│
├── APIAA13032/                  # Backend PHP Slim
│
└── P3Clave2Practico-AA13032/    # Frontend Android Kotlin
```

---

# PARTE I: BACKEND

---

## 6. Backend API REST con Slim

El backend será una API REST independiente desarrollada con PHP y Slim Framework.

Debe encargarse de:

1. Conectarse a MySQL.
2. Exponer endpoints GET y POST.
3. Validar datos recibidos.
4. Ejecutar consultas SQL.
5. Devolver respuestas JSON.
6. Manejar errores.
7. Poder probarse independientemente desde Postman, navegador u otra herramienta HTTP.

Android no debe conectarse directamente a MySQL.

---

## 7. Estructura sugerida del backend

```text
APIAA13032/
│
├── public/
│   └── index.php
│
├── src/
│   ├── config/
│   │   └── database.php
│   │
│   ├── routes/
│   │   ├── doctorRoutes.php
│   │   └── hospitalRoutes.php
│   │
│   ├── controllers/
│   │   ├── DoctorController.php
│   │   └── HospitalController.php
│   │
│   ├── repositories/
│   │   ├── DoctorRepository.php
│   │   └── HospitalRepository.php
│   │
│   └── helpers/
│       └── ResponseHelper.php
│
├── vendor/
├── composer.json
├── composer.lock
└── AA13032Clave2.sql
```

---

## 8. Responsabilidad de cada capa del backend

### `public/`

Contiene el punto de entrada de la API.

Archivo principal:

```text
public/index.php
```

Responsabilidades:

1. Cargar Composer.
2. Crear la instancia de Slim.
3. Registrar rutas.
4. Ejecutar la aplicación.

---

### `src/config/`

Contiene configuración de conexión a MySQL.

Archivo sugerido:

```text
src/config/database.php
```

Responsabilidades:

1. Definir host.
2. Definir base de datos.
3. Definir usuario.
4. Definir contraseña.
5. Crear conexión PDO.
6. Manejar errores de conexión.

---

### `src/routes/`

Contiene definición de rutas.

Archivos sugeridos:

```text
src/routes/doctorRoutes.php
src/routes/hospitalRoutes.php
```

Responsabilidades:

1. Definir rutas GET y POST.
2. Asociar rutas con controladores.
3. Evitar lógica SQL dentro de las rutas.

---

### `src/controllers/`

Contiene controladores.

Archivos sugeridos:

```text
src/controllers/DoctorController.php
src/controllers/HospitalController.php
```

Responsabilidades:

1. Recibir solicitudes HTTP.
2. Leer datos enviados.
3. Validar campos requeridos.
4. Llamar a repositorios.
5. Devolver respuestas JSON.

---

### `src/repositories/`

Contiene acceso a datos.

Archivos sugeridos:

```text
src/repositories/DoctorRepository.php
src/repositories/HospitalRepository.php
```

Responsabilidades:

1. Ejecutar consultas SQL.
2. Insertar registros.
3. Consultar registros.
4. Validar existencia de registros relacionados.
5. No generar respuestas HTTP directamente.

---

### `src/helpers/`

Contiene funciones auxiliares.

Archivo sugerido:

```text
src/helpers/ResponseHelper.php
```

Responsabilidades:

1. Estandarizar respuestas JSON.
2. Crear respuestas de éxito.
3. Crear respuestas de error.
4. Reducir repetición en controladores.

---

## 9. Base de datos

### Tabla Hospitales

Campos:

| Campo | Tipo sugerido | Descripción |
|---|---|---|
| `IdHospital` | `VARCHAR(15)` | Clave primaria |
| `NomHospital` | `VARCHAR(100)` | Nombre del hospital |
| `CapacidadAtencion` | `VARCHAR(50)` o `INT` | Capacidad de atención |
| `Especialidades` | `VARCHAR(150)` | Especialidades disponibles |

---

### Tabla Doctores

Campos:

| Campo | Tipo sugerido | Descripción |
|---|---|---|
| `IdDoctor` | `VARCHAR(15)` | Clave primaria |
| `NombresDoctor` | `VARCHAR(100)` | Nombres del doctor |
| `ApellidosDoctor` | `VARCHAR(100)` | Apellidos del doctor |
| `Especialidad` | `VARCHAR(80)` | Especialidad médica |
| `TurnoAtencion` | `VARCHAR(30)` | Turno de atención |
| `PacientesMinDiarios` | `INT` | Pacientes mínimos diarios |
| `Sueldo` | `DECIMAL(10,2)` | Sueldo del doctor |
| `IdHospital` | `VARCHAR(15)` | Clave foránea hacia Hospitales |

---

## 10. Endpoints mínimos requeridos

### Hospitales

```text
POST /hospitales
GET  /hospitales/{id}
```

### Doctores

```text
POST /doctores
GET  /doctores
```

---

## 11. Formato de respuestas JSON

### Respuesta exitosa sugerida

```json
{
  "success": true,
  "message": "Operación realizada correctamente",
  "data": {}
}
```

### Respuesta de error sugerida

```json
{
  "success": false,
  "message": "Descripción clara del error",
  "data": null
}
```

---

# PARTE II: FRONTEND ANDROID

---

## 12. Frontend Android Kotlin

El frontend será una aplicación Android desarrollada en Kotlin.

Debe encargarse de:

1. Mostrar pantallas al usuario.
2. Capturar datos desde formularios.
3. Consumir la API REST.
4. Mostrar respuestas del backend.
5. Validar datos básicos.
6. Manejar errores de conexión.
7. No conectarse directamente a MySQL.

---

## 13. Estructura sugerida del frontend Android

```text
P3Clave2Practico-AA13032/
│
└── app/src/main/java/sv/ues/aa13032/medcontrol/
    │
    ├── ui/
    │   ├── MainActivity.kt
    │   ├── HospitalRegistroActivity.kt
    │   ├── HospitalBusquedaActivity.kt
    │   ├── DoctorRegistroActivity.kt
    │   └── DoctorListadoActivity.kt
    │
    ├── data/
    │   ├── model/
    │   │   ├── Doctor.kt
    │   │   └── Hospital.kt
    │   │
    │   ├── remote/
    │   │   ├── ApiClient.kt
    │   │   └── ApiService.kt
    │   │
    │   └── repository/
    │       ├── DoctorRepository.kt
    │       └── HospitalRepository.kt
    │
    └── utils/
        └── ValidationUtils.kt
```

---

## 14. Responsabilidad de cada capa del frontend

### `ui/`

Contiene pantallas de la aplicación.

Responsabilidades:

1. Mostrar formularios.
2. Capturar interacción del usuario.
3. Mostrar mensajes.
4. Mostrar listados.
5. No contener lógica HTTP compleja.

---

### `data/model/`

Contiene modelos de datos.

Archivos sugeridos:

```text
Doctor.kt
Hospital.kt
```

Responsabilidades:

1. Representar objetos recibidos desde la API.
2. Representar datos enviados hacia la API.
3. Mantener nombres compatibles con JSON.

---

### `data/remote/`

Contiene configuración de Retrofit.

Archivos sugeridos:

```text
ApiClient.kt
ApiService.kt
```

Responsabilidades:

1. Definir URL base.
2. Crear instancia Retrofit.
3. Declarar endpoints GET y POST.
4. Manejar comunicación HTTP.

---

### `data/repository/`

Contiene repositorios del frontend.

Responsabilidades:

1. Servir de puente entre UI y API.
2. Evitar que las Activities llamen directamente a Retrofit en exceso.
3. Centralizar operaciones por entidad.

---

### `utils/`

Contiene utilidades comunes.

Responsabilidades:

1. Validar campos vacíos.
2. Validar enteros.
3. Validar decimales.
4. Reutilizar lógica simple.

---

## 15. Pantallas mínimas del aplicativo

### Pantalla principal

Nombre sugerido:

```text
MainActivity.kt
```

Funciones:

1. Mostrar nombre de la app.
2. Mostrar accesos a módulos.
3. Navegar a Hospitales.
4. Navegar a Doctores.

---

### Pantalla registrar hospital

Nombre sugerido:

```text
HospitalRegistroActivity.kt
```

Campos:

1. IdHospital.
2. NomHospital.
3. CapacidadAtencion.
4. Especialidades.

Función:

1. Enviar datos por POST a `/hospitales`.

---

### Pantalla buscar hospital

Nombre sugerido:

```text
HospitalBusquedaActivity.kt
```

Campos:

1. IdHospital.

Función:

1. Consultar datos por GET a `/hospitales/{id}`.
2. Mostrar resultado.
3. Mostrar mensaje si no existe.

---

### Pantalla registrar doctor

Nombre sugerido:

```text
DoctorRegistroActivity.kt
```

Campos:

1. IdDoctor.
2. NombresDoctor.
3. ApellidosDoctor.
4. Especialidad.
5. TurnoAtencion.
6. PacientesMinDiarios.
7. Sueldo.
8. IdHospital.

Función:

1. Enviar datos por POST a `/doctores`.

---

### Pantalla listar doctores

Nombre sugerido:

```text
DoctorListadoActivity.kt
```

Función:

1. Consumir GET `/doctores`.
2. Mostrar todos los doctores.
3. Usar RecyclerView o una alternativa ordenada.
4. Mostrar mensaje si no hay registros.

---

# PARTE III: PROMPTS PARA CODEX

---

## 16. Prompt maestro para Codex

```text
Estoy desarrollando un proyecto académico individual. No quiero que generes todo el proyecto automáticamente ni que produzcas una solución lista para entregar.

Quiero que actúes como tutor técnico, arquitecto de software y revisor.

Contexto:
Debo crear una API REST con PHP usando Slim Framework, base de datos MySQL y una app Android en Kotlin que consuma la API. El sistema gestiona hospitales y doctores.

Carnet:
AA13032

Nombres oficiales:
- ZIP final: EjercicioP3AA13032-CLAVE2.zip
- Documento Word: AA13032_ReporteLAB3CLAVE2.docx
- Carpeta API: APIAA13032
- Script SQL: AA13032Clave2.sql
- Proyecto Android: P3Clave2Practico-AA13032

Arquitectura:
- Backend separado en PHP Slim.
- Frontend separado en Android Kotlin.
- Android consume la API usando Retrofit.
- Android no se conecta directamente a MySQL.
- El backend debe tener rutas, controladores, repositorios, configuración y helpers.
- El frontend debe tener UI, modelos, remote/api, repositorios y utilidades.

Reglas:
1. Explícame primero qué debo hacer.
2. Dame pasos concretos.
3. Pídeme mis archivos actuales antes de corregir código específico.
4. No generes todo el proyecto de golpe.
5. No mezcles backend y frontend.
6. Mantén estructura por capas.
7. Explica cada cambio importante.
8. Sugiere nombres personalizados y claros.
9. Ayúdame a que la app sea única y no parezca una plantilla genérica.
10. No ayudes a ocultar uso de IA ni a evadir revisiones académicas.
11. Ayúdame a entender el código para poder defenderlo.
```

---

## 17. Fase 1: Comprensión del enunciado

```text
Ayúdame a descomponer este evaluado en tareas técnicas.

No generes código todavía.

Quiero que me entregues:

1. Lista de entregables.
2. Funcionalidades mínimas obligatorias.
3. Riesgos técnicos.
4. Orden recomendado de desarrollo.
5. Criterios para que la app sea única.
6. Cómo aplicar arquitectura por capas.
7. Qué debo poder explicar personalmente.

Recuerda que el backend será una API Slim separada y el frontend será una app Android Kotlin.
```

---

## 18. Fase 2: Identidad propia de la app

```text
Quiero definir una identidad propia para mi app antes de programar.

No generes código.

Propón 5 conceptos de app para un sistema de control de doctores y hospitales.

Para cada concepto incluye:

1. Nombre de la app.
2. Estilo visual sugerido.
3. Pantallas principales.
4. Mensajes personalizados.
5. Mejoras funcionales permitidas sin salirme del enunciado.
6. Riesgo de parecer genérico y cómo evitarlo.

Usa como referencia el carnet AA13032.
```

---

## 19. Fase 3: Diseño de base de datos

```text
Ayúdame a diseñar la base de datos MySQL para este proyecto.

No generes todavía el script final.

Tablas requeridas:
- Hospitales
- Doctores

Campos de Hospitales:
- IdHospital
- NomHospital
- CapacidadAtencion
- Especialidades

Campos de Doctores:
- IdDoctor
- NombresDoctor
- ApellidosDoctor
- Especialidad
- TurnoAtencion
- PacientesMinDiarios
- Sueldo
- IdHospital

Necesito que me propongas:

1. Tipo de dato recomendado por campo.
2. Tamaño recomendado.
3. Llaves primarias.
4. Llave foránea.
5. Restricciones útiles.
6. Recomendación sobre usar DOUBLE o DECIMAL para sueldo.
7. Datos de prueba originales.
8. Nombre de base de datos usando AA13032.

No generes el SQL final hasta que confirme los tipos de datos.
```

---

## 20. Fase 4: Generación del script SQL

```text
Con base en el diseño aprobado, genera el script SQL para MySQL.

Condiciones:

1. El archivo debe llamarse AA13032Clave2.sql.
2. Debe crear la base de datos.
3. Debe crear las tablas Hospitales y Doctores.
4. Debe incluir claves primarias.
5. Debe incluir clave foránea.
6. Debe incluir datos de prueba originales.
7. Debe usar nombres claros.
8. Debe estar comentado.
9. Después del código, explica cada sección.

No agregues tablas fuera del alcance del evaluado sin justificarlo.
```

---

## 21. Fase 5: Preparación del backend Slim

```text
Estoy creando la API REST en PHP usando Slim Framework.

Necesito que me guíes paso a paso para crear la estructura del proyecto APIAA13032.

No generes todo el proyecto de golpe.

Primero explícame:

1. Qué carpetas crear.
2. Qué archivos mínimos necesito.
3. Cómo instalar Slim con Composer.
4. Cómo configurar XAMPP.
5. Cómo probar que Slim responde.
6. Cómo mantener separadas rutas, controladores, repositorios y configuración.

La estructura debe ser por capas.
```

---

## 22. Fase 6: Conexión a MySQL desde PHP

```text
Necesito implementar la conexión de PHP a MySQL para mi API Slim.

Quiero que la conexión quede en:

src/config/database.php

Condiciones:

1. Usar PDO.
2. Manejar errores de conexión.
3. Separar datos de conexión.
4. Explicar cada línea importante.
5. Indicar qué cambiar cuando pase de local a hosting.
6. No colocar consultas SQL en este archivo.

Antes de generar código, dime qué archivos necesitas que cree o comparta.
```

---

## 23. Fase 7: Endpoints de Hospitales

```text
Quiero implementar los endpoints de Hospitales en la API Slim.

Rutas requeridas:

POST /hospitales
GET /hospitales/{id}

Estructura obligatoria:

1. Las rutas deben estar en src/routes/hospitalRoutes.php.
2. La lógica HTTP debe estar en src/controllers/HospitalController.php.
3. Las consultas SQL deben estar en src/repositories/HospitalRepository.php.
4. Las respuestas JSON pueden apoyarse en src/helpers/ResponseHelper.php.

Requisitos:

1. Insertar hospital.
2. Buscar hospital por IdHospital.
3. Validar campos requeridos.
4. Devolver JSON.
5. Manejar error si el hospital no existe.
6. Manejar errores de base de datos.
7. Explicar el flujo antes del código.

No generes todo sin explicación.
```

---

## 24. Fase 8: Endpoints de Doctores

```text
Quiero implementar los endpoints de Doctores en la API Slim.

Rutas requeridas:

POST /doctores
GET /doctores

Estructura obligatoria:

1. Las rutas deben estar en src/routes/doctorRoutes.php.
2. La lógica HTTP debe estar en src/controllers/DoctorController.php.
3. Las consultas SQL deben estar en src/repositories/DoctorRepository.php.
4. Las respuestas JSON pueden apoyarse en src/helpers/ResponseHelper.php.

Requisitos:

1. Insertar doctor.
2. Listar todos los doctores.
3. Validar campos requeridos.
4. Validar que IdHospital exista.
5. Devolver JSON.
6. Manejar errores.
7. Explicar el flujo antes del código.

No mezcles consultas SQL directamente en las rutas.
```

---

## 25. Fase 9: Pruebas de API

```text
Ya tengo mi API con endpoints de Hospitales y Doctores.

Quiero preparar pruebas manuales.

Ayúdame a crear una matriz de pruebas con:

1. Endpoint.
2. Método HTTP.
3. URL.
4. Body JSON si aplica.
5. Resultado esperado.
6. Posibles errores.
7. Cómo confirmar en MySQL.
8. Evidencia recomendada para el reporte.

No inventes rutas. Primero pídeme mis rutas actuales.
```

---

## 26. Fase 10: Preparación del frontend Android

```text
Estoy creando la app Android en Kotlin llamada MedControl AA13032.

El proyecto debe llamarse:

P3Clave2Practico-AA13032

El paquete sugerido es:

sv.ues.aa13032.medcontrol

No quiero código completo todavía.

Ayúdame a definir:

1. Activities necesarias.
2. Modelos de datos.
3. Estructura de carpetas.
4. Librerías necesarias.
5. Permisos requeridos.
6. Flujo de navegación.
7. Cómo aplicar separación por capas.
8. Cómo evitar que la UI quede genérica.

La app debe permitir:

- Registrar hospital.
- Buscar hospital.
- Registrar doctor.
- Listar doctores.
```

---

## 27. Fase 11: Configuración de Retrofit

```text
Necesito configurar Retrofit en Android Kotlin para consumir mi API.

Antes de generar código, explícame:

1. Qué dependencia debo agregar.
2. Qué permiso necesita Android.
3. Qué es una data class.
4. Qué es ApiClient.
5. Qué es ApiService.
6. Qué es baseUrl.
7. Cómo manejar GET.
8. Cómo manejar POST.
9. Cómo manejar errores de conexión.

Después, ayúdame a crear:

- data/remote/ApiClient.kt
- data/remote/ApiService.kt

Pídeme primero la URL base y las rutas reales.
```

---

## 28. Fase 12: Modelos Android

```text
Ayúdame a crear los modelos de datos de Android.

Archivos:

- data/model/Hospital.kt
- data/model/Doctor.kt

Condiciones:

1. Deben coincidir con los nombres JSON de la API.
2. Deben ser fáciles de entender.
3. Deben permitir enviar datos por POST.
4. Deben permitir recibir datos por GET.
5. Explica cómo se relacionan con las tablas MySQL.

No generes modelos sin confirmar los nombres exactos de campos de mi API.
```

---

## 29. Fase 13: Repositorios Android

```text
Quiero crear repositorios Android para no llamar Retrofit directamente desde todas las pantallas.

Archivos:

- data/repository/HospitalRepository.kt
- data/repository/DoctorRepository.kt

Requisitos:

1. HospitalRepository debe registrar hospital y buscar hospital.
2. DoctorRepository debe registrar doctor y listar doctores.
3. Deben usar ApiService.
4. Deben simplificar el código de las Activities.
5. Deben manejar respuestas exitosas y errores.

Primero explícame el patrón de repositorio de forma sencilla.
```

---

## 30. Fase 14: Pantalla principal

```text
Quiero crear la pantalla principal de la app.

Archivo:

ui/MainActivity.kt

Objetivo:

1. Mostrar el nombre MedControl AA13032.
2. Mostrar botones de navegación.
3. Acceder al módulo de hospitales.
4. Acceder al módulo de doctores.
5. Tener diseño propio relacionado con salud.
6. Evitar apariencia de plantilla genérica.

Primero propón el diseño lógico y luego el código por partes.
```

---

## 31. Fase 15: Pantalla registrar hospital

```text
Quiero desarrollar la pantalla de registro de hospitales.

Archivo:

ui/HospitalRegistroActivity.kt

Campos:

- IdHospital
- NomHospital
- CapacidadAtencion
- Especialidades

Requisitos:

1. Validar campos vacíos.
2. Enviar datos por POST a /hospitales.
3. Mostrar mensaje de éxito.
4. Mostrar mensaje de error.
5. Usar HospitalRepository.
6. Mantener la UI separada de Retrofit.
7. Usar mensajes personalizados.

Primero dame el diseño lógico de la pantalla.
```

---

## 32. Fase 16: Pantalla buscar hospital

```text
Quiero crear una pantalla para buscar hospital.

Archivo:

ui/HospitalBusquedaActivity.kt

Requisitos:

1. Pedir IdHospital.
2. Consultar GET /hospitales/{id}.
3. Mostrar datos del hospital.
4. Mostrar mensaje si no existe.
5. Manejar error de conexión.
6. Usar HospitalRepository.
7. No llamar Retrofit directamente desde todos lados si puede evitarse.

Primero explícame el flujo.
```

---

## 33. Fase 17: Pantalla registrar doctor

```text
Quiero crear la pantalla para registrar doctores.

Archivo:

ui/DoctorRegistroActivity.kt

Campos:

- IdDoctor
- NombresDoctor
- ApellidosDoctor
- Especialidad
- TurnoAtencion
- PacientesMinDiarios
- Sueldo
- IdHospital

Requisitos:

1. Validar campos vacíos.
2. Validar que PacientesMinDiarios sea entero.
3. Validar que Sueldo sea decimal.
4. Enviar POST a /doctores.
5. Mostrar mensajes claros.
6. Usar DoctorRepository.
7. Explicar cómo se relaciona el doctor con el hospital.
8. Evitar lógica excesiva dentro de la Activity.

Primero ayúdame con el diseño visual y el flujo.
```

---

## 34. Fase 18: Pantalla listar doctores

```text
Quiero crear la pantalla para listar doctores.

Archivo:

ui/DoctorListadoActivity.kt

Requisitos:

1. Consumir GET /doctores.
2. Mostrar los doctores en una lista.
3. Usar RecyclerView o una alternativa ordenada.
4. Mostrar nombre, especialidad, turno, sueldo e IdHospital.
5. Mostrar mensaje si no hay registros.
6. Manejar error de conexión.
7. Usar DoctorRepository.
8. Mantener diseño propio.

Primero explícame la estructura necesaria.
```

---

## 35. Fase 19: Validaciones reutilizables

```text
Quiero crear funciones reutilizables de validación.

Archivo:

utils/ValidationUtils.kt

Validaciones necesarias:

1. Campo vacío.
2. Número entero.
3. Número decimal.
4. Longitud mínima si aplica.
5. Mensajes claros.

Requisitos:

1. Las Activities deben usar estas funciones.
2. Evitar repetir la misma validación en todas las pantallas.
3. Mantener el código simple.

Primero propón las funciones necesarias.
```

---

## 36. Fase 20: Revisión de arquitectura

```text
Revisa si mi proyecto respeta la arquitectura por capas.

Quiero que evalúes:

1. Separación backend/frontend.
2. Separación de rutas, controladores, repositorios y configuración en la API.
3. Separación de UI, modelos, remote, repositorios y utils en Android.
4. Si Android evita conectarse directamente a MySQL.
5. Si hay lógica SQL en lugares incorrectos.
6. Si hay lógica HTTP demasiado mezclada con UI.
7. Qué cambios mínimos debo hacer para mejorar.

Primero pídeme la estructura actual de carpetas.
```

---

## 37. Fase 21: Revisión de originalidad

```text
Quiero revisar si mi proyecto parece demasiado genérico.

No quiero ocultar uso de IA ni evadir controles. Quiero mejorar la identidad propia del proyecto.

Analiza:

1. Nombres de archivos.
2. Nombres de clases.
3. Mensajes de la app.
4. Flujo de pantallas.
5. Diseño visual.
6. Datos de prueba.
7. Documentación.
8. Comentarios en código.

Dime qué partes parecen de plantilla y cómo personalizarlas de forma legítima.

Primero pídeme capturas, estructura o código actual.
```

---

## 38. Fase 22: Hosting

```text
Ya tengo mi API funcionando localmente.

Necesito prepararla para subirla a hosting gratuito y conectar la base de datos en línea.

Ayúdame a revisar:

1. Archivos que debo subir.
2. Configuración de conexión a base de datos remota.
3. Variables que debo cambiar.
4. Rutas públicas.
5. Posibles errores.
6. Cómo probar endpoints en línea.
7. Qué URLs debo documentar.

No inventes configuraciones. Pídeme primero el hosting que usaré y los datos disponibles.
```

---

## 39. Fase 23: Pruebas integradas

```text
Quiero hacer pruebas finales entre Android y la API en hosting.

Ayúdame a crear un checklist de pruebas para:

1. Insertar hospital.
2. Buscar hospital.
3. Insertar doctor.
4. Listar doctores.
5. Probar campos vacíos.
6. Probar datos inválidos.
7. Probar hospital inexistente.
8. Probar error de conexión.
9. Confirmar registros en MySQL.
10. Tomar evidencias para el reporte.

Incluye resultado esperado y espacio para resultado real.
```

---

## 40. Fase 24: Reporte final

```text
Necesito preparar mi reporte final.

No quiero que lo escribas como plantilla genérica. Quiero que me ayudes a estructurarlo para redactarlo con mis palabras.

El documento debe llamarse:

AA13032_ReporteLAB3CLAVE2.docx

Debe incluir:

1. Carátula.
2. Documentación de la API.
3. Cómo usar la API.
4. Endpoints.
5. Métodos HTTP.
6. Campos enviados.
7. Rutas.
8. URL base.
9. URL de cada endpoint.
10. Datos de conexión a la BD en línea.
11. Interfaces de Android.
12. Explicación de qué entendí sobre API REST.
13. Ventajas de Slim.
14. Conclusiones.

Primero dame un índice recomendado y preguntas guía para redactar cada sección.
```

---

## 41. Fase 25: Defensa técnica

```text
Quiero prepararme para explicar mi proyecto oralmente.

Hazme preguntas técnicas una por una sobre:

1. Qué es una API REST.
2. Para qué sirve Slim.
3. Cómo funciona GET.
4. Cómo funciona POST.
5. Cómo Android consume la API.
6. Qué hace Retrofit.
7. Cómo se relacionan doctores y hospitales.
8. Cómo funciona la conexión a MySQL.
9. Qué hace cada capa del backend.
10. Qué hace cada capa del frontend.
11. Qué errores tuve y cómo los resolví.
12. Qué decisiones propias tomé.

No me des todas las respuestas al inicio. Pregunta una por una y corrige mis respuestas.
```

---

## 42. Fase 26: Revisión final de entrega

```text
Ayúdame a revisar mi entrega final.

Debo entregar:

1. ZIP llamado EjercicioP3AA13032-CLAVE2.zip.
2. Carpeta API llamada APIAA13032.
3. Script SQL llamado AA13032Clave2.sql.
4. Proyecto Android llamado P3Clave2Practico-AA13032.
5. Documento Word llamado AA13032_ReporteLAB3CLAVE2.docx.
6. URL de API en hosting.
7. Base de datos en línea.
8. Endpoints documentados.
9. App Android funcionando con la API.

Hazme una lista de verificación final.

No asumas que algo está hecho; pregúntame por cada evidencia.
```

---

# PARTE IV: PROMPTS DE APOYO

---

## 43. Prompt de depuración

```text
Estoy teniendo un error en mi proyecto.

No generes una solución a ciegas.

Te voy a compartir:

1. Código relacionado.
2. Mensaje de error.
3. Qué estaba intentando hacer.
4. Qué resultado esperaba.
5. Qué resultado obtuve.

Quiero que respondas con:

1. Causa probable.
2. Cómo verificarla.
3. Corrección mínima.
4. Explicación del error.
5. Cómo probar que quedó resuelto.
```

---

## 44. Prompt para revisar código antes de continuar

```text
Voy a compartirte mi código actual.

Quiero que lo revises con estos criterios:

1. ¿Cumple el requisito del evaluado?
2. ¿Respeta arquitectura por capas?
3. ¿Tiene errores evidentes?
4. ¿Hay nombres poco claros?
5. ¿Hay código repetido?
6. ¿Se puede explicar fácilmente?
7. ¿Qué cambios mínimos recomiendas?

No reescribas todo el código si no es necesario.
```

---

## 45. Prompt para documentar avance

```text
Ayúdame a crear una bitácora técnica breve de mi avance.

Por cada fase quiero registrar:

1. Qué hice.
2. Qué archivo modifiqué.
3. Qué problema encontré.
4. Cómo lo resolví.
5. Qué aprendí.
6. Qué falta por hacer.

La bitácora debe ayudarme a demostrar que entiendo mi propio proyecto.
```

---

## 46. Prompt para revisar nombres finales

```text
Revisa si los nombres finales de mi entrega son correctos.

Carnet:
AA13032

Nombres esperados:

- EjercicioP3AA13032-CLAVE2.zip
- AA13032_ReporteLAB3CLAVE2.docx
- APIAA13032
- AA13032Clave2.sql
- P3Clave2Practico-AA13032

Dime si hay inconsistencias en nombres de carpetas, archivos, base de datos, paquete Android o rutas.
```

---

## 47. Prompt para explicación simple de API REST

```text
Explícame con palabras simples cómo funciona una API REST usando mi proyecto como ejemplo.

Quiero entender:

1. Qué hace Android.
2. Qué hace la API.
3. Qué hace MySQL.
4. Qué ocurre cuando registro un hospital.
5. Qué ocurre cuando listo doctores.
6. Qué diferencia hay entre GET y POST.
7. Por qué Android no debe conectarse directamente a MySQL.

La explicación debe servirme para redactar mi reporte con mis propias palabras.
```

---

## 48. Prompt para checklist de evidencia

```text
Ayúdame a definir qué evidencias debería guardar para mi reporte.

Quiero evidencias de:

1. Base de datos creada.
2. Tablas creadas.
3. API funcionando localmente.
4. API funcionando en hosting.
5. Prueba POST hospital.
6. Prueba GET hospital.
7. Prueba POST doctor.
8. Prueba GET doctores.
9. Pantalla Android registrar hospital.
10. Pantalla Android buscar hospital.
11. Pantalla Android registrar doctor.
12. Pantalla Android listar doctores.

Indica qué captura o dato debería guardar en cada caso.
```

---

# PARTE V: CONTROL DE CALIDAD

---

## 49. Checklist técnico del backend

- [ ] La API usa Slim Framework.
- [ ] La API está en carpeta `APIAA13032`.
- [ ] Existe `public/index.php`.
- [ ] Existe conexión a MySQL.
- [ ] Se usa PDO o mecanismo claro de conexión.
- [ ] Existen rutas separadas.
- [ ] Existen controladores.
- [ ] Existen repositorios.
- [ ] Existe endpoint `POST /hospitales`.
- [ ] Existe endpoint `GET /hospitales/{id}`.
- [ ] Existe endpoint `POST /doctores`.
- [ ] Existe endpoint `GET /doctores`.
- [ ] Las respuestas son JSON.
- [ ] Se validan campos requeridos.
- [ ] Se maneja hospital inexistente.
- [ ] Se maneja error de base de datos.
- [ ] La API funciona localmente.
- [ ] La API funciona en hosting.

---

## 50. Checklist técnico de Android

- [ ] El proyecto se llama `P3Clave2Practico-AA13032`.
- [ ] La app está en Kotlin.
- [ ] El paquete usa una identidad propia.
- [ ] Existe pantalla principal.
- [ ] Existe pantalla registrar hospital.
- [ ] Existe pantalla buscar hospital.
- [ ] Existe pantalla registrar doctor.
- [ ] Existe pantalla listar doctores.
- [ ] Se usa Retrofit o cliente HTTP claro.
- [ ] Existe permiso de internet.
- [ ] Existen modelos Doctor y Hospital.
- [ ] Existen clases de API remota.
- [ ] Existen repositorios o separación equivalente.
- [ ] Se validan campos.
- [ ] Se muestran mensajes de éxito.
- [ ] Se muestran mensajes de error.
- [ ] La app consume la API publicada.

---

## 51. Checklist de documentación

- [ ] El documento se llama `AA13032_ReporteLAB3CLAVE2.docx`.
- [ ] Tiene carátula.
- [ ] Incluye datos de universidad, facultad, carrera y asignatura.
- [ ] Incluye nombre y carnet.
- [ ] Incluye documentación de la API.
- [ ] Incluye endpoints.
- [ ] Incluye métodos HTTP.
- [ ] Incluye rutas.
- [ ] Incluye campos enviados.
- [ ] Incluye URL base.
- [ ] Incluye URLs de cada endpoint.
- [ ] Incluye datos de conexión a BD en línea.
- [ ] Incluye interfaces de Android.
- [ ] Incluye explicación de API REST.
- [ ] Incluye ventajas de Slim.
- [ ] Incluye conclusiones.

---

## 52. Checklist de originalidad legítima

- [ ] La app tiene nombre propio.
- [ ] El paquete Android no es genérico.
- [ ] Las pantallas tienen diseño propio.
- [ ] Los mensajes no son genéricos.
- [ ] Los datos de prueba son originales.
- [ ] Los nombres de clases son claros.
- [ ] La estructura tiene criterio propio.
- [ ] El reporte está redactado con palabras propias.
- [ ] Puedo explicar cada endpoint.
- [ ] Puedo explicar cada pantalla.
- [ ] Puedo explicar la relación Doctor-Hospital.
- [ ] Puedo explicar cómo Android consume la API.

---

# PARTE VI: ORDEN RECOMENDADO DE TRABAJO

1. Leer y confirmar requisitos.
2. Definir identidad de la app.
3. Diseñar base de datos.
4. Crear script SQL.
5. Crear backend Slim local.
6. Configurar conexión MySQL.
7. Crear endpoints de Hospitales.
8. Crear endpoints de Doctores.
9. Probar API local.
10. Crear proyecto Android.
11. Configurar estructura de capas Android.
12. Configurar Retrofit.
13. Crear modelos.
14. Crear repositorios Android.
15. Crear pantalla principal.
16. Crear pantalla registrar hospital.
17. Crear pantalla buscar hospital.
18. Crear pantalla registrar doctor.
19. Crear pantalla listar doctores.
20. Probar Android contra API local.
21. Subir API y BD a hosting.
22. Cambiar URL base en Android.
23. Probar Android contra API en línea.
24. Tomar evidencias.
25. Redactar reporte.
26. Revisar nombres finales.
27. Comprimir entrega final.

---

# PARTE VII: Nota final para Codex

Codex debe ayudarme a desarrollar de forma ordenada, entendible y por fases.

El objetivo no es generar una entrega automática, sino construir un proyecto que pueda explicar personalmente.

La prioridad técnica es:

1. Cumplimiento del evaluado.
2. Separación backend/frontend.
3. Arquitectura por capas.
4. Código claro.
5. Funcionalidad probada.
6. Identidad propia.
7. Documentación completa.
