<?php

namespace App\Http\Controllers;

use App\Models\Workspace;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WorkspaceController extends Controller
{
    /**
     * @route /api/v1/projects
     * @method Get
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->success(
            'List of workspaces',
            Workspace::get()
        );
    }
}
