<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Probability;
use App\Models\Symptom;
use App\Models\Disease;

class ProbabilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // foreach([
        //     [1, 0.8, 0.8, 0.7, 0.7, 0.8, 0.8],
        //     [0.6, 0.5, 0.5, 0.5, 0.5, 0.5, 0.5],
        //     [0.7, 0.5, 0.5, 0.5, 0.5, 0.5, 0.5],
        //     [0.7, 0.5, 0.5, 0.5, 0.5, 0.5, 0.5],
        //     [0.5, 0.5, 0.5, 0.5, 0.5, 0.5, 0.5],
        //     [0.5, 0.5, 0.5, 0.5, 0.5, 0.5, 0.5],
        //     [0.7, 0.6, 0.6, 0.6, 0.6, 0.6, 0.6],
        //     [0.6, 0.6, 0.6, 0.6, 0.6, 0.6, 0.6],
        //     [0.6, 0.6, 0.6, 0.6, 0.6, 0.6, 0.6]
        // ] as $yKey => $yValue)
        // foreach($yValue as $xKey => $xValue) Probability::create([
        //     'disease_id' => $xKey+1,
        //     'symptom_id' => $yKey+1,
        //     'amount' => $xValue
        // ]);

        foreach(Symptom::all() as $symptom) {
            foreach(Disease::all() as $disease) {
                Probability::create([
                    'disease_id' => $disease->id,
                    'symptom_id' => $symptom->id,
                    'amount' => 1
                ]);
            }
        }
    }
}
