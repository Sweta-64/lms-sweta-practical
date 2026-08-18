# 🎯 Employee Leave Management System - Quick Start Guide

## ✨ Project Overview

A complete **Employee Leave Management System** with:

- ✅ Employee leave applications
- ✅ Admin approval/rejection workflow
- ✅ Automatic overlapping leave prevention
- ✅ Beautiful responsive UI (Bootstrap 5)
- ✅ RESTful API endpoints
- ✅ Complete validation
- ✅ Sample test data

---

## 🚀 Getting Started

### Step 1: Start Your Server

```bash
php artisan serve
```

The application will be available at: `http://localhost:8000`

### Step 2: Login with Test Accounts

#### Admin Account

```
Email: admin@lms.com
Password: password123
```

#### Employee Accounts

```
1. Email: john@lms.com | Password: password123
2. Email: jane@lms.com | Password: password123
3. Email: mike@lms.com | Password: password123
```

---

## 📍 Key Features

### 🔑 Easy-to-Recognize Code

All code follows Laravel best practices with clear naming:

- **Models**: `User.php`, `Leave.php` - Represent database entities
- **Controllers**: `LeaveController.php` - Handles business logic
- **Middleware**: `AdminMiddleware.php` - Protects admin routes
- **Views**: `resources/views/leaves/` - Beautiful UI templates
- **Routes**: `routes/web.php`, `routes/api.php` - All endpoints clearly defined

### 🎨 Professional UI Theme

