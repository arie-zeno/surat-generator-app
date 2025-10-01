<?php

namespace Database\Factories;

use App\Models\Helper;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class HelperFactory extends Factory
{
    protected $model = Helper::class;

    public function definition(): array
    {
        return [
            'nama' => $this->faker->name(),
            'nip' => $this->faker->unique()->numberBetween(10000000, 99999999),
            'ket' => $this->faker->text(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
