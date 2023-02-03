<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Установка проекта

1. ``` cp .env.example .env ``` - потом настроивайте БД
2. ``` composer install ``` - для установки зависимостей
3. ``` php artisan migrate``` - для создание таблиц в БД
4. ``` php artisan db:seed``` - для создание админ пользователя
5. ``` php artisan serve``` - для запуска сервера

### ИЛИ

1. ``` cp .env.example .env ``` - потом настроивайте БД
2. ``` bash deploy.sh ``` - и все произайдет автоматически )))

# Как устроен проект

Сам проект из себя предостовляет RESTApi

- Использован SOLID принципи для построение архитектуры. 
- Использован полностю тонкие контроллери
- Логику контроллеров можете найтй в 'App\Services\'
- Интерфейси находится в папке 'App\Clusters\Api'
- Используется bind метод для связки интерфейса и сервиса
- Создан artisan команда для создание обичного CRUD ( боллее подробно ниже )
- Для авторизации токеном использован ```Laravel/Passport```
- Для автогенерации документации использован ```rakutentech/laravel-request-docs```
- Для доступа к документации ``` http://127.0.0.1:8000/request-docs/ ```

# Команда для создание CRUD template

Так как при больших проектах мне всегда приходилось создавать ручками много файлов и писать скучный CRUD
связанные с логикой и архитектурой, я создал свою команду для создание базового функционала одним щелчком.

```php artisan make:crud --name={{ModelName}} --directory={{DirectoryName}}```

## Как устроена сама команда

В проекте вы найдете папку ```stubs``` там расположены все необходимее stub шаблоны для создание классов.
при запуске команды ```php artisan make:crud --name={{ModelName}} --directory={{DirectoryName}}```
запускается ряд artisan команд которые уже создают нужную мне архитектуру с уже готовым CRUD решением.

Все команды вы найдете в папке ```App\Console\Commands```
