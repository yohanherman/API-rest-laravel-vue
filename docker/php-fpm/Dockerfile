FROM php:8.3.0-fpm

# install dependances
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libicu-dev \
    libpq-dev \
    libzip-dev \
    default-mysql-client \
    && docker-php-ext-install \
    intl \
    opcache \
    pdo \
    pdo_pgsql \
    pdo_mysql \
    zip \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    && apt-get clean \  
    && rm -rf /var/lib/apt/lists/*

# opcache configuration
RUN echo "opcache.enable=1\n\
    opcache.memory_consumption=128\n\
    opcache.interned_strings_buffer=8\n\
    opcache.max_accelerated_files=4000\n\
    opcache.revalidate_freq=2\n\
    opcache.validate_timestamps=0" > /usr/local/etc/php/conf.d/opcache.ini

# set workig directory
WORKDIR /var/www/API_VUE

# # Copy existing appliaction directory contents
# COPY . /var/www/API      
COPY . .

# Create necessary directories and set permissions
RUN mkdir -p /var/www/API_VUE/storage /var/www/API_VUE/bootstrap/cache \
    && chown -R www-data:www-data /var/www/API_VUE \
    && chmod -R 775 /var/www/API_VUE/storage \
    && chmod -R 775 /var/www/API_VUE/bootstrap/cache

# Change current user to www
USER www-data

EXPOSE 9000

# Start PHP-FPM server
CMD [ "php-fpm" ]
