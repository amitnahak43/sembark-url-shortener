# 🔗 Laravel Multi-Role URL Shortener System

A Laravel 10-based multi-role URL shortener application supporting **SuperAdmin**, **Admin**, and **Member** roles. Each role has specific access levels, and users can generate and manage short URLs within their company context.

---

## ✨ Features

- 👤 **Multi-role Authentication** (SuperAdmin, Admin, Member)
- 🏢 **Company-based Access Control**
- 🔗 **Short URL Generation & Redirection**
- 📊 **Stats Dashboard** (Users, URLs, Hits)
- 📁 **User Invitation System**
- 🔍 **Filter by Date** (Today, Week, Month)
- 📥 **Download URLs (Print View)**

---

## 🛠 Tech Stack

- Laravel 10
- Blade (with Bootstrap 5)
- MySQL
- PHP 8.x

---

## 🚀 Setup Instructions

### 1. Clone the Repository

```bash
- git clone https://github.com/your-username/url-shortener-app.git
- cd url-shortener-app


## Create DataBase 
- Database Name :  sembark (You can set up as per the env file)

## Install Dependencies & Migrate DB
- composer install
- php artisan key:generate
- php artisan migrate
- php artisan db:seed
- php artisan serve

## Open in browser:

- http://127.0.0.1:8000
- Credentials 
    Email : superadmin@example.com
    Password : password
