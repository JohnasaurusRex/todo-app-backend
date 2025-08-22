<?php
namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_task()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/tasks', [
                'title' => 'Test Task',
                'description' => 'Test Description',
                'priority' => 'high',
            ]);
        $response->assertStatus(201)->assertJsonStructure(['id', 'title', 'description', 'priority']);
    }

    public function test_authenticated_user_can_get_tasks()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;
        Task::factory()->count(2)->create(['user_id' => $user->id]);
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/tasks');
        $response->assertStatus(200)->assertJsonStructure([['id', 'title', 'description']]);
    }
}
