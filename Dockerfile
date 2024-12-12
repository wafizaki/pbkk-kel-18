FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    npm

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring

# Set working directory
WORKDIR /app

# Copy Composer files and install dependencies
COPY composer.json composer.lock ./
RUN composer install --no-scripts --no-dev

# Copy NPM files and install dependencies
COPY package.json package-lock.json ./
COPY vite.config.js ./
COPY resources resources/
RUN npm install && npm run build

# Copy the rest of the application
COPY . .

# Set permissions
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache

# Optimize Laravel
RUN php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# Expose port and set the default command
EXPOSE 80
CMD php artisan serve --host=0.0.0.0 --port=80
