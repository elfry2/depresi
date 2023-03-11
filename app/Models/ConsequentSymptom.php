<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsequentSymptom extends Model
{
    use HasFactory;

    protected $fillable = [
        'rule_id',
        'symptom_id'
    ];

    public function rule()
    {
        return $this->belongsTo(Rule::class);
    }

    public function symptom()
    {
        return $this->belongsTo(Symptom::class);
    }
}
