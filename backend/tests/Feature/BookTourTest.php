<?php

namespace Tests\Feature;

use App\Models\Tour;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class BookTourTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_books_a_single_seat_when_no_seats_are_provided()
    {
        /** @var \App\Models\User $user*/
        $user = User::factory()->create();
        $tour = Tour::factory()->create(['slots' => 5]);

        $response = $this->actingAs($user)->postJson(route('tour.book', $tour));

        $response->assertStatus(201);
        $this->assertDatabaseHas('bookings', [
            'user_id' => $user->id,
            'tour_id' => $tour->id,
            'status'  => 'pending',
        ]);
        $this->assertDatabaseHas('tours', [
            'id' => $tour->id,
            'slots' => 4, // 5 - 1 seat
        ]);
        $this->assertDatabaseCount('tickets', 1);
    }

    #[Test]
    public function it_books_multiple_seats_and_decrements_slots_accordingly()
    {
        /** @var \App\Models\User $user*/
        $user = User::factory()->create();
        $tour = Tour::factory()->create(['slots' => 5]);

        $response = $this->actingAs($user)->postJson(route('tour.book', $tour), [
            'seats' => 3,
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('bookings', [
            'user_id' => $user->id,
            'tour_id' => $tour->id,
            'status'  => 'pending',
        ]);
        $this->assertDatabaseHas('tours', [
            'id' => $tour->id,
            'slots' => 2, // 5 - 3 seats
        ]);
        $this->assertDatabaseCount('tickets', 3);
    }

    #[Test]
    public function it_returns_an_error_if_not_enough_slots_are_available()
    {
        /** @var \App\Models\User $user*/
        $user = User::factory()->create();
        $tour = Tour::factory()->create(['slots' => 2]);

        $response = $this->actingAs($user)->postJson(route('tour.book', $tour), [
            'seats' => 3,
        ]);

        $response->assertStatus(400);
        $response->assertJson(['error' => 'Not enough slots available']);
        $this->assertDatabaseHas('tours', [
            'id' => $tour->id,
            'slots' => 2, // No change since the booking failed
        ]);
        $this->assertDatabaseCount('tickets', 0);
    }
}
