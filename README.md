# Student ERP System — Complete Setup & Documentation

**Live Deployment:** [https://oliveflow.gt.tc/](https://oliveflow.gt.tc/)






> **Project:** Student ERP (Enterprise Resource Planning for Educational Institutions)  
> **Version:** 1.0.0  
> **Stack:** PHP 8+, MySQL, Bootstrap 5, Chart.js, Bootstrap Icons  
> **Environment:** XAMPP (Apache + MySQL) on Windows  

---

## 📖 Table of Contents

1. [Project Overview](#1-project-overview)
2. [Technology Stack](#2-technology-stack)
3. [Setup & Installation](#3-setup--installation)
4. [Customization Guide (URL & Database)](#4-customization-guide-url--database)
5. [Directory Structure](#5-directory-structure)
6. [Module Details (20+ Modules)](#6-module-details-20-modules)
7. [Navigation & Routing](#7-navigation--routing)
8. [UI / Design System](#8-ui--design-system)
9. [Security Implementation](#9-security-implementation)
10. [Known Limitations & Future Scope](#10-known-limitations--future-scope)

---

## 1. Project Overview

Student ERP is a comprehensive, modular web-based ERP designed for educational institutions to strictly manage students, academic planning, attendance, fees, faculty, and system administration from a centralized dashboard.

**Key Features:**
- **Student Information Management (SIM)** — Profiles, admission records, parent directory.
- **Academic Management** — Programs, batches, subjects, and course mappings.
- **Faculty & Staff HR** — Hiring details, categories, designations, and workload allocation.
- **Attendance & Examinations** — Tracking student attendance and scheduling exams.
- **Fees & Library** — Record payments with receipts, library book catalog with copy tracking.
- **Communications** — Internal announcements and alerts dashboard.

---

## 2. Technology Stack

| Layer | Technology |
|---|---|
| **Backend** | PHP 8+ (Procedural structure with robust PDO abstractions) |
| **Database** | MySQL 8+ via PDO prepared statements |
| **Frontend UI** | Bootstrap 5.3 Framework + Custom CSS |
| **Icons & Charts** | Bootstrap Icons 1.11, Chart.js (via CDN) |
| **Fonts** | Inter (Google Fonts) |
| **Server** | Apache (XAMPP environment recommended) |
| **Authentication** | PHP Sessions + Secure `password_verify()` |

---

## 3. Setup & Installation

Follow these instructions exactly to get the ERP up and running in minutes.

### Step 1 — Verify Environment
Ensure you have **XAMPP** installed and both **Apache** and **MySQL** are running in the XAMPP Control Panel.

### Step 2 — Import the Database
1. Open your browser and navigate to `http://localhost/phpmyadmin`
2. Create a new database named **`college_db`**. Ensure the collation is `utf8mb4_general_ci`.
3. Select the newly created `college_db` database on the left sidebar.
4. Click the **Import** tab at the top.
5. Click **Go** to run the import. This sets up all 20+ tables along with sample/dummy data.

### Step 3 — Configure Environment Variables
1. In the root directory, you will find a file named **`.env.example`**.
2. Create a copy of this file and rename it to **`.env`**.
3. Open **`.env`** and update the database credentials if they differ from the defaults:
   ```env
   DB_HOST=localhost
   DB_USER=root
   DB_PASS=your_password
   DB_NAME=college_db
   ```

### Step 4 — Visit the Application
Once the database is imported and the `.env` is configured, you can access the project:
**URL:** `http://localhost/Ex_OliveFlow`

### Step 5 — Default Login Credentials
Use the following credentials to access the Admin Dashboard:
- **Email:** `abc@domain.com`
- **Password:** `123456`
  
Use the following credentials to access the Faculty Dashboard:
- **Email:** `abcf@domain.com`
- **Password:** `123456`
---

## 4. Customization Guide (URL & Database)

It is highly likely you will want to deploy this app to a live server or simply change the folder name. Here is exactly where you make those changes.

### How to change the Project Folder Name (Base URL)
Currently, the app expects to be inside a folder named `studentErpFin`. If you rename the folder to something like `my_college_erp` or upload it to a live domain (`https://erp.mycollege.com`), you **must** update the `BASE_URL` constant.

1. Open the file: `config/config.php`
2. Find this line:
   ```php
   define('BASE_URL', 'http://localhost/Ex_OliveFlow');
   ```
3. Change it to your new path or live domain:
   ```php
   // Example local change:
   define('BASE_URL', 'http://localhost/my_college_erp');
   
   // Example live domain change:
   define('BASE_URL', 'https://erp.mycollege.com');
   ```
*Warning: If you do not update this, all CSS/JS assets and links will break!*

### How to change the Database Name/Credentials
If you name your database something different (e.g., `college_db`) or upload it to a production server with a specific username/password:

1. Open the file: `config/config.php`
2. Update the following constants to match your MySQL server details:
   ```php
   define('DB_HOST', 'localhost'); // Leave as localhost on most servers
   define('DB_USER', 'your_production_username');
   define('DB_PASS', 'your_production_password');
   define('DB_NAME', 'college_db'); // Name of your imported database
   ```

---

## 5. Directory Structure

```text
studentErpFin/
├── config/config.php               # DB credentials, BASE_URL, session initialization
├── controller/
│   ├── AuthController.php          # Secure login / logout handler
│   └── (Other operational controllers)
├── assets/
│   ├── css/custom.css              # Full UI/UX Design System (Colors, layout)
│   └── js/custom.js                # Sidebar toggles, flash messages, JS confirms
├── view/
│   ├── landing.php                 # Beautiful login page
│   ├── layout/header.php           # Top navbar with drop-downs (includes CSS imports)
│   ├── layout/sidebar.php          # Collapsible sidebar
│   ├── layout/footer.php           # Script imports
│   ├── dashboard/index.php         # Main dashboard with Chart.js stats
│   ├── students/                   # SIM operations (index, add, edit, view)
│   ├── faculty/                    # Staff HR operations (allocations, designations)
│   ├── institutes/                 # Institute hierarchy and branches
│   ├── programs/                   # Core academic hierarchy (programs, batches, subjects)
│   ├── fees/                       # Fee records and receipt generation
│   ├── (And various other robust module folders...)
├── final_db_setup.sql              # The REQUIRED database schema & dummy data
├── index.php                       # MAIN ROUTER (All traffic passes through here)
└── README.md                       # This file
```

---

## 6. Module Details (20+ Modules)

| Category | Modules | Core Features |
|---|---|---|
| **Auth & Profile** | Login, Registration, Profile | Role-based registration (Student/Faculty/Admin), unified session management, and extended profile editing. |
| **Overview** | Dashboard, Analytics | Real-time visual metrics, KPI stat cards, charts representing system health. |
| **People** | Students, Faculty, Parent Portal | Full CRUD for profiles, automated ID generation, designation tracking, guardian mapping. |
| **Academics** | Programs, Batches, Subjects, Courses | Creating multi-year programs, assigning subjects, scheduling batches. |
| **Operations** | Attendance, Exams, Fees, Library | Date-based attendance filtering, fee transactions, exam scheduling, book cataloging. |
| **Structure** | Institutes, Departments, Branches | Useful for multi-campus management and isolating departmental data. |
| **System** | Communications, System Settings | Compose internal alerts/notices, manage institution name/branding dynamically. |

---

## 7. Role-Based Authorization (RBAC)

The system enforces strict access control at both the UI (sidebar/navbar) and the Router level (`index.php`):

- **Admin**: Full access to all modules, including Institute setup, Staff HR, and System Settings.
- **Faculty**: Can manage Academics (Programs, Batches, Subjects), Attendance, and Examinations. Cannot modify Institute structure or other Staff records.
- **Student**: View-only access to their own Performance, Attendance, and Courses. Can fully manage their own Profile. Access to management-level modules is strictly blocked.

---

## 8. Implementation Guide: Profile Image Uploading

While the current version stores profile data in the database, you can implement photo uploads by following these steps:

### Step 1: Update the Database
Add a `profile_image` column to your profile tables:
```sql
ALTER TABLE students ADD COLUMN profile_image varchar(255) DEFAULT 'default-avatar.png';
ALTER TABLE staff ADD COLUMN profile_image varchar(255) DEFAULT 'default-avatar.png';
```

### Step 2: Create an Upload Directory
Create a folder named `uploads/profiles/` in your project root and ensure it has write permissions (`chmod 777` on Linux).

### Step 3: Add `enctype` to the Profile Form
In `view/system/profile.php`, update the `<form>` tag:
```html
<form method="POST" enctype="multipart/form-data">
```

### Step 4: Handle the File in PHP
Add this logic to the POST handler in `profile.php`:
```php
if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
    $target_dir = "uploads/profiles/";
    $file_ext = pathinfo($_FILES["profile_pic"]["name"], PATHINFO_EXTENSION);
    $new_name = $_SESSION['user_id'] . "_" . time() . "." . $file_ext;
    $target_file = $target_dir . $new_name;

    if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file)) {
        // Update the DB with $new_name
    }
}
```

---

## 9. UI / Design System
... (rest of the content)


The application boasts a premium, modern aesthetic using CSS variables located at the top of `assets/css/custom.css`.

**Core Palette:**
- **Accent/Primary:** Olive Green (`#4a7c59`)
- **Secondary/Dark:** Charcoal (`#2c3e50`)
- **Danger/Alert:** Maroon (`#800000`)
- **Background:** Soft Gray (`#f0f2f5`)

**Components:**
- **Cards:** Soft drop-shadows with hover translation (lift) effects.
- **Alerts:** Dynamic fixed flash messages that auto-dismiss after 4 seconds using CSS animation.
- **Forms:** Customized border-focus rings reflecting the primary olive color instead of standard Bootstrap blue.

---

## 9. Security Implementation

- **SQL Injection Prevention:** 100% usage of PDO Prepared Statements `prepare()` and `execute()`.
- **Cross-Site Scripting (XSS):** Data printed to the HTML body is wrapped in `htmlspecialchars()` to prevent malicious script injection.
- **Session Jacking Mitigation:** Strict session tracking. No page can be loaded without `$_SESSION['user_id']` being active.
- **Password Hashes:** Raw passwords are NEVER stored in the database. PHP's robust `password_hash()` (Bcrypt) and `password_verify()` are used.
- **Action Confirmation:** JavaScript interception requires users to confirm irreversible actions (like deletes) using a `.confirm-delete` class bind.

---

## 10. Known Limitations & Future Scope

While the system handles data beautifully via database inputs, some aspects are designed for future scalability:

1. **File Uploads:** The database schemas have hooks for student photos, signatures, and ID cards, but the actual file-system upload utility requires wiring up in a future update.
2. **Granular Role-Based Access Control (RBAC):** Currently, all logged-in administrators have sweeping access. Future builds could restrict Faculty users to only view their designated class schedules or mark attendance specifically for their batches.
3. **Automated Exports:** PDF/Excel generation for mark-sheets and fee receipts from the web views.

---

## 11. Database Reset & Mock Data Generation

During development or testing, you might need to completely wipe the existing database and generate fresh, randomized test data. You can securely clear out all existing records without breaking table relationships using the following SQL snippet:

```sql
-- Disable foreign key checks to avoid constraint errors
SET FOREIGN_KEY_CHECKS = 0;

-- Truncate tables (order does not matter now)
TRUNCATE TABLE users;
TRUNCATE TABLE system_settings;
TRUNCATE TABLE institute_types;
TRUNCATE TABLE institutes;
TRUNCATE TABLE departments;
TRUNCATE TABLE branches;

TRUNCATE TABLE academic_programs;
TRUNCATE TABLE academic_batches;
TRUNCATE TABLE subjects;
TRUNCATE TABLE course_mappings;
TRUNCATE TABLE class_schedules;

TRUNCATE TABLE staff_categories;
TRUNCATE TABLE staff_designations;
TRUNCATE TABLE staff;
TRUNCATE TABLE staff_subject_allocations;
TRUNCATE TABLE staff_leave_balance;

TRUNCATE TABLE students;

TRUNCATE TABLE attendance;
TRUNCATE TABLE student_attendance_summary;
TRUNCATE TABLE examinations;
TRUNCATE TABLE student_grades;

TRUNCATE TABLE fee_transactions;
TRUNCATE TABLE communications;
TRUNCATE TABLE library_books;

-- Re-enable foreign key checks
SET FOREIGN_KEY_CHECKS = 1;
```

### Generative AI Prompt for Fake Data (DeepSeek / ChatGPT)
If you want to quickly populate the database with extensive, customized, and realistic mock data after truncating, copy and paste the prompt below into an LLM like [DeepSeek](https://chat.deepseek.com/) or ChatGPT. 

This prompt is heavily detailed to ensure the AI explicitly matches the exact architecture of this ERP project:

> "I have an extremely flexible, modular standard MySQL database for an educational Student ERP system where Admins can dynamically add, update, and delete entries. I have truncated the database and need realistic, custom testing data. Generate complete standard raw SQL `INSERT INTO` statements (use bulk inserts). 
> 
> *Constraint Rules:* Ensure every foreign key ID matches corresponding primary keys inserted in your referenced tables. Maintain sensible data logic and abide by all these table schemas and ENUM constraints:
> 
> 1. `users`: generate 1 admin, 4 faculty, and 12 students. (`role` ENUM('admin', 'faculty', 'student'), `status` ENUM('active', 'suspended', '')). Use a standard valid bcrypt password hash.
> 2. `institutes`, `institute_types`: Generate 1 detailed college institute.
> 3. `departments`, `branches`: Map 3-4 distinct academic departments (e.g., CST, ECE) to the institute (`type` ENUM('academic', 'administrative', 'support')).
> 4. `academic_programs`, `academic_batches`: Generate 3 academic programs (e.g. Diploma in CST) and link related active batches to them accurately.
> 5. `subjects`, `course_mappings`: Generate 12 varied subjects (`subject_type` ENUM('core','elective','lab','project','seminar','workshop')). Map these to existing programs, batches, and assign them to generated faculty members.
> 6. `class_schedules`: Schedule different subjects throughout the week referencing proper batch and faculty IDs.
> 7. `staff_categories`, `staff_designations`: Add standard 'Teaching' & 'Non-Teaching' roles.
> 8. `staff`: Insert your 4 faculty members and map them correctly to categories/designations. (`gender` ENUM('male','female','other')).
> 9. `students`: Insert the 12 generated students. You MUST tie them properly to `program_id`, `batch_id`, and `user_id`. Ensure `status` ENUM('active','inactive','graduated','suspended','discontinued','completed') is respected. Include realistic parent details.
> 10. `attendance`, `examinations`, `student_grades`: Generate random robust attendance logs (`status` ENUM('present','absent','late','half_day')). Create exams and populated grading mappings for your students tied to subjects.
> 11. `fee_transactions`: Generate fee tuition receipts mapping to students (`payment_status` ENUM('paid','partial','pending')).
> 12. `library_books`, `communications`: Add 6-8 library books (`status` ENUM('active','lost','damaged','withdrawn')) and some standard notice alerts (`message_type` ENUM('notice','alert','email','sms')).
> 
> Return ONLY valid SQL that is rigorously structured and ready to explicitly execute against the DB without throwing constraint check constraint errors."

---
*Developed proudly with PHP 8, MySQL, and Bootstrap 5.*
