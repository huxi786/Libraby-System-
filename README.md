<p align="center"><a href="#" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Library System Logo"></a></p>

<p align="center">
<a href="#"><img src="https://img.shields.io/badge/PHP-8.2-777BB4.svg?style=flat&logo=php" alt="PHP Version"></a>
<a href="#"><img src="https://img.shields.io/badge/Laravel-10-FF2D20.svg?style=flat&logo=laravel" alt="Laravel Version"></a>
<a href="#"><img src="https://img.shields.io/badge/Database-MySQL-4479A1.svg?style=flat&logo=mysql" alt="Database"></a>
<a href="#"><img src="https://img.shields.io/badge/License-MIT-green.svg" alt="License"></a>
</p>

# 📚 Library CRUD Management System

## Project Overview

The **Library CRUD System** is a comprehensive web-based application designed to digitize and streamline library operations. It replaces traditional manual paperwork with an accurate, efficient, and role-based digital system.

The system allows **Admins** to manage books, members, and issue/return records, while **Users (Members)** can browse books, view their history, and manage their profiles.

## 🎯 Purpose of the System

The primary goal is to:
- **Digitize Records:** Eliminate manual registers and paperwork.
- **Improve Efficiency:** Quick access to book and member information.
- **Role-Based Access:** Secure separate panels for Admins and Users.
- **Error Reduction:** Automate the tracking of issued and returned books.

---

## ✨ Key Features

### 1. 🛡️ Admin Panel (Login as Admin)
The Admin has full control over the system:
- **Dashboard:** View reports (Total Books, Total Members, Issued Books stats).
- **Book Management:** Create, Read, Update, and Delete (CRUD) books.
- **Member Management:** Add, Edit, View, or Delete members.
- **Issue & Return:** Issue books with due dates and update return status.
- **Category Management:** Organize books into different categories.
- **Notifications:** Receive alerts for new registrations or due dates.

### 2. 👤 User Panel (Login as Member)
Members have restricted access focused on their activities:
- **Registration & Login:** Secure account creation and login.
- **Book List:** Browse available books in the library.
- **My History:** View list of books issued to them.
- **Profile Management:** Update personal details.

### 3. 🔔 System Notifications
Notifications ensure users and admins stay informed about:
- Book Issue & Return status.
- Due date alerts.
- New User Registrations (Admin alert).

---

## 🔄 System Flow

The system follows a logical flow to ensure security and usability:

1.  **Visit:** User/Admin visits the Login Page.
2.  **Role Selection:** Choose to login as Admin or User (or Register if new).
3.  **Authentication:** System verifies credentials and checks the Role.
4.  **Dashboard:** * *Admin* redirects to Admin Dashboard.
    * *User* redirects to User Dashboard.
    * 
5.  **Action:** Perform tasks (Issue book, Add member, etc.).
6.  **Database:** System updates the records in real-time.
7.  **Logout:** Session ends securely.

---

## 🗄️ Database Design

The system uses a relational database structure:

| Table Name | Description |
| :--- | :--- |
| **Users** | Stores login credentials and roles (`admin` / `user`). |
| **Books** | Stores book details (Title, Author, Qty, etc.). |
| **Categories** | Helps in organizing books by genre/type. |
| **Members** | Stores extended member profile data (optional). |
| **Issued_Books** | Tracks transactions (Book ID, User ID, Issue Date, Return Date, Status). |

---

## 💻 UI Screens

The application includes the following user interface pages:
- 🔐 Login (Admin & User)
- 📝 Registration Page
- 📊 Admin Dashboard
- 👤 User Dashboard
- 📚 Books Management Page
- 👥 Members List Page
- 🔄 Issue & Return Book Pages

*(Screenshots can be added here)*

---

## ⚙️ Installation Guide

Follow these steps to run the project locally:

1.  **Clone the Repository**
    ```bash
    git clone [https://github.com/yourusername/library-crud-system.git](https://github.com/yourusername/library-crud-system.git)
    cd library-crud-system
    ```

2.  **Install Dependencies**
    ```bash
    composer install
    npm install && npm run build
    ```

3.  **Environment Setup**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
    *Configure your database name and credentials in the `.env` file.*

4.  **Run Migrations**
    ```bash
    php artisan migrate --seed
    ```

5.  **Start Server**
    ```bash
    php artisan serve
    ```

---

## 🚀 Conclusion

This **Library Management System** successfully simplifies the complex task of managing a library. By implementing organized modules for books and members, along with role-based security, it provides a seamless experience for both librarians and readers.

## License

The Library CRUD System is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
