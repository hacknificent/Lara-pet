<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class ProjectIdea extends Model
{
    protected $fillable = [
        'title',
        'description',
        'status',
        'order',
        'project_id',
        'uuid',
    ];

    protected $casts = [
        'order' => 'float',
    ];

    protected static function booted(): void
    {
        static::creating(function (ProjectIdea $projectIdea): void {
            if (empty($projectIdea->uuid)) {
                $projectIdea->uuid = (string) Str::uuid();
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
