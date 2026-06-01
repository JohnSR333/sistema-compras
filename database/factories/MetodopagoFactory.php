<?php

namespace Database\Factories;

use App\Models\Metodopago;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Metodopago>
 */
class MetodopagoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $metodos = [
            'efectivo',
            'tarjeta',
            'transferencia'
        ];
        return [
            'nombre' => $this->faker->randomElement($metodos),
            'descripcion' => $this->faker->sentence(),
            'estado' => '1',
            'registradopor' => $this->faker->randomElement(config('datos.registradopor')),
        ];
    }
}
