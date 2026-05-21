<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Create projects for the test user
        $projects = Project::factory()
            ->count(3)
            ->for($user)
            ->create();

        // Create tasks for each project
        foreach ($projects as $project) {
            // Pending tasks
            Task::factory()
                ->count(2)
                ->for($project)
                ->pending()
                ->create();

            // In progress tasks
            Task::factory()
                ->count(2)
                ->for($project)
                ->inProgress()
                ->create();

            // Completed tasks
            Task::factory()
                ->count(2)
                ->for($project)
                ->completed()
                ->create();
        }
    }
}
