# E-Home Services Management System (Handy Hands)

**Repository:** `e-home-services-management-system`  
**Author:** Arooj Khan (BS in Computer Science Final Year Project, The University of Haripur)  
**Stack:** PHP (PDO), MySQL (XAMPP), HTML5, CSS3, JavaScript, Bootstrap 5, FontAwesome

## 1. Project Overview

**Handy Hands** is a full-stack web-based home services booking and management platform designed to connect households with verified local technicians across five core maintenance categories: **Plumbing Services, Electrical Repairs, Painting & Decor, Home Cleaning, and Carpentry & Furniture**.

## 2. Implemented Features & Role-Based Architecture

- **Role-Based Authentication (`auth/login.php`, `auth/register.php`, `auth/logout.php`):**
  - Supports **Customer**, **Service Provider (Technician)**, and **Administrator** roles with `password_hash()` (BCrypt) and session-based route protection (`requireRole()`).
- **Customer Portal (`customer/dashboard.php`, `customer/book.php`):**
  - Browse service categories with transparent base pricing (PKR), select preferred dates and time slots, submit service addresses and issue notes, automatic technician assignment by trade specialization, and real-time booking status tracking (*Pending*, *Confirmed*, *In Progress*, *Completed*, *Cancelled*).
- **Service Provider Portal (`provider/dashboard.php`):**
  - View assigned service orders, customer contact details, and service addresses, with one-click job status updates (*Confirmed* $\rightarrow$ *In Progress* $\rightarrow$ *Completed*).
- **Administrator Console (`admin/dashboard.php`):**
  - Real-time platform KPIs (Total Registered Users, Total Bookings, Completed Revenue in PKR) and recent system-wide booking activity monitor.
- **Relational MySQL Database (`database/handy_hands.sql`):**
  - Normalized 6-table InnoDB schema (`users`, `categories`, `services`, `service_providers`, `bookings`, `reviews`) pre-populated with Haripur seed data.

## 3. Repository Structure

```text
e-home-services-management-system/
├── README.md
├── .gitignore
├── index.php                  # Public landing page & service catalog
├── config/
│   └── db.php                 # PDO MySQL connection & session auth helpers
├── database/
│   └── handy_hands.sql        # Full MySQL schema + seed data for XAMPP
├── includes/
│   ├── header.php             # Shared responsive navigation bar
│   └── footer.php             # Shared footer & Bootstrap JS bundle
├── assets/
│   └── css/
│       └── style.css          # Custom styles & status badge themes
├── auth/
│   ├── login.php              # Multi-role sign-in
│   ├── register.php           # Customer & Technician registration
│   └── logout.php             # Session termination
├── customer/
│   ├── dashboard.php          # Customer booking history & status tracker
│   └── book.php               # Service booking form & auto-dispatch
├── provider/
│   └── dashboard.php          # Technician job queue & status updater
└── admin/
    └── dashboard.php          # Admin KPIs & platform booking monitor
```

## 4. Local XAMPP Installation & Setup

1. Install and open **XAMPP Control Panel** and start **Apache** and **MySQL**.
2. Clone or copy this repository into your XAMPP `htdocs` directory:
   ```bash
   cd C:/xampp/htdocs
   git clone https://github.com/Arooj-khan301/e-home-services-management-system.git handy-hands
   ```
3. Open `http://localhost/phpmyadmin/` in your browser, click **Import**, and import `database/handy_hands.sql` (it automatically creates and populates the `handy_hands` database).
4. Visit `http://localhost/handy-hands/` in your browser.
5. **Pre-Seeded Demo Accounts** (Password for all demo accounts: `Password123`):
   - **Customer:** `customer@handyhands.com`
   - **Service Provider (Plumbing):** `tariq.plumber@gmail.com`
   - **Service Provider (Electrical):** `sajid.electric@gmail.com`
   - **Administrator:** `admin@handyhands.com`

## 5. License

Released under the **MIT License**.
