<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'currency', 'active'];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
