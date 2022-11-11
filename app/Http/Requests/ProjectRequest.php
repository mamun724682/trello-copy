<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Models\Workspace;
use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'workspace_id' => 'required|in:' . Workspace::pluck('id')->join(','),
            'name'         => 'required|string|min:2',
            'members'      => 'nullable|array',
            'members.*'    => 'integer|in:' . User::where('id', '!=', auth()->id())->pluck('id')->join(','),
        ];
    }

    /**
     * @param $key
     * @param $default
     * @return array|mixed
     */
    public function validated($key = null, $default = null): array
    {
        return parent::validated($key, $default) + ['user_id' => auth()->id()];
    }
}
