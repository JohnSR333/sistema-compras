<?php

namespace Database\Factories;

use App\Models\Proveedor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Proveedor>
 */
class ProveedorFactory extends Factory
{
    protected $model = Proveedor::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            
            'nombre'=> $this->faker->name(),
            'documento'=> $this->faker->numberBetween(1000000, 9999999999),
            'direccion'=> $this->faker->address(),
            'telefono'=> $this->faker->phoneNumber(),
            'email'=> $this->faker->unique()->safeEmail(),
            'estado'=> '1',
            'registradopor'=> $this->faker->randomElement(config('datos.registradopor')),
            
        ];
    }
}
