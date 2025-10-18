# People Manager

This is a simple web application for managing a database of people, 
built with the TALL stack (Tailwind, Alpine.js, Laravel, and Livewire) 
and containerized with Laravel Sail.

## 🚀 Getting Started

These instructions will get you a copy of the project up and running on 
your local machine for development and testing purposes.

### Prerequisites

* [Docker Desktop](https://www.docker.com/products/docker-desktop/)
* [Node.js & npm](https://nodejs.org/en)

### 1. Clone the Repository

```shell
git clone git@github.com:Daniel-C02/people-manager.git
cd people-manager
```

### 2. Configure Environment
   
Copy the example environment file. You may configure your database and 
other settings here, but the defaults are set up for Laravel Sail.

```shell
cp .env.example .env
```

### 3. Install Composer Dependencies

This command runs `composer install` inside a temporary Docker container.

```shell
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var_www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs
```

### 4. Start Docker Containers

Start the application containers (web, database, etc.) in the background.

```shell
./vendor/bin/sail up -d
```

Note: You can now use sail as an alias for interacting with 
the application (e.g., sail artisan..., sail npm...).

### 5. Generate Application Key

```shell
sail artisan key:generate
```

### 6. Run Database Migrations & Seed

This will create the database schema and populate it with initial data (including the admin user).

```shell
sail artisan migrate:fresh --seed
```

### 7. Clear Configuration Cache

Any time you change your .env file, you must run this command to load the new configuration.

```shell
sail artisan config:cache
```

If the command above gives you trouble, you can also run:

```shell
sail artisan optimize:clear
```

### 8. Install NPM Dependencies

```shell
npm install
```

### 9. Build Frontend Assets

Run the Vite development server to compile assets and enable hot-reloading.

```shell
npm run dev
```

You can now access the application at http://localhost

### 🔒 Logins

| **Email**        | **Password** | **Type**           |
|------------------|--------------|--------------------|
| daniel@gmail.com | password     | Admin              |
