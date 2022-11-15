<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'           => $this->id,
            'name'         => $this->name,
            'created_at'   => $this->created_at,
            'updated_at'   => $this->updated_at,
            'owner_status' => $this->user_id == auth()->id() ? 'Owner' : 'Member',
            'tasks_count'  => $this->whenCounted('tasks'),
            'workspace'    => $this->whenLoaded('workspace'),
            'owner'        => new UserResource($this->whenLoaded('user')),
            'members'      => UserResource::collection($this->whenLoaded('members')),
        ];
    }
}
