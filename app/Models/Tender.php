<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tender extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'user_id',
        'city_id',
        'area',
        'project_type',
        'work_type',
        'tender_type',
        'category_id',
        'floors',
        'building_area',
        'land_area',
        'required_service',
        'status',
        'closing_date'
    ];

    protected $casts = [
        'closing_date' => 'datetime',
        'building_area' => 'decimal:2',
        'land_area' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function category()
    {
        return $this->belongsTo(ProjectCategory::class);
    }

    public function specifications()
    {
        return $this->hasMany(TenderSpecification::class);
    }

    public function quotes()
    {
        return $this->hasMany(Quote::class);
    }

    public function contract()
    {
        return $this->hasOne(Contract::class);
    }
}
