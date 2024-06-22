<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test login successful
     *
     */
    public function test_logout_successful(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $response = $this->post(route('logout'));
        $responseData = $response->json();

        $response->assertStatus(200);
        $this->assertEquals($responseData['message'], 'Logged out successfully');
    }
}
