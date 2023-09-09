<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BayesController extends Controller
{
    public static function getProbability(
        $hypothesis,
        $evidences,
    ) {
        /* BEGIN Naive bayes */

        $hypotheses = get_class($hypothesis)::all();

        $numerator = $hypothesis->probability;

        $sampleCount = env('LAPLACE_SAMPLE_COUNT');

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

        return $numerator / $denominator;

        /* END Naive bayes */
    }
}
