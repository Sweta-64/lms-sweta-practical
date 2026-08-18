# Database Setup Guide

## Quick Start - Import Database

If you want to quickly set up the database with all sample data, follow these steps:

### Option 1: Using MySQL Command (Recommended)

```bash
mysql -u root -h 127.0.0.1 lms_sweta_practical < database_export.sql
```

### Option 2: Using PHP Script

```bash
php export_db.php
```

### Option 3: Using phpMyAdmin (GUI)

1. Open phpMyAdmin in browser: `http://localhost/phpmyadmin`
2. Click on "Import" tab
3. Choose `database_export.sql` file
4. Click "Import"

---

## Database Structure

### Tables (10 total)

#### 1. **users**

Stores employee and admin user data

| Column            | Type      | Description           |
| ----------------- | --------- | --------------------- |
| id                | INT       | Primary key           |
| name              | VARCHAR   | User's full name      |
| email             | VARCHAR   | Unique email          |
| email_verified_at | TIMESTAMP | Email verification    |
| password          | VARCHAR   | Hashed password       |
| role              | ENUM      | 'employee' or 'admin' |
| department        | VARCHAR   | User's department     |
| remember_token    | VARCHAR   | Login token           |
| created_at        | TIMESTAMP | Creation date         |
| updated_at        | TIMESTAMP | Last update date      |

#### 2. **leaves**

Stores all leave applications

| Column      | Type      | Description                             |
| ----------- | --------- | --------------------------------------- |
| id          | INT       | Primary key                             |
| user_id     | INT       | Employee ID (FK)                        |
| start_date  | DATE      | Leave start date                        |
| end_date    | DATE      | Leave end date                          |
| type        | ENUM      | 'sick', 'personal', 'vacation', 'other' |
| reason      | TEXT      | Reason for leave                        |
| status      | ENUM      | 'pending', 'approved', 'rejected'       |
| approved_by | INT       | Admin ID who approved (FK)              |
| remarks     | TEXT      | Rejection remarks                       |
| created_at  | TIMESTAMP | Application date                        |
| updated_at  | TIMESTAMP | Last update date                        |

#### 3. **migrations**

Track database migrations

#### 4. **password_reset_tokens**

Store password reset tokens

#### 5. **sessions**

User session storage

#### 6. **cache** & **cache_locks**

Application caching

#### 7. **jobs** & **job_batches**

Background job queue

#### 8. **failed_jobs**

Failed job tracking

---

## Sample Data Included

### Admin User

```
Name: Admin User
Email: admin@lms.com
Password: password123 (hashed)
Role: admin
Department: Administration
```

### Employee Users

```
1. Name: John Doe
   Email: john@lms.com
   Department: IT

2. Name: Jane Smith
   Email: jane@lms.com
   Department: HR

3. Name: Mike Johnson
   Email: mike@lms.com
   Department: Finance
```

### Sample Leave Requests

- Approved leaves
- Pending leaves
- Rejected leaves with remarks

---

## Export Instructions

To export the current database state:

```bash
php export_db.php
```

This will create `database_export.sql` with:

- All table structures
- All data
- Foreign key constraints

---

## Reset Database

To reset the database to migrations only (without sample data):

```bash
php artisan migrate:refresh
```

To reset with fresh sample data:

```bash
php artisan migrate:refresh --seed
```

---

## Database Connection

Current configuration (from `.env`):

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lms_sweta_practical
DB_USERNAME=root
DB_PASSWORD=
```

To use different credentials, update `.env` file and run migrations again.

---

## Troubleshooting

### Database doesn't exist

```bash
# Create database first
mysql -u root -e "CREATE DATABASE lms_sweta_practical;"
```

### Connection refused

- Ensure MySQL server is running
- Check DB_HOST and DB_PORT in .env
- Verify credentials are correct

### Import fails

- Make sure database exists
- Check file encoding (should be UTF-8)
- Try importing in smaller chunks

### Overlapping leave errors

The system prevents overlapping leaves automatically using the database constraints.

---

## Backing Up Your Data

To create a backup:

```bash
php export_db.php
# This creates database_export.sql
```

Backup your SQL file regularly to a safe location.

---

## Version Info

- **Database**: MySQL 5.7+
- **Framework**: Laravel 11
- **PHP**: 8.2+
- **Export Date**: 2026-08-18

---

## Support

For issues with database setup, ensure:

1. MySQL server is running
2. Database exists
3. User has proper permissions
4. .env has correct credentials
