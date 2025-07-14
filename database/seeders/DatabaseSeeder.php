<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear usuario administrador
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@ecomer-web.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);

        // Crear usuario de prueba
        User::factory()->create([
            'name' => 'Cliente Demo',
            'email' => 'cliente@ecomer-web.com',
            'password' => bcrypt('cliente123'),
            'role' => 'customer',
        ]);

        // Ejecutar seeders
        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
        ]);
    }
}
