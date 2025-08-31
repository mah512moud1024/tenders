<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'parent_id', 'order', 'active'];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function parent()
    {
        return $this->belongsTo(ProjectCategory::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(ProjectCategory::class, 'parent_id');
    }

    public function tenders()
    {
        return $this->hasMany(Tender::class);
    }
}
