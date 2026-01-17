# Laravel URL Shortener (Assessment Project)

A multi-tenant URL shortener application built using Laravel as part of a backend developer assessment.

The system is designed with clear separation of concerns, predictable authorization rules, and a setup process that allows reviewers to run the project locally without additional configuration or third-party services.

## Features Overview

- Multi-company (tenant) architecture
- Company-scoped users
- Role-based access control (Admin / Member)
- Short URL generation
- Public redirection with hit tracking
- Invitation-based user onboarding
- Custom 404 handling for invalid short URLs
- Feature tests using PHPUnit

## Tech Stack

- **Framework**: Laravel 12.x
- **Language**: PHP 8.3
- **Database**: MySQL
- **Testing**: PHPUnit (Feature Tests)
- **Frontend**: Blade Templates
- **Asset Bundling**: Node.js 20 (Vite)

## Architecture Overview

This application follows a **modular, layered architecture** aligned with Laravel best practices.

### High-Level Structure

- **Presentation Layer**
    - Blade templates
    - Controllers handling request/response flow

- **Domain / Application Layer**
    - Form Requests for validation
    - Policies for authorization
    - Service-style logic where applicable

- **Persistence Layer**
    - Eloquent models
    - MySQL database
    - Company-scoped queries to enforce tenant isolation

### Multi-Tenancy Approach

- Single database
- Company-based data segregation
- All core resources are scoped by `company_id`
- Authorization enforced via policies and middleware

## Prerequisites

Ensure the following are installed on your local system:

- PHP >= 8.3
- Composer
- MySQL 8+
- Node.js >= 20
- npm

Verify installations:

```bash
php -v
composer -V
node -v
npm -v
```

---

## Project Setup (Local)

Follow the steps below **in the given order** to set up the project locally for testing.

### 1. Clone the Repository

```bash
git clone <repository-url>
cd <project-directory>
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Environment Configuration

Copy the environment example file:

```bash
cp .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

### 4. Configure Database

Update the following values in your .env file:

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

Create the database manually:

```bash
CREATE DATABASE your_database_name;
```

### 5. Run Migrations & Seeders

```bash
php artisan migrate --seed
```

This command will:

- Create all required database tables
- Seed base system data (super-admin)

### 6. Install & Build Frontend Assets

Install Node dependencies:

```bash
npm install
```

Build assets for production:

```bash
npm run build
```

For development with hot reload:

```bash
npm run dev
```

### 7. Start the Development Server

```bash
php artisan serve
```

The application will be available at:

http://127.0.0.1:8000

---

## Authentication & Roles

- Each user belongs to **exactly one company**
- Each user has one role within that company:
    - **Admin**
    - **Member**

### Role Capabilities

- **Admin**
    - Invite users (admin/member) to the company
    - Manage company-level resources (Create & View short links, View team users, etc.)
- **Member**
    - Access features permitted by assigned role (Short link creation)

## Single-Company User Design

This project intentionally follows a **single-company-per-user** design.

### Design Principle

- Users cannot belong to multiple companies
- Roles are scoped strictly within a company
- This approach:
    - Simplifies authorization logic
    - Improves data isolation
    - Avoids complex pivot tables
    - Matches common SaaS multi-tenant patterns

## Public Short URL Redirection

- All short URLs are publicly accessible
- Visiting a short URL:
    - Redirects to the original destination URL
    - Records a hit for analytics purposes
- Invalid or non-existent short URLs return 404

## Email Handling (Assignment Mode)

For simplicity and security, this project uses **Laravel’s log mailer**.

When an invitation is sent, the email content (including the invitation link) is written to:

```text
storage/logs/laravel.log
```

This allows easy verification without configuring external email services.

### Switching to Real Email (Optional)

To enable real email delivery (Mailtrap, SES, etc.), update the mail configuration in .env:

```bash
MAIL_MAILER=smtp
MAIL_HOST=your_smtp_host
MAIL_PORT=587
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=no-reply@linksy.local
MAIL_FROM_NAME="Linksy"
```

## Running Tests (PHPUnit)

### PHPUnit Configuration

Ensure the following environment variables exist in phpunit.xml:

```bash
<php>
    <env name="APP_ENV" value="testing"/>
    <env name="DB_CONNECTION" value="mysql"/>
    <env name="DB_DATABASE" value="your_test_database_name"/>
    <env name="DB_USERNAME" value="your_username"/>
    <env name="DB_PASSWORD" value="your_password"/>
</php>
```

Create the database manually:

```bash
CREATE DATABASE your_test_database_name;
```

### Run Tests

```bash
php artisan test
```

or

```bash
vendor/bin/phpunit
```

All feature tests should pass successfully.

---

## Notes for Reviewers

- No third-party services are required to run this project
- Email functionality is intentionally handled via log files
- The project follows Laravel best practices:
    - Policy-based authorization
    - Form request validation
    - Feature testing
    - Clear separation of concerns

If the setup steps are followed correctly, the application should run without additional configuration.
