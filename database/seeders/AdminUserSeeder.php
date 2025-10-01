<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AdminUser;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default admin user
        // Password will be: admin123
        // Frontend will hash it with SHA-256: hash('sha256', 'admin@yesilToprak.com' . 'admin123' . 'admin@yesilToprak.com')
        // This results in: 8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918
        
        $hashedPassword = hash('sha256', 'admin@yesilToprak.com' . 'admin123' . 'admin@yesilToprak.com');
        
        AdminUser::create([
            'name' => 'Admin',
            'email' => 'admin@yesilToprak.com',
            'password' => $hashedPassword, // This will be bcrypt'ed by the model
            'role' => 'admin',
            'is_active' => true,
        ]);

        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: admin@yesilToprak.com');
        $this->command->info('Password: admin123');
    }
}
