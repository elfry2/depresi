<?php

namespace App\Http\Controllers;

use App\Models\Rule;
use App\Models\Disease;
use App\Models\Symptom;
use App\Models\AntecedentSymptom;
use App\Models\ConsequentDisease;
use App\Models\ConsequentSymptom;
use App\Http\Requests\StoreRuleRequest;
use App\Http\Requests\UpdateRuleRequest;
use App\Models\AntecedentSymptomCount;
use App\Models\AntecedentSymptomScore;
use App\Models\Frequency;

class RuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title' => 'Aturan',
            'resource' => 'rules',
            'items' => new Rule
        ];

        $data['preferences'] = [
            'sortingDirection' => PreferenceController::get(
                $data['resource'] . 'SortingDirection') ?: 'asc'
        ];

        $data['items'] = $data['items']->orderBy(
            'id',
            $data['preferences']['sortingDirection']
        );

        /* BEGIN Search */
        if(request('q')) {
            $q = request('q');

            $symptomIds = array_map(function($element) {
                return $element['id'];
            }, Symptom::select('id')
            ->where('name', 'like', "%$q%")->get()->toArray());
            
            $ruleIdsFromAntecedentSymptoms = AntecedentSymptom::select('rule_id')
            ->distinct()->whereIn('symptom_id', $symptomIds)->get();
    
            $ruleIdsFromConsequentSymptoms
            = ConsequentSymptom::select('rule_id')
            ->distinct()->whereIn('symptom_id', $symptomIds)->get();
    
            $diseaseIds = array_map(function($element) {
                return $element['id'];
            }, Disease::select('id')
            ->where('name', 'like', "%$q%")->get()->toArray());
    
            $ruleIdsFromConsequentDiseases
            = ConsequentDisease::select('rule_id')
            ->distinct()->whereIn('disease_id', $diseaseIds)->get();
    
            $data['items']
            = $data['items']->whereIn('id', $ruleIdsFromAntecedentSymptoms)
            ->orWhereIn('id', $ruleIdsFromConsequentSymptoms)
            ->orWhereIn('id', $ruleIdsFromConsequentDiseases);
        }

        /* END Search */

        $data['items'] = $data['items']->paginate(config('app.itemsPerPage'));

        for($i = 0; $i < count($data['items']); $i++) {
            $antecedentSymptomNames = [];

            foreach($data['items'][$i]->antecedent_symptoms as $antecedent_symptom) {
                array_push($antecedentSymptomNames, $antecedent_symptom->symptom->name);
            }

            if($data['items'][$i]->antecedent_symptom_count) {
                $count = $data['items'][$i]->antecedent_symptom_count;

                if($count->from) {
                    array_push($antecedentSymptomNames, 'Jumlah gejala >= ' . $count->from);
                }

                if($count->to) {
                    array_push($antecedentSymptomNames, 'Jumlah gejala <= ' . $count->to);
                }
            }

            if($data['items'][$i]->antecedent_symptom_score) {
                $score = $data['items'][$i]->antecedent_symptom_score;

                if($score->from) {
                    array_push($antecedentSymptomNames, 'Skor >= ' . $score->from);
                }

                if($score->to) {
                    array_push($antecedentSymptomNames, 'Skor <= ' . $score->to);
                }
            }

            $data['items'][$i]->antecedent_symptoms 
            = ucfirst(strtolower(implode('; ', $antecedentSymptomNames)));
        }

        for($i = 0; $i < count($data['items']); $i++) {
            $consequentSymptomNames = [];

            foreach(
                $data['items'][$i]->consequent_symptoms as $consequentSymptom) {
                array_push(
                    $consequentSymptomNames, $consequentSymptom->symptom->name
                );
            }

            $data['items'][$i]->consequent_symptoms 
            = ucfirst(strtolower(implode('; ', $consequentSymptomNames)));
        }

        return view('dashboard.' . $data['resource'] . '.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'title' => 'Tambah aturan',
            'resource' => 'rules',
            'noPagination' => true,
            'backURL' => '/rules',
            'items' => Symptom::all(),
            'items2' => Disease::all(),
            'item3' => Frequency::where('value', '>', 0)->count(),
        ];

        return view('dashboard.' . $data['resource'] . '.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRuleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRuleRequest $request)
    {
        $request->validate([
            'antecedent_symptom_ids' => 'array',
            'antecedent_symptom_count_from' => [
                'nullable',
                'integer',
                'min:0',
                'max:' . Symptom::count()
            ],
            'antecedent_symptom_count_to' => [
                'nullable',
                'integer',
                'min:0',
                'max:' . Symptom::count()
            ],
            'antecedent_symptom_score_from' => [
                'nullable',
                'integer',
                'min:0',
                'max:' . Symptom::count()
                * (Frequency::where('value', '>', 0)->count())
            ],
            'antecedent_symptom_score_to' => [
                'nullable',
                'integer',
                'min:0',
                'max:' . Symptom::count()
                * (Frequency::where('value', '>', 0)->count())
            ],
        ]);
        
        $rule = Rule::create();

        if(is_array($request->antecedent_symptom_ids)) {
            foreach($request->antecedent_symptom_ids as $antecedent_symptom_id) {
                AntecedentSymptom::create([
                    'rule_id' => $rule->id,
                    'symptom_id' => $antecedent_symptom_id
                ]);
            }
        }

        if($request->use_antecedent_symptom_count) {
            AntecedentSymptomCount::create([
                'rule_id' => $rule->id,
                'from' => $request->antecedent_symptom_count_from ?: null,
                'to' => $request->antecedent_symptom_count_to ?: null,
            ]);
        }

        if($request->use_antecedent_symptom_score) {
            AntecedentSymptomScore::create([
                'rule_id' => $rule->id,
                'from' => $request->antecedent_symptom_score_from ?: null,
                'to' => $request->antecedent_symptom_score_to ?: null,
            ]);
        }
        
        if(isset($request->consequent_symptom_ids)) {
            foreach($request->consequent_symptom_ids as $consequent_symptom_id) {
                ConsequentSymptom::create([
                    'rule_id' => $rule->id,
                    'symptom_id' => $consequent_symptom_id
                ]);
            }
        }

        if(!is_null($request->consequent_disease_id)) {
            ConsequentDisease::create([
                'rule_id' => $rule->id,
                'disease_id' => $request->consequent_disease_id
            ]);
        }

        return redirect('/rules')
        // return redirect('/rules/' . $rule->id . '/edit')
        ->with('message', (object) [
            'type' => 'success',
            'content' => 'Aturan berhasil ditambahkan.'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rule  $rule
     * @return \Illuminate\Http\Response
     */
    public function show(Rule $rule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rule  $rule
     * @return \Illuminate\Http\Response
     */
    public function edit(Rule $rule)
    {
        $data = [
            'title' => 'Sunting aturan ' . $rule->id,
            'resource' => 'rules',
            'noPagination' => true,
            'backURL' => '/rules',
            'items' => Symptom::all(),
            'items2' => Disease::all(),
            'theItem' => $rule,
            'item3' => Frequency::where('value', '>', 0)->count(),
        ];

        $antecedent_symptoms = AntecedentSymptom::where('rule_id', $rule->id)->get();

        $antecedentSymptomIds = [];
        
        foreach($antecedent_symptoms as $antecedent_symptom) {
            array_push(
                $antecedentSymptomIds,
                $antecedent_symptom->symptom_id
            );
        }

        $data['theItem']['antecedent_symptom_ids'] = $antecedentSymptomIds;

        $consequentSymptoms
        = ConsequentSymptom::where('rule_id', $rule->id)->get();
        
        $consequentSymptomIds = [];

        foreach($consequentSymptoms as $consequentSymptom) {
            array_push(
                $consequentSymptomIds,
                $consequentSymptom->symptom_id
            );
        }

        $data['theItem']['consequent_symptom_ids'] = $consequentSymptomIds;

        $consequentDisease
        = ConsequentDisease::where('rule_id', $rule->id)->first();

        if(!is_null($consequentDisease)) {
            $data['theItem']['consequent_disease_id']
            = $consequentDisease->disease_id;
        }

        return view('dashboard.' . $data['resource'] . '.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRuleRequest  $request
     * @param  \App\Models\Rule  $rule
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRuleRequest $request, Rule $rule)
    {   
        if($request->method === 'changeId') {
            $newId = (int) $request->validate([
                'id' => 'required|integer|exists:rules'
            ])['id'];

            $antecedent_symptoms = AntecedentSymptom::where('rule_id', $newId)->get();
            
            $consequentSymptoms
            = ConsequentSymptom::where('rule_id', $newId)->get();

            $consequentDisease
            = ConsequentDisease::where('rule_id', $newId)->first();

            AntecedentSymptom::where('rule_id', $newId)->delete();

            ConsequentSymptom::where('rule_id', $newId)->delete();

            ConsequentDisease::where('rule_id', $newId)->delete();

            AntecedentSymptom::where('rule_id', $rule->id)->update([
                'rule_id' => (int) $newId
            ]);

            ConsequentSymptom::where('rule_id', $rule->id)->update([
                'rule_id' => (int) $newId
            ]);

            ConsequentDisease::where('rule_id', $rule->id)->update([
                'rule_id' => (int) $newId
            ]);

            foreach($antecedent_symptoms as $antecedent_symptoms) {
                AntecedentSymptom::create([
                    'rule_id' => $rule->id,
                    'symptom_id' => $antecedent_symptoms->symptom_id
                ]);
            }

            foreach($consequentSymptoms as $consequentSymptom) {
                ConsequentSymptom::create([
                    'rule_id' => $rule->id,
                    'symptom_id' => $consequentSymptom->symptom_id
                ]);
            }

            if($consequentDisease) {
                ConsequentDisease::create([
                    'rule_id' => $rule->id,
                    'disease_id' => $consequentDisease->disease_id
                ]);
            }

            return redirect('/rules')
            ->with('message', (object) [
                'type' => 'success',
                'content' => 'Id. berhasil diganti.'
            ]);
        }

        $request->validate([
            'antecedent_symptom_ids' => 'array',
            'antecedent_symptom_count_from' => [
                'nullable',
                'integer',
                'min:0',
                'max:' . Symptom::count()
            ],
            'antecedent_symptom_count_to' => [
                'nullable',
                'integer',
                'min:0',
                'max:' . Symptom::count()
            ],
            'antecedent_symptom_score_from' => [
                'nullable',
                'integer',
                'min:0',
                'max:' . Symptom::count()
                * (Frequency::where('value', '>', 0)->count())
            ],
            'antecedent_symptom_score_to' => [
                'nullable',
                'integer',
                'min:0',
                'max:' . Symptom::count()
                * (Frequency::where('value', '>', 0)->count())
            ],
        ]);

        AntecedentSymptom::where('rule_id', $rule->id)->delete();

        AntecedentSymptomCount::where('rule_id', $rule->id)->delete();

        AntecedentSymptomScore::where('rule_id', $rule->id)->delete();

        ConsequentSymptom::where('rule_id', $rule->id)->delete();

        ConsequentDisease::where('rule_id', $rule->id)->delete();

        if(is_array($request->antecedent_symptom_ids)) {
            foreach($request->antecedent_symptom_ids as $antecedent_symptom_id) {
                AntecedentSymptom::create([
                    'rule_id' => $rule->id,
                    'symptom_id' => $antecedent_symptom_id
                ]);
            }
        }

        if($request->use_antecedent_symptom_count) {
            AntecedentSymptomCount::create([
                'rule_id' => $rule->id,
                'from' => $request->antecedent_symptom_count_from ?: null,
                'to' => $request->antecedent_symptom_count_to ?: null,
            ]);
        }

        if($request->use_antecedent_symptom_score) {
            AntecedentSymptomScore::create([
                'rule_id' => $rule->id,
                'from' => $request->antecedent_symptom_score_from ?: null,
                'to' => $request->antecedent_symptom_score_to ?: null,
            ]);
        }

        if(isset($request->consequent_symptom_ids)) {
            foreach($request->consequent_symptom_ids as $consequent_symptom_id) {
                ConsequentSymptom::create([
                    'rule_id' => $rule->id,
                    'symptom_id' => $consequent_symptom_id
                ]);
            }
        }

        if(!is_null($request->consequent_disease_id)) {
            ConsequentDisease::create([
                'rule_id' => $rule->id,
                'disease_id' => $request->consequent_disease_id
            ]);
        }

        return redirect('/rules')
        // return redirect('/rules/' . $rule->id . '/edit')
        ->with('message', (object) [
            'type' => 'success',
            'content' => 'Aturan berhasil disunting.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rule  $rule
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rule $rule)
    {
        AntecedentSymptom::where('rule_id', $rule->id)->delete();

        AntecedentSymptomCount::where('rule_id', $rule->id)->delete();

        AntecedentSymptomScore::where('rule_id', $rule->id)->delete();

        ConsequentSymptom::where('rule_id', $rule->id)->delete();

        ConsequentDisease::where('rule_id', $rule->id)->delete();
        
        $rule->delete();

        return redirect('/rules')
        ->with('message', (object) [
            'type' => 'success',
            'content' => 'Aturan berhasil dihapus.'
        ]);
    }
}
