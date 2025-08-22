<?php
namespace App\Repositories;

use App\Models\Task;
use App\Models\User;
use App\Repositories\Contracts\TaskRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class TaskRepository implements TaskRepositoryInterface
{
    public function findByUser(User $user): Collection
    {
        return $user->tasks()
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function findById(int $id): ?Task
    {
        return Task::find($id);
    }

    public function create(array $data): Task
    {
        return Task::create($data);
    }

    public function update(Task $task, array $data): Task
    {
        $task->update($data);
        return $task->fresh();
    }

    public function delete(Task $task): bool
    {
        return $task->delete();
    }

    public function findByUserAndId(User $user, int $id): ?Task
    {
        return $user->tasks()->find($id);
    }

    public function searchByUser(User $user, array $filters): Collection
    {
        $query = $user->tasks()->with('category');

        if (isset($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('title', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('description', 'like', '%' . $filters['search'] . '%');
            });
        }

        if (isset($filters['status'])) {
            if ($filters['status'] === 'completed') {
                $query->completed();
            } elseif ($filters['status'] === 'pending') {
                $query->pending();
            } elseif ($filters['status'] === 'overdue') {
                $query->overdue();
            }
        }

        if (isset($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (isset($filters['priority'])) {
            $query->where('priority', $filters['priority']);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }
}
