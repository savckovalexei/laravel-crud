# laravel-crud
Магазин товаров — Небольшое, одностраничное веб-приложение для управления каталогом товаров, построенное на фреймворке Laravel с использованием сервисной архитектуры, AJAX взаимодействия и Bootstrap интерфейса.

Основные цели:
1. Создание интуитивно понятной системы управления товарами

2. Реализация полного цикла CRUD операций через AJAX

Архитектура:
1. Сервисный слой: Вынесение бизнес-логики в отдельные сервисные классы

2. Request классы: Централизованная валидация входных данных

3. AJAX взаимодействие: Обновление данных без перезагрузки страницы

Технологический стек
Бэкенд
    Laravel 10.x — PHP фреймворк

    MySQL 8.0 — Реляционная база данных

Фронтенд
    Bootstrap 5 — CSS фреймворк

    jQuery 3.6 — JavaScript библиотека

    Font Awesome 6 — Векторные иконки

    AJAX — Асинхронные запросы

    Развертывание приложения:
    1. Системные требования
        PHP 8.1 или выше

        Composer 2.x

        MySQL 5.7+ или PostgreSQL 10+

        Web-сервер: Apache/Nginx с поддержкой mod_rewrite

        Расширения PHP:
            BCMath
            Ctype
            cURL
            DOM
            Fileinfo
            JSON
            Mbstring
            OpenSSL
            PCRE
            PDO
            SimpleXMLTokenizer
            UXML
            ZIP (для установки пакетов)

    2. Проверка окружения
    # Проверка версии PHP
    php --version

    # Проверка Composer
    composer --version

    Установка приложения
1. Клонирование репозитория
git clone https://github.com/savckovalexei/laravel-crud.git laravel-shop

cd laravel-shop

2. Установка зависимостей PHP
composer install --optimize-autoloader --no-dev

3. Настройка окружения

# Копируем файл окружения
cp .env.example .env

# Генерируем ключ приложения
php artisan key:generate

4. Настройка базы данных
Отредактируйте файл .env:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_shop
DB_USERNAME=root
DB_PASSWORD=your_password

# Для продакшена
APP_ENV=production
APP_DEBUG=false
APP_URL=http://your-domain.com

5. Миграции и сидеры
# Запускаем миграции
php artisan migrate --force

# Заполняем базу тестовыми данными (опционально)
php artisan db:seed --class=ProductSeeder


Конфигурация веб-сервера
Для Apache (.htaccess в корневой директории)
<IfModule mod_rewrite.c>


RewriteEngine On  

# Redirect from root to the public directory  
RewriteCond %{REQUEST_URI} !^/public/  
RewriteRule ^(.*)$ public/$1 [L]  


</IfModule>

Для Nginx
server {
    listen 80;
    server_name your-domain.com;
    root /var/www/laravel-shop/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";
    add_header X-XSS-Protection "1; mode=block";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }

    # Увеличение максимального размера загружаемых файлов
    client_max_body_size 100M;
    fastcgi_read_timeout 300;
}