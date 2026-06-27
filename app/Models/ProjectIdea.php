<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectIdea extends Model
{
    protected $fillable = [
        'title',
        'description',
        'status',
        'order',
        'project_id',
    ];

    protected $casts = [
        'order' => 'float',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
