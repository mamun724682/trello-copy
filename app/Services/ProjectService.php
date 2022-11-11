<?php

namespace App\Services;

use App\Models\Project;
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
                return auth()->user()->projects()->latest()->with($with)->get();
            }
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
                if (isset($data['members'])){
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
                if (isset($data['members'])){
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
