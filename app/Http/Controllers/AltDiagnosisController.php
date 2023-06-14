<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AltDiagnosisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected static $title = 'Skrining';
    protected static $resource = 'diagnosis';

    public function index()
    {
        $data = [
            'title' => self::$title,
            'resource' => self::$resource
        ];

        if(
            !is_array(session('workspace'))
            || request('purgeWorkspace')
        ) session([
            'workspace' => [
                'iteratedSymptoms' => []
            ]
        ]);

        return view('alt-diagnosis.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'title' => self::$title,
            'resource' => self::$resource
        ];
        
        $workspace = (object) session('workspace');

        $symptoms = Symptom::all();

        $currentSymptom = null;

        foreach($symptoms as $symptom)
        if (!in_array($symptom->id, $workspace->iteratedSymptomIds))
        $currentSymptom = $symptom;

        if(!isset($currentSymptom))
        return redirect('/' . self::$resource . '/result');

        $data['item'] = $currentSymptom;

        return view('alt-diagnosis.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request = $request->validate([
            'symptomId' => 'required|integer',
            'score' => 'required|integer'
        ]);

        $workspace = (object) session('workspace');

        $symptom = Symptom::find($request->symptomId);

        $symptom->score = $request->score;

        if($symptom->score > 0)
        array_push($workspace->iteratedSymptoms, $symptom);

        session(['workspace' => (array) $workspace]);

        return redirect('/' . self::$resource . '/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $workspace = (object) session('workspace');

        $score = 0;

        foreach($workspace->iteratedSymptoms as $symptom)
        $score += $symptom->score;

        $disease = null;

        foreach(Rule::all() as $rule) {
            if(
                $score >= $rule->min
                && ($rule->max === 0 || $score <= $rule->max)
            ) $disease = $rule->disease;
        }

        /* Naive bayes goes here */

        $data = [
            'title' => self::$title,
            'resource' => self::$resource,
            'item' => $disease
        ];

        return view('alt-diagnosis.show', $data);
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
