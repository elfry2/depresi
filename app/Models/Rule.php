<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    use HasFactory;

    protected $with = [
        'antecedent_symptoms',
        'consequent_symptoms',
        'consequent_disease'
    ];

    public function antecedent_symptoms()
    {
        return $this->hasMany(AntecedentSymptom::class);
    }

    public function consequent_symptoms()
    {   
        return $this->hasMany(ConsequentSymptom::class);
    }

    public function consequent_disease()
    {
        return $this->hasOne(ConsequentDisease::class);
    }

    public static function allAndAllRelated()
    {
        $rules = self::all();

        foreach($rules as $key => $rule) {
            $antecedent_symptoms = [];

            foreach($rule->antecedent_symptoms as $antecedent) {
                array_push($antecedent_symptoms, Symptom::find($antecedent->symptom_id));
            }

            $rules[$key]->antecedent_symptoms = collect($antecedent_symptoms);

            $consequentSymptoms = [];

            if(!is_null($rule->consequent_symptoms)) {
                foreach($rule->consequent_symptoms as $consequentSymptom) {
                    array_push(
                        $consequentSymptoms,
                        Symptom::find($consequentSymptom->symptom_id)
                    );
                }
            }

            $rules[$key]->consequent_symptoms = collect($consequentSymptoms);

            if(!is_null($rule->consequent_disease)) {
                $rules[$key]->consequent_disease 
                = Disease::find($rules[$key]->consequent_disease->disease_id);
            }
        }

        return $rules;
    }

    function antecedent_symptom_count() {
        return $this->hasOne(AntecedentSymptomCount::class);
    }
    
    function antecedent_symptom_score() {
        return $this->hasOne(AntecedentSymptomScore::class);
    }
}
