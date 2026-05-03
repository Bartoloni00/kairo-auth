<?php

namespace App\Modules\Auditlogs\Domain\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Users\Domain\Entities\User;

class AuditLog extends Model
{
    protected $table = 'audit_logs';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'action',
        'metadata',
        'created_at'
    ];

    protected $casts = [
        'metadata' => 'json',
        'created_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
