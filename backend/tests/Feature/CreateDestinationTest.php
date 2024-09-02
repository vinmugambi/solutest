<?php

namespace Tests\Feature;

use App\Models\Destination;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CreateDestinationTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_store_a_destination_and_generate_a_slug()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $data = [
            'name' => 'Maasai Mara',
            'description' => 'A beautiful national park in Kenya.'
        ];

        $response = $this->postJson('/api/destinations', $data);

        $response->assertStatus(201)
            ->assertJson([
                'name' => 'Maasai Mara',
                'slug' => 'maasai-mara',
                'description' => 'A beautiful national park in Kenya.'
            ]);

        $this->assertDatabaseHas('destinations', [
            'name' => 'Maasai Mara',
            'slug' => 'maasai-mara',
            'description' => 'A beautiful national park in Kenya.'
        ]);
    }
}
