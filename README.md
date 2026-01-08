# 🛒 ShopEasy - Online Shopping Management System

<div align="center">
  <img src="https://img.shields.io/badge/Laravel-12.44.0-red?style=for-the-badge&logo=laravel" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.2+-blue?style=for-the-badge&logo=php" alt="PHP">
  <img src="https://img.shields.io/badge/MySQL-8.0-orange?style=for-the-badge&logo=mysql" alt="MySQL">
  <img src="https://img.shields.io/badge/Bootstrap-5.3-purple?style=for-the-badge&logo=bootstrap" alt="Bootstrap">
  <img src="https://img.shields.io/badge/License-MIT-green?style=for-the-badge" alt="License">
</div>

---

## 📋 Description

**ShopEasy** is a full-stack e-commerce platform built with Laravel 12 that provides a complete online shopping experience. This application allows customers to browse products by categories, add items to their cart, place orders, and track their purchase history. Administrators can manage products, categories, orders, and monitor sales analytics through a dedicated admin panel.

### Why It's Useful

- **Complete E-commerce Solution**: Ready-to-deploy shopping platform with all essential features
- **User-Friendly Interface**: Modern, responsive design with intuitive navigation
- **Secure Transactions**: Database-driven architecture with proper authentication and authorization
- **Real-time Inventory**: Automatic stock management and order tracking
- **Admin Dashboard**: Comprehensive management tools for business operations
- **Scalable Architecture**: Built on Laravel framework for easy maintenance and expansion

---

## ✨ Features

### 👥 Customer Features
- 🏠 **Product Browsing** - View all products with detailed information
- 🔍 **Category Filtering** - Filter products by Electronics, Clothing, Books, Home & Kitchen, Sports
- 🛒 **Shopping Cart** - Add, update, and remove items from cart
- 💳 **Checkout Process** - Secure order placement with shipping details
- 📦 **Order History** - Track all past and current orders with status
- 👤 **User Authentication** - Secure registration and login system
- 📱 **Responsive Design** - Works seamlessly on desktop, tablet, and mobile

### 🔧 Admin Features
- 📊 **Admin Dashboard** - Real-time statistics (products, orders, users, revenue)
- 📦 **Product Management** - Create, read, update, delete (CRUD) products
- 🏷️ **Category Management** - Organize products into categories
- 📋 **Order Management** - View and update order status (pending, processing, completed, cancelled)
- 👥 **User Overview** - Monitor registered users
- 💰 **Revenue Tracking** - View total sales and order analytics

### 🔒 Security Features
- ✅ CSRF Protection on all forms
- ✅ SQL Injection prevention with Eloquent ORM
- ✅ Password hashing with bcrypt
- ✅ Middleware authentication
- ✅ Role-based access control (User/Admin)
- ✅ Database transactions for data integrity

---

## 🛠️ Technologies Used

### Backend
- **PHP** `8.2+` - Server-side scripting language
- **Laravel** `12.44.0` - Modern PHP framework (MVC architecture)
- **MySQL** `8.0` - Relational database management
- **Composer** - Dependency management

### Frontend
- **Blade Templates** - Laravel's templating engine
- **Bootstrap** `5.3` - Responsive CSS framework
- **Font Awesome** `6.4` - Icon library
- **JavaScript (ES6+)** - Client-side interactivity

### Development Tools
- **XAMPP** - Local development environment
- **Git** - Version control
- **Artisan** - Laravel command-line tool
- **PHPUnit** - Testing framework

---

## 📥 Installation

### Prerequisites
- PHP >= 8.2
- Composer
- MySQL 8.0+
- XAMPP or similar local server environment

### Step-by-Step Setup

#### 1. Clone the Repository
```bash
git clone https://github.com/yourusername/online-shopping-management.git
cd online-shopping-management
```

#### 2. Install Dependencies
```bash
composer install
```

#### 3. Environment Configuration
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

