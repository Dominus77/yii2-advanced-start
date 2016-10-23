Yii 2 Advanced Start Project Template
===============================

The application is built using advanced pattern and has a modular structure.
Backend part uses AdminLTE template
Available console user management commands and RBAC system. All available commands can be found by following in the console:
~~~
php yii
~~~

- [Web page](http://dominus77.github.io/yii2-advanced-start)
- [github.com](https://github.com/Dominus77/yii2-advanced-start)

Base components
------

Pages (backend AdminLTE template)
- Home
- Users
- Login and Logout

Pages (frontend)
- Home
- Contact
- Sign Up
- Login

Modules
- main
- rbac
- users

Functional
- Reset password
- Confirmation by email
- Last visit
- Registration Type

System
- RBAC (DbManager)
- Manage users
- Console commands
- i18n

Requirements
------

The minimum requirement by this project template that your Web server supports PHP 5.4.0.

DIRECTORY STRUCTURE
-------------------

```
common
    assets/              contains application assets such as JavaScript and CSS
    components/          contains components frontend, backend and console
    config/              contains shared configurations
    mail/                contains layouts files for e-mails
    messages/            contains i18n backend frontend
    models/              contains model classes used in both backend and frontend
    widgets/             contains widgets backend and frontend
console
    components/          contains console components
    config/              contains console configurations
    controllers/         contains console controllers (commands)
    messages/            contains i18n console
    migrations/          contains database migrations
    models/              contains console-specific model classes
    runtime/             contains files generated during runtime
backend
    assets/              contains application assets such as JavaScript and CSS
    components/          contains backend components
    config/              contains backend configurations
    controllers/         contains Web controller classes
    messages/            contains i18n backend
    models/              contains backend-specific model classes
    runtime/             contains files generated during runtime
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
    widgets/             contains backend widgets
frontend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains frontend configurations
    controllers/         contains Web controller classes
    messages/            contains i18n frontend
    models/              contains frontend-specific model classes
    runtime/             contains files generated during runtime
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
    widgets/             contains frontend widgets
vendor/                  contains dependent 3rd-party packages
environments/            contains environment-based overrides
tests                    contains various tests for the advanced application
    codeception/         contains tests developed with Codeception PHP Testing Framework
modules/
    main/               contains module main
        controllers/    contains module Web controller classes
            backend/    contains module backend Web controller classes
            frontend/   contains module frontend Web controller classes
        messages/       contains i18n module
        models/         contains module-specific model classes
            backend/    contains module backend-specific model classes
            frontend/   contains module frontend-specific model classes
        views/          contains module view files for the Web application
            backend/    contains module backend view files for the Web application
            frontend/   contains module frontend view files for the Web application
        Bootstrap.php   File autoload module settings app components (urlManager)
        Module.php      General Module class
    rbac/               contains module rbac
        commands/       contains console controllers (commands)
        controllers/    contains module Web controller classes
            backend/    contains module backend Web controller classes
        migrations/     contains database migrations module
        models/         contains module-specific model classes
        rules/          contains rbac specific rules
        views/          contains module view files for the Web application
            backend/    contains module backend view files for the Web application
        Bootstrap.php   File autoload module settings app components (urlManager)
        Module.php      General Module class
    users/              contains module users
        commands/       contains console controllers (commands)
        components/     contains module components
        controllers/    contains module Web controller classes
            backend/    contains module backend Web controller classes
            frontend/   contains module frontend Web controller classes
        mail/           contains module view files for e-mails
        messages/       contains i18n module
        migrations/     contains database migrations module
        models/         contains module-specific model classes
            backend/    contains module backend-specific model classes
            frontend/   contains module frontend-specific model classes
        views/          contains module view files for the Web application
            backend/    contains module backend view files for the Web application
            frontend/   contains module frontend view files for the Web application
        Bootstrap.php   File autoload module settings app components (urlManager)
        Module.php      General Module class
```

INSTALLATION
------------

Create a project:
~~~
composer global require "fxp/composer-asset-plugin:~1.2.0"
composer create-project --prefer-dist --stability=dev dominus77/yii2-advanced-start advanced-project
~~~

or clone the repository for `pull` command availability:

~~~
git clone https://github.com/Dominus77/yii2-advanced-start.git advanced-project
cd advanced-project
composer global require "fxp/composer-asset-plugin:~1.2.0"
composer install
~~~

Init an environment:

~~~
php init
~~~

Create a database, default configure: advanced_project

Apply migration:

~~~
php yii migrate
~~~

See all available commands:

~~~
php yii
~~~

Initialization RBAC:

~~~
php yii rbac/rbac/init
~~~

Create user, enter the command and follow the instructions:

~~~
php yii users/user/create
~~~

- Username: set username (admin);
- Email: set email (admin@example.com);
- Password: set password (min 6 symbol);
- Status: set status (0 - blocked, 1 - active, 2 - wait, ? - Help);

Assign role admin:

~~~
php yii rbac/roles/assign
~~~

- Username: set username (admin);
- Role: set role (admin, manager, moder, user, ? - Help);


If you are installing the server into the public_html folder on the server with Apache, you must configure redirection.
At the root folder, create a public_html .hitaccess with the following content:

~~~
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
~~~

The web folder, the backend and frontend parts also add .hitaccess:

~~~
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . index.php
~~~

Now frontend is available at http://advanced-project.com, and backend at http://advanced-project.com/admin


