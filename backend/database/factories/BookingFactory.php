<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\User;
use App\Models\Tour;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */

class BookingFactory extends Factory
{
    protected $model = Booking::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'tour_id' => Tour::factory(),
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'cancelled']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
