## REQUIREMENTS

- [Docker](https://www.docker.com/)


## CONFIGURATION

- Go To root Directory `./technical-test`
- Type `docker-compose up -d --build site`
- After finish. Type `docker-compose run --rm composer install`
- Type `docker-compose run --rm artisan migrate`
- Optional `docker-compose run --rm key:generate`

## HOW TO USE 

- This Apps running on port `${localhost}:505` or with domain peasy-ai.test
- Before Open apps, type `docker-compose up --build cron` to run jobs
- Wait for 1 minutes, then data will appear in apps.

