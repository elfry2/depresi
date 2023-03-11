<?php

namespace App\Http\Controllers;

use App\Models\Rule;
use App\Models\Disease;
use App\Models\Symptom;
use App\Models\Antecedent;
use App\Models\ConsequentDisease;
use App\Models\ConsequentSymptom;
use App\Http\Requests\StoreRuleRequest;
use App\Http\Requests\UpdateRuleRequest;

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
            
            $ruleIdsFromAntecedents = Antecedent::select('rule_id')
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
            = $data['items']->whereIn('id', $ruleIdsFromAntecedents)
            ->orWhereIn('id', $ruleIdsFromConsequentSymptoms)
            ->orWhereIn('id', $ruleIdsFromConsequentDiseases);
        }

        /* END Search */

        $data['items'] = $data['items']->paginate(config('app.itemsPerPage'));

        for($i = 0; $i < count($data['items']); $i++) {
            $antecedentNames = [];

            foreach($data['items'][$i]->antecedents as $antecedent) {
                array_push($antecedentNames, $antecedent->symptom->name);
            }

            $data['items'][$i]->antecedents 
            = ucfirst(strtolower(implode('; ', $antecedentNames)));
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
            'items2' => Disease::all()
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
            'antecedent_ids' => 'required'
        ]);
        
        $rule = Rule::create();

        foreach($request->antecedent_ids as $antecedent_id) {
            Antecedent::create([
                'rule_id' => $rule->id,
                'symptom_id' => $antecedent_id
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
            'theItem' => $rule
        ];

        $antecedents = Antecedent::where('rule_id', $rule->id)->get();

        $antecedentIds = [];
        
        foreach($antecedents as $antecedent) {
            array_push(
                $antecedentIds,
                $antecedent->symptom_id
            );
        }

        $data['theItem']['antecedent_ids'] = $antecedentIds;

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

            $antecedents = Antecedent::where('rule_id', $newId)->get();
            
            $consequentSymptoms
            = ConsequentSymptom::where('rule_id', $newId)->get();

            $consequentDisease
            = ConsequentDisease::where('rule_id', $newId)->first();

            Antecedent::where('rule_id', $newId)->delete();

            ConsequentSymptom::where('rule_id', $newId)->delete();

            ConsequentDisease::where('rule_id', $newId)->delete();

            Antecedent::where('rule_id', $rule->id)->update([
                'rule_id' => (int) $newId
            ]);

            ConsequentSymptom::where('rule_id', $rule->id)->update([
                'rule_id' => (int) $newId
            ]);

            ConsequentDisease::where('rule_id', $rule->id)->update([
                'rule_id' => (int) $newId
            ]);

            foreach($antecedents as $antecedent) {
                Antecedent::create([
                    'rule_id' => $rule->id,
                    'symptom_id' => $antecedent->symptom_id
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
            'antecedent_ids' => 'required'
        ]);

        Antecedent::where('rule_id', $rule->id)->delete();

        ConsequentSymptom::where('rule_id', $rule->id)->delete();

        ConsequentDisease::where('rule_id', $rule->id)->delete();

        foreach($request->antecedent_ids as $antecedent_id) {
            Antecedent::create([
                'rule_id' => $rule->id,
                'symptom_id' => $antecedent_id
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
        ->with('message', (object) [
            'type' => 'success',
            'content' => 'Aturan berhasil ditambahkan.'
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
        Antecedent::where('rule_id', $rule->id)->delete();

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
