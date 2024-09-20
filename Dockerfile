FROM php:8.2-fpm

# Copy composer.json
#COPY ./ /var/www

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y --no-install-recommends \
    build-essential \
    mariadb-client \
    libpng-dev \
    libjpeg62-turbo-dev \
libonig-dev \
    libfreetype6-dev \
    locales \
    libtidy-dev \
    libzip-dev \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    nano \
    curl

RUN apt-get update && apt-get install -y libicu-dev
# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath intl
RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd
#install nodejs
RUN apt-get update && apt-get install -y nodejs npm
RUN npm install -g npm@10.8.3
# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

RUN echo 'memory_limit=512M' > /usr/local/etc/php/conf.d/memory-limit.ini; \
    echo 'post_max_size=100M' > /usr/local/etc/php/conf.d/post-max-size.ini; \
    echo 'upload_max_filesize=100M' > /usr/local/etc/php/conf.d/upload-max-filesize.ini;

# Copy existing application directory contents
#COPY ./ /var/www

# Copy existing application directory permissions
#COPY --chown=www:www ./ /var/www

# Change current user to www
USER www

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]

