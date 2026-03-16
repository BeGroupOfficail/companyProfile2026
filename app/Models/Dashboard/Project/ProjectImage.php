<?php

namespace App\Models\Dashboard\Project;

use Illuminate\Database\Eloquent\Model;

class ProjectImage extends Model
{
    protected $fillable = [
        'project_id',
        'image',
        'alt',
        'sort_order',
        'is_featured'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
