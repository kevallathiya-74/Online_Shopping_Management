<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User (in users table with admin role)
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'phone' => '1234567890',
            'address' => 'Admin Address',
        ]);

        // Create Test User
        User::create([
            'name' => 'John Doe',
            'email' => 'user@test.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'phone' => '9876543210',
            'address' => '123 Main Street, City, State',
        ]);

        // Create Categories
        $categories = [
            ['name' => 'Electronics', 'description' => 'Electronic devices and gadgets'],
            ['name' => 'Clothing', 'description' => 'Fashion and apparel'],
            ['name' => 'Books', 'description' => 'Books and educational materials'],
            ['name' => 'Home & Kitchen', 'description' => 'Home appliances and kitchen items'],
            ['name' => 'Sports', 'description' => 'Sports equipment and accessories'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create Sample Products
        $products = [
            // Electronics
            ['category_id' => 1, 'name' => 'Laptop', 'description' => 'High-performance laptop', 'price' => 45000, 'stock' => 10, 'image' => 'https://placehold.co/300x300/4f46e5/ffffff?text=Laptop'],
            ['category_id' => 1, 'name' => 'Smartphone', 'description' => 'Latest smartphone model', 'price' => 25000, 'stock' => 15, 'image' => 'https://placehold.co/300x300/3b82f6/ffffff?text=Smartphone'],
            ['category_id' => 1, 'name' => 'Headphones', 'description' => 'Wireless headphones', 'price' => 2500, 'stock' => 20, 'image' => 'https://placehold.co/300x300/6366f1/ffffff?text=Headphones'],
            
            // Clothing
            ['category_id' => 2, 'name' => 'T-Shirt', 'description' => 'Cotton t-shirt', 'price' => 500, 'stock' => 50, 'image' => 'https://placehold.co/300x300/10b981/ffffff?text=T-Shirt'],
            ['category_id' => 2, 'name' => 'Jeans', 'description' => 'Denim jeans', 'price' => 1500, 'stock' => 30, 'image' => 'https://placehold.co/300x300/14b8a6/ffffff?text=Jeans'],
            ['category_id' => 2, 'name' => 'Jacket', 'description' => 'Winter jacket', 'price' => 3000, 'stock' => 25, 'image' => 'https://placehold.co/300x300/059669/ffffff?text=Jacket'],
            
            // Books
            ['category_id' => 3, 'name' => 'PHP Programming', 'description' => 'Learn PHP from scratch', 'price' => 600, 'stock' => 40, 'image' => 'https://placehold.co/300x300/f59e0b/ffffff?text=PHP+Book'],
            ['category_id' => 3, 'name' => 'Laravel Guide', 'description' => 'Master Laravel framework', 'price' => 800, 'stock' => 35, 'image' => 'https://placehold.co/300x300/ef4444/ffffff?text=Laravel+Book'],
            
            // Home & Kitchen
            ['category_id' => 4, 'name' => 'Microwave Oven', 'description' => 'Convection microwave', 'price' => 8000, 'stock' => 12, 'image' => 'https://placehold.co/300x300/8b5cf6/ffffff?text=Microwave'],
            ['category_id' => 4, 'name' => 'Blender', 'description' => 'High-speed blender', 'price' => 2000, 'stock' => 18, 'image' => 'https://placehold.co/300x300/a855f7/ffffff?text=Blender'],
            
            // Sports
            ['category_id' => 5, 'name' => 'Cricket Bat', 'description' => 'Professional cricket bat', 'price' => 3500, 'stock' => 8, 'image' => 'https://placehold.co/300x300/ec4899/ffffff?text=Cricket+Bat'],
            ['category_id' => 5, 'name' => 'Football', 'description' => 'Official size football', 'price' => 1000, 'stock' => 25, 'image' => 'https://placehold.co/300x300/f43f5e/ffffff?text=Football'],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
