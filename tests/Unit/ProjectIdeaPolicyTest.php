<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\ProjectIdea;
use App\Models\User;
use App\Policies\ProjectIdeaPolicy;
use PHPUnit\Framework\TestCase;

class ProjectIdeaPolicyTest extends TestCase
{
    public function test_owner_can_view_and_manage_project_idea(): void
    {
        $user = new User(['id' => 1]);
        $project = new Project(['user_id' => 1]);
        $project->setRelation('user', $user);

        $projectIdea = new ProjectIdea();
        $projectIdea->setRelation('project', $project);

        $policy = new ProjectIdeaPolicy();

        $this->assertTrue($policy->view($user, $projectIdea));
        $this->assertTrue($policy->update($user, $projectIdea));
        $this->assertTrue($policy->delete($user, $projectIdea));
    }

    public function test_non_owner_cannot_view_or_manage_project_idea(): void
    {
        $user = new User(['id' => 2]);
        $project = new Project(['user_id' => 1]);
        $project->setRelation('user', new User(['id' => 1]));

        $projectIdea = new ProjectIdea();
        $projectIdea->setRelation('project', $project);

        $policy = new ProjectIdeaPolicy();

        $this->assertFalse($policy->view($user, $projectIdea));
        $this->assertFalse($policy->update($user, $projectIdea));
        $this->assertFalse($policy->delete($user, $projectIdea));
    }
}
