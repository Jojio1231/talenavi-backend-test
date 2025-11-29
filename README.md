Talenavi Backend Internship Test

Candidate: Joshua Nicholas Harludi
Role: Backend Developer Internship

This repository contains the source code for the Talenavi Technical Test. It is a RESTful API built with Laravel 11 that handles Todo management and generates custom Excel reports.

Tech Stack

Framework: Laravel 12

Database: MySQL

Language: PHP 8.2+

Tools: Postman, Composer, Git

Libraries: maatwebsite/excel

Features

1. Create Todo (POST)

Endpoint: /api/todos

Functionality: Validates and stores new tasks.

Validation Rules:

due_date must be today or in the future.

status defaults to pending.

priority accepts low, medium, high.

2. Export Excel Report (GET)

Endpoint: /api/todos/export

Functionality: Generates an .xlsx file with a summary row (Total Count & Total Time).

Filtering: Supports complex query parameters:

Partial Match: title

Multi-Select: priority=high,medium

Date Range: due_date=start=2025-01-01&end=2025-12-31

Installation & Setup

Clone the repository

git clone [https://github.com/Jojio1231/talenavi-backend-test.git](https://github.com/Jojio1231/talenavi-backend-test.git)
cd talenavi-backend-test



Install Dependencies

composer install



Environment Setup
Copy the .env.example file and configure your database:

cp .env.example .env



Update DB_DATABASE, DB_USERNAME, etc., in the .env file.

Run Migrations

php artisan migrate



Start Server

php artisan serve



Testing

The API is designed to be tested via Postman.

Base URL: http://127.0.0.1:8000

Collection: A Postman collection can be created to test the endpoints as demonstrated in the submission video.