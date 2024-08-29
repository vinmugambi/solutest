<?php

namespace Tests\Feature;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ViewTicketsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admins_can_view_all_tickets()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'user']);
        Ticket::factory()->count(5)->create();

        // Admin can view all tickets
        $this->actingAs($admin)
            ->get('/tickets')
            ->assertStatus(200)
            ->assertJsonCount(5);

        // Non-admin users cannot view all tickets
        $this->actingAs($user)
            ->get('/tickets')
            ->assertStatus(403);
    }
}
