# CMS

cms power by laravel framework.

## Requirements

- Laravel 9
- PHP 8.1
- Bootstrap - SB Admin [Overview](https://startbootstrap.com/template/sb-admin)
- Bootstrap v5.1 [Document](https://getbootstrap.com)
- jQuery 3.6.0

## Command
หลังจาก clone project ลบไฟล์ `composer.lock` และ folder `vendor` แล้วใช้คำสั่ง

- Copy and edit .env file from .env.example `cp .env.example .env`
- config database in .env
- Install composer `composer install` 
- Install npm package `npm install`
- Generate project key `php artisan key:generate`

## Laravel Command

[Laravel](https://laravel.com/docs/9.x/eloquent#generating-model-classes)

    //Generate a model, FlightController resource class, and form request classes...
    php artisan make:model Flight --controller --resource --requests
    php artisan make:model Flight -crR

    //สร้าง model พร้อม migrate
    php artisan make:model <modelname> -m
    
    //สร้าง seed ของ model
    php artisan make:seeder <modelname>TableSeeder
    
    //migrate database and use seed data
    php artisan migrate:refresh --seed -v
    
    ถ้าเพิ่ม seed ใหม่ ใช้คำสั่ง  
    composer dump-autoload
    
    สั่ง migrate เฉพาะ table 
    1. สร้าง folder ใน folder migrations
    2. Copyไฟล์ migration ไปไว้ใน folder ที่สร้างใหม่
    3. php artisan migrate --path=/database/migrations/<folder>

    สั่ง migrate update table
    1. สร้าง folder ใน folder migrations
    2. Copyไฟล์ migration ไปไว้ใน folder ที่สร้างใหม่
    3. php artisan migrate:refresh --path=/database/migrations/<folder>
    
    สั่ง migrate ถ้ามี table อยู่แล้ว
    php artisan migrate:refresh --path=

    clean cache config
    `php artisan config:cache`

    สร้าง blade component
    `php artisan make:component TestimonialCard`


## Custom Helper

[Reference](https://laravel-news.com/creating-helpers)
- Create file in app/ ex. `app/helpers.php`
- Add files array in composer.json session autoload


    "autoload": {
        "files":[
            "app/helpers.php"
        ]
    }
    
 - dump autoloader: `composer dump-autoload` 

## Laravel file manager

[Reference](https://unisharp.github.io/laravel-filemanager/installation)
