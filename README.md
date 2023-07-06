# Laravel Blog (REST API)

The Laravel Blog is a REST API-based project that aims to create a simple blog system with API functionalities. It includes features for managing members, posts, post photos, and thumbnails. The project implements various software design patterns to ensure a robust and maintainable codebase.

## Prerequisites

To run the project, you need to have the following dependencies installed:

- Composer
- PHP
- MySQL

## Installation and Setup

1. Clone the repository:
```bash
git clone https://github.com/erfangho/laravel-api-blog.git
```
2. Navigate to the project directory: 
```bash
cd laravel-api-blog
```
3. Create the .env file: 
```bash
cp .env.example .env
```
4. Install the dependencies:
```bash
composer install
```
5. Generate an application key:
```bash
php artisan key:generate
```
6. Run the database migrations:
```bash
php artisan migrate --seed
```
7. Start the development server:
```bash
php artisan serve
```

## Accessing the System

Once the development server is running, you can access the system by visiting the following URL in your web browser:
- Localhost: http://127.0.0.1:8000

## Contributing

Contributions to the Charity Aid Allocation System are welcome. If you have any suggestions, bug reports, or would like to contribute to the project, please contact the project maintainer at erfan2ghorbani@gmail.com.

## License

This project is open-source and is licensed under the [Creative Commons Attribution-NonCommercial-ShareAlike 4.0 International License](https://creativecommons.org/licenses/by-nc-sa/4.0/). Before using this project for commercial purposes or in business projects, please contact the project maintainer at erfan2ghorbani@gmail.com to obtain proper authorization.

