<?php

use Illuminate\Support\Facades\Facade;

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    */

    'name' => env('APP_NAME', 'Mtvradmin'),
    'appversion' => '2.0',
    'cmaurl' => env('CMA_URL','api.contentful.com'),
    'cmaaccesstoken' => env('CMA_ACCESSTOKEN','CFPAT-exMpOHWpILkcfIj2RQeSkHeDw374tdk0fZxsWOTa8KE'),
    'cdaurl' => env('CDA_URL','cdn.contentful.com'),
    'cdaaccesstoken' => env('CDA_ACCESSTOKEN','oY3_9SZtJCbJUzl4qLbSGS2qAiiO-MFSbChb42zI6OU'),
    'graphqlurl' => env('GRAPHQL_URL','graphql.contentful.com'),
    'imageurl' => env('IMAGE_URL','images.ctfassets.net'),
    'uploadurl' => env('UPLOAD_URL','upload.contentful.com'),
    'spaceid' => env('SPACE_ID','12hhoq6qt7p6'),
    'ctenv' => env('CT_ENV', 'master'),
    'defaultimage' => env('DEFAULT_IMAGE','39ZNESl87Y7Xl8QTnShvDZ'),
    'defaultimageurl' => env('DEFAULT_IMAGE_URL','https://images.ctfassets.net/12hhoq6qt7p6/39ZNESl87Y7Xl8QTnShvDZ/b973728e89ced542c90e388b02b974c5/logo.png'),
    'pseudonymtitle' => env('PSEUDONYM_TITLE','กองบรรณาธิการ Montivory'),
    'mockauth' => env('DEV_MOCKAUTH', false),
    'mockauthrole' => env('DEV_MOCKAUTH', 'admin'),
    'mockupdata' => env('DEV_MOCKUPDATA', false),
    'defaultthumbnaildesktop' => env('DEFAULT_IMAGE','6ON2Fh4DxVmOh7VSkz3gYv'),
    'defaultthumbnaildesktopurl' => env('DEFAULT_IMAGE_URL','https://images.ctfassets.net/12hhoq6qt7p6/6ON2Fh4DxVmOh7VSkz3gYv/0a9f06540ff3bd8ee0af5338545eb2b0/Thumnail.png'),
    'defaultthumbnailmobile' => env('DEFAULT_IMAGE','5hQ4G7bHGJk2jWnMseH95H'),
    'defaultthumbnailmobileurl' => env('DEFAULT_IMAGE_URL','https://images.ctfassets.net/12hhoq6qt7p6/5hQ4G7bHGJk2jWnMseH95H/f564c64d6295123b148fbae9a945eb4b/Thumbnail-Mobile.png'),
    'defaultheroimage' => env('DEFAULT_IMAGE','3Xl0L4hqwT0GjBo815ouoQ'),
    'defaultheroimageurl' => env('DEFAULT_IMAGE_URL','https://images.ctfassets.net/12hhoq6qt7p6/3Xl0L4hqwT0GjBo815ouoQ/8e9b98f8c9cbd575226e94e0c29dd5af/Hero-Banner.png'),
    'defaultcategorybanner' => env('DEFAULT_IMAGE','kjdh60orkOhqYJit7IyxA'),
    'defaultcategorybannerurl' => env('DEFAULT_IMAGE_URL','https:/images.ctfassets.net/12hhoq6qt7p6/kjdh60orkOhqYJit7IyxA/6b37b133fd23889f54770b272ed6b9f9/cover-image.jpg'),
    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. Set this in your ".env" file.
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => (bool) env('APP_DEBUG', true),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | your application so that it is used when running Artisan tasks.
    |
    */

    'url' => env('APP_URL', 'http://newweb.montivory.com'),

    'asset_url' => env('ASSET_URL', 'http://newweb.montivory.com'),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. We have gone
    | ahead and set this to a sensible default for you out of the box.
    |
    */

    'timezone' => 'Asia/Bangkok',

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */

    'locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Application Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale determines the locale to use when the current one
    | is not available. You may change the value to correspond to any of
    | the language folders that are provided through your application.
    |
    */

    'fallback_locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Faker Locale
    |--------------------------------------------------------------------------
    |
    | This locale will be used by the Faker PHP library when generating fake
    | data for your database seeds. For example, this will be used to get
    | localized telephone numbers, street address information and more.
    |
    */

    'faker_locale' => 'en_US',

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Illuminate encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    */

    'key' => env('APP_KEY','base64:TactdCZECSm2NJjUvP3ER4ssRijMlvzXGL//x4FTTls='),

    'cipher' => 'AES-256-CBC',

    /*
    |--------------------------------------------------------------------------
    | Maintenance Mode Driver
    |--------------------------------------------------------------------------
    |
    | These configuration options determine the driver used to determine and
    | manage Laravel's "maintenance mode" status. The "cache" driver will
    | allow maintenance mode to be controlled across multiple machines.
    |
    | Supported drivers: "file", "cache"
    |
    */

    'maintenance' => [
        'driver' => 'file',
        // 'store'  => 'redis',
    ],

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

    'providers' => [

        /*
         * Laravel Framework Service Providers...
         */
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Notifications\NotificationServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,

        /*
         * Package Service Providers...
         */

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        // App\Providers\BroadcastServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,

    ],

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
    */

    'aliases' => Facade::defaultAliases()->merge([
        // 'ExampleClass' => App\Example\ExampleClass::class,
    ])->toArray(),

];
