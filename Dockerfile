FROM linuxserver/nginx:latest

# Install npm
RUN apk add --no-cache nodejs npm

# Set working directory
WORKDIR /app/www

# Copy application files
COPY ./www .

# Remove vendor and node_modules if they exist (to ensure clean install)
RUN rm -rf vendor node_modules

# Install composer dependencies during build
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Install npm dependencies and build during build
RUN npm install && npm run build

# Create storage link during build
RUN php artisan storage:link