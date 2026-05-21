<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProjectController extends Controller
{
    /**
     * Display a listing of the projects.
     */
    public function index(): View
    {
        $projects = auth()->user()->projects()->latest()->get();

        return view('projects-index', compact('projects'));
    }

    /**
     * Show the form for creating a new project.
     */
    public function create(): View
    {
        return view('projects-create');
    }

    /**
     * Store a newly created project in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        auth()->user()->projects()->create($validated);

        return redirect()->route('projects.index')->with('success', 'Proyecto creado exitosamente.');
    }

    /**
     * Display the specified project.
     */
    public function show(Project $project): View
    {
        $this->authorize('view', $project);

        $tasks = $project->tasks()->latest()->get();
        $statuses = \App\Models\Task::getStatuses();

        return view('projects-show', compact('project', 'tasks', 'statuses'));
    }

    /**
     * Show the form for editing the specified project.
     */
    public function edit(Project $project): View
    {
        $this->authorize('update', $project);

        return view('projects-edit', compact('project'));
    }

    /**
     * Update the specified project in storage.
     */
    public function update(Request $request, Project $project): RedirectResponse
    {
        $this->authorize('update', $project);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $project->update($validated);

        return redirect()->route('projects.show', $project)->with('success', 'Proyecto actualizado exitosamente.');
    }

    /**
     * Remove the specified project from storage.
     */
    public function destroy(Project $project): RedirectResponse
    {
        $this->authorize('delete', $project);

        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Proyecto eliminado exitosamente.');
    }
}
