<?php

namespace Database\Factories;

use App\Models\Destination;
use App\Models\Tour;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tour>
 */
class TourFactory extends Factory
{
    protected $model = Tour::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'destination_id' => Destination::factory(),
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 100, 10000),
            'slots' => $this->faker->numberBetween(10, 20),
            'capacity' => $this->faker->numberBetween(20, 50),
            'image' => "https://letsdrift.co.ke/wp-content/uploads/2024/04/82.jpg",
            'start_time' => $this->faker->dateTimeBetween('now', '+30 years'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
