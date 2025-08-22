<?php
namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_category()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/categories', [
                'name' => 'Work',
                'color' => '#ff0000',
            ]);
        $response->assertStatus(201)->assertJsonStructure(['id', 'name', 'color']);
    }

    public function test_authenticated_user_can_get_categories()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;
        Category::factory()->count(2)->create(['user_id' => $user->id]);
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/categories');
        $response->assertStatus(200)->assertJsonStructure([['id', 'name', 'color']]);
    }
}
