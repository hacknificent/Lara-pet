<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectIdea extends Model
{
    protected $fillable = [
        'title',
        'description',
        'status',
    ];
    public const STATUSES = [
        0 => 'Draft',
        1 => 'Confirmed',
        2 => 'In Progress',
        3 => 'Completed',
    ];
}
