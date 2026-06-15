<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Status extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function addedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'added_by');
    }
}
