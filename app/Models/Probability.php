<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Probability extends Model
{
    use HasFactory;

    protected $fillable = [
        'symptom_id',
        'disease_id',
        'amount'
    ];

    public function symptom()
    {
        return $this->belongsTo(Symptom::class)->orderBy('symptoms_id', 'ASC');
    }

    public function disease()
    {
        return $this->belongsTo(Disease::class)->orderBy('disease_id', 'ASC');
    }
}
