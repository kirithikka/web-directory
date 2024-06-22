<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test login successful
     *
     */
    public function test_login_successful(): void
    {
        $userPassword = 'password';
        $user = User::factory()->create([
            'password' => $userPassword
        ]);

        $request = new Request([
            'email' => $user->email,
            'password' => $userPassword,
        ]);

        $userData = $request->all();

        $response = $this->post(route('login'), $userData);
        $responseData = $response->json();

        $response->assertStatus(200);
        $this->assertNotNull($responseData['token']);
    }

    /**
     * Test login validation exception
     *
     */
    public function test_login_validation_exception(): void
    {
        $request = new Request([
            'email' => 'useremail', // invalid email
            'password' => 'pass', // invalid password - less than 5 characters
        ]);

        $userData = $request->all();

        $response = $this->post(route('login'), $userData);
        $responseData = $response->json();

        $response->assertStatus(422);
        $this->assertEquals($responseData['errors']['email'][0], 'The email field must be a valid email address.');
        $this->assertEquals($responseData['errors']['password'][0], 'The password field must be at least 5 characters.');
    }
}
