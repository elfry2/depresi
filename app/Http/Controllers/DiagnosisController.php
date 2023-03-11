<?php

namespace App\Http\Controllers;

use App\Models\Rule;
use App\Models\Expert;
use App\Models\Disease;
use App\Models\Symptom;
use App\Models\Diagnosis;
use App\Models\Antecedent;
use App\Models\Probability;
use App\Policies\SymptomPolicy;
use App\Models\ConsequentSymptom;
use App\Http\Requests\StoreDiagnosisRequest;
use App\Http\Requests\UpdateDiagnosisRequest;

class DiagnosisController extends Controller
{
    protected static $title = 'Diagnosis';
    protected static $resource = 'diagnosis';

    public static function applyRules($workspace)
    {
        $rules = $workspace['rules'];

        $iteratedSymptomIds = array_map(function($element) {
            return $element['id'];
        }, $workspace['iterated']['symptoms']);

        $absentIteratedSymptomIds = array_map(function($element) {
            if(!$element['isPresent']) return $element['id'];
        }, $workspace['iterated']['symptoms']);

        foreach($rules as $rule) {
            $currentRuleAntecedentIds = array_map(function($element) {
                return $element['id'];
            }, $rule->antecedents->toArray());
    
            if(array_intersect(
                $currentRuleAntecedentIds,
                $iteratedSymptomIds
            ) === $currentRuleAntecedentIds
            && count(array_intersect(
                $currentRuleAntecedentIds,
                $absentIteratedSymptomIds
            )) === 0) {
                foreach($rule->consequent_symptoms as $symptom) {
                    $entry = [
                        'id' => $symptom->id,
                        'isPresent' => false
                    ];
    
                    $iteratedSymptomIndex
                    = array_search($entry, $workspace['iterated']['symptoms']);
    
                    if($iteratedSymptomIndex !== false) {
                        array_splice(
                            $workspace['iterated']['symptoms'],
                            $iteratedSymptomIndex, 1
                        );
                    }
    
                    $entry = [
                        'id' => $symptom->id,
                        'isPresent' => true
                    ];
    
                    if(!in_array($entry, $workspace['iterated']['symptoms'])) {
                        array_push($workspace['iterated']['symptoms'], $entry);
                    }
                }
    
                if($rule->consequent_disease) {
                    $entry = [
                        'id' => $rule->consequent_disease->id,
                        'ruleId' => $rule->id
                    ];
                    
                    if(!in_array($entry, $workspace['iterated']['diseases'])) {
                        array_push($workspace['iterated']['diseases'], $entry);
                    }
                }
            }
        }

        return $workspace;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title' => self::$title,
            'resource' => self::$resource
        ];

        if(
            !is_array(session('workspace'))
            || request('purgeWorkspace')
        ) {
            $rules = Rule::allAndAllRelated();

            // $rules = $rules->sortBy(function($item, $key) {
            //     return count($item->antecedents);
            // })->values()->all();

            session([
                'workspace' => [
                    'rules' =>  $rules,
                    'indices' => [
                        'rule' => 0,
                        'antecedent' => 0
                    ],
                    'iterated' => [
                        'symptoms' => [],
                        'diseases' => []
                    ]
                ]
            ]);
            
            return redirect('/'. $data['resource']);
        }

