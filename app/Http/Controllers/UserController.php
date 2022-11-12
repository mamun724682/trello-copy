<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    /**
     * @route /api/v1/users
     * @method Get
     * @param UserService $userService
     * @return JsonResponse
     */
    public function index(UserService $userService): JsonResponse
    {
        return response()->success(
            'List of users',
            UserResource::collection($userService->get())
        );
    }

    /**
     * @route /api/v1/api-users
     * @method Get
     * @return JsonResponse
     */
    public function apiUsers(): JsonResponse
    {
        $response = Cache::remember('users', 300, fn() => Http::retry(3, 100)->get('https://randomuser.me/api?results=5')->json());

        return response()->success(
            'List of api users',
            $response
        );
    }
}
