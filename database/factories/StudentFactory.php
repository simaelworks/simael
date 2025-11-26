<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition()
    {
        $majors = ['PPLG', 'TJKT', 'BCF', 'DKV'];
        return [
            'name' => $this->faker->name(),
            'nisn' => $this->faker->unique()->numerify('##########'),
            'major' => $this->faker->randomElement($majors),
            'password' => bcrypt('password'),
            'status' => $this->faker->randomElement(['verified', 'pending']),
        ];
    }
}
