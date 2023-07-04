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
        foreach([
            [0.2, 0.2, 0.5, 1.0],
            [0.0, 0.2, 0.5, 1.0],
            [0.2, 0.5, 0.5, 0.7],
            [0.2, 0.2, 0.5, 1.0],
            [0.5, 0.5, 0.5, 0.7],
            [0.2, 0.5, 0.5, 1.0],
            [0.0, 0.5, 0.5, 1.0],
            [0.2, 0.5, 0.5, 1.0],
            [0.2, 0.5, 0.5, 0.7],
            [0.2, 0.5, 0.5, 0.7],
            [0.2, 0.5, 0.5, 0.7],
            [0.2, 0.5, 0.5, 0.7],
            [0.2, 0.5, 0.5, 0.7],
            [0.7, 0.7, 0.7, 0.7],
            [0.2, 0.5, 0.5, 0.7],
            [0.2, 0.5, 0.5, 0.7],
            [0.2, 0.5, 0.5, 0.7],
            [0.2, 0.5, 0.5, 0.7],
            [0.7, 0.7, 0.7, 0.7],
            [0.2, 0.5, 0.5, 0.5],
            [0.5, 0.5, 0.5, 1.0],
            [0.2, 0.5, 0.5, 1.0],
            [0.2, 0.2, 0.2, 0.5],
            [0.2, 0.2, 0.5, 0.5],
            [0.2, 0.5, 0.5, 0.7],
            [0.2, 0.7, 0.7, 0.7],
            [0.2, 0.5, 0.5, 0.7],
            [0.2, 0.5, 0.5, 1.0],
            [0.2, 0.5, 0.5, 0.7],
            [0.2, 0.5, 0.5, 0.7],
            [0.5, 0.5, 0.5, 0.5],
            [0.2, 0.5, 0.5, 0.7],
            [0.2, 0.5, 0.5, 1.0]
        ] as $yKey => $yValue)
        foreach($yValue as $xKey => $xValue) Probability::create([
            'disease_id' => $xKey+1,
            'symptom_id' => $yKey+1,
            'amount' => $xValue
        ]);
    }
}
