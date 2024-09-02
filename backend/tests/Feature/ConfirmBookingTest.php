<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Tour;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ConfirmBookingTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function only_admin_can_confirm_booking()
    {
        /** @var \App\Models\User $admin */
        $admin = User::factory()->create(['role' => 'admin']);
        /** @var \App\Models\User $user */

        $user = User::factory()->create(['role' => 'user']);
        $tour = Tour::factory()->create(['slots' => 5]);
        $booking = Booking::factory()->create(['user_id' => $user->id, 'tour_id' => $tour->id, 'status' => 'pending']);

        // Attempt to confirm booking as a regular user
        $response = $this->actingAs($user)->postJson(route('bookings.confirm', $booking));
        $response->assertStatus(403);
        $this->assertEquals('pending', $booking->fresh()->status);

        // Confirm booking as an admin
        $response = $this->actingAs($admin)->postJson(route('bookings.confirm', $booking));
        $response->assertStatus(200);
        $this->assertEquals('confirmed', $booking->fresh()->status);
    }

    #[Test]
    public function it_returns_error_for_invalid_booking()
    {
        /** @var \App\Models\User $admin */
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->postJson(route('bookings.confirm', ['booking' => 999])); // Non-existent booking ID
        $response->assertStatus(404);
    }
}