        return view($data['resource'] . '.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!session('workspace')) return redirect('/diagnosis');
        
        $data = [
            'title' => self::$title,
            'resource' => self::$resource,
        ];

        $workspace = session('workspace');

        $rules = $workspace['rules'];

        $antecedentIndex = $workspace['indices']['antecedent'];

        $ruleIndex = $workspace['indices']['rule'];

        $iteratedSymptomIds = array_map(function($element) {
            return $element['id'];
        }, $workspace['iterated']['symptoms']);

        $absentIteratedSymptomIds = array_map(function($element) {
            if(!$element['isPresent']) return $element['id'];
        }, $workspace['iterated']['symptoms']);

        for ($i = $ruleIndex; $i < count($rules); $i++) { 
            $workspace['indices']['rule'] = $i;
            
            $currentRuleAntecedentIds = array_map(function($element) {
                return $element['id'];
            }, $rules[$i]->antecedents->toArray());
            
            if (count(array_intersect(
                $currentRuleAntecedentIds,
                $absentIteratedSymptomIds
            )) <= 0) {

                $isFound = false;

                for (
                    $j = $antecedentIndex;
                    $j < count($currentRuleAntecedentIds);
                    $j++
                ) { 
                    $workspace['indices']['antecedent'] = $j;

                    if(!in_array(
                        $currentRuleAntecedentIds[$j],
                        $iteratedSymptomIds
                    )) {
                        $isFound = true;
                        
                        break;
                    }
                }

                if($isFound) {
                    $workspace['indices']['rule'] = $i;
                    
                    break;
                }

                $antecedentIndex = 0;
            }

            if($i+1 >= count($rules)) $workspace['indices']['rule'] = $i+1;
        }

        // $currentRuleAntecedentIds = array_map(function($element) {
        //     return $element['id'];
        // }, $rules[$ruleIndex]->antecedents->toArray());

        // if(session('next')) {
        //     while($antecedentIndex < count($rules[$ruleIndex]->antecedents)) {
        //         $workspace['indices']['antecedent'] = ++$antecedentIndex;

        //         if($antecedentIndex >= count($rules[$ruleIndex]->antecedents))
        //         break;
                
        //         if(!in_array(
        //             $currentRuleAntecedentIds[$antecedentIndex],
        //             $iteratedSymptomIds
        //         )) break;
        //     }
            
        //     if($antecedentIndex >= count($rules[$ruleIndex]->antecedents)) {                
        //         while($ruleIndex < count($rules)) {
        //             $workspace['indices']['rule'] = ++$ruleIndex;

        //             if($ruleIndex >= count($rules)) break;

        //             $currentRuleAntecedentIds = array_map(function($element) {
        //                 return $element['id'];
        //             }, $rules[$ruleIndex]->antecedents->toArray());
    
        //             if(count(array_intersect(
        //                 $currentRuleAntecedentIds,
        //                 $absentIteratedSymptomIds
        //             )) === 0) break;
        //         }

        //         $antecedentIndex = 0;

        //         $workspace['indices']['antecedent'] = $antecedentIndex;
        //     }
        // }

        if($workspace['indices']['rule'] >= count($workspace['rules'])) {
            return redirect('/diagnosis/result');
        }

        $data['item']
        = $workspace['rules'][$workspace['indices']['rule']]
        ->antecedents[$workspace['indices']['antecedent']];

        $data['debug'] = [
            'currentItemId' => $data['item']->id,
            'indices' => $workspace['indices'],
            'iterated' => $workspace['iterated']
        ];

        session(['workspace' => $workspace]);
        
        return view($data['resource'] . '.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDiagnosisRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDiagnosisRequest $request)
    {
        $workspace = session('workspace');

        $entry = [
            'id' => (int) $request->id,
            'isPresent' => (bool) $request->isPresent
        ];

        if(!in_array($entry, $workspace['iterated']['symptoms'])) {
            array_push($workspace['iterated']['symptoms'], $entry);
        }

        $rules = $workspace['rules'];

        $ruleIndex = $workspace['indices']['rule'];

        $workspace = self::applyRules($workspace);

        session(['workspace' => $workspace]);
        
        return redirect('/diagnosis/create')->with('next', true);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Diagnosis  $diagnosis
     * @return \Illuminate\Http\Response
     */
    public function show(Diagnosis $diagnosis)
    {
        if(!session('workspace')) return redirect('/diagnosis');
        
        $data = [
            'title' => self::$title,
            'resource' => self::$resource
        ];

        $workspace = session('workspace');

        $workspace = self::applyRules($workspace);

        $data['item'] = [
            'isFound' => 0,
            'name' => 'Selamat. Anda sehat!',
            'bayes' => 1
        ];

        $ruleId = end($workspace['iterated']['diseases']);

        if($ruleId) {
            $data['item']['isFound'] = 1;

            $ruleId = $ruleId['ruleId'];
            
            $rule = Rule::find($ruleId);

            $diseases = Disease::all();
    
            // P(H|EF) = P(E|H)(F|H)P(H)/(P(E|H)(F|H)P(H)+...)
    
            $numerator
            = Disease::find($rule->consequent_disease->disease_id)->probability;
    
            foreach($rule->antecedents as $antecedent) {
                $probability
                = Probability::where('symptom_id', $antecedent->symptom_id)
                ->where('disease_id', $rule->consequent_disease->disease_id)
                ->first();
    
                $numerator *= ($probability ? $probability->amount : 0);
            }
    
            $denominatorSum = 0;
        
            foreach ($diseases as $disease) {
                $denominator = $disease->probability;
    
                foreach($rule->antecedents as $antecedent) {
                    $probability
                    = Probability::where('symptom_id', $antecedent->symptom_id)
                    ->where('disease_id', $disease->id)
                    ->first();
        
                    $denominator *= ($probability ? $probability->amount : 0);
                }
    
                $denominatorSum += $denominator;
            }
    
            $bayes = $numerator/$denominatorSum;
    
            /** So that was naive bayes */

            $data['item']['name']
            = Disease::find($rule->consequent_disease->disease_id)->name;

            $data['item']['bayes']
            = $bayes;
    
            $presentSymptomIds = array_map(function($element) {
                if($element['isPresent']) return $element['id'];
            }, $workspace['iterated']['symptoms']);

            $presentSymptomIds
            = array_filter($presentSymptomIds, function($element) {
                return !is_null($element);
            });
    
            $data['item']['presentSymptoms'] = array_map(function($element) {
                return Symptom::find($element)->name;
            }, $presentSymptomIds);
    
            $antecedentIds = array_map(function($element) {
                return $element['symptom_id'];
            }, Antecedent::where('rule_id', $ruleId)->get()->toArray());
    
            $data['item']['antecedents'] = array_map(function($element) {
                return Symptom::find($element)->name;
            }, $antecedentIds);
        }

        session(['workspace' => null]);

        $data['item'] = (object) $data['item'];

        $data['items2'] = Expert::all();

        return view('diagnosis.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Diagnosis  $diagnosis
     * @return \Illuminate\Http\Response
     */
    public function edit(Diagnosis $diagnosis)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDiagnosisRequest  $request
     * @param  \App\Models\Diagnosis  $diagnosis
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDiagnosisRequest $request, Diagnosis $diagnosis)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
    * @param  \App\Models\Diagnosis  $diagnosis
     * @return \Illuminate\Http\Response
     */
    public function destroy(Diagnosis $diagnosis)
    {
        //
    }
}
