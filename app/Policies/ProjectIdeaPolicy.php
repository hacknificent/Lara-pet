<?php

namespace App\Policies;

use App\Models\ProjectIdea;
use App\Models\User;

class ProjectIdeaPolicy
{
    public function view(User $user, ProjectIdea $projectIdea): bool
    {
        return $user->is($projectIdea->project?->user);
    }

    public function update(User $user, ProjectIdea $projectIdea): bool
    {
        return $user->is($projectIdea->project?->user);
    }

    public function delete(User $user, ProjectIdea $projectIdea): bool
    {
        return $user->is($projectIdea->project?->user);
    }
}
