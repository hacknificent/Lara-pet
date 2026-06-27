<?php

namespace App\Models;

use App\Models\ProjectIdea;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;

    public const DEFAULT_STATUSES = [
        0 => 'Draft',
        1 => 'Confirmed',
        2 => 'In Progress',
        3 => 'Completed',
    ];

    protected $fillable = [
        'title',
        'user_id',
        'uuid',
        'statuses',
    ];

    protected $casts = [
        'statuses' => 'array',
    ];

    protected static function booted(): void
    {
        static::creating(function (Project $project) {
            if (empty($project->uuid)) {
                $project->uuid = (string) Str::uuid();
            }

            if (is_null($project->statuses)) {
                $project->statuses = self::DEFAULT_STATUSES;
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function ideas(): HasMany
    {
        return $this->hasMany(ProjectIdea::class);
    }
}
