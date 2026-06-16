FROM php:8.2-cli

# Instala dependencias necesarias para Composer y habilita PDO MySQL para conectar con la base remota.
RUN apt-get update \
    && apt-get install -y --no-install-recommends unzip git \
    && docker-php-ext-install pdo pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

# Copia Composer desde su imagen oficial para instalar las dependencias PHP del proyecto.
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copia primero los archivos de Composer para aprovechar la cache de construccion.
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Copia el codigo de la API despues de instalar dependencias.
COPY . .

# Render entrega el puerto por variable de entorno, por eso se usa PORT con un valor de respaldo local.
CMD ["sh", "-c", "php -S 0.0.0.0:${PORT:-10000} -t public"]
