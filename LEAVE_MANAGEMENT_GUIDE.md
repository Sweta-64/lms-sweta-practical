# Employee Leave Management System - API & User Guide

## Overview

This is a comprehensive Employee Leave Management System built with Laravel. It allows employees to apply for leaves and admins to approve or reject them. The system prevents overlapping leave applications automatically.

## System Features

### 1. **User Roles**

- **Employee**: Can apply for leave, view their requests, and edit/delete pending requests
- **Admin**: Can view all leave requests, approve/reject leaves, and add remarks

### 2. **Leave Types**

- Sick Leave
- Personal Leave
- Vacation
- Other

### 3. **Leave Status**

- **Pending**: Waiting for admin approval
- **Approved**: Approved by admin
- **Rejected**: Rejected by admin with remarks

### 4. **Key Features**

✅ Overlapping leave prevention
✅ Date validation (cannot apply for past dates)
✅ Easy-to-use web interface
✅ RESTful API for integration
✅ Admin approval workflow
✅ Leave rejection with remarks
✅ Responsive design with Bootstrap 5

---

## Test Credentials

```
Admin User:
Email: admin@lms.com
Password: password123

Employee Users:
1. Email: john@lms.com | Password: password123
2. Email: jane@lms.com | Password: password123
3. Email: mike@lms.com | Password: password123
```

---

## Web Routes (User Interface)

### Authentication Required Routes

#### Leave Management Routes (Prefix: `/leaves`)

| Method | Route                     | Description                                                 | Role           |
| ------ | ------------------------- | ----------------------------------------------------------- | -------------- |
| GET    | `/leaves`                 | View all leaves (employees see only theirs, admins see all) | Employee/Admin |
| GET    | `/leaves/create`          | Show form to create new leave                               | Employee       |
| POST   | `/leaves`                 | Store new leave application                                 | Employee       |
| GET    | `/leaves/{leave}`         | View leave details                                          | Employee/Admin |
| GET    | `/leaves/{leave}/edit`    | Show edit form for pending leave                            | Employee       |
| PUT    | `/leaves/{leave}`         | Update pending leave                                        | Employee       |
| DELETE | `/leaves/{leave}`         | Delete pending leave                                        | Employee       |
| POST   | `/leaves/{leave}/approve` | Approve a leave (Admin only)                                | Admin          |
| POST   | `/leaves/{leave}/reject`  | Reject a leave with remarks (Admin only)                    | Admin          |

---

## API Routes (RESTful)

Base URL: `/api`

### Public Routes

| Method | Route         | Description           |
| ------ | ------------- | --------------------- |
| GET    | `/api/health` | Health check endpoint |

### Authentication Required Routes (Bearer Token)

#### User Endpoints

| Method | Route       | Description                  |
| ------ | ----------- | ---------------------------- |
| GET    | `/api/user` | Get current user information |

#### Leave Endpoints (Authenticated Users)

| Method | Route         | Description      |
| ------ | ------------- | ---------------- |
| GET    | `/api/leaves` | Get my leaves    |
| POST   | `/api/leaves` | Create new leave |

**Request Body for POST /api/leaves:**

```json
{
    "start_date": "2026-09-01",
    "end_date": "2026-09-03",
    "type": "vacation",
    "reason": "Family vacation to the mountains"
}
```

**Response (Success - 201):**

```json
{
    "data": {
        "id": 1,
        "user_id": 2,
        "start_date": "2026-09-01",
        "end_date": "2026-09-03",
        "type": "vacation",
        "reason": "Family vacation to the mountains",
        "status": "pending",
        "approved_by": null,
        "remarks": null,
        "created_at": "2026-08-18T12:30:00.000000Z",
        "updated_at": "2026-08-18T12:30:00.000000Z"
    }
}
```

**Response (Error - 409 - Overlapping Leave):**

```json
{
    "message": "Overlapping leave request already exists",
    "error": "overlap"
}
```

#### Admin Endpoints (Prefix: `/api/admin/leaves`)

| Method | Route                               | Description                |
| ------ | ----------------------------------- | -------------------------- |
| GET    | `/api/admin/leaves`                 | Get all leave requests     |
| GET    | `/api/admin/leaves/pending`         | Get pending leave requests |
| POST   | `/api/admin/leaves/{leave}/approve` | Approve a leave            |
| POST   | `/api/admin/leaves/{leave}/reject`  | Reject a leave             |

