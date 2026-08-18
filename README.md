# Employee Leave Management System

## Project Overview

A complete web-based application for managing employee leave requests. Employees can apply for leaves, admins can approve/reject them, and the system automatically prevents overlapping applications.

### Key Features

- ✅ Employee leave applications (Sick, Personal, Vacation, Other)
- ✅ Admin approval/rejection workflow
- ✅ Automatic overlapping leave prevention
- ✅ Beautiful responsive UI (Bootstrap 5)
- ✅ Role-based access control
- ✅ RESTful API

---

## Quick Start

### Step 1: Start the Server

```bash
cd d:\xamp\htdocs\LMS_Sweta_Practical
php artisan serve
```

Keep this terminal open. Server runs at: **http://127.0.0.1:8000**

### Step 2: Open in Browser

Go to: **http://127.0.0.1:8000**

### Step 3: Login

Use these credentials:

**ADMIN Account:**

- Email: `admin@lms.com`
- Password: `password123`

**EMPLOYEE Accounts:**

- Email: `john@lms.com` | Password: `password123`
- Email: `jane@lms.com` | Password: `password123`
- Email: `mike@lms.com` | Password: `password123`

---

## How to Use

### For Employees

1. **Login** with your employee email
2. **Apply for Leave** → Click "Apply for Leave" button
    - Select leave type
    - Choose start & end dates
    - Write reason (min 10 characters)
    - Click "Submit"
3. **View Leaves** → Go to "My Leaves"
    - See status (Pending/Approved/Rejected)
    - Edit pending leaves
    - Delete pending leaves
4. **Logout** → Click your name → Logout

### For Admins

1. **Login** with admin email
2. **View All Leaves** → Go to "My Leaves"
    - See all employee requests
3. **Approve Leave** → Click on pending leave → Click "Approve"
4. **Reject Leave** → Click on pending leave → Click "Reject" → Add remarks
5. **Logout** → Click your name → Logout

---

## Overlapping Leave Prevention

System automatically prevents overlapping leaves:

- ❌ Cannot apply for dates that already have leave
- ✅ Can apply for adjacent dates (e.g., Aug 5-8, then Aug 9-12)
- ✅ Rejected leaves don't block new applications

Example: If you have leave Aug 5-10, you cannot apply for Aug 8-12 (overlap detected).

---

## Technology Stack

- **Framework**: Laravel 11
- **Database**: MySQL
- **Frontend**: Bootstrap 5, CSS, JavaScript
- **PHP**: 8.2+

---

## Database

**Sample Data Included:**

- 1 Admin account
- 3 Employee accounts
- Sample leave requests

**Database File**: `database_export.sql` (included in project)

---

## URLs

| Page        | URL                                 |
| ----------- | ----------------------------------- |
| Home/Login  | http://127.0.0.1:8000               |
| My Leaves   | http://127.0.0.1:8000/leaves        |
| Apply Leave | http://127.0.0.1:8000/leaves/create |
| API Health  | http://127.0.0.1:8000/api/health    |

---

## Documentation

- **USER_GUIDE.txt** → Complete step-by-step guide
- **QUICK_START.md** → Quick overview
- **LEAVE_MANAGEMENT_GUIDE.md** → API documentation
- **DATABASE_SETUP.md** → Database setup

---

## Troubleshooting

| Issue                      | Solution                               |
| -------------------------- | -------------------------------------- |
| Cannot login               | Check email & password from login page |
| "Overlapping leave" error  | Choose different dates                 |
| Cannot edit approved leave | Only pending leaves can be edited      |
| Server won't start         | Ensure MySQL is running (XAMPP)        |
| Blank page                 | Refresh browser or wait 3 seconds      |

---

## Stop the Server

Press **Ctrl + C** in the terminal where you started the server.

---

## GitHub Repository

https://github.com/Sweta-64/lms-sweta-practical

---

**Version**: 1.0 | **Status**: Production Ready | **Last Updated**: August 18, 2026
