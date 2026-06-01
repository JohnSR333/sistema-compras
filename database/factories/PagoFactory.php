<?php

namespace Database\Factories;

use App\Models\Pago;
use App\Models\Ordencompra;
use App\Models\Metodopago;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pago>
 */
class PagoFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ordencompra_id' => $this->faker->randomElement(\App\Models\Ordencompra::pluck('id')->toArray()),
            'fechapago' => $this->faker->datetime(),
            'monto' => $this->faker->randomFloat(2, 50, 500),
            'metodopago_id' => $this->faker->randomElement(\App\Models\Metodopago::pluck('id')->toArray()),
            'registradopor' => $this->faker->randomElement(config('datos.registradopor')),
        ];
    }
}
