<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class UserService extends BaseService
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    /**
     * @param $id
     * @param $with
     * @return Builder|Builder|Collection|Model|void|null
     */
    public function get(int|null $id = null, string|array $with = []): Model|Collection
    {
        try {
            if ($id) {
                return $this->model::with($with)->findOrFail($id);
            } else {
                return $this->model::with($with)->where('id', "!=", auth()->id())->get();
            }
        } catch (\Exception $e) {
            $this->logErrorResponse($e);
        }
    }
}
