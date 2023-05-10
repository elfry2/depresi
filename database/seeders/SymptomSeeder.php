<?php

namespace Database\Seeders;

use App\Models\Symptom;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SymptomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach([
            'Kesedihan yang amat sangat hampir setiap hari dalam dua minggu terakhir',
            'Perasaan tidak berarti dan bersalah hampir setiap hari dalam dua minggu terakhir',
            'Keinginan untuk menarik diri dari orang lain hampir setiap hari dalam dua minggu terakhir',
            'Kesulitan untuk tidur atau terlalu banyak tidur hampir setiap hari dalam dua minggu terakhir',
            'Kehilangan berat badan dan selera makan hampir setiap hari dalam dua minggu terakhir',
            'Kehilangan hasrat seksual hampir setiap hari dalam dua minggu terakhir',
            'Kehilangan minat pada aktivitas-aktivitas yang biasa dilakukan hampir setiap hari dalam dua minggu terakhir',
            'Tidak mendapatkan kesenangan dari aktivitas-aktivitas yang biasa dilakukan hampir setiap hari dalam dua minggu terakhir',
            'Sulit memusatkan perhatian hampir setiap hari dalam dua minggu terakhir'
        ] as $item) {
            Symptom::create(['name' => $item]);
        }
    }
}
