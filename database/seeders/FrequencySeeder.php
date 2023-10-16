<?php

namespace Database\Seeders;

use App\Models\Frequency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FrequencySeeder extends Seeder
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
                'name' => 'Tidak pernah',
                'value' => 0,
            ],
            [
                'name' => 'Jarang',
                'value' => 1,
            ],
            [
                'name' => 'Sering',
                'value' => 2,
            ],
            [
                'name' => 'Hampir setiap hari',
                'value' => 3,
            ],
        ] as $frequency) Frequency::create($frequency);
    }
}
