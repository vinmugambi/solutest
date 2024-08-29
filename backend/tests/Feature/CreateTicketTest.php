<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateTicketTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_a_ticket_for_a_valid_booking()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();
        $booking = Booking::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->postJson(route('ticket.booking', $booking->id));

        $response->assertStatus(200);
        $response->assertJsonStructure(['id', 'booking_id', 'ticket_number', 'created_at', 'updated_at']);

        $this->assertDatabaseHas('tickets', [
            'booking_id' => $booking->id,
        ]);

        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'status' => 'completed',
        ]);
    }

    /** @test */
    public function it_returns_403_if_the_user_is_not_authorized_to_create_ticket()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();
        $anotherUser = User::factory()->create();
        $booking = Booking::factory()->create(['user_id' => $anotherUser->id]);

        $response = $this->actingAs($user)->postJson(route('ticket.booking', $booking->id));

        $response->assertStatus(403);
        $response->assertJson(['error' => 'Unauthorized']);
    }

    /** @test */
    public function it_returns_400_if_ticket_already_exists_for_the_booking()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();
        $booking = Booking::factory()->create(['user_id' => $user->id]);
        Ticket::factory()->create(['booking_id' => $booking->id]);

        $response = $this->actingAs($user)->postJson(route('ticket.booking', $booking->id));

        $response->assertStatus(400);
        $response->assertJson(['error' => 'Ticket already generated']);
    }
}
