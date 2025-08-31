<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'country_id', 'active'];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function serviceAreas()
    {
        return $this->hasMany(ServiceArea::class);
    }

    public function tenders()
    {
        return $this->hasMany(Tender::class);
    }
}
