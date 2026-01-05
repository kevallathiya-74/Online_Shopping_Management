<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
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
        // Create Admin User
        Admin::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin123'),
        ]);

        // Create Test User
        User::create([
            'name' => 'John Doe',
            'email' => 'user@test.com',
            'password' => Hash::make('password'),
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
            ['category_id' => 1, 'name' => 'Laptop', 'description' => 'High-performance laptop', 'price' => 45000, 'stock' => 10, 'image' => 'https://via.placeholder.com/300x300?text=Laptop'],
            ['category_id' => 1, 'name' => 'Smartphone', 'description' => 'Latest smartphone model', 'price' => 25000, 'stock' => 15, 'image' => 'https://via.placeholder.com/300x300?text=Smartphone'],
            ['category_id' => 1, 'name' => 'Headphones', 'description' => 'Wireless headphones', 'price' => 2500, 'stock' => 20, 'image' => 'https://via.placeholder.com/300x300?text=Headphones'],
            
            // Clothing
            ['category_id' => 2, 'name' => 'T-Shirt', 'description' => 'Cotton t-shirt', 'price' => 500, 'stock' => 50, 'image' => 'https://via.placeholder.com/300x300?text=T-Shirt'],
            ['category_id' => 2, 'name' => 'Jeans', 'description' => 'Denim jeans', 'price' => 1500, 'stock' => 30, 'image' => 'https://via.placeholder.com/300x300?text=Jeans'],
            ['category_id' => 2, 'name' => 'Jacket', 'description' => 'Winter jacket', 'price' => 3000, 'stock' => 25, 'image' => 'https://via.placeholder.com/300x300?text=Jacket'],
            
            // Books
            ['category_id' => 3, 'name' => 'PHP Programming', 'description' => 'Learn PHP from scratch', 'price' => 600, 'stock' => 40, 'image' => 'https://via.placeholder.com/300x300?text=PHP+Book'],
            ['category_id' => 3, 'name' => 'Laravel Guide', 'description' => 'Master Laravel framework', 'price' => 800, 'stock' => 35, 'image' => 'https://via.placeholder.com/300x300?text=Laravel+Book'],
            
            // Home & Kitchen
            ['category_id' => 4, 'name' => 'Microwave Oven', 'description' => 'Convection microwave', 'price' => 8000, 'stock' => 12, 'image' => 'https://via.placeholder.com/300x300?text=Microwave'],
            ['category_id' => 4, 'name' => 'Blender', 'description' => 'High-speed blender', 'price' => 2000, 'stock' => 18, 'image' => 'https://via.placeholder.com/300x300?text=Blender'],
            
            // Sports
            ['category_id' => 5, 'name' => 'Cricket Bat', 'description' => 'Professional cricket bat', 'price' => 3500, 'stock' => 8, 'image' => 'https://via.placeholder.com/300x300?text=Cricket+Bat'],
            ['category_id' => 5, 'name' => 'Football', 'description' => 'Official size football', 'price' => 1000, 'stock' => 25, 'image' => 'https://via.placeholder.com/300x300?text=Football'],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
