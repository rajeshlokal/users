Dockerfile
FROM php:8.0-alpine  # Base image with PHP 8.0 and Alpine Linux

WORKDIR /app

COPY composer.json composer.lock ./  # Copy composer configuration files
RUN composer install --no-interaction # Install dependencies

COPY . .  # Copy all project files

EXPOSE 8000  # Expose port for user service

RUN chmod +x bin/console  # Make console executable

CMD ["bin/console", "server:run", "-d", "--no-debug", "-h", "0.0.0.0"] 