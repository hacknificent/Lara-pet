<?php

namespace App\Http\Controllers;

use App\Models\ProjectIdea;

class ProjectIdeasController extends Controller
{
    public function getProjectIdeas()
    {
        $query = ProjectIdea::query();
        $default_status_to_show = 1;

        $query->where(
            'status',
            request()->has('status')
                ? request('status')
                : $default_status_to_show
        );

        return $query->latest()->get();
    }

    public function showIdeasPage()
    {
        return view('project-ideas', [
            'ideas' => $this->getProjectIdeas(),
        ]);
    }

    public function createIdea()
    {

        request()->validate([
            'description' => 'required|string|max:1000',
        ]);

        $idea = ProjectIdea::create([
            'description' => request('description'),
            'status' => 0,
        ]);


        return redirect('/project-ideas?success=1');
    }
}
