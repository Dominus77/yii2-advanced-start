Yii 2 Advanced Project Template
===============================

Yii 2 Advanced Project Template is a skeleton [Yii 2](http://www.yiiframework.com/) application best for
developing complex Web applications with multiple tiers.

The template includes three tiers: front end, back end, and console, each of which
is a separate Yii application.

The template is designed to work in a team development environment. It supports
deploying the application in different environments.

Documentation is at [docs/guide/README.md](docs/guide/README.md).

[![Latest Stable Version](https://poser.pugx.org/yiisoft/yii2-app-advanced/v/stable.png)](https://packagist.org/packages/yiisoft/yii2-app-advanced)
[![Total Downloads](https://poser.pugx.org/yiisoft/yii2-app-advanced/downloads.png)](https://packagist.org/packages/yiisoft/yii2-app-advanced)
[![Build Status](https://travis-ci.org/yiisoft/yii2-app-advanced.svg?branch=master)](https://travis-ci.org/yiisoft/yii2-app-advanced)

DIRECTORY STRUCTURE
-------------------

```
common
    config/              contains shared configurations
    mail/                contains view files for e-mails
    models/              contains model classes used in both backend and frontend
console
    config/              contains console configurations
    controllers/         contains console controllers (commands)
    migrations/          contains database migrations
    models/              contains console-specific model classes
    runtime/             contains files generated during runtime
backend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains backend configurations
    controllers/         contains Web controller classes
    models/              contains backend-specific model classes
    runtime/             contains files generated during runtime
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
frontend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains frontend configurations
    controllers/         contains Web controller classes
    models/              contains frontend-specific model classes
    runtime/             contains files generated during runtime
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
    widgets/             contains frontend widgets
vendor/                  contains dependent 3rd-party packages
environments/            contains environment-based overrides
tests                    contains various tests for the advanced application
    codeception/         contains tests developed with Codeception PHP Testing Framework
```

ОПИСАНИЕ
--------
Приложение построено с использованием шаблона advanced и имеет frontend и backend части.
Так же добавлена система RBAC
Доступны консольные команды управления пользователями и системой RBAC. Все доступные команды можно узнать выполнив в консоли: php yii

По умолчанию в систему RBAC добавлено 4 роли:

admin - Администратор,
manager - Менеджер,
moder - Модератор
user - Зарегестрированые пользователи.

Структура RBAC настроеная по умолчанию имеет следующую древовидную структуру:

Администратор
    Менеджер -------------------------- Управление пользователями
        Модератор --------------------- Backend
            Пользователь

Разрешения:
-----------
Backend (Доступ к Backend)
Управления пользователями
    Создание
    Редактирование
    Просмотр
    Удаление

Роли и разрешения наследуются.
При регистрации нового пользователя, по умолчанию присваивается роль user
Настройка ролей и разрешений производится в console/controllers/RbacController.php
После изменения и вступления в силу новых ролей и правил, необходимо выполнить php yii rbac/init и пройзвести привязку пользователей к ролям
php yii roles/assign
Через консоль достаточно создать одного пользователя и дать ему права администратора, чтобы получить доступ к backend.
Остальных пользователей можно добавлять и назначать им права через вэб интерфейс.

INSTALLATION AND INITIALIZATION
------------

После стандартной установки и настройки конфигурационных файлов, выполняем миграции:
php yii migrate

Инициализируем RBAC
php yii rbac/rbac/init

Добавляем пользователя
php yii users/user/create

Присваиваем пользователю роль Администратора
php yii rbac/roles/assign

Теперь у нас есть пользователь с ролью Администратора и мы можем зайти в Backend и добавлять пользователей через вэб интерфейс.

Если производится установка на сервере в папку public_html, на сервере с Apache необходимо настроить перенаправления.
В корне папки public_html создаем .hitaccess со следующим содержимым:

###
Options FollowSymLinks
AddDefaultCharset utf-8

<IfModule mod_rewrite.c>
    RewriteEngine On

    # the main rewrite rule for the frontend application
    RewriteCond %{REQUEST_URI} !^/(backend/web|admin)
    RewriteRule !^frontend/web /frontend/web%{REQUEST_URI} [L]

    # redirect to the page without a trailing slash (uncomment if necessary)
    #RewriteCond %{REQUEST_URI} ^/admin/$
    #RewriteRule ^(admin)/ /$1 [L,R=301]
    # the main rewrite rule for the backend application
    RewriteCond %{REQUEST_URI} ^/admin
    RewriteRule ^admin(.*) /backend/web/$1 [L]

    # if a directory or a file of the frontend application exists, use the request directly
    RewriteCond %{REQUEST_URI} ^/frontend/web
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    # otherwise forward the request to index.php
    RewriteRule . /frontend/web/index.php [L]

    # if a directory or a file of the backend application exists, use the request directly
    RewriteCond %{REQUEST_URI} ^/backend/web
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    # otherwise forward the request to index.php
    RewriteRule . /backend/web/index.php [L]

    RewriteCond %{REQUEST_URI} \.(htaccess|htpasswd|svn|git)
    RewriteRule \.(htaccess|htpasswd|svn|git) - [F]
</IfModule>
###

В папку web, backend и frontend частях, так же добавляем .hitaccess

###
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . index.php
###

Теперь frontend доступен по адресу http://mysite.ru, а backend по адресу http://mysite.ru/admin


