<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Modules\Auth\Interfaces\Http\AuthServiceProvider::class,
    App\Modules\Users\Interfaces\Http\UsersServiceProvider::class,
    App\Modules\Organizations\Interfaces\Http\OrganizationsServiceProvider::class,
    App\Modules\Projects\Interfaces\Http\ProjectsServiceProvider::class,
    App\Modules\Licenses\Interfaces\Http\LicensesServiceProvider::class,
    App\Modules\Invitations\Interfaces\Http\InvitationsServiceProvider::class,
    App\Modules\Auditlogs\Interfaces\Http\AuditlogsServiceProvider::class,
];
