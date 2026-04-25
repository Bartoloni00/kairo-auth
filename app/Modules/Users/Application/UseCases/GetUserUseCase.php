<?php

namespace App\Modules\Users\Application\UseCases;

use App\Modules\Users\Application\Ports\UserRepositoryInterface;
use App\Modules\Users\Domain\Entities\User;

class GetUserUseCase
{
  public function __construct(
    private readonly UserRepositoryInterface $userRepository
  ) {}

  public function execute(int $id, ?User $authUser = null): ?User
  {
    $user = $this->userRepository->findById($id);

    if ($user && $authUser && !$authUser->is_root) {
      // Check if they share any project or organization
      $myAccess = $authUser->access;
      $myProjects = $myAccess->pluck('project_id')->filter()->unique()->toArray();
      $myOrgs = $myAccess->pluck('organization_id')->filter()->unique()->toArray();

      $hasAccess = $user->access()->where(function ($q) use ($myProjects, $myOrgs) {
        $q->whereIn('project_id', $myProjects)
          ->orWhereIn('organization_id', $myOrgs);
      })->exists();

      if (!$hasAccess) {
        return null;
      }
    }

    return $user;
  }
}
