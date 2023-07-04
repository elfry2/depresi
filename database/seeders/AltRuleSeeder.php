<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AltRule;

class AltRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach([
            [
                'min' => 0,
                'max' => 25,
                'disease_id' => 1
            ],
            [
                'min' => 26,
                'max' => 50,
                'disease_id' => 2
            ],
            [
                'min' => 51,
                'max' => 75,
                'disease_id' => 3
            ],
            [
                'min' => 76,
                'disease_id' => 4
            ],
        ] as $item) AltRule::create($item);
    }
}