#### 4. Configure Database
Edit `.env` file with your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=online_shopping_management
DB_USERNAME=root
DB_PASSWORD=
```

#### 5. Create Database
```bash
# Windows (XAMPP)
C:\xampp\mysql\bin\mysql.exe -u root -e "CREATE DATABASE online_shopping_management;"

# Linux/Mac
mysql -u root -p -e "CREATE DATABASE online_shopping_management;"
```

#### 6. Run Migrations
```bash
php artisan migrate
```

#### 7. Seed Database (Optional - Sample Data)
```bash
php artisan db:seed
```

#### 8. Start Development Server
```bash
php artisan serve
```

The application will be available at **http://127.0.0.1:8000**

---

## 🚀 Usage

### Starting the Application

#### Development Server
```bash
# Navigate to project directory
cd c:\xampp\htdocs\online_shopping_management

# Start Laravel development server
php artisan serve

# Server will run at: http://127.0.0.1:8000
```

#### Accessing the Platform

**🌐 Customer Portal**
```
URL: http://127.0.0.1:8000
- Browse products
- Register new account or login
- Add products to cart
- Place orders
```

**🔐 Admin Panel**
```
URL: http://127.0.0.1:8000/admin/dashboard
Email: admin@admin.com
Password: admin123
```

**👤 Test User Account**
```
Email: user@test.com
Password: password
```

### Common Commands

```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear

# Database operations
php artisan migrate:fresh       # Reset database
php artisan db:seed            # Seed sample data
php artisan migrate:fresh --seed  # Reset and seed

# View all routes
php artisan route:list

# Run tests
php artisan test
```

---

## 💻 Code Examples

### Creating a New Product (Admin)

**Controller: `app/Http/Controllers/AdminController.php`**
```php
public function storeProduct(Request $request)
{
    $request->validate([
        'category_id' => 'required|exists:categories,id',
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'image' => 'nullable|url|max:500',
    ]);

    Product::create($request->all());

    return redirect()->route('admin.products')
        ->with('success', 'Product created successfully!');
}
```

### Adding Item to Cart (User)

**Controller: `app/Http/Controllers/CartController.php`**
```php
public function add(Request $request, $productId)
{
    $product = Product::findOrFail($productId);

    // Check if product already in cart
    $cartItem = Cart::where('user_id', Auth::id())
        ->where('product_id', $productId)
        ->first();

    if ($cartItem) {
        $cartItem->quantity += $request->input('quantity', 1);
        $cartItem->save();
    } else {
        Cart::create([
            'user_id' => Auth::id(),
            'product_id' => $productId,
            'quantity' => $request->input('quantity', 1),
        ]);
    }

    return redirect()->route('cart.index')
        ->with('success', 'Product added to cart!');
}
```

### Placing an Order (User)

**Controller: `app/Http/Controllers/OrderController.php`**
```php
public function placeOrder(Request $request)
{
    $request->validate([
        'shipping_address' => 'required|string',
        'phone' => 'required|string|max:15',
    ]);

    $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
    $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

    DB::beginTransaction();
    try {
        // Create Order
        $order = Order::create([
            'user_id' => Auth::id(),
            'total_amount' => $total,
            'status' => 'pending',
            'shipping_address' => $request->shipping_address,
            'phone' => $request->phone,
        ]);

        // Create Order Items & Update Stock
        foreach ($cartItems as $cartItem) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->product->price,
            ]);

            $product = Product::find($cartItem->product_id);
            $product->stock -= $cartItem->quantity;
            $product->save();
        }

        Cart::where('user_id', Auth::id())->delete();
        DB::commit();

        return redirect()->route('orders.index')
            ->with('success', 'Order placed successfully!');
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Failed to place order. Please try again.');
    }
}
```

### Fetching Products with Category (View)

**Blade Template: `resources/views/home.blade.php`**
```php
@foreach($products as $product)
    <div class="card h-100">
        <div class="card-body">
            <img src="{{ $product->image }}" alt="{{ $product->name }}">
            <span class="badge">{{ $product->category->name }}</span>
            <h6>{{ $product->name }}</h6>
            <span class="price">₹{{ number_format($product->price, 2) }}</span>
            
            @auth
                @if($product->stock > 0)
                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            Add to Cart
                        </button>
                    </form>
                @endif
            @else
                <a href="{{ route('login') }}" class="btn btn-primary">
                    Login to Buy
                </a>
            @endauth
        </div>
    </div>
