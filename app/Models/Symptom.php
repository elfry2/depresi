<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Symptom extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    protected $with = [
        'probabilities'
    ];

    public function probabilities()
    {
        return $this->hasMany(Probability::class);
    }

    public function parent_antecedents()
    {
        return $this->hasMany(Antecendent::class);
    }

    public function parent_consequents()
    {
        return $this->hasMany(ConsequentSymptom::class);
    }
}
