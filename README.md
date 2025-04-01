# Prototype-Assignment-BC200417404

# Laravel Project Setup Guide

## Prerequisites

Before you begin, ensure you have met the following requirements:

- **PHP**: Version 8.0 or higher
- **Composer**: Dependency manager for PHP
- **Node.js**: Version 14 or higher (for front-end assets)
- **MySQL**: Version 5.7 or higher (or any other database supported by Laravel)

## Cloning the Repository

To download the project, follow these steps:

1. Open your terminal (Command Prompt, PowerShell, or Terminal).
2. Navigate to the directory where you want to clone the project.
3. Run the following command to clone the repository:

   ```bash
   git clone https://github.com/your-username/your-repo-name.git
   ```

   Replace `your-username` and `your-repo-name` with your GitHub username and the repository name.

4. Navigate into the project directory:

   ```bash
   cd your-repo-name
   ```

## Installing Dependencies

Once you have cloned the repository, you need to install the project dependencies:

1. Run the following command to install PHP dependencies using Composer:

   ```bash
   composer install
   ```

2. If your project uses front-end assets, install Node.js dependencies:

   ```bash
   npm install
   ```

## Setting Up the Environment

1. Copy the `.env.example` file to create a new `.env` file:

   ```bash
   cp .env.example .env
   ```

2. Open the `.env` file in a text editor and configure your database and other environment settings.

3. Generate the application key:

   ```bash
   php artisan key:generate
   ```

## Running Migrations

If your project uses a database, run the migrations to set up the database schema:

```bash
php artisan migrate
```

## Seeding the Database

To populate your database with initial data, you can use seeders. Follow these steps:

1. If you have created seeders, you can run them using the following command:

   ```bash
   php artisan db:seed
   ```

2. If you want to run a specific seeder, you can use the `--class` option:

   ```bash
   php artisan db:seed --class=YourSeederClassName
   ```

   Replace `YourSeederClassName` with the name of the seeder you want to run.

## Starting the Development Server

To start the Laravel development server, run the following command:

```bash
php artisan serve
```

You can now access your application at `http://localhost:8000`.

## Additional Commands

- **Run Tests**: To run the tests, use the following command:

  ```bash
  php artisan test
  ```

- **Compile Assets**: If you have front-end assets, compile them using:

  ```bash
  npm run dev
  ```

## Conclusion

You have successfully set up the Laravel project. If you encounter any issues, please refer to the Laravel documentation or check the project's issues on GitHub.