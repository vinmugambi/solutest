<?php

namespace Tests\Feature;

use App\Models\Destination;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateDestinationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_store_a_destination_and_generate_a_slug()
    {
        // Simulate a user being authenticated
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        // Define the data to be sent in the request
        $data = [
            'name' => 'Maasai Mara',
            'description' => 'A beautiful national park in Kenya.'
        ];

        // Send a POST request to store the destination
        $response = $this->postJson('/api/destinations', $data);

        // Assert the destination was created successfully
        $response->assertStatus(201)
            ->assertJson([
                'name' => 'Maasai Mara',
                'slug' => 'maasai-mara',
                'description' => 'A beautiful national park in Kenya.'
            ]);

        // Ensure the destination was stored in the database
        $this->assertDatabaseHas('destinations', [
            'name' => 'Maasai Mara',
            'slug' => 'maasai-mara',
            'description' => 'A beautiful national park in Kenya.'
        ]);
    }
}
