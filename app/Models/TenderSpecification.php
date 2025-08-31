<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenderSpecification extends Model
{
    use HasFactory;

    protected $fillable = [
        'tender_id',
        'specifiable_type',
        'specifiable_id',
        'file_path',
        'original_name',
        'file_type',
        'file_size'
    ];

    public function tender()
    {
        return $this->belongsTo(Tender::class);
    }

    public function specifiable()
    {
        return $this->morphTo();
    }
}
