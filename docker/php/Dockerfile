FROM php:7.4-fpm

# Dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    zip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libwebp-dev

# Instalar Node.js 20 + npm
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Limpar cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Configurar GD
RUN docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg \
    --with-webp

# Extensões PHP
RUN docker-php-ext-install \
    pdo_mysql \
    mbstring \
    bcmath \
    gd \
    zip \
    exif \
    pcntl

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Configurar limites de upload do PHP
RUN echo "upload_max_filesize=30M" > /usr/local/etc/php/conf.d/uploads.ini \
    && echo "post_max_size=30M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "memory_limit=256M" >> /usr/local/etc/php/conf.d/uploads.ini

# Diretório
WORKDIR /var/www

# Porta do PHP-FPM
EXPOSE 9000

CMD ["php-fpm"]