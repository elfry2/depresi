<?php

namespace Database\Seeders;

use App\Models\Disease;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DiseaseSeeder extends Seeder
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
                'name' => 'Gangguan Depresif Mayor',
                'probability' => 0
            ],
            [
                'name' => 'Depresi Hipomanik',
                'probability' => 0
            ],
            [
                'name' => 'Depresi Psikotik',
                'probability' => 0
            ],
            [
                'name' => 'Depresi Melankolik',
                'probability' => 0
            ],
            [
                'name' => 'Depresi Pasca-Melahirkan',
                'probability' => 0
            ],
            [
                'name' => 'Depresi Musiman',
                'probability' => 0
            ],
            [
                'name' => 'Distimia',
                'probability' => 0
            ],
            [
                'name' => 'Gangguan Siklotimik',
                'probability' => 0
            ],
            
        ] as $item) {
            Disease::create($item);
        }
    }
}
