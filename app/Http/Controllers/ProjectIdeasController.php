<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectIdeaRequest;
use App\Http\Requests\UpdateProjectIdeaRequest;
use App\Models\Project;
use App\Models\ProjectIdea;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Gate;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class ProjectIdeasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Factory|View
    {
        // For now, just show the ideas for the first project. In the future, we may want to allow the user to select which project to view.
        $project = Project::find(1);

        return view('project-ideas/index', [
            'project' => $project,
            'ideas' => $project ? $project->ideas()->orderBy('status')->orderBy('order')->get() : collect(),
            'statuses' => $project ? $project->statuses ?? Project::DEFAULT_STATUSES : Project::DEFAULT_STATUSES,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Factory|View
    {
        return view('project-ideas/create');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProjectIdea $projectIdea): Factory|View
    {
        Gate::authorize('view', $projectIdea);

        return view('project-ideas/show', [
            'projectIdea' => $projectIdea,
            'projectStatuses' => $projectIdea->project->statuses ?? Project::DEFAULT_STATUSES,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProjectIdea $projectIdea): Factory|View
    {
        Gate::authorize('view', $projectIdea);

        return view('project-ideas/edit', [
            'projectIdea' => $projectIdea,
            'projectStatuses' => $projectIdea->project->statuses ?? Project::DEFAULT_STATUSES,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectIdeaRequest $request): Redirector|RedirectResponse
    {
        $project = auth()->user()->projects()->findOrFail($request->project_id);

        $maxOrder = $project->ideas()->where('status', 0)->max('order');
        $order = is_null($maxOrder) ? 1.0 : (float) (floor($maxOrder) + 1);

        $project->ideas()->create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => 0,
            'order' => $order,
        ]);

        return redirect()->route('project.show', $project);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectIdeaRequest $request, ProjectIdea $projectIdea, ProjectIdeaRescaleController $rescaler): Redirector|RedirectResponse|\Illuminate\Http\JsonResponse
    {
        Gate::authorize('update', $projectIdea);

        $data = $request->validated();
        $projectIdea->update($data);

        // Check if rescale is needed
        $shouldRescale = false;
        if (isset($data['order']) && $rescaler->rescaleIsEnabled()) {
            $shouldRescale = $rescaler->shouldRescaleOrder($data['order']);
            if ($shouldRescale) {
                $rescaler->rescaleOrderForStatus($projectIdea->status);
            }
        }

        // If this was an AJAX/json request, return JSON so client can handle it.
        if ($request->wantsJson() || $request->expectsJson()) {
            return response()->json([
                'projectStatuses' => $projectIdea->status,
                'rescaled' => $shouldRescale,
            ]);
        }

        return redirect()->route('project.show', $projectIdea->project);
    }

    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectIdea $projectIdea): Redirector|RedirectResponse
    {
        Gate::authorize('delete', $projectIdea);

        $projectIdea->delete();

        return redirect()->route('project.show', $projectIdea->project);
    }

}
