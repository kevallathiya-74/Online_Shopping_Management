# Online Shopping Management System
**College Major Project - Laravel + MySQL**

---

## 📋 Project Overview
A complete e-commerce web application built with **Laravel Framework** and **MySQL Database** for college project demonstration.

### 🎯 Features Implemented
- User Registration & Login
- Product Catalog with Categories
- Shopping Cart Management
- Checkout & Order Placement
- Order History for Users
- Admin Panel with Login
- Product & Category Management (Admin)
- Order Management & Status Updates (Admin)

---

## 🛠️ Technologies Used
- **Backend**: Laravel 11.x (PHP Framework)
- **Database**: MySQL (via XAMPP)
- **Frontend**: Blade Templates + Bootstrap 5
- **Server**: Apache (XAMPP)
- **ORM**: Eloquent (Laravel's Database ORM)

---

## 📊 Database Structure

### Tables Created:
1. **users** - Store customer information
2. **admins** - Store admin credentials
3. **categories** - Product categories
4. **products** - Product details with foreign key to categories
5. **carts** - Shopping cart items (user_id, product_id, quantity)
6. **orders** - Order master table
7. **order_items** - Individual products in each order

### Relationships:
- **Category → Products**: One-to-Many
- **Product → Cart Items**: One-to-Many
- **User → Carts**: One-to-Many
- **User → Orders**: One-to-Many
- **Order → Order Items**: One-to-Many

---

## 🚀 Installation & Setup Guide

### Prerequisites:
✅ XAMPP installed (Apache + MySQL running)
✅ PHP 8.2 or higher
✅ Composer installed

### Step 1: Start XAMPP Services
1. Open XAMPP Control Panel
2. Start **Apache**
3. Start **MySQL**

### Step 2: Create Database
1. Open browser: `http://localhost/phpmyadmin`
2. Create new database: `online_shopping_management`
3. (No need to create tables manually - migrations will handle it)

### Step 3: Configure Environment
The `.env` file is already configured with:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=online_shopping_management
DB_USERNAME=root
DB_PASSWORD=
```

### Step 4: Run Migrations & Seed Data
Open terminal in project folder and run:
```bash
php artisan migrate:fresh --seed
```

This will:
- Create all database tables
- Insert sample data (admin, user, categories, products)

### Step 5: Start Laravel Server
```bash
php artisan serve
```

Server will start at: **http://127.0.0.1:8000**

---

## 🔐 Login Credentials

### Admin Panel
- URL: `http://127.0.0.1:8000/admin/login`
- Email: `admin@admin.com`
- Password: `admin123`

### User Account
- URL: `http://127.0.0.1:8000/login`
- Email: `user@test.com`
- Password: `password`

---

## 📂 Project Structure Explanation

```
online_shopping_management/
├── app/
│   ├── Http/Controllers/     # All business logic
│   │   ├── AuthController.php          # User Login/Register
│   │   ├── AdminAuthController.php     # Admin Login
│   │   ├── HomeController.php          # Homepage
│   │   ├── ProductController.php       # Product Display
│   │   ├── CartController.php          # Cart Management
│   │   ├── OrderController.php         # Checkout & Orders
│   │   └── AdminController.php         # Admin Dashboard & CRUD
│   │
│   └── Models/               # Database Models (Eloquent ORM)
│       ├── User.php
│       ├── Admin.php
│       ├── Category.php
│       ├── Product.php
│       ├── Cart.php
│       ├── Order.php
│       └── OrderItem.php
│
├── database/
│   ├── migrations/           # Database table structures
│   └── seeders/             # Sample data insertion
│
├── resources/views/          # Frontend Blade Templates
│   ├── layouts/             # Master layouts
│   ├── auth/                # Login & Register pages
│   ├── home.blade.php       # Product listing
│   ├── products/            # Product details
│   ├── cart/                # Shopping cart
│   ├── orders/              # Checkout & order history
│   └── admin/               # Admin panel views
│
├── routes/
│   └── web.php              # All application routes
│
└── .env                     # Environment configuration
```

---

## 🎓 How to Explain in Viva (College Exam)

### 1. **What is MVC Architecture?**
**Answer**: 
- **Model**: Handles database operations (app/Models/)
- **View**: Displays data to users (resources/views/)
- **Controller**: Contains business logic (app/Http/Controllers/)

**Example**: When user clicks "Add to Cart":
1. Route sends request to `CartController@add`
2. Controller validates and saves data to database using `Cart` model
3. Returns view with success message

---

### 2. **Explain Database Relationships**
**Answer**: 
- **One-to-Many**: One Category has many Products
  ```php
  // In Category Model
  public function products() {
      return $this->hasMany(Product::class);
  }
  ```

- **Belongs To**: Product belongs to a Category
  ```php
  // In Product Model
  public function category() {
      return $this->belongsTo(Category::class);
  }
  ```

---

### 3. **How Authentication Works?**
**Answer**:
- Used Laravel's built-in Auth system
- Separate guards for User and Admin
- Configured in `config/auth.php`
- Passwords hashed using bcrypt

**User Login Flow**:
1. User submits email/password
2. `AuthController@login` validates credentials
3. Laravel's `Auth::attempt()` checks database
4. If valid, creates session and redirects to home

---

### 4. **How Shopping Cart Works?**
**Answer**:
1. User clicks "Add to Cart"
2. System checks if product already in cart
3. If yes, updates quantity
4. If no, creates new cart entry
5. All linked to logged-in user's ID

**Code Example**:
```php
Cart::create([
    'user_id' => Auth::id(),
    'product_id' => $productId,
    'quantity' => $quantity
]);
```

---

### 5. **How Order Placement Works?**
**Answer**:
1. User goes to checkout
2. Enters shipping address and phone
3. System calculates total from cart items
4. Creates order in `orders` table
5. Moves cart items to `order_items` table
6. Updates product stock
7. Clears user's cart
8. All wrapped in database transaction (if any step fails, rollback)

---

### 6. **Why Use Eloquent ORM?**
**Answer**:
- No need to write raw SQL queries
- Prevents SQL injection attacks
- Cleaner and readable code
- Built-in relationship handling

**Example**:
```php
// Instead of: SELECT * FROM products WHERE category_id = 1
$products = Product::where('category_id', 1)->get();
```

---

### 7. **Admin vs User Separation**
**Answer**:
- Separate authentication guards in `config/auth.php`
- Admin guard uses `admins` table
- User guard uses `users` table
- Different middleware for route protection
- Admin routes prefixed with `/admin`

---

### 8. **Security Features Implemented**
**Answer**:
1. **CSRF Protection**: All forms have `@csrf` token
2. **Password Hashing**: Never store plain passwords
3. **SQL Injection Prevention**: Using Eloquent ORM
4. **Route Middleware**: Auth check before accessing protected pages
5. **Validation**: All inputs validated before processing

---

## 🎯 Key Features to Demonstrate

### User Flow:
1. Register new account
2. Browse products by category
3. View product details
4. Add to cart
5. Update cart quantities
6. Checkout and place order
7. View order history

### Admin Flow:
1. Login to admin panel
2. View dashboard statistics
3. Create/Edit/Delete categories
4. Create/Edit/Delete products
5. View all orders
6. Update order status (Pending → Processing → Completed)

---

## 📝 Important Laravel Commands

```bash
# Run migrations
php artisan migrate

# Fresh migrations (drops all tables and recreates)
php artisan migrate:fresh

# Run seeders
php artisan db:seed

# Fresh migrations + seeders
php artisan migrate:fresh --seed

# Start development server
php artisan serve

# Clear application cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

---

## 🐛 Common Issues & Solutions

### Issue 1: "Base table or view not found"
**Solution**: Run `php artisan migrate:fresh --seed`

### Issue 2: "Access denied for user 'root'@'localhost'"
**Solution**: Check MySQL is running in XAMPP, verify .env database credentials

### Issue 3: "Class 'App\Models\XXX' not found"
**Solution**: Run `composer dump-autoload`

### Issue 4: Blank page or errors
**Solution**: 
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

---

## 📚 Technologies Explained Simply

### Laravel (Framework)
- PHP framework that organizes code in MVC pattern
- Provides tools for routing, database, authentication
- Makes development faster and cleaner

### Eloquent ORM
- Object-Relational Mapping
- Work with database using PHP objects instead of SQL
- Example: `Product::all()` instead of `SELECT * FROM products`

### Blade Templates
- Laravel's templating engine
- Allows PHP code in HTML views
- Uses `@foreach`, `@if`, `@extends` directives

### Bootstrap
- CSS framework for responsive design
- Pre-built components (buttons, cards, forms)
- Makes UI look professional without custom CSS

---

## ✅ Project Completion Checklist

- ✅ Database migrations with proper relationships
- ✅ Eloquent models with fillable fields
- ✅ Controllers with simple, explainable logic
- ✅ User authentication (register, login, logout)
- ✅ Admin authentication (separate guard)
- ✅ Product listing with category filter
- ✅ Add to cart functionality
- ✅ Cart management (update, remove)
- ✅ Checkout and order placement
- ✅ Order history for users
- ✅ Admin dashboard with statistics
- ✅ Category management (CRUD)
- ✅ Product management (CRUD)
- ✅ Order management and status update
- ✅ Bootstrap UI (clean and professional)
- ✅ Sample data seeder
- ✅ All data from database (no hard-coded values)

---

## 🎉 Project Demo Flow

1. **Start**: Show homepage with products
2. **User Registration**: Create new account
3. **Browse Products**: Filter by category
4. **Add to Cart**: Add multiple products
5. **Checkout**: Complete order with address
6. **Order History**: Show placed orders
7. **Admin Login**: Switch to admin panel
8. **Dashboard**: Show statistics
9. **Manage Products**: Create/Edit/Delete
10. **Manage Orders**: Update order status

---

## 📞 Support

For any issues during project demonstration:
1. Check XAMPP services are running
2. Verify database name in .env matches phpMyAdmin
3. Run `php artisan migrate:fresh --seed` to reset database
4. Clear cache: `php artisan cache:clear`

---

## 📄 License
This is a college educational project.

---

**Developed by**: [Your Name]
**Institution**: [Your College Name]
**Project Type**: Major Project
**Year**: 2026

---

## 🎯 Quick Start Commands

```bash
# 1. Start XAMPP (Apache + MySQL)

# 2. Create database in phpMyAdmin: online_shopping_management

# 3. Run these commands:
cd c:\xampp\htdocs\online_shopping_management
php artisan migrate:fresh --seed
php artisan serve

# 4. Open browser:
# User: http://127.0.0.1:8000
# Admin: http://127.0.0.1:8000/admin/login
```

**That's it! Your project is ready to demonstrate! 🚀**
