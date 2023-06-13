<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Disease;

class AltRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'min',
        'max',
        'disease_id'
    ];

    public function disease()
    {
        return $this->belongsTo(Disease::class);
    }
}
