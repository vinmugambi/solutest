<?php

namespace Tests\Feature;

use App\Models\Destination;
use App\Models\Tour;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateTourTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admins_can_create_tours()
    {
        /** @var \App\Models\User $admin */
        $admin = User::factory()->create(['role' => 'admin']);
        $destination = Destination::factory()->create();
        $tourData = [
            'name' => 'Amazing Safari',
            'description' => 'An incredible safari experience.',
            'price' => 1500.00,
            'slots' => 10,
            'start_time' => '2025-01-12T0930',
            'destination_id' => $destination->id,
        ];

        // Admin can create a tour
        $this->actingAs($admin)
            ->post('/tours', $tourData)
            ->assertStatus(201);

        $this->assertDatabaseHas('tours', ['name' => 'Amazing Safari']);
    }

    public function non_admin_user_cannot_create_tours()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create(['role' => 'user']);

        $destination = Destination::factory()->create();

        $tourData = [
            'name' => 'Amazing Safari',
            'description' => 'An incredible safari experience.',
            'price' => 1500.00,
            'slots' => 10,
            'destination_id' => $destination->id,  // Assume destination ID 1 exists
        ];

        $this->actingAs($user)
            ->post('/tours', $tourData)
            ->assertStatus(403);

        $this->assertDatabaseMissing('tours', ['name' => 'Amazing Safari']);
    }
}
