<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'quote_id',
        'file_path',
        'original_name',
        'file_type',
        'file_size'
    ];

    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }
}
