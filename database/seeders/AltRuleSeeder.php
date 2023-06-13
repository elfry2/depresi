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
                'max' => 0,
                'disease_id' => 1
            ],
            [
                'min' => 0,
                'max' => 0,
                'disease_id' => 2
            ],
            [
                'min' => 0,
                'max' => 0,
                'disease_id' => 3
            ],
        ] as $item) AltRule::create($item);
    }
}