@endforeach
```

---

## 📁 Folder Structure

```
online_shopping_management/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AdminAuthController.php    # Admin authentication
│   │   │   ├── AdminController.php        # Admin panel operations (products, categories, orders)
│   │   │   ├── AuthController.php         # User authentication (login, register, logout)
│   │   │   ├── CartController.php         # Shopping cart management
│   │   │   ├── Controller.php             # Base controller
│   │   │   ├── HomeController.php         # Homepage with product listing
│   │   │   ├── OrderController.php        # Order placement and history
│   │   │   └── ProductController.php      # Product details and filtering
│   │   │
│   │   └── Middleware/
│   │       └── AdminMiddleware.php        # Admin role verification
│   │
│   ├── Models/
│   │   ├── Admin.php                      # Admin user model
│   │   ├── Cart.php                       # Shopping cart model
│   │   ├── Category.php                   # Product category model
│   │   ├── Order.php                      # Order model
│   │   ├── OrderItem.php                  # Order items model
│   │   ├── Product.php                    # Product model
│   │   └── User.php                       # Customer user model
│   │
│   └── Providers/
│       └── AppServiceProvider.php         # Service providers
│
├── bootstrap/
│   ├── app.php                            # Application bootstrapping
│   ├── providers.php                      # Provider configuration
│   └── cache/                             # Bootstrap cache
│
├── config/
│   ├── app.php                            # Application configuration
│   ├── auth.php                           # Authentication settings
│   ├── database.php                       # Database connections
│   ├── session.php                        # Session configuration
│   └── ...                                # Other config files
│
├── database/
│   ├── migrations/
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 2026_01_05_094036_create_categories_table.php
│   │   ├── 2026_01_05_094037_create_products_table.php
│   │   ├── 2026_01_05_094038_create_carts_table.php
│   │   ├── 2026_01_05_094039_create_orders_table.php
│   │   ├── 2026_01_05_094040_create_order_items_table.php
│   │   └── 2026_01_05_094041_create_admins_table.php
│   │
│   └── seeders/
│       └── DatabaseSeeder.php             # Sample data (admin, users, products)
│
├── public/
│   ├── index.php                          # Application entry point
│   └── ...                                # Public assets
│
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   ├── app.blade.php              # Main customer layout
│   │   │   └── admin.blade.php            # Admin panel layout
│   │   │
│   │   ├── admin/
│   │   │   ├── dashboard.blade.php        # Admin dashboard
│   │   │   ├── categories/                # Category management views
│   │   │   ├── products/                  # Product management views
│   │   │   └── orders/                    # Order management views
│   │   │
│   │   ├── auth/
│   │   │   ├── login.blade.php            # User login page
│   │   │   └── register.blade.php         # User registration page
│   │   │
│   │   ├── cart/
│   │   │   └── index.blade.php            # Shopping cart page
│   │   │
│   │   ├── orders/
│   │   │   ├── checkout.blade.php         # Checkout page
│   │   │   ├── index.blade.php            # Order history
│   │   │   └── show.blade.php             # Order details
│   │   │
│   │   ├── products/
│   │   │   └── show.blade.php             # Product details page
│   │   │
│   │   └── home.blade.php                 # Homepage
│   │
│   ├── css/
│   │   └── app.css                        # Custom styles
│   │
│   └── js/
│       └── app.js                         # JavaScript code
│
├── routes/
│   ├── web.php                            # Web routes (all application routes)
│   └── console.php                        # Artisan commands
│
├── storage/
│   ├── app/                               # File storage
│   ├── framework/                         # Framework cache
│   └── logs/                              # Application logs
│
├── tests/
│   ├── Feature/                           # Feature tests
│   └── Unit/                              # Unit tests
│
├── vendor/                                # Composer dependencies
│
├── .env                                   # Environment configuration
├── .env.example                           # Example environment file
├── artisan                                # Laravel CLI tool
├── composer.json                          # PHP dependencies
├── composer.lock                          # Locked dependency versions
├── package.json                           # Node.js dependencies
├── phpunit.xml                            # PHPUnit configuration
├── README.md                              # This file
└── vite.config.js                         # Vite configuration
```

### Key Directories Explained

- **`app/Http/Controllers/`** - Handles HTTP requests and business logic
- **`app/Models/`** - Database models using Eloquent ORM
- **`database/migrations/`** - Database schema definitions
- **`resources/views/`** - Blade templates for frontend
- **`routes/web.php`** - Defines all application routes
- **`public/`** - Publicly accessible files (entry point)
- **`storage/logs/`** - Application error logs

---

## 📸 Screenshots

### 🏠 Homepage - Product Listing
![Homepage](https://via.placeholder.com/800x450/4f46e5/ffffff?text=ShopEasy+Homepage+-+Product+Grid+with+Category+Filters)

*Modern, responsive product grid with category filtering and search capabilities*

---

### 📦 Product Details
![Product Details](https://via.placeholder.com/800x450/10b981/ffffff?text=Product+Details+-+Image+Price+Stock+Add+to+Cart)

*Detailed product view with image, description, price, stock status, and add-to-cart functionality*

---

### 🛒 Shopping Cart
![Shopping Cart](https://via.placeholder.com/800x450/f59e0b/ffffff?text=Shopping+Cart+-+Items+Quantity+Total+Checkout)

*Interactive shopping cart with quantity adjustment and total calculation*

---

### 💳 Checkout Process
![Checkout](https://via.placeholder.com/800x450/ef4444/ffffff?text=Checkout+-+Shipping+Address+Payment+Confirmation)

*Secure checkout with shipping information and order summary*

---

### 📋 Order History
![Order History](https://via.placeholder.com/800x450/8b5cf6/ffffff?text=Order+History+-+Track+All+Orders+Status)

*Complete order tracking with status updates*

---

### 🔐 Admin Dashboard
![Admin Dashboard](https://via.placeholder.com/800x450/1f2937/ffffff?text=Admin+Dashboard+-+Statistics+Revenue+Recent+Orders)

*Comprehensive admin panel with real-time business analytics*

---

### ⚙️ Admin Product Management
![Admin Products](https://via.placeholder.com/800x450/6366f1/ffffff?text=Admin+Products+-+CRUD+Operations+Inventory)

*Full CRUD operations for product and category management*

---

## 🤝 Contributing

We welcome contributions to improve ShopEasy! Here's how you can help:

### How to Contribute

1. **Fork the Repository**
   ```bash
   git clone https://github.com/yourusername/online-shopping-management.git
   cd online-shopping-management
   git checkout -b feature/your-feature-name
   ```

2. **Create a Feature Branch**
   ```bash
   git checkout -b feature/amazing-feature
   ```

3. **Make Your Changes**
   - Write clean, well-documented code
   - Follow Laravel coding standards
   - Add tests for new features
   - Update documentation as needed

4. **Commit Your Changes**
   ```bash
   git add .
   git commit -m "Add: Amazing new feature"
   ```

5. **Push to Your Fork**
   ```bash
   git push origin feature/amazing-feature
   ```

6. **Open a Pull Request**
   - Provide a clear description of changes
   - Reference any related issues
   - Wait for code review

### Contribution Guidelines

- 📝 **Code Style**: Follow PSR-12 coding standards
- ✅ **Testing**: Add PHPUnit tests for new features
- 📖 **Documentation**: Update README for significant changes
- 🐛 **Bug Reports**: Use GitHub Issues with detailed reproduction steps
- 💡 **Feature Requests**: Discuss in Issues before implementing

### Areas for Contribution

- 🎨 UI/UX improvements
- 🔒 Security enhancements
- 📱 Mobile responsiveness
- 🌐 Multi-language support
- 💳 Payment gateway integration
- 📊 Advanced analytics
- 🔍 Search functionality
- ⭐ Product ratings and reviews

---

## 📄 License

This project is licensed under the **MIT License**.

```
MIT License

