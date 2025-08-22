<?php
namespace App\Repositories;

use App\Models\Category;
use App\Models\User;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function findByUser(User $user): Collection
    {
        return $user->categories()
            ->withCount('tasks')
            ->orderBy('name')
            ->get();
    }

    public function findById(int $id): ?Category
    {
        return Category::find($id);
    }

    public function create(array $data): Category
    {
        return Category::create($data);
    }

    public function update(Category $category, array $data): Category
    {
        $category->update($data);
        return $category->fresh();
    }

    public function delete(Category $category): bool
    {
        return $category->delete();
    }

    public function findByUserAndId(User $user, int $id): ?Category
    {
        return $user->categories()->find($id);
    }
}
