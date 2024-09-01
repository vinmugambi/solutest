<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Tour;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class BookTourTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_creates_a_booking_for_a_valid_tour_with_available_slots()
    {
        /** @var \App\Models\User $user */

        $user = User::factory()->create();
        $tour = Tour::factory()->create(['slots' => 10]);

        $response = $this->actingAs($user)->postJson(route('book.tour', $tour->id));

        $response->assertStatus(200);
        $response->assertJsonStructure(['id', 'user_id', 'tour_id', 'status', 'created_at', 'updated_at']);

        $this->assertDatabaseHas('bookings', [
            'user_id' => $user->id,
            'tour_id' => $tour->id,
            'status'  => 'pending',
        ]);

        $this->assertEquals(9, $tour->fresh()->slots);
    }

    #[Test]
    public function it_returns_400_if_no_slots_are_available()
    {
        /** @var \App\Models\User $user */

        $user = User::factory()->create();
        $tour = Tour::factory()->create(['slots' => 0]);

        $response = $this->actingAs($user)->postJson(route('book.tour', $tour->id));

        $response->assertStatus(400);
        $response->assertJson(['error' => 'No slots available']);

        $this->assertDatabaseMissing('bookings', [
            'tour_id' => $tour->id,
        ]);

        $this->assertEquals(0, $tour->fresh()->slots);
    }

    #[Test]
    public function it_requires_authentication_to_create_a_booking()
    {
        $tour = Tour::factory()->create(['slots' => 10]);

        $response = $this->postJson(route('book.tour', $tour->id));

        $response->assertStatus(401); // Unauthorized status

        $this->assertDatabaseMissing('bookings', [
            'tour_id' => $tour->id,
        ]);
    }
}
