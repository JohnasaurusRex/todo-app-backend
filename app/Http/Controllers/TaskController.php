<?php
namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct(
        private TaskService $taskService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $filters = $request->only(['search', 'status', 'category_id', 'priority']);

        if (empty(array_filter($filters))) {
            $tasks = $this->taskService->getUserTasks(auth()->user());
        } else {
            $tasks = $this->taskService->searchTasks(auth()->user(), $filters);
        }

        return response()->json($tasks);
    }

    public function store(CreateTaskRequest $request): JsonResponse
    {
        $task = $this->taskService->createTask(auth()->user(), $request->validated());

        return response()->json($task->load('category'), 201);
    }

    public function update(UpdateTaskRequest $request, int $id): JsonResponse
    {
        try {
            $task = $this->taskService->updateTask(auth()->user(), $id, $request->validated());
            return response()->json($task->load('category'));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode() ?: 400);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $this->taskService->deleteTask(auth()->user(), $id);
            return response()->json(['message' => 'Task deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode() ?: 400);
        }
    }

    public function toggle(int $id): JsonResponse
    {
        try {
            $task = $this->taskService->toggleTaskCompletion(auth()->user(), $id);
            return response()->json($task->load('category'));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode() ?: 400);
        }
    }
}
