<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class LegalCase extends Model
{
    use SoftDeletes;

    protected $table = 'cases';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'open_project' => 'boolean',
            'urgency' => 'boolean',
        ];
    }

    public function projectType(): BelongsTo
    {
        return $this->belongsTo(ProjectType::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function addedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'added_by');
    }
}
