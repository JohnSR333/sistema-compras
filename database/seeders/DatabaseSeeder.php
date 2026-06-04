<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Crear usuario admin manualmente
        if (!User::where('email', 'admin@admin.com')->exists()) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt('12345678'),
            ]);
        }
        
        // Por ahora, comentamos los factories para evitar errores
        // User::factory(10)->create();
        // Proveedor::factory(10)->create();
        // Ordencompra::factory(10)->create();
        // Producto::factory(10)->create();
        // Detallecompra::factory(10)->create();
        // Metodopago::factory(3)->create();
        // Pago::factory(10)->create();
    }
}