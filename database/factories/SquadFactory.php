<?php

namespace Database\Factories;

use App\Models\Squad;
use Illuminate\Database\Eloquent\Factories\Factory;

class SquadFactory extends Factory
{
    protected $model = Squad::class;

    public function definition()
    {
        return [
            'name' => $this->faker->unique()->words(2, true),
            'description' => $this->faker->sentence(),
            'status' => $this->faker->randomElement(['on-progress', 'pengajuan', 'diterima']),
        ];
    }
}
