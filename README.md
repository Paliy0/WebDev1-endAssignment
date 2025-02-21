# Basic PHP MVC demo

This repository demonstrates how the MVC design pattern can be implemented using PHP.

It contains a docker configuration with:

- NGINX webserver
- PHP FastCGI Process Manager with PDO MySQL support
- MariaDB (GPL MySQL fork)
- PHPMyAdmin

## Installation Instructions

1. Install Docker Desktop on Windows or Mac, or Docker Engine on Linux.
1. Clone the project
1. Run containers
1. Install dependencies.

## Running the containers

While in the project's root directory, run:

```bash
docker-compose up
```

NGINX will now serve files in the app/public folder. Visit localhost in your browser to check.
PHPMyAdmin is accessible on localhost:8080

If you want to stop the containers, press Ctrl+C.
Or run:

```bash
docker-compose down
```

## Install Dependencies

with the containers running, run the following command to install composer dependencies

```bash
docker run --rm --interactive --tty \
  --volume $PWD/app:/app \
  composer install
```

## Access site

You can find the project running in http://localhost:80

If you want to access the phpmyadmin panel, instead visit
http://localhost:8080
