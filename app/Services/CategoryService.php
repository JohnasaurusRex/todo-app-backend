<?php
namespace App\Services;

use App\Models\Category;
use App\Models\User;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    public function __construct(
        private CategoryRepositoryInterface $categoryRepository
    ) {}

    public function getUserCategories(User $user): Collection
    {
        return $this->categoryRepository->findByUser($user);
    }

    public function createCategory(User $user, array $data): Category
    {
        $data['user_id'] = $user->id;
        return $this->categoryRepository->create($data);
    }

    public function updateCategory(User $user, int $categoryId, array $data): Category
    {
        $category = $this->findUserCategory($user, $categoryId);
        return $this->categoryRepository->update($category, $data);
    }

    public function deleteCategory(User $user, int $categoryId): bool
    {
        $category = $this->findUserCategory($user, $categoryId);
        return $this->categoryRepository->delete($category);
    }

    private function findUserCategory(User $user, int $categoryId): Category
    {
        $category = $this->categoryRepository->findByUserAndId($user, $categoryId);
        
        if (!$category) {
            throw new \Exception('Category not found', 404);
        }

        return $category;
    }
}
