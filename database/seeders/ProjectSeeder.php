<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use App\Models\Workspace;
use App\Services\ProjectService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1, 100) as $item) {
            $data = [
                'workspace_id' => Workspace::query()->inRandomOrder()->first()->id,
                'user_id' => User::query()->inRandomOrder()->first()->id,
                'name' => fake()->name
            ];

            $project = Project::create($data);
            $project->members()->attach(User::pluck('id')->toArray());
        }
    }
}
