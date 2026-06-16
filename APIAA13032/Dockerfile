FROM php:8.2-cli

# Instala paquetes del sistema y habilita PDO MySQL para conectar la API con la base de datos.
RUN apt-get update \
    && apt-get install -y --no-install-recommends unzip git \
    && docker-php-ext-install pdo pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

# Copia Composer desde la imagen oficial para instalar las dependencias PHP.
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Instala dependencias antes de copiar el codigo para reutilizar la cache de construccion.
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Copia los archivos de la API dentro del directorio de trabajo del contenedor.
COPY . .

# Ejecuta el servidor embebido de PHP usando el puerto asignado por la plataforma.
CMD ["sh", "-c", "php -S 0.0.0.0:${PORT:-10000} -t public"]
