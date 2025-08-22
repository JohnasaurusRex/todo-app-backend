<?php
// app/Repositories/Contracts/CategoryRepositoryInterface.php
namespace App\Repositories\Contracts;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface CategoryRepositoryInterface
{
    public function findByUser(User $user): Collection;
    public function findById(int $id): ?Category;
    public function create(array $data): Category;
    public function update(Category $category, array $data): Category;
    public function delete(Category $category): bool;
    public function findByUserAndId(User $user, int $id): ?Category;
}
