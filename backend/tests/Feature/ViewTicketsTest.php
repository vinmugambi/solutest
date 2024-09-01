<?php

namespace Tests\Feature;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ViewTicketsTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
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
}
