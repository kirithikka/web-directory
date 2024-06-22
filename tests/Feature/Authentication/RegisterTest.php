<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test registration successful
     *
     */
    public function test_register_successful(): void
    {
        $request = new Request([
            'name' => 'Username',
            'email' => 'user@gmail.com',
            'password' => 'password',
        ]);

        $userData = $request->all();

        $response = $this->post(route('register'), $userData);
        $responseData = $response->json();

        $response->assertStatus(200);
        $this->assertSame($responseData['user']['name'], 'Username');
        $this->assertSame($responseData['user']['email'], 'user@gmail.com');
        $this->assertNotNull($responseData['token']);
    }

    /**
     * Test user already exists case
     *
     */
    public function test_register_user_already_exists(): void
    {
        $user = User::factory()->create();

        $request = new Request([
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password,
        ]);

        $userData = $request->all();

        $response = $this->post(route('register'), $userData);
        $responseData = $response->json();

        $response->assertStatus(200);
        $this->assertEquals($responseData['message'], 'User already registered. Please login');
    }

    /**
     * Test registration validation exception
     *
     */
    public function test_register_validation_exception(): void
    {
        $request = new Request([
            'name' => 'Username',
            'email' => 'useremail', // invalid email
            'password' => 'pass', // invalid password - less than 5 characters
        ]);

        $userData = $request->all();

        $response = $this->post(route('register'), $userData);
        $responseData = $response->json();

        $response->assertStatus(422);
        $this->assertEquals($responseData['errors']['email'][0], 'The email field must be a valid email address.');
        $this->assertEquals($responseData['errors']['password'][0], 'The password field must be at least 5 characters.');
    }
}
