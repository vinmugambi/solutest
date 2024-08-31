<?php

namespace Tests\Feature;

use App\Models\Tour;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ListToursTest extends TestCase
{
    use RefreshDatabase;

    public function unauthenticated_can_lists_tours()
    {

        Tour::factory()->count(10)->create();

        $response = $this->get("/tours");

        $response->assertStatus(200);
    }
}
