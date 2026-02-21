<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
        ]);

        // Create regular user
        User::factory()->create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'role' => 'user',
        ]);

        // Create sample products
        Product::factory()->create([
            'name' => 'Premium Laptop',
            'description' => 'High-performance laptop with latest specs',
            'price' => 1299.99,
            'status' => 'active',
        ]);

        Product::factory()->create([
            'name' => 'Wireless Mouse',
            'description' => 'Ergonomic wireless mouse with long battery life',
            'price' => 29.99,
            'status' => 'active',
        ]);

        Product::factory()->create([
            'name' => 'Mechanical Keyboard',
            'description' => 'RGB mechanical keyboard with blue switches',
            'price' => 89.99,
            'status' => 'active',
        ]);

        Product::factory()->create([
            'name' => 'USB-C Hub',
            'description' => 'Multi-port USB-C hub with 4K HDMI output',
            'price' => 49.99,
            'status' => 'inactive',
        ]);
    }
}
