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
        /** @var \App\Models\User $admin */
        $admin = User::factory()->create(['role' => 'admin']);
        Ticket::factory()->count(5)->create();

        $this->actingAs($admin)
            ->get('/tickets')
            ->assertStatus(200)
            ->assertJsonCount(5);
    }

    public function non_admins_can_only_view_their_own_tickets()
    {
        /** @var \App\Models\User $user*/
        $user = User::factory()->create(['role' => 'user']);
        Ticket::factory()->count(5)->create();

        $this->actingAs($user)
            ->get('/tickets')
            ->assertStatus(403);
    }
}
