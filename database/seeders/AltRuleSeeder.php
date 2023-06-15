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
                'min' => 3,
                'max' => 33,
                'disease_id' => 1
            ],
            [
                'min' => 34,
                'max' => 66,
                'disease_id' => 2
            ],
            [
                'min' => 67,
                'max' => null,
                'disease_id' => 3
            ],
        ] as $item) AltRule::create($item);
    }
}
