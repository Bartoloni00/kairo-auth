<?php

namespace App\Modules\Users\Interfaces\Http\Middlewares\Traits;

use App\Modules\Users\Domain\Entities\ProjectUserAccess;
use App\Modules\Users\Domain\Entities\User;

trait HasAuthorizationHelpers
{
    /**
     * Check if auth user is in at least one organization.
     */
    protected function hasAnyOrganization(User $authUser): bool
    {
        return $authUser->access()->whereNotNull('organization_id')->exists();
    }

    /**
     * Check if auth user and target user share at least one organization.
     */
    protected function isSameOrganization(User $authUser, $targetUserId): bool
    {
        if (!$targetUserId) {
            return false;
        }

        $targetOrgIds = ProjectUserAccess::where('user_id', $targetUserId)
            ->whereNotNull('organization_id')
            ->pluck('organization_id')
            ->unique()
            ->toArray();

        if (empty($targetOrgIds)) {
            return false;
        }

        return $authUser->access()
            ->whereIn('organization_id', $targetOrgIds)
            ->exists();
    }

    /**
     * Check if auth user is ADMIN of at least one organization that the target user belongs to.
     */
    protected function isAdminOfSameOrg(User $authUser, $targetUserId): bool
    {
        if (!$targetUserId) {
            return false;
        }

        $targetOrgIds = ProjectUserAccess::where('user_id', $targetUserId)
            ->whereNotNull('organization_id')
            ->pluck('organization_id')
            ->unique()
            ->toArray();

        if (empty($targetOrgIds)) {
            return false;
        }

        return $authUser->access()
            ->whereIn('organization_id', $targetOrgIds)
            ->whereHas('role', function ($query) {
                $query->where('name', 'admin');
            })
            ->exists();
    }

    /**
     * Check if auth user has access to a specific project.
     */
    protected function hasProjectAccess(User $authUser, $projectId): bool
    {
        if (!$projectId) {
            return false;
        }

        return $authUser->access()
            ->where('project_id', $projectId)
            ->exists();
    }

    /**
     * Check if auth user is ADMIN of a specific project.
     */
    protected function isAdminOfProject(User $authUser, $projectId): bool
    {
        if (!$projectId) {
            return false;
        }

        return $authUser->access()
            ->where('project_id', $projectId)
            ->whereHas('role', function ($query) {
                $query->where('name', 'admin');
            })
            ->exists();
    }

    /**
     * Check if auth user is ADMIN of a specific organization.
     */
    protected function isAdminOfOrganization(User $authUser, $organizationId): bool
    {
        if (!$organizationId) {
            return false;
        }

        return $authUser->access()
            ->where('organization_id', $organizationId)
            ->whereHas('role', function ($query) {
                $query->where('name', 'admin');
            })
            ->exists();
    }
}
