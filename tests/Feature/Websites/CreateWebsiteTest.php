<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use  App\Models\Category;
use Illuminate\Http\Request;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateWebsiteTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test website creation
     *
     */
    public function test_create_website(): void
    {
        Sanctum::actingAs($user = User::factory()->create());
        $category = Category::factory()->create();

        $request = new Request([
            'name' => 'Google',
            'url' => 'https://www.google.com',
            'description' => 'Google search engine',
            'category' => $category->name,
        ]);

        $websiteData = $request->all();

        $response = $this->post(route('websites.store'), $websiteData);
        $responseData = $response->json();

        $response->assertStatus(200);
        $this->assertEquals($responseData['website']['user_id'], $user->id);
        $this->assertEquals($responseData['website']['name'], $websiteData['name']);
        $this->assertEquals($responseData['website']['url'], $websiteData['url']);
        $this->assertEquals($responseData['website']['description'], $websiteData['description']);
    }

    /**
     * Test website validation exception
     *
     */
    public function test_website_valiadation_exception(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $request = new Request([
            'name' => 'Google',
            'url' => 'google', // invalid url
            'description' => 'Google search engine',
            'category' => 'Random category', // not a valid category
        ]);

        $websiteData = $request->all();

        $response = $this->post(route('websites.store'), $websiteData);
        $responseData = $response->json();

        $response->assertStatus(422);
        $this->assertEquals($responseData['errors']['url'][0], 'The url field must be a valid URL.');
        $this->assertEquals($responseData['errors']['category'][0], 'The selected category is invalid.');
    }
}
