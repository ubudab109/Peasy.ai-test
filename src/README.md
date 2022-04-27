## REQUIREMENTS

- PHP 7.4+
- MySQL
- [Redis](https://developer.redis.com/create/windows)
- [Composer](https://getcomposer.org/)


## CONFIGURATION

- Rename Your .env.example file to .env and change the configuration with your own
- Run `composer install`
- Run `php artisan key:generate`
- Run `php artisan migrate`

## HOW TO USE 

- Run `php artisan queue:work` or `php artisan queue:listen`
- Open Your browser and hit the API route with your local url. For example if You run Your project at localhost with Port 8000, then type this in Your browser `localhost:8000/api/{results}`. Change `{results}` parameter with number, for example `20`.

