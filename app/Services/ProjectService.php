<?php

namespace App\Services;

use App\Models\Project;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ProjectService extends BaseService
{
    public function __construct(Project $model)
    {
        parent::__construct($model);
    }

    /**
     * @param int|null $id
     * @param string|array $with
     * @return Project|Collection
     */
    public function get(int|null $id = null, string|array $with = []): Project|Collection
    {
        try {
            if ($id) {
                return $this->model::with($with)->findOrFail($id);
            } else {
//                return $this->model::where('user_id', auth()->id())->latest()->with($with)->get();
                return auth()->user()->projects()->latest()->with($with)->withCount('tasks')->get();
            }
        } catch (\Exception $e) {
            $this->logErrorResponse($e);
        }
    }

    /**
     * @param string|array $with
     * @return LengthAwarePaginator|void
     */
    public function getPaginate(string|array $with = []): string|array
    {
        try {
            return $this->model::query()
                ->whereRelation('members', 'user_id', auth()->id())
                ->when(request()->email, function ($q) {
                    $q->whereRelation('members', 'email', request()->email);
                })
                ->when(request()->from_date && !request()->to_date, function ($q) {
                    $q->whereBetween('created_at', [request()->from_date, now()]);
                })
                ->when(!request()->from_date && request()->to_date, function ($q) {
                    $q->whereBetween('created_at', [now()->subCentury(), request()->to_date]);
                })
                ->when(request()->from_date && request()->to_date, function ($q) {
                    $q->whereBetween('created_at', [request()->from_date, request()->to_date]);
                })
                ->latest()
                ->with($with)
                ->withCount('tasks')
                ->paginate();


            return auth()->user()->projects()->latest()
                ->when(request()->from_date && !request()->to_date, function ($q) {
                    info(4444444444444444444444444);
                    info($q);
                    $q->whereBetween('created_at', [request()->from_date, now()]);
                })
                ->when(!request()->from_date && request()->to_date, function ($q) {
                    $q->whereBetween('created_at', [now()->subCentury(), request()->to_date]);
                })
                ->when(request()->from_date && request()->to_date, function ($q) {
                    $q->whereBetween('created_at', [request()->from_date, request()->to_date]);
                })
                ->with($with)->withCount('tasks')->paginate();
        } catch (\Exception $e) {
            $this->logErrorResponse($e);
        }
    }

    /**
     * @param array $data
     * @param int|null $id
     * @return Project
     */
    public function storeOrUpdate(array $data, int $id = null): Project
    {
        try {
            if ($id) {
                // Update project
                $project = tap($this->model::findOrFail($id))->update($data);

                // Sync members
                if (isset($data['members'])) {
                    $members = [...$data['members'], auth()->id()];
                } else {
                    $members = auth()->id();
                }
                $project->members()->sync($members);

                return $project;
            } else {
                // Create
                $project = $this->model::create($data);

                // Attach members
                if (isset($data['members'])) {
                    $members = [...$data['members'], auth()->id()];
                } else {
                    $members = auth()->id();
                }
                $project->members()->attach($members);

                return $project;
            }
        } catch (\Exception $e) {
            $this->logErrorResponse($e);
        }
    }

    /**
     * @param $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        try {
            // Find Project
            $project = $this->model::findOrfail($id);

            // Detach members
            $project->members()->detach();

            return $project->delete();
        } catch (\Exception $e) {
            $this->logErrorResponse($e);
        }
    }
}
