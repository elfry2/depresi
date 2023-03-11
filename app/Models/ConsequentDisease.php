<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsequentDisease extends Model
{
    use HasFactory;

    protected $fillable = [
        'rule_id',
        'disease_id'
    ];

    public function rule()
    {
        return $this->belongsTo(Rule::class);
    }

    public function disease()
    {
        return $this->belongsTo(Disease::class);
    }
}
