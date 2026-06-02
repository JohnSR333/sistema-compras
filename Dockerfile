FROM php:8.2-cli

# Directorio de trabajo
WORKDIR /var/www

# =========================================
# 1. DEPENDENCIAS DEL SISTEMA
# =========================================
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    zip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev

# =========================================
# 2. NODE.JS (PARA VITE)
# =========================================
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# =========================================
# 3. EXTENSIONES PHP
# =========================================
RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd

# =========================================
# 4. COMPOSER
# =========================================
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# =========================================
# 5. COPIAR PROYECTO
# =========================================
COPY . .

# =========================================
# 6. DEPENDENCIAS BACKEND (LARAVEL)
# =========================================
RUN composer install --no-dev --optimize-autoloader

# =========================================
# 7. DEPENDENCIAS FRONTEND (VITE)
#    🔥 ORDEN CRÍTICO PARA QUE NO ROMPA CSS
# =========================================
RUN npm install
RUN npm run build

# =========================================
# 8. PERMISOS LARAVEL
# =========================================
RUN chmod -R 775 storage bootstrap/cache


# =========================================
# 10. PUERTO RENDER
# =========================================
EXPOSE 10000

# =========================================
# 11. INICIAR SERVIDOR
# =========================================
CMD php artisan serve --host=0.0.0.0 --port=${PORT:-10000}