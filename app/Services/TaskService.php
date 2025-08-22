<?php
namespace App\Services;

use App\Models\Task;
use App\Models\User;
use App\Repositories\Contracts\TaskRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class TaskService
{
    public function __construct(
        private TaskRepositoryInterface $taskRepository
    ) {}

    public function getUserTasks(User $user): Collection
    {
        return $this->taskRepository->findByUser($user);
    }

    public function createTask(User $user, array $data): Task
    {
        $data['user_id'] = $user->id;
        return $this->taskRepository->create($data);
    }

    public function updateTask(User $user, int $taskId, array $data): Task
    {
        $task = $this->findUserTask($user, $taskId);
        return $this->taskRepository->update($task, $data);
    }

    public function deleteTask(User $user, int $taskId): bool
    {
        $task = $this->findUserTask($user, $taskId);
        return $this->taskRepository->delete($task);
    }

    public function toggleTaskCompletion(User $user, int $taskId): Task
    {
        $task = $this->findUserTask($user, $taskId);
        
        if ($task->is_completed) {
            $task->markAsIncomplete();
        } else {
            $task->markAsCompleted();
        }

        return $task->fresh();
    }

    public function searchTasks(User $user, array $filters): Collection
    {
        return $this->taskRepository->searchByUser($user, $filters);
    }

    private function findUserTask(User $user, int $taskId): Task
    {
        $task = $this->taskRepository->findByUserAndId($user, $taskId);
        
        if (!$task) {
            throw new \Exception('Task not found', 404);
        }

        return $task;
    }
}
