<?php

return [
    App\Modules\Auth\Interface\Http\AuthServiceProvider::class,
    App\Modules\Users\Interface\Http\UsersServiceProvider::class,
    App\Modules\Organizations\Interface\Http\OrganizationsServiceProvider::class,
    App\Modules\Projects\Interface\Http\ProjectsServiceProvider::class,
    App\Modules\Licenses\Interface\Http\LicensesServiceProvider::class,
    App\Modules\Invitations\Interface\Http\InvitationsServiceProvider::class,
    App\Modules\Auditlogs\Interface\Http\AuditlogsServiceProvider::class,
];
