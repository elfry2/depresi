<?php

namespace App\Http\Controllers;

use App\Models\Disease;
use App\Models\Symptom;
use Illuminate\Http\Request;

class BayesDemoController extends Controller
{
    public function index() {
        $data = [
            'title' => 'Bayes Demo',
            'evidences' => Symptom::all(),
            'hypotheses' => Disease::all(),
        ];

        return view('bayes-demo.index', $data);
    }

    public function result(Request $request) {
        $evidences = Symptom::whereIn('id', $request->evidenceIds ?: [])->get();
        $hypothesis = Disease::find($request->hypothesisId);
        
        $bayes = BayesController::getProbability(
            $evidences,
            $hypothesis
        );

        $data = [
            'evidences' => $evidences,
            'hypothesis' => $hypothesis,
            'probability' => $bayes
        ];

        return view('bayes-demo.result', $data);
    }
}
