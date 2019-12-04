<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RouteTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */ 
    public function testExample()
    {
        // $response = $this->get('/divisions');
        // $response->assertStatus(200);

        $response = $this->json('POST', '/divisions', 
            [
                'name' => 'Dhaka',
                'country_id' => 1,
                'isActive' => 1,
                'isDefault' => 1
            ]);

        $response->assertStatus(201);
            // ->assertJson([
            //     'created' => true,
            // ]);
    }
}
