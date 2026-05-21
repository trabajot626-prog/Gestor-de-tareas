<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class TaskController extends Controller
{
    /**
     * Store a newly created task in storage.
     */
    public function store(Request $request, Project $project): RedirectResponse
    {
        $this->authorize('update', $project);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $validated['status'] = 'pending';

        $project->tasks()->create($validated);

        return redirect()->route('projects.show', $project)->with('success', 'Tarea creada exitosamente.');
    }

    /**
     * Update the specified task in storage.
     */
    public function update(Request $request, Task $task): RedirectResponse
    {
        $this->authorize('update', $task->project);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        $task->update($validated);

        return redirect()->route('projects.show', $task->project)->with('success', 'Tarea actualizada exitosamente.');
    }

    /**
     * Remove the specified task from storage.
     */
    public function destroy(Task $task): RedirectResponse
    {
        $this->authorize('update', $task->project);

        $project = $task->project;
        $task->delete();

        return redirect()->route('projects.show', $project)->with('success', 'Tarea eliminada exitosamente.');
    }

    /**
     * Update task status.
     */
    public function updateStatus(Request $request, Task $task): RedirectResponse
    {
        $this->authorize('update', $task->project);

        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        $task->update($validated);

        return redirect()->route('projects.show', $task->project)->with('success', 'Estado de la tarea actualizado.');
    }
}
