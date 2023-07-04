<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AltRule;
use App\Models\Expert;
use App\Models\Symptom;
use App\Models\Disease;

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
            'resource' => self::$resource,
            'item' => Symptom::count()
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
        if(is_null(session('workspace')))
        return redirect('/' . self::$resource);

        $data = [
            'title' => self::$title,
            'resource' => self::$resource
        ];
        
        $workspace = (object) session('workspace');

        $symptoms = Symptom::all();

        $currentSymptom = null;

        $iteratedSymptomIds = array_map(function($item) {
            return $item->id;
        }, $workspace->iteratedSymptoms);

        foreach($symptoms as $symptom)
        if (!in_array($symptom->id, $iteratedSymptomIds)) {
            $currentSymptom = $symptom;
            break;
        }

        if(!isset($currentSymptom))
        return redirect('/' . self::$resource . '/result');

        $data['item'] = $currentSymptom;

        // $data['debug'] = [
        //     'workspace' => $workspace
        // ];

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
        $request->validate([
            'id' => 'required|integer',
            'score' => 'required|integer'
        ]);

        $workspace = (object) session('workspace');

        $symptom = Symptom::find($request->id);

        $symptom->score = (int) $request->score;

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
        if(is_null(session('workspace')))
        return redirect('/' . self::$resource);

        $data = [
            'title' => self::$title,
            'resource' => self::$resource,
            'item' => Disease::where('is_healthy', true)->first()
        ];

        $workspace = (object) session('workspace');

        $score = 0;

        foreach($workspace->iteratedSymptoms as $symptom)
        $score += $symptom->score;

        foreach(AltRule::all() as $rule) {
            if(
                (is_null($rule->min) || $score >= $rule->min)
                && (is_null($rule->max) || $score <= $rule->max)
            ) { 
                $data['item'] = $rule->disease;
            }
        }

        /* BEGIN Naive bayes */

        $evidences
        = array_filter($workspace->iteratedSymptoms, function($item) {
            return $item->score > 0;
        });
        

        $hypothesis = $data['item'];

        $hypotheses = Disease::all();

        $numerator = $hypothesis->probability;

        $floatPrecision = 5;
        
        $sampleCount = 10 ** $floatPrecision;

        foreach($evidences as $evidence)
        {
            $smoothie = $evidence->probability_given($hypothesis)
            * $sampleCount;
            
            $smoothie++;

            $smoothie /= ($sampleCount + count($evidences));

            $numerator *= $smoothie;
        }

        $denominator = 0;

        foreach($hypotheses as $hypothesis) {
            $probability = $hypothesis->probability;

            foreach($evidences as $evidence)
            {
                $smoothie = $evidence->probability_given($hypothesis)
                * $sampleCount;
                
                $smoothie++;
    
                $smoothie /= ($sampleCount + count($evidences));
    
                $probability *= $smoothie;
            }

            $denominator += $probability;
        }

        $data['item']->bayes = $numerator / $denominator;

        /* END Naive bayes */

        $data['item']->score = $score;
        $data['items2'] = collect($workspace->iteratedSymptoms);
        $data['items3'] = Expert::all();

        session(['workspace' => null]);

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
