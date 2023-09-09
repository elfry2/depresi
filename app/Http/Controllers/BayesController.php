<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BayesController extends Controller
{

    protected static function smoothen(
        float $probability,
        int $dimension,
        int $sampleCount = null,
        int $alpha = 1)  {
        if(is_null($sampleCount)) $sampleCount
        = config('app.laplaceSampleCount');

        return ($probability * $sampleCount + $alpha)
        / ($sampleCount + ($dimension * $alpha));
    }
    public static function getProbability(
        $hypothesis,
        $evidences,
    ) {
        /* BEGIN Naive bayes */

        $hypotheses = get_class($hypothesis)::all();

        $numerator = self::smoothen($hypothesis->probability, count($evidences));

        foreach($evidences as $evidence)
        {
            // $smoothie = $evidence->probability_given($hypothesis)
            // * $sampleCount;
            
            // $smoothie++;

            // $smoothie /= ($sampleCount + count($evidences));

            $probability = self::smoothen(
                $evidence->probability_given($hypothesis),
                count($evidences)
            );

            $numerator *= $probability;
        }

        $denominator = 0;

        foreach($hypotheses as $hypothesis) {
            $probability
            = self::smoothen($hypothesis->probability, count($evidences));

            foreach($evidences as $evidence)
            {
                // $smoothie = $evidence->probability_given($hypothesis)
                // * $sampleCount;
                
                // $smoothie++;
    
                // $smoothie /= ($sampleCount + count($evidences));
    
                // $probability *= $smoothie;
                
                $probability *= self::smoothen(
                    $evidence->probability_given($hypothesis),
                    count($evidences)
                );
            }

            $denominator += $probability;
        }

        // return (0.99980*0.99980*0.99980*0.10006)/((0.20003*0.20003*0.20003*0.99980) + (0.20003*0.20003*0.49995*0.20003) + (0.49995*0.49995*0.49995*0.10006) + (0.99980*0.99980*0.99980*0.10006));
        return $numerator / $denominator;

        /* END Naive bayes */
    }
}
