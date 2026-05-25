<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::firstOrFail();

        // Create 5 projects with 10 tasks each = 50 tasks
        $projects = Project::factory()
            ->count(5)
            ->for($user)
            ->create();

        foreach ($projects as $project) {
            // Pending tasks
            Task::factory()
                ->count(3)
                ->for($project)
                ->pending()
                ->create();

            // In progress tasks
            Task::factory()
                ->count(4)
                ->for($project)
                ->inProgress()
                ->create();

            // Completed tasks
            Task::factory()
                ->count(3)
                ->for($project)
                ->completed()
                ->create();
        }
    }
}
