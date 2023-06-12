<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Rule;
use App\Models\Antecedent;
use App\Models\ConsequentSymptom;
use App\Models\ConsequentDisease;

// [A B C D E] C 3
// A B C
// A B D
// A B E
// A C D
// A C E
// A D E
// B C D
// B C E
// B D E
// C D E
// function factorial(float $number)
// {
//     if($number == 1) return 1;

//     return factorial($number-1) * $number;
// }

// function generateCombination(
//     array $data,
//     int $size,
//     array $mustInclude = null)
// {
//     // Calculate number of possible combinations
//     $possibleCombinationCount
//     = factorial(count($data))
//     /(factorial($size)
//     *factorial(count($data)-$size));
    
//     $combinations = [];
    
//     for($i = 0; $i < $possibleCombinationCount; $i++)
//     {
//     	$combination = array_slice($data, 0, $size);
        
//         if(in_array($combination, $combinations))
//         {
//         	for($j = $size-1; $j >= 0; $j--)
//             {
//             	$temp = $combination;
                
//                 $ok = false;

//                 for($k = 0; $k < count($data); $k++)
//                 {
//                     if(!in_array($data[$k], $temp))
//                     {
//                         $temp[$j] = $data[$k];
                        
//                         if(!in_array($temp, $combinations))
//                         {
//                         	$ok = true;
                        
//                         	break;
//                         }
//                     }
//                 }

//                 if($ok)
//                 {
//                 	$combination = $temp;
                    
//                     break;
//                 }
//             }
//         }
        
//         array_push($combinations, $combination);
//     }
    
//     return $combinations;
// }

// echo "<pre>";
// print_r(generateCombination([A, B, C, D, E], 3));
// echo "</pre>";

class RuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ruleId = Rule::create()->id;

        foreach([1, 2, 3, 4, 5] as $symptomId) Antecedent::create([
            'rule_id' => $ruleId,
            'symptom_id' => $symptomId
        ]);

        ConsequentDisease::create([
            'rule_id' => $ruleId,
            'disease_id' => 1
        ]);
    }
}
