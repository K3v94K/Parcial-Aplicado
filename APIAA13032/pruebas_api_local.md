# Matriz de pruebas locales de la API

Estas pruebas sirven para confirmar que la API REST funciona correctamente en XAMPP antes de conectarla con Android.

## Datos generales

- Base local: `http://127.0.0.1:8088`
- Base de datos: `p3_aa13032_salud`
- Formato de comunicacion: JSON
- Tablas usadas: `Hospitales` y `Doctores`

## Pruebas principales

| No. | Endpoint | Metodo | Body JSON | Resultado esperado | Evidencia sugerida |
|---|---|---|---|---|---|
| 1 | `/` | GET | No aplica | Mensaje indicando que la API esta funcionando. | Captura del navegador o Postman con respuesta JSON. |
| 2 | `/hospitales/HOSP-AA01` | GET | No aplica | Devuelve el Hospital Nacional Rosales. | Captura de respuesta JSON y registro en phpMyAdmin. |
| 3 | `/hospitales/HOSP-ZZ99` | GET | No aplica | Devuelve error porque el hospital no existe. | Captura del mensaje de error JSON. |
| 4 | `/hospitales` | POST | Ver ejemplo 1 | Registra un hospital nuevo. | Captura del POST exitoso y tabla `Hospitales` actualizada. |
| 5 | `/hospitales` | POST | Ver ejemplo 2 | Devuelve error si se repite `IdHospital`. | Captura del mensaje de identificador duplicado. |
| 6 | `/doctores` | GET | No aplica | Devuelve todos los doctores registrados. | Captura del listado JSON. |
| 7 | `/doctores` | POST | Ver ejemplo 3 | Registra un doctor asociado a un hospital existente. | Captura del POST exitoso y tabla `Doctores` actualizada. |
| 8 | `/doctores` | POST | Ver ejemplo 4 | Devuelve error si `IdHospital` no existe. | Captura del mensaje de relacion invalida. |
| 9 | `/doctores` | POST | Ver ejemplo 5 | Devuelve error si `PacientesMinDiarios` no es entero. | Captura del mensaje de validacion. |
| 10 | `/doctores` | POST | Ver ejemplo 6 | Devuelve error si falta un campo requerido. | Captura del mensaje indicando el campo obligatorio. |

## Ejemplo 1: registrar hospital

```json
{
  "IdHospital": "HOSP-AA04",
  "NomHospital": "Hospital Nacional Zacamil",
  "CapacidadAtencion": "Atencion regional y emergencias",
  "Especialidades": "Emergencias, Medicina familiar, Consulta externa"
}
```

## Ejemplo 2: hospital duplicado

```json
{
  "IdHospital": "HOSP-AA01",
  "NomHospital": "Hospital duplicado",
  "CapacidadAtencion": "Prueba",
  "Especialidades": "Prueba"
}
```

## Ejemplo 3: registrar doctor

```json
{
  "IdDoctor": "DOC-AA04",
  "NombresDoctor": "Sofia Carolina",
  "ApellidosDoctor": "Ramirez Escobar",
  "Especialidad": "Emergencias",
  "TurnoAtencion": "Matutino",
  "PacientesMinDiarios": 11,
  "Sueldo": 1310.75,
  "IdHospital": "HOSP-AA01"
}
```

## Ejemplo 4: doctor con hospital inexistente

```json
{
  "IdDoctor": "DOC-AA99",
  "NombresDoctor": "Prueba",
  "ApellidosDoctor": "Hospital Inexistente",
  "Especialidad": "Emergencias",
  "TurnoAtencion": "Matutino",
  "PacientesMinDiarios": 5,
  "Sueldo": 900.00,
  "IdHospital": "HOSP-ZZ99"
}
```

## Ejemplo 5: pacientes con dato invalido

```json
{
  "IdDoctor": "DOC-AA98",
  "NombresDoctor": "Prueba",
  "ApellidosDoctor": "Dato Invalido",
  "Especialidad": "Medicina interna",
  "TurnoAtencion": "Vespertino",
  "PacientesMinDiarios": "abc",
  "Sueldo": 1000.00,
  "IdHospital": "HOSP-AA01"
}
```

## Ejemplo 6: campo requerido faltante

```json
{
  "IdDoctor": "DOC-AA97",
  "NombresDoctor": "Prueba",
  "ApellidosDoctor": "Campo Faltante",
  "Especialidad": "Medicina interna",
  "PacientesMinDiarios": 8,
  "Sueldo": 1000.00,
  "IdHospital": "HOSP-AA01"
}
```

## Confirmacion en MySQL

Despues de cada POST exitoso se debe revisar phpMyAdmin:

```sql
SELECT * FROM Hospitales;
SELECT * FROM Doctores;
```

Estas consultas permiten comprobar que los datos enviados por la API fueron almacenados en la base de datos.
