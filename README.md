# Final-Project-BC200417404
## Important Notice

This project is being updated until the viva, and all documentation will also be updated before the viva.

## Project Structure

In the `src` directory, there is a folder named `restaurant_web`, which contains all the scenarios and project requirements for creating the entire application in Laravel.

# Laravel Project Setup Guide

This guide will help you set up the Laravel project from scratch, including cloning the repository, installing dependencies, setting up the environment, and accessing the admin panel.

## Prerequisites

Before you begin, ensure you have the following installed on your machine:

- PHP (version 8.0 or higher)
- Composer
- MySQL or another database server
- Git

## Step 1: Clone the Repository

To get started, open your terminal and run the following command to clone the repository:

```bash
git clone https://github.com/Student-BC200417404/Prototype-Assignment-BC200417404.git
```

This command will create a local copy of the project in a directory named `Prototype-Assignment-BC200417404`.

## Step 2: Navigate to the Project Directory

Change into the project directory:

```bash
cd Prototype-Assignment-BC200417404
```

## Step 3: Install Dependencies

Install the required PHP dependencies using Composer. Run the following command:

```bash
composer install
```

This command will read the `composer.json` file and install all the necessary packages.

## Step 4: Set Up Environment Variables

Copy the example environment file to create your own `.env` file:

```bash
cp .env.example .env
```

Open the `.env` file in a text editor and configure your database settings. Look for the following lines and update them according to your database configuration:

```plaintext
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

Make sure to replace `your_database_name`, `your_database_user`, and `your_database_password` with your actual database credentials.

## Step 5: Generate Application Key

Run the following command to generate a unique application key for your Laravel application:

```bash
php artisan key:generate
```

This command will set the `APP_KEY` value in your `.env` file.

## Step 6: Run Migrations

To set up your database schema, run the migrations with the following command:

```bash
php artisan migrate
```

This command will create the necessary tables in your database as defined in the migration files.

## Step 7: Seed the Database

To populate your database with initial data, run the seeder:

```bash
php artisan db:seed
```

This command will execute the seeder classes defined in your project, allowing you to insert sample data into your database.

## Step 8: Serve the Application

You can now serve the application using the built-in PHP server. Run the following command:

```bash
php artisan serve
```

This will start the server, and you should see output indicating that the application is running at `http://localhost:8000`.

## Step 9: Access the Application

Open your web browser and navigate to:

```
http://localhost:8000
```

You should see your Laravel application running.

## Step 10: Access the Admin Panel

To access the admin panel, go to the following URL:

```
http://localhost:8000/admin
```

Log in using your admin credentials. If you haven't set up any users yet, you may need to create an admin user through the database or modify the seeder to include an admin account.

## Conclusion

You have successfully set up your Laravel project! If you encounter any issues, please refer to the Laravel documentation or check the project's issues on GitHub for assistance.