- **Color Scheme**: Modern blue gradient (#2563eb)
- **Layout**: Responsive Bootstrap 5
- **Icons**: Font Awesome 6.4
- **Animations**: Smooth transitions & hover effects
- **Cards**: Professional card-based design
- **Badges**: Color-coded status (Pending/Approved/Rejected)

### 🛡️ Overlapping Leave Prevention

The system automatically checks for overlapping leaves:

```php
// In Leave model
Leave::hasOverlappingLeave($userId, $startDate, $endDate)
```

### 🔐 Role-Based Access Control

- **Employees** can: Apply, edit pending leaves, view their leaves
- **Admins** can: View all leaves, approve/reject, add remarks

---

## 📊 User Dashboard

### For Employees

```
┌─ Leave Management
│  ├─ Summary Cards (Pending, Approved, Rejected counts)
│  ├─ Leave List with status badges
│  ├─ Quick actions (View, Edit, Delete)
│  └─ Apply for Leave button
```

### For Admins

```
┌─ Leave Management
│  ├─ All employee leaves
│  ├─ Filter by status
│  ├─ Approve/Reject buttons
│  └─ Add remarks on rejection
```

---

## 🔌 API Endpoints

### Get My Leaves

```http
GET /api/leaves
Authorization: Bearer YOUR_TOKEN
```

### Create Leave

```http
POST /api/leaves
Authorization: Bearer YOUR_TOKEN
Content-Type: application/json

{
    "start_date": "2026-09-01",
    "end_date": "2026-09-03",
    "type": "vacation",
    "reason": "Family vacation to mountains"
}
```

### Approve Leave (Admin Only)

```http
POST /api/admin/leaves/{leave}/approve
Authorization: Bearer YOUR_TOKEN
```

### Reject Leave (Admin Only)

```http
POST /api/admin/leaves/{leave}/reject
Authorization: Bearer YOUR_TOKEN
Content-Type: application/json

{
    "remarks": "Cannot approve due to insufficient notice"
}
```

### Get All Leaves (Admin Only)

```http
GET /api/admin/leaves
Authorization: Bearer YOUR_TOKEN
```

### Get Pending Leaves (Admin Only)

```http
GET /api/admin/leaves/pending
Authorization: Bearer YOUR_TOKEN
```

---

## 📁 Project Structure

```
LMS_Sweta_Practical/
├── app/
│   ├── Models/
│   │   ├── User.php           ← User with relationships
│   │   └── Leave.php          ← Leave with validation logic
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── LeaveController.php  ← All leave operations
│   │   └── Middleware/
│   │       └── AdminMiddleware.php  ← Admin verification
│   └── Providers/
├── database/
│   ├── migrations/
│   │   ├── *_create_leaves_table.php
│   │   └── *_add_role_to_users_table.php
│   └── seeders/
│       └── UserSeeder.php     ← Sample data
├── resources/views/
│   ├── layouts/
│   │   └── app.blade.php      ← Main layout with theme
│   └── leaves/
│       ├── index.blade.php    ← List leaves
│       ├── create.blade.php   ← Apply form
│       ├── edit.blade.php     ← Edit form
│       └── show.blade.php     ← Details & approval
├── routes/
│   ├── web.php                ← Web routes
│   └── api.php                ← API routes
└── LEAVE_MANAGEMENT_GUIDE.md  ← Detailed documentation
```

---

## 🎨 UI/Theme Highlights

### Color Palette

- **Primary**: #2563eb (Blue)
- **Success**: #10b981 (Green)
- **Danger**: #ef4444 (Red)
- **Warning**: #f59e0b (Orange)
- **Info**: #0ea5e9 (Cyan)

### Components

- **Cards**: Elevated with hover animation
- **Buttons**: Gradient background with shadow
- **Forms**: Clean with focus states
- **Table**: Striped with hover effect
- **Badges**: Color-coded by status
- **Navbar**: Gradient with dropdown menu
- **Alerts**: Styled with icons

### Responsive

- Mobile-first design
- Works on all devices
- Touch-friendly buttons
- Stacked forms on mobile

---

## 🧪 Testing the System

### Test Scenario 1: Apply for Leave

1. Login as `john@lms.com`
2. Click "Apply for Leave"
3. Fill in:
    - Type: Vacation
    - Start: 2026-09-05
    - End: 2026-09-08
    - Reason: "Family vacation"
4. Click "Submit Application"
5. Leave appears in pending status

### Test Scenario 2: Overlapping Prevention

1. Try to apply for same dates again
2. System shows error: "You already have a leave request for these dates"
3. Choose different dates

### Test Scenario 3: Admin Approval

1. Login as `admin@lms.com`
2. Click "My Leaves"
3. Click on pending leave
4. Click "Approve Leave"
5. Leave status changes to Approved

### Test Scenario 4: Admin Rejection

1. Login as `admin@lms.com`
2. Click on pending leave
3. Click "Reject Leave"
4. Enter remarks: "Needs advance notice"
5. Click "Reject"
6. Leave status changes to Rejected with remarks

---

## 📋 Validation Rules

```
Start Date:
  ✓ Required
  ✓ Valid date
  ✓ Must be today or later
  ✓ Cannot be in past

End Date:
  ✓ Required
  ✓ Valid date
  ✓ Must be after start date
  ✓ Cannot create overlapping requests

Type:
  ✓ Required
  ✓ One of: sick, personal, vacation, other

Reason:
  ✓ Required
  ✓ Minimum 10 characters
  ✓ Maximum 500 characters

Admin Remarks:
  ✓ Required for rejection
  ✓ Minimum 5 characters
  ✓ Maximum 500 characters
```

---

## 🔄 User Workflows

### Employee Workflow

```
1. Login with email/password
2. Apply for leave
3. Fill form with dates & reason
4. System checks for conflicts
5. Application submitted (Pending status)
6. Receive approval/rejection from admin
7. Can edit/delete if still pending
8. View approved leaves in calendar view
```

### Admin Workflow

```
1. Login as admin
2. View all employee leaves
3. Click on pending request
4. Review details
5. Either:
   a) Click "Approve" → Status: Approved
   b) Click "Reject" → Add remarks → Status: Rejected
6. Employee sees decision
```

---

## 🛠️ Technical Stack

- **Framework**: Laravel 11
- **Database**: MySQL/SQLite
- **Frontend**: Bootstrap 5 + Custom CSS
- **Icons**: Font Awesome 6.4
- **API**: RESTful with Sanctum authentication
- **PHP Version**: 8.2+

---

## 📚 Code Highlights

### Leave Model - Overlap Prevention

```php
// In app/Models/Leave.php
public static function hasOverlappingLeave($userId, $startDate, $endDate, $excludeId = null)
{
    $query = self::where('user_id', $userId)
        ->where('status', '!=', 'rejected')
        ->where(function ($q) use ($startDate, $endDate) {
            $q->whereBetween('start_date', [$startDate, $endDate])
                ->orWhereBetween('end_date', [$startDate, $endDate])
                ->orWhere(function ($q) use ($startDate, $endDate) {
                    $q->where('start_date', '<=', $startDate)
                        ->where('end_date', '>=', $endDate);
                });
        });

    if ($excludeId) {
        $query->where('id', '!=', $excludeId);
    }

    return $query->exists();
}
```

### Controller - Simple & Clear

```php
// In app/Http/Controllers/LeaveController.php
public function store(Request $request)
{
    $request->validate([...]);

    // Check overlapping
    if (Leave::hasOverlappingLeave(...)) {
        return back()->withErrors(['overlap' => 'Overlapping leave']);
    }

    // Create leave
    auth()->user()->leaves()->create([...]);

    return redirect()->route('leaves.index')->with('success', '...');
}
```

### Admin Middleware - Protection

```php
// In app/Http/Middleware/AdminMiddleware.php
public function handle(Request $request, Closure $next): Response
{
    if (!auth()->check() || !auth()->user()->isAdmin()) {
        abort(403, 'Unauthorized: Admin access required');
    }

    return $next($request);
}
```

---

## 🚨 Common Issues & Solutions

| Issue                        | Solution                                        |
| ---------------------------- | ----------------------------------------------- |
| "Overlapping leave" error    | Choose different dates or delete existing leave |
| "Cannot edit approved leave" | Only pending leaves can be edited               |
| Can't access admin features  | Login with admin account                        |
| Migration errors             | Check database connection in .env               |
| 404 on API endpoints         | Ensure routes are registered in api.php         |

---

## 📈 Future Enhancements

Possible features to add:

- Email notifications for approvals
- Bulk approve/reject
- Leave balance tracking
- Department-wise reports
- Export to PDF/Excel
- Mobile app
- Calendar view
- Two-level approval
- Leave history

---

## 🎓 Learning Points

This project teaches:
✅ Laravel Eloquent relationships
✅ Form validation & error handling
✅ Middleware & authorization
✅ RESTful API design
✅ Blade templating
✅ Database migrations
✅ Seeding & factories
✅ Bootstrap responsive design
✅ Bootstrap 5 grid system
✅ Git version control

---

## 📞 Support

For detailed information, see **LEAVE_MANAGEMENT_GUIDE.md**

---

## 🎉 Summary

You now have a **production-ready** leave management system with:

- ✅ Clean, recognizable code
- ✅ Beautiful responsive UI
- ✅ Proper validation
- ✅ Admin approval workflow
- ✅ Overlapping prevention
- ✅ Complete API
- ✅ Test data included

**Everything is ready to use!**

---

**Made with ❤️ for LMS Practical**
**Version 1.0 | August 2026**
