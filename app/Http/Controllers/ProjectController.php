<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Services\ProjectService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ProjectController extends Controller
{
    public function __construct(private ProjectService $projectService)
    {
    }

    /**
     * @route /api/v1/projects
     * @method Get
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->success(
            'List of projects',
            ProjectResource::collection($this->projectService->get(null, ['workspace', 'user', 'members']))
        );
    }

    /**
     * @route /api/v1/projects
     * @method Post
     * @param ProjectRequest $request
     * @return JsonResponse
     */
    public function store(ProjectRequest $request): JsonResponse
    {
        return response()->success(
            'Project created successfully.',
            new ProjectResource($this->projectService->storeOrUpdate($request->validated())),
            Response::HTTP_CREATED
        );
    }

    /**
     * @route /api/v1/projects/{id}
     * @method Get
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        return response()->success(
            'Project show.',
            new ProjectResource($this->projectService->get($id))
        );
    }

    /**
     * @route /api/v1/projects/{id}
     * @method Put|Patch
     * @param ProjectRequest $request
     * @return JsonResponse
     */
    public function update(ProjectRequest $request, int $id): JsonResponse
    {
        return response()->success(
            'Project updated successfully.',
            new ProjectResource($this->projectService->storeOrUpdate($request->validated(), $id)),
            Response::HTTP_ACCEPTED
        );
    }

    /**
     * @route /api/v1/projects/{id}
     * @method Delete
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->projectService->delete($id);

        return response()->success('Project deleted successfully.');
    }
}
