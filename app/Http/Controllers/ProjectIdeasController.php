<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectIdeaRequest;
use App\Http\Requests\UpdateProjectIdeaRequest;
use App\Models\ProjectIdea;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class ProjectIdeasController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(): Factory|View
    {
        return view('project-ideas/index', [
            'ideas' => ProjectIdea::orderBy('status')->orderBy('order')->get(),
            'statuses' => ProjectIdea::STATUSES,
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
        return view('project-ideas/show', [
            'projectIdea' => $projectIdea,
            'projectStatuses' => ProjectIdea::STATUSES,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProjectIdea $projectIdea): Factory|View
    {
        return view('project-ideas/edit', [
            'projectIdea' => $projectIdea,
            'projectStatuses' => ProjectIdea::STATUSES,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectIdeaRequest $request): Redirector|RedirectResponse
    {
        $maxOrder = ProjectIdea::where('status', 0)->max('order');
        $order = is_null($maxOrder) ? 1.0 : (float) (floor($maxOrder) + 1);

        $idea = ProjectIdea::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => 0,
            'order' => $order,
        ]);

        return redirect('/project-ideas?created=1');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectIdeaRequest $request, ProjectIdea $projectIdea, ProjectIdeaRescaleController $rescaler): Redirector|RedirectResponse|\Illuminate\Http\JsonResponse
    {
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

        return redirect('/project-ideas?updated=1');
    }

    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectIdea $projectIdea): Redirector|RedirectResponse
    {
        $projectIdea->delete();

        return redirect('/project-ideas?deleted=1');
    }
}
