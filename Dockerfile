# # Use the official PHP 8.2 image with Apache
# FROM php:8.2-apache

# # Install system dependencies
# RUN apt-get update && apt-get install -y \
#     libpng-dev \
#     libjpeg-dev \
#     libfreetype6-dev \
#     zip \
#     unzip \
#     libcurl4-openssl-dev \
#     && docker-php-ext-configure gd --with-freetype --with-jpeg \
#     && docker-php-ext-install gd pdo pdo_mysql mysqli curl

# # Set the working directory
# WORKDIR /var/www/html

# # Copy the application source code
# COPY src/ .

# # Copy composer files
# COPY composer.json composer.lock ./

# # Install Composer
# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# # Install dependencies
# RUN composer install --no-dev --optimize-autoloader

# # Set permissions for the uploads folder
# RUN chown -R www-data:www-data /var/www/html/uploads && \
#     chmod -R 755 /var/www/html/uploads

# # Expose port 80
# EXPOSE 80

# # Start Apache
# CMD ["apache2-foreground"]





# Use the official PHP 8.2 image with Apache
FROM php:8.2-apache

# Install system dependencies + cleanup
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl \
    libcurl4-openssl-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql mysqli curl \
    && rm -rf /var/lib/apt/lists/*

# Enable mod_rewrite (useful for many PHP apps)
RUN a2enmod rewrite

# Set working dir
WORKDIR /var/www/html

# Copy composer files first to leverage Docker cache
COPY composer.json composer.lock ./

# Install Composer (and allow superuser use)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
ENV COMPOSER_ALLOW_SUPERUSER=1

# Install PHP dependencies into /var/www/html/vendor
RUN composer install --no-dev --prefer-dist --no-progress --no-interaction \
    && composer dump-autoload --optimize

# Now copy application source (won't overwrite vendor/)
COPY src/ .

# Ensure uploads directory exists and set ownership/permissions
RUN mkdir -p /var/www/html/uploads \
 && chown -R www-data:www-data /var/www/html/uploads \
 && chmod -R 755 /var/www/html/uploads

# Expose port and start Apache
EXPOSE 80
CMD ["apache2-foreground"]
