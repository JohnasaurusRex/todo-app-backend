<?php
// app/Repositories/Contracts/TaskRepositoryInterface.php
namespace App\Repositories\Contracts;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface TaskRepositoryInterface
{
    public function findByUser(User $user): Collection;
    public function findById(int $id): ?Task;
    public function create(array $data): Task;
    public function update(Task $task, array $data): Task;
    public function delete(Task $task): bool;
    public function findByUserAndId(User $user, int $id): ?Task;
    public function searchByUser(User $user, array $filters): Collection;
}
