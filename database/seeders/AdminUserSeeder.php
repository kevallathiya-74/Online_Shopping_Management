<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeder.
     *
     * @return void
     */
    public function run()
    {
        // Check if admin already exists
        $existingAdmin = User::where('email', 'admin@gmail.com')->first();
        
        if ($existingAdmin) {
            // Update existing user to admin role
            $existingAdmin->update([
                'role' => 'admin',
                'password' => Hash::make('admin123'),
            ]);
            $this->command->info('Existing user updated to admin role!');
        } else {
            // Create new admin user
            User::create([
                'name' => 'Admin User',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin123'),
                'phone' => '1234567890',
                'address' => 'Admin Address',
                'role' => 'admin',
            ]);
            $this->command->info('Admin user created successfully!');
        }
        
        $this->command->info('=====================================');
        $this->command->info('Email: admin@gmail.com');
        $this->command->info('Password: admin123');
        $this->command->info('=====================================');
    }
}
