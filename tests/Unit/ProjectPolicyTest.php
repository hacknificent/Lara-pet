<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\User;
use App\Policies\ProjectPolicy;
use PHPUnit\Framework\TestCase;

class ProjectPolicyTest extends TestCase
{
    public function test_owner_can_view_and_manage_project(): void
    {
        $user = new User(['id' => 1]);
        $project = new Project(['user_id' => 1]);
        $project->setRelation('user', $user);
        $policy = new ProjectPolicy();

        $this->assertTrue($policy->view($user, $project));
        $this->assertTrue($policy->update($user, $project));
        $this->assertTrue($policy->delete($user, $project));
    }

    public function test_non_owner_cannot_view_or_manage_project(): void
    {
        $user = new User(['id' => 2]);
        $project = new Project(['user_id' => 1]);
        $project->setRelation('user', new User(['id' => 1]));
        $policy = new ProjectPolicy();

        $this->assertFalse($policy->view($user, $project));
        $this->assertFalse($policy->update($user, $project));
        $this->assertFalse($policy->delete($user, $project));
    }
}