**Request Body for POST `/api/admin/leaves/{leave}/reject`:**

```json
{
    "remarks": "Cannot approve due to insufficient notice period"
}
```

**Response (Approve - 200):**

```json
{
    "data": {
        "id": 1,
        "user_id": 2,
        "start_date": "2026-09-01",
        "end_date": "2026-09-03",
        "type": "vacation",
        "reason": "Family vacation to the mountains",
        "status": "approved",
        "approved_by": 1,
        "remarks": null,
        "created_at": "2026-08-18T12:30:00.000000Z",
        "updated_at": "2026-08-18T12:30:00.000000Z"
    },
    "message": "Leave approved"
}
```

---

## Validation Rules

### Leave Application Validation

```
- start_date: Required, must be a valid date, must be today or after
- end_date: Required, must be a valid date, must be equal or after start_date
- type: Required, must be one of: sick, personal, vacation, other
- reason: Required, string, minimum 10 characters, maximum 500 characters
- No overlapping leave requests allowed (system checks automatically)
```

### Leave Rejection Validation

```
- remarks: Required, string, minimum 5 characters, maximum 500 characters
```

---

## Database Schema

### Users Table

```sql
- id (primary key)
- name (string)
- email (string, unique)
- email_verified_at (timestamp, nullable)
- password (string, hashed)
- role (enum: 'employee', 'admin') - default: 'employee'
- department (string, nullable)
- remember_token (string, nullable)
- timestamps
```

### Leaves Table

```sql
- id (primary key)
- user_id (foreign key → users.id)
- start_date (date)
- end_date (date)
- type (enum: 'sick', 'personal', 'vacation', 'other')
- reason (text)
- status (enum: 'pending', 'approved', 'rejected') - default: 'pending'
- approved_by (foreign key → users.id, nullable)
- remarks (text, nullable)
- timestamps
```

---

## Code Structure

### Models

- **App\Models\User**: User model with relationships to leaves
- **App\Models\Leave**: Leave model with validation logic and relationships

### Controllers

- **App\Http\Controllers\LeaveController**: Handles all leave operations

### Middleware

- **App\Http\Middleware\AdminMiddleware**: Verifies user is admin

### Migrations

- `*_create_users_table.php`: Initial users table
- `*_create_leaves_table.php`: Leaves table with all required fields
- `*_add_role_to_users_table.php`: Adds role and department columns

### Views

- `layouts/app.blade.php`: Main layout with navigation and styling
- `leaves/index.blade.php`: List all leaves with summary cards
- `leaves/create.blade.php`: Form to create new leave
- `leaves/edit.blade.php`: Form to edit pending leave
- `leaves/show.blade.php`: View leave details with admin approval/rejection

---

## User Interface Features

### For Employees

1. **Dashboard (Leaves Index)**
    - View summary cards (Pending, Approved, Rejected counts)
    - List all their leave requests
    - Edit pending requests
    - Delete pending requests
    - Quick access to apply for new leave

2. **Apply for Leave**
    - Select leave type
    - Choose start and end dates
    - Automatic day count calculation
    - Write reason for leave
    - Validation prevents overlapping leaves

3. **View Leave Details**
    - See all leave information
    - View status and dates
    - Check remarks if rejected

### For Admins

1. **Dashboard (Leaves Index)**
    - View all employee leave requests
    - See status and employee details
    - Quick action buttons

2. **Leave Details Page**
    - View complete leave information
    - Approve or reject with one click
    - Add remarks when rejecting
    - Modal popup for rejection form
    - See who approved/rejected and when

### UI Theme

- **Color Scheme**: Professional blue gradient
- **Components**: Bootstrap 5 with custom CSS
- **Icons**: Font Awesome 6.4
- **Responsive**: Works perfectly on mobile and desktop
- **Animations**: Smooth transitions and hover effects

---

## How to Use

### For Employees

1. **Login**
    - Enter your email and password
    - Click "Login"

2. **Apply for Leave**
    - Click "Apply for Leave" in navigation
    - Select leave type (Sick/Personal/Vacation/Other)
    - Choose start date and end date
    - System automatically calculates days
    - Enter reason for leave (min 10 characters)
    - Click "Submit Application"

3. **View Your Leaves**
    - Click "My Leaves" to see all your requests
    - View summary of Pending, Approved, and Rejected leaves
    - Click on any leave to see full details

