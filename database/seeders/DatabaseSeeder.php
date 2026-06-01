<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Proveedor;
use App\Models\Ordencompra;
use App\Models\Detallecompra;
use App\Models\Producto;
use App\Models\Metodopago;
use App\Models\Pago;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        User::factory(10)->create();
        Proveedor::factory(10)->create();
        Ordencompra::factory(10)->create();
        Producto::factory(10)->create();
        Detallecompra::factory(10)->create();
        Metodopago::factory(3)->create();
        Pago::factory(10)->create();
        /*

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);*/
    }
}
