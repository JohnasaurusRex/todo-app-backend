<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'is_completed' => $this->faker->boolean(20),
            'due_date' => $this->faker->optional()->dateTimeBetween('now', '+1 month'),
            'priority' => $this->faker->randomElement(['high', 'medium', 'low']),
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
        ];
    }
}