4. **Edit Pending Leave**
    - Click on a pending leave request
    - Click "Edit" button
    - Modify dates, type, or reason
    - Click "Update Request"
    - Note: Cannot edit approved or rejected leaves

5. **Delete Pending Leave**
    - Click on a pending leave request
    - Click "Delete" button
    - Confirm deletion
    - Note: Cannot delete approved or rejected leaves

### For Admins

1. **View All Leaves**
    - Click "My Leaves" to see all employee requests
    - See status, employee info, and dates

2. **Review a Leave Request**
    - Click on a leave request
    - Review all details including employee name and reason

3. **Approve a Leave**
    - Click "Approve Leave" button
    - Leave status changes to "Approved"
    - Employee gets your name as approver

4. **Reject a Leave**
    - Click "Reject Leave" button
    - Modal popup appears
    - Add remarks explaining rejection
    - Click "Reject"
    - Leave status changes to "Rejected" with remarks

---

## Error Handling

### Common Errors

1. **Overlapping Leave (409)**
    - Message: "You already have a leave request for these dates."
    - Solution: Choose different dates or delete the existing leave

2. **Past Date (422)**
    - Message: "The start date must be after today."
    - Solution: Choose a future date

3. **Invalid Date Range (422)**
    - Message: "The end date must be after or equal to start date."
    - Solution: Ensure end date is after start date

4. **Short Reason (422)**
    - Message: "The reason must be at least 10 characters."
    - Solution: Provide a more detailed reason

5. **Unauthorized (403)**
    - Message: "Unauthorized"
    - Solution: Only admin can approve/reject, only employee can edit their own leaves

---

## API Authentication

The API uses **Sanctum tokens** for authentication.

### Getting an API Token

You can generate tokens manually or implement a login endpoint.

### Using Bearer Token

All API requests require the `Authorization` header:

```
Authorization: Bearer YOUR_TOKEN_HERE
```

Example cURL request:

```bash
curl -X GET http://localhost:8000/api/leaves \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Accept: application/json"
```

---

## Database Setup

The system includes sample data:

### Admin User

- Name: Admin User
- Email: admin@lms.com
- Password: password123

### Sample Employees

1. John Doe (IT Department)
2. Jane Smith (HR Department)
3. Mike Johnson (Finance Department)

### Sample Leaves

- Multiple approved leaves
- Multiple pending leaves
- Some rejected leaves with remarks

---

## Deployment & Configuration

### Environment Setup

1. Copy `.env.example` to `.env`
2. Update database credentials
3. Generate app key: `php artisan key:generate`
4. Run migrations: `php artisan migrate`
5. Seed data: `php artisan db:seed`
6. Generate storage link: `php artisan storage:link`

### Starting the Server

Development:

```bash
php artisan serve
```

Production:

- Use a web server like Nginx or Apache
- Ensure proper file permissions
- Set up SSL certificate
- Configure .env for production

---

## Tips for Usage

✅ **Best Practices**

- Apply for leave with advance notice
- Provide detailed reasons for better approval chances
- Check calendar before applying
- Admins should add helpful remarks for rejections

❌ **Things to Avoid**

- Don't apply for overlapping dates
- Don't use past dates
- Don't submit without proper reason
- Don't delete important leave records

---

## Support & Troubleshooting

### Common Issues

1. **"Unauthorized: Admin access required"**
    - Only admins can access admin features
    - Contact your administrator for role change

2. **"You can only edit pending leave requests"**
    - Approved or rejected leaves cannot be edited
    - Create a new leave request instead

3. **Migrations fail**
    - Check database connection in .env
    - Ensure database exists
    - Run: `php artisan migrate:refresh` (caution: deletes data)

---

## Version & License

- **Version**: 1.0
- **Framework**: Laravel 11
- **PHP**: 8.2+
- **Database**: MySQL/SQLite
- **License**: MIT

---

## Contributors

- Developed as a practical LMS project
- Built with ❤️ using Laravel

---

## Changelog

### Version 1.0 (Current)

- ✅ User authentication with roles
- ✅ Leave application and management
- ✅ Overlapping leave prevention
- ✅ Admin approval/rejection workflow
- ✅ RESTful API endpoints
- ✅ Responsive web interface
- ✅ Beautiful UI with Bootstrap 5
- ✅ Comprehensive validation
- ✅ Sample data seeding

---

**Last Updated**: August 18, 2026
**Status**: Production Ready
