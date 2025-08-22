<?php
namespace App\Http\Controllers;

use App\Http\Requests\CreateCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function __construct(
        private CategoryService $categoryService
    ) {}

    public function index(): JsonResponse
    {
        $categories = $this->categoryService->getUserCategories(auth()->user());
        return response()->json($categories);
    }

    public function store(CreateCategoryRequest $request): JsonResponse
    {
        $category = $this->categoryService->createCategory(auth()->user(), $request->validated());
        return response()->json($category, 201);
    }

    public function update(UpdateCategoryRequest $request, int $id): JsonResponse
    {
        try {
            $category = $this->categoryService->updateCategory(auth()->user(), $id, $request->validated());
            return response()->json($category);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode() ?: 400);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $this->categoryService->deleteCategory(auth()->user(), $id);
            return response()->json(['message' => 'Category deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode() ?: 400);
        }
    }
}
