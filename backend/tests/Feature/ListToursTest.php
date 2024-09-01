<?php

namespace Tests\Feature;

use App\Models\Destination;
use App\Models\Tour;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ListToursTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function unauthenticated_can_lists_tours()
    {

        Tour::factory()->count(10)->create();

        $response = $this->get("/tours");

        $response->assertStatus(200);
    }

    #[Test]
    public function unauthenticated_can_view_single_tour()
    {
        $tour = Tour::factory()->create();

        $response = $this->get("/tours", ["id" => $tour->id]);

        $response->assertStatus(200);
    }

    #[Test]
    public function unauthenticated_can_retrieve_all_destinations()
    {
        $tour = Destination::factory()->create();

        $response = $this->get("/tours", ["id" => $tour->id]);

        $response->assertStatus(200);
    }
}
