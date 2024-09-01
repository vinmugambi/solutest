<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ViewBookingsTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function admin_can_view_all_bookings()
    {
        /** @var \App\Models\User $admin */
        $admin = User::factory()->create(['role' => 'admin']);
        Booking::factory()->count(5)->create();

        $this->actingAs($admin)
            ->get('/bookings')
            ->assertStatus(200)
            ->assertJsonCount(5);
    }

    #[Test]
    public function users_can_only_view_their_own_bookings()
    {

        /** @var \App\Models\User $user */
        $user = User::factory()->create(["role" => "user"]);

        Booking::factory()->count(5)->create();
        Booking::factory()->create(["user_id" => $user->id]);


        $this->actingAs($user)
            ->get(route('bookings.me'))
            ->assertStatus(200)
            ->assertJsonCount(1);
    }
}
