<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Probability;

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

    function probability_given(Disease $disease) : float
    {
        return Probability::where([
            'symptom_id' => $this->id,
            'disease_id' => $disease->id
        ])->first()->amount;
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
