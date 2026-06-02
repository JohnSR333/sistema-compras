FROM php:8.2-cli

# Directorio de trabajo
WORKDIR /var/www

# Instalar dependencias del sistema (IMPORTANTES para Laravel + PostgreSQL)
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    zip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev

# Instalar extensiones PHP necesarias
RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar proyecto al contenedor
COPY . .

# Instalar dependencias Laravel
RUN composer install --no-dev --optimize-autoloader

# Permisos necesarios para Laravel
RUN chmod -R 775 storage bootstrap/cache

# Exponer puerto que usa Render
EXPOSE 10000

# Levantar servidor Laravel
CMD php artisan serve --host=0.0.0.0 --port=${PORT:-10000}