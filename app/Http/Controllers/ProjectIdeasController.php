<?php

namespace App\Http\Controllers;

use App\Models\ProjectIdea;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class ProjectIdeasController extends Controller
{

    public function statuses(): array
    {
        return [
            0 => 'Draft',
            1 => 'Confirmed',
            2 => 'In Progress',
            3 => 'Completed',
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Factory|View
    {
        return view('project-ideas/index', [
            'ideas' => ProjectIdea::latest()->get(),
            'statuses' => $this->statuses(),
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
            'projectStatuses' => $this->statuses(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProjectIdea $projectIdea): Factory|View
    {
        return view('project-ideas/edit', [
            'projectIdea' => $projectIdea,
            'projectStatuses' => $this->statuses(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): Redirector|RedirectResponse
    {

        $request->validate([
            'description' => 'required|string|max:1000',
        ]);

        $idea = ProjectIdea::create([
            'description' => request('description'),
            'status' => 0,
        ]);


        return redirect('/project-ideas?created=1');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProjectIdea $projectIdea): Redirector|RedirectResponse
    {
        request()->validate([
            'description' => 'required|string|max:1000',
            'status' => 'required|integer|in:0,1,2,3',
        ]);

        $projectIdea->update([
            'description' => request('description'),
            'status' => request('status'),
        ]);

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
