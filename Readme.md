# Log Parser Service

This is a Log parsing command service built on Symfony.

# Tech Stack

This is a complete stack running Symfony 6.1 into Docker containers using docker-compose tool with [docker-sync library](https://docker-sync.readthedocs.io/en/latest/).

It is composed of:
- Docker
- PHP 8.1
- MySQL
- Nginx
- Symfony 6.1

## Installation

1. Clone this repo

2. Create the file `./.docker/.env.nginx.local` using `./.docker/.env.nginx` as template. The value of the variable `NGINX_BACKEND_DOMAIN` is the `server_name` used in NGINX.

3. Go inside folder `./docker` and run `docker-sync-stack start` to start containers.

4. You should work inside the `php` container. 

5. Inside the `php` container, run `composer install` to install dependencies from `/var/www/symfony` folder.

6. Use the following value for the DATABASE_URL environment variable:

```
DATABASE_URL=mysql://root:hello@db:3306/app_db?serverVersion=8.0.23
```

You could change the name, user and password of the database in the `env` file at the root of the project.

7. Run database migrations

```
php bin/console doctrine:migrations:migrate
```

## Running Tests

Inside the `php` container, create a new database `app_db_test` using the following commands.

- Create the test database 

```
php bin/console --env=test doctrine:database:create
```

- Create tables\columns in the test database 

```
php bin/console --env=test doctrine:schema:create
```

- You can now run the tests 

```
php bin/phpunit
```

## Usage

- update the .env  with the log file url and the parsing pattern: 

Log File:
```
LOG_FILE_PATH="logs.txt"
```

Log pattern: 
```
LOG_PATTERN="/(?<service>\S+) (?<space1>\S+) (?<spacer2>\S+) (?<datetime>\[([^:]+):(\d+:\d+:\d+) ([^\]]+)\]) (?<requestType>\S+) (?<path>\S+) (?<httpHeader>\S+) (?<status>\d+)/"
```

- run the console command to process the log file

```
php bin/console app:log-parser
```

## To Do:

- Resetting the database automatically before each test
- extend test coverage
- support for remote log files


## Credits

 - [symfony-docker boilerplate](https://github.com/ger86/symfony-docker) 


 



