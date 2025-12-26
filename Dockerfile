FROM linuxserver/nginx:latest

# Install npm
RUN apk add --no-cache nodejs npm

# Set working directory
WORKDIR /app/www

# Copy application files
COPY ./www .

# Remove vendor and node_modules if they exist (to ensure clean install)
RUN rm -rf vendor node_modules

# Install composer dependencies
RUN composer install --no-interaction --optimize-autoloader

# Copy .env.example to .env
RUN cp .env.example .env

# Generate application key
RUN php artisan key:generate

# Install npm dependencies and build
RUN npm install && npm run build

# Create storage link
RUN php artisan storage:link

# Fix permissions for Laravel storage and bootstrap/cache
# Use numeric IDs (1000:1000 from PUID/PGID in docker-compose)
RUN chown -R 1000:1000 /app/www && \
    chmod -R 775 /app/www/storage /app/www/bootstrap/cache