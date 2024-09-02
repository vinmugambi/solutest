<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewBookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_any_booking()
    {
        /** @var \App\Models\User $admin */
        $admin = User::factory()->create(['role' => 'admin']);
        $booking = Booking::factory()->create();

        $response = $this->actingAs($admin)->getJson("/api/bookings/{$booking->id}");

        $response->assertStatus(200)
            ->assertJson($booking->toArray());
    }

    public function test_user_can_view_their_own_booking()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create(['role' => 'user']);
        $booking = Booking::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->getJson("/api/bookings/{$booking->id}");

        $response->assertStatus(200)
            ->assertJson($booking->toArray());
    }

    public function test_user_cannot_view_another_users_booking()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create(['role' => 'user']);
        $otherUser = User::factory()->create(['role' => 'user']);
        $booking = Booking::factory()->create(['user_id' => $otherUser->id]);

        $response = $this->actingAs($user)->getJson("/api/bookings/{$booking->id}");

        $response->assertStatus(403)
            ->assertJson(['error' => 'Unauthorized']);
    }
}
