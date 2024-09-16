# Используем официальный образ PHP с Apache
FROM php:8.1-apache

# Устанавливаем необходимые расширения
RUN docker-php-ext-install pdo pdo_mysql

# Копируем содержимое проекта в директорию веб-сервера
COPY . /var/www/html/

# Устанавливаем права доступа для Apache
RUN chown -R www-data:www-data /var/www/html
RUN find /var/www/html -type d -exec chmod 755 {} \; # Папки
RUN find /var/www/html -type f -exec chmod 644 {} \; # Файлы

# Открываем порт 80
EXPOSE 80