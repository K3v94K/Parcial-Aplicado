# APIAA13032

API REST para gestionar hospitales y doctores.

## Estructura

- `public/`: punto de entrada de la API.
- `src/configuracion/`: configuracion de conexion a MySQL.
- `src/rutas/`: definicion de endpoints.
- `src/controladores/`: validacion y manejo de solicitudes HTTP.
- `src/repositorios/`: consultas SQL y acceso a datos.
- `src/ayudas/`: respuestas JSON reutilizables.

## Prueba inicial esperada

Cuando Slim este instalado, la ruta principal debe responder:

```text
GET /APIAA13032/public/
```

con un mensaje JSON indicando que la API esta funcionando.
