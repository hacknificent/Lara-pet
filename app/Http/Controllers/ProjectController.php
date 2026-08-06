<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use Illuminate\Support\Facades\Gate;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): Factory|View
    {
        return view('projects/index', [
            'projects' => auth()->user()->projects()->orderBy('created_at', 'desc')->get(),
        ]);
    }

    public function create(): Factory|View
    {
        return view('projects/create', [
            'statuses' => Project::DEFAULT_STATUSES,
        ]);
    }

    public function store(StoreProjectRequest $request): Redirector|RedirectResponse
    {
        $project = auth()->user()->projects()->create([
            'title' => $request->title,
            'statuses' => array_values($request->statuses),
        ]);

        return redirect()->route('project.show', $project);
    }

    public function show(Project $project): Factory|View
    {
        Gate::authorize('view', $project);

        return view('project-ideas/index', [
            'project' => $project,
            'ideas' => $project->ideas()->orderBy('status')->orderBy('order')->get(),
            'statuses' => $project->statuses ?? Project::DEFAULT_STATUSES,
        ]);
    }

    public function edit(Project $project): Factory|View
    {
        Gate::authorize('view', $project);

        return view('projects/edit', [
            'project' => $project,
            'statuses' => $project->statuses ?? Project::DEFAULT_STATUSES,
        ]);
    }

    public function update(UpdateProjectRequest $request, Project $project): Redirector|RedirectResponse
    {
        Gate::authorize('update', $project);

        $project->update([
            'title' => $request->title,
            'statuses' => array_values($request->statuses),
        ]);

        return redirect()->route('project.show', $project);
    }

    public function destroy(Project $project): Redirector|RedirectResponse
    {
        Gate::authorize('delete', $project);

        $project->delete();

        return redirect()->route('project.index');
    }
}
