<?php

namespace App\Http\Controllers;

use App\Models\Disease;
use App\Models\Expert;
use App\Models\Frequency;
use App\Models\Rule;
use App\Models\Symptom;
use Illuminate\Http\Request;

class DiagnosisController extends Controller
{
    protected static $resource = 'diagnosis';
    protected static $title = 'Skrining';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = (object) [
            'resource' => self::$resource,
            'title' => self::$title,
            'item' => Symptom::count(),
        ];

        if(!session('workspace') || request('purgeWorkspace')) {
            session(['workspace' => (object) [
                'iteratedAntecedentSymptoms' => [],
                'consequentDisease' => null,
                'currentRule' => Rule::first(),
            ]]);
        }

        return view(self::$resource . '.index', (array) $data);
    }

    protected function triggerConsequences($workspace) {
        $rule = $workspace->currentRule;

        $absentIteratedAntecedentSymptomIds = array_map(
            function($element) {
                if($element->frequency->value <= 0) return $element->id;

                return false;
            }, $workspace->iteratedAntecedentSymptoms
        );

        $antecedentSymptomIds = [];

        foreach($rule->antecedent_symptoms as $antecedentSymptom) {
            array_push(
                $antecedentSymptomIds,
                $antecedentSymptom->symptom->id
            );
        }

        /**
         * Check whether a symptom of this rule is absent. If yes, skip the
         * rule.
         */
        if(count(array_intersect(
            $antecedentSymptomIds,
            $absentIteratedAntecedentSymptomIds
        )) > 0) return $workspace;

        $hasUniterated = false;

        foreach($rule->antecedent_symptoms as $antecedentSymptom) {
                
            /**
             * Check whether the current symptom is already iterated. If no,
             *  ask this one.
             */

             $antecedentSymptom = $antecedentSymptom->symptom;

             $iteratedAntecedentSymptomIds = array_map(function($element) {
                return $element->id;
             }, $workspace->iteratedAntecedentSymptoms);

            if(!in_array(
                $antecedentSymptom->id,
                $iteratedAntecedentSymptomIds
            )) {
                $hasUniterated = true;

                break;
            }
        }

        if($hasUniterated) return $workspace;

        $presentIteratedAntecedentSymptoms = array_filter(
            $workspace->iteratedAntecedentSymptoms,
            function($element) {
                return $element->frequency->value > 0;
        });

        /** Check whether the current rule uses iterated symptom count. If
         * count not in range, skip the rule.
        */
        if(isset($rule->antecedent_symptom_count)) {
            if(isset($rule->antecedent_symptom_count->from)
            && count($presentIteratedAntecedentSymptoms)
            < $rule->antecedent_symptom_count->from
            ) return $workspace;

            if(isset($rule->antecedent_symptom_count->to)
            && count($presentIteratedAntecedentSymptoms)
            > $rule->antecedent_symptom_count->to
            ) return $workspace;
        }

        /** Check whether the current rule uses iterated symptom frequency
         * score. If score not in range, skip the rule.
        */
        $score = 0;

        foreach($workspace->iteratedAntecedentSymptoms as $symptom) {
            $score += $symptom->frequency->value;
        }

        if(isset($rule->antecedent_symptom_score)) {
            if(isset($rule->antecedent_symptom_score->from)
            && $score < $rule->antecedent_symptom_score->from) return $workspace;

            if(isset($rule->antecedent_symptom_score->to)
            && $score > $rule->antecedent_symptom_score->to) return $workspace;
        }


        if(is_iterable($rule->consequent_symptoms)) {
            foreach($rule->consequent_symptoms as $consequentSymptom) {
                $consequentSymptom = $consequentSymptom->symptom;
                $consequentSymptom->frequency
                = Frequency::where('value', '>', 0)->first(); // ffffffck

                array_push(
                    $workspace->iteratedAntecedentSymptoms,
                    $consequentSymptom
                );
            }
        }

        if(isset($rule->consequent_disease)) {
            $workspace->consequentDisease = $rule->consequent_disease->disease;
        }

        return $workspace;
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $workspace = session('workspace');

        if(!$workspace) return redirect('/diagnosis');
        
        $data = (object) [
            'title' => self::$title,
            'resource' => self::$resource,
            'item' => null,
            'items2' => Frequency::all(),
        ];

        /**
         * BEGIN forward chaining
         * 
         * Please never ask me how it works.
         */

        $rules = Rule::all();

        foreach($rules as $rule) {
            $workspace->currentRule = $rule;

            $hasUniterated = false;

            $absentIteratedAntecedentSymptomIds = array_map(
                function($element) {
                    if($element->frequency->value <= 0) return $element->id;

                    return false;
                }, $workspace->iteratedAntecedentSymptoms
            );

            $antecedentSymptomIds = [];

            foreach($rule->antecedent_symptoms as $antecedentSymptom) {
                array_push(
                    $antecedentSymptomIds,
                    $antecedentSymptom->symptom->id
                );
            }

            /**
             * Check whether a symptom of this rule is absent. If yes, skip the
             * rule.
             */
            if(count(array_intersect(
                $antecedentSymptomIds,
                $absentIteratedAntecedentSymptomIds
            )) > 0) continue;

            foreach($rule->antecedent_symptoms as $antecedentSymptom) {
                
                /**
                 * Check whether the current symptom is already iterated. If no,
                 *  ask this one.
                 */

                 $antecedentSymptom = $antecedentSymptom->symptom;

                 $iteratedAntecedentSymptomIds = array_map(function($element) {
                    return $element->id;
                 }, $workspace->iteratedAntecedentSymptoms);

                if(!in_array(
                    $antecedentSymptom->id,
                    $iteratedAntecedentSymptomIds
                )) {
                    $data->item = $antecedentSymptom;

                    $hasUniterated = true;

                    break;
                }
            }

            if($hasUniterated) break;

            $workspace = $this->triggerConsequences($workspace);
        }

        session(['workspace' => $workspace]);

        if(is_null($data->item)) return redirect('/diagnosis/result');

        /** END forward chaining */

        return view(self::$resource . '.create', (array) $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $workspace = session('workspace');

        $entry = Symptom::find((integer) $request->id);

        $entry->frequency = Frequency::find((float) $request->frequency_id);

        if(!in_array($entry, $workspace->iteratedAntecedentSymptoms)) {
            array_push($workspace->iteratedAntecedentSymptoms, $entry);
        }

        $workspace = $this->triggerConsequences($workspace);

        session(['workspace' => $workspace]);
        
        return redirect('/diagnosis/create');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        if(is_null(session('workspace')))
        return redirect('/' . self::$resource);

        $data = (object) [
            'title' => self::$title,
            'resource' => self::$resource,
            'item' => Disease::where('is_healthy', true)->first()
        ];

        $workspace = session('workspace');

        if(!is_null($workspace->consequentDisease)) {
            $data->item = $workspace->consequentDisease;
        }

        $presentIteratedAntecedentSymptoms = array_filter(
            $workspace->iteratedAntecedentSymptoms,
            function($element) {
                return $element->frequency->value > 0;
            });
        
        $data->item->bayes = BayesController::getProbability(
            $data->item,
            $presentIteratedAntecedentSymptoms
        );

        $score = 0;

        foreach($workspace->iteratedAntecedentSymptoms as $symptom) {
            $score += $symptom->frequency->value;
        }

        $data->item->score = $score;
        $data->items2 = collect($workspace->iteratedAntecedentSymptoms);
        $data->items3 = Expert::all();

        session(['workspace' => null]);

        return view(self::$resource . '.show', (array) $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
