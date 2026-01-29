<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Categories (Wese hi rakhi hain jese aapne di thin)
        $categories = [
            ['name' => 'Fiction', 'slug' => 'fiction'],
            ['name' => 'Science & Tech', 'slug' => 'science-tech'], // Thoda slug fix kiya (space hata diya)
            ['name' => 'History', 'slug' => 'history'],
            ['name' => 'Biography', 'slug' => 'biography'],
            ['name' => 'Technology', 'slug' => 'technology'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['slug' => $cat['slug']], $cat);
        }

        // 2. Admin User Create (UPDATED for Direct Login)
        // Password: 12345678
        User::firstOrCreate(
            ['email' => 'admin@gmail.com'], // Check karega ke ye email pehle se to nahi?
            [
                'name'     => 'Super Admin',
                'password' => Hash::make('12345678'), // Password set kiya
                'role'     => 'admin',   // 👈 IMPORTANT: 'is_admin' ki jagah 'role' lagaya
                'status'   => 'active'   // 👈 IMPORTANT: Direct Active status
            ]
        );
        
        // (Optional) Ek normal User bhi bana dete hain testing ke liye
        User::firstOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name'     => 'Test User',
                'password' => Hash::make('12345678'),
                'role'     => 'user',
                'status'   => 'active'
            ]
        );
    }
}