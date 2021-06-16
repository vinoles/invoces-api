# invoces-api

FACTURANDO ECUADOR API
====================

1) Instalación: 

+ https : git clone https://github.com/vinoles/invoces-api.git
+ shh : git clone git@github.com:vinoles/invoces-api.git

+ next: composer install or composer update.
+ Create .env file with .env.dist
+ Create database invoice_api: php bin/console doctrine:database:create
+ Create Schema database: php bin/console doctrine:schema:create
+ Create user test test@email.com / pass_1234: php bin/console doctrine:fixtures:load
+ run server: symfony server:start
+ go to http://127.0.0.1:8000/api/docs
+ login in the api : POST "http://127.0.0.1:8000/authentication_token"
+ set token (Authorization) in api: Bearer + token_response
+ get companies example: GET  http://127.0.0.1:8000/api/companies


https://symfony.com/doc/4.4/setup.html

AUTOR: Felipe viñoles <felipe.vinoles@gmail.com>