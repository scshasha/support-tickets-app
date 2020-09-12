# Support Ticket Application

## Requirements

- [Laravel work environment](https://laravel.com/docs/5.x)
- [Dev Desktop / Docker Toolbox](https://www.docker.com/products/docker-desktop) _(Optional)_

## Setup

The setup guide assumes that you have the above requirements.

### Running the Docker setup

Clone repo: (or manually download the [env-setup](https://gitlab.com/epione-tests/scshasha-be/-/tree/env-setup) branch and run the install script)

> git clone git@gitlab.com:epione-tests/scshasha-be.git

> git pull origin env-setup --force

> . install.sh

The bash script will run the application setup

- Laravel application will run on [http://localhost:8001](http://localhost:8001) (note that your IP may be different)
- Use [http://localhost:8080](http://localhost:8080) for Adminer (Database GUI). You can also use bash by running `docker-compose exec mariadb sh` (Login credentials will be on the .env file)
- For email [http://localhost:8002](http://localhost:8002) [MailHog]

* Ensure you have these containers running:

```
mariadb
php
nginx
redis
adminer
mailhog
```

### Running on other local environments

> git clone git@gitlab.com:epione-tests/scshasha-be.git

> git pull origin master

> composer install

> php artisan serve

---

## configurations

Files and variable to update.

#### On Docker (.env)

```
DB_NAME=databasename
DB_USER=userpassowrd
DB_PASSWORD=userpassword
```

#### On Laravel (.env)

```
DB_NAME=databasename
DB_USER=userpassowrd
DB_PASSWORD=userpassword
DB_HOST=mariadb

QUEUE_DRIVER= redis

BOOKS_CSV_API=https://raw.githubusercontent.com/zygmuntz/goodbooks-10k/master/books.csv

REDIS_HOST=(DOCKER MACHINE IP OR SERVICE NAME [default is localhost])
REDIS_CLIENT=predis
```

DB migrations. Run:

> php artisan migrate

## [Additional]: When using Docker Toolbox (as I am) you may be required to do the following configurations to your setup

- Port mapping - Basically you are telling your VM that your machines `:8001` is listening to its `:80` traffic. If you wish to change these port you may do so by updating `./docker-compose.yml`
- By default on Docker Toolbox http://localhost (which in reality is address 127.0.0.1) will not work, instead use `YOUR_VM_ASSIGNED_IP:8001`. To find that IP execute command `docker-machine ip`. In my case I access it via [https://192.168.99.100:8001](https://192.168.99.100:8001)
- Although the install bash script should be taking care of setting up the application, there are instances where migrations fail, in such cases you will need to sh into the php container by running `docker-compose exec php sh` from there you can run Laravel commands i.e `php artisan migrate:refresh` etc.

#### Commands:

- `php artisan migrate` to create tables
- `php artisan db:seed --class=BookSeeder` to import csv data.