Copyright (c) 2026 ShopEasy Team

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```

### What This Means

✅ **Free to use** for personal and commercial projects  
✅ **Modify** the code as needed  
✅ **Distribute** copies of the software  
✅ **Sublicense** to others  
❗ **No warranty** - use at your own risk  

---

## 👨‍💻 Author / Contact

### Developer Information

**Name:** ShopEasy Development Team  
**Project:** Online Shopping Management System  
**Version:** 1.0.0  
**Year:** 2026

### 📫 Get in Touch

- 🌐 **Website:** [https://shopeasy-demo.com](https://shopeasy-demo.com)
- 📧 **Email:** support@shopeasy.com
- 💼 **GitHub:** [@yourusername](https://github.com/yourusername)
- 🐦 **Twitter:** [@shopeasy_dev](https://twitter.com/shopeasy_dev)
- 💬 **Discord:** [Join our community](https://discord.gg/shopeasy)

### 🙏 Acknowledgments

Built with:
- [Laravel](https://laravel.com/) - The PHP Framework for Web Artisans
- [Bootstrap](https://getbootstrap.com/) - Responsive CSS Framework
- [Font Awesome](https://fontawesome.com/) - Icon Library
- [MySQL](https://www.mysql.com/) - Database Management System

Special thanks to the open-source community for their invaluable contributions!

---

## 🎯 Roadmap

### Upcoming Features

- [ ] Payment Gateway Integration (Stripe, PayPal, Razorpay)
- [ ] Product Reviews & Ratings
- [ ] Wishlist Functionality
- [ ] Email Notifications
- [ ] Advanced Search & Filters
- [ ] Coupon & Discount System
- [ ] Multi-language Support
- [ ] Product Recommendations (AI)
- [ ] Live Chat Support
- [ ] Mobile Application (Flutter/React Native)

---

## ❓ FAQ

**Q: How do I reset my admin password?**  
A: Use `php artisan tinker` and run:
```php
$admin = App\Models\Admin::where('email', 'admin@admin.com')->first();
$admin->password = bcrypt('newpassword');
$admin->save();
```

**Q: Can I use this for commercial projects?**  
A: Yes! The MIT license allows commercial use.

**Q: How do I add more products?**  
A: Login as admin and use the Admin Panel → Products → Create New Product

**Q: The images are not showing?**  
A: Ensure you have internet connection (using placeholder images) or upload local images to `storage/app/public/`

**Q: How do I enable email notifications?**  
A: Configure MAIL settings in `.env` file with your SMTP credentials

---

## 🐛 Troubleshooting

### Common Issues

**Problem:** 500 Internal Server Error  
**Solution:** 
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

**Problem:** Database connection error  
**Solution:** Check `.env` file database credentials and ensure MySQL is running

**Problem:** Session table not found  
**Solution:** 
```bash
php artisan migrate
```

**Problem:** Permission denied errors  
**Solution:** 
```bash
chmod -R 775 storage bootstrap/cache
```

---

<div align="center">

### ⭐ Star this repository if you find it helpful!

**Made with ❤️ using Laravel**

[Report Bug](https://github.com/yourusername/online-shopping-management/issues) · 
[Request Feature](https://github.com/yourusername/online-shopping-management/issues) · 
[Documentation](https://github.com/yourusername/online-shopping-management/wiki)

</div>
