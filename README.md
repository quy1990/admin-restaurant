<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Laravel

Start laradock in laradock:

    docker-compose up -d nginx postgres pgadmin redis workspace

Start all:

    cd D:\CODE\PHP\laradock\laradock ; docker-compose up -d nginx postgres pgadmin redis workspace ; docker exec -it laradock_workspace_1 bash
    
Seeder Database:

    docker exec -it laradock_workspace_1 php artisan migrate:refresh --seed

generate key for passport database

    docker exec -it laradock_workspace_1 php artisan passport:install --force

Test:

    vendor/bin/phpunit --coverage-html /reports

Generate:

	Change fileName hang loat:
	find . -name 'XXXXXXXXXYYYYYYXXXXXX*.php' -type f -exec bash -c 'mv "$1" "${1/\/XXXXXXXXXYYYYYYXXXXXX//Category}"' -- {} \;
	
	Change noi dung hang loat:
	grep -RiIl 'XXXXXXXXXYYYYYYXXXXXX' | xargs sed -i 's/XXXXXXXXXYYYYYYXXXXXX/Category/g'
	
	grep -RiIl 'zzzzzzzzzzzxxxxxxxxxxxzzzzzzzzz' | xargs sed -i 's/zzzzzzzzzzzxxxxxxxxxxxzzzzzzzzz/category/g'