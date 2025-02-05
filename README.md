# Vehicle Registry System

Это система учета автотранспортных средств, которая позволяет регистрировать новые автомобили, а также переоформлять их на нового владельца. В системе используется база данных PostgreSQL.

### Требования

- PHP >= 7.4
- Composer
- PostgreSQL

### Шаги для установки

1. Клонируйте репозиторий:
   ```bash
   git clone https://github.com/zhomaerkinbek/vehicle-registry.git
   cd vehicle-registry
2. Установить зависимости:
   ```bash
   composer install

3. Откройте файл .env и настройте параметры подключения к базе данных
    ```bash
    DB_CONNECTION=pgsql
    DB_HOST=127.0.0.1
    DB_PORT=5432
    DB_DATABASE=vehicle_registration
    DB_USERNAME=your-username
    DB_PASSWORD=your-password

4. Запустите миграции для создания таблиц в базе данных
    ```bash
    php artisan migrate
5. Запустите локальный сервер для тестирования
    ```bash
    php artisan serve