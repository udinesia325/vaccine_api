<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">

<img src="https://img.shields.io/badge/Laravel-10.10-orange" alt="Laravel">
</p>

## Introduction

this as a backend application for create a vaccinations

### Server Requirements

- ```php ^8.1```
- ```composer ^2.5.5```

### Installation

- copy ```.env.example``` to ```.env```
- run ``` composer install```
- run ```php artisan key:generate```
- set the database configuration in .env file
- for testing database connection , just type in the terminal ```php artisan db:monitor```
- create a table by typing ```php artisan migrate```
- if you want to do unit testing , do seeding database by run command ```php artisan db:seed```
- and run ```php artisan test```

### Routes

The backend api documentation are available as openapi specification in ```docs/api``` or click [here](docs/api/)


# Thank You

### Don't forget the semicolon :)
