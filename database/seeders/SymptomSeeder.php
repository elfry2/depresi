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
            'Saya merasa sedih sepanjang hari',
            'Orang lain melihat saya selalu murung',
            'Saya di sebagian besar waktu merasa kesepian',
            'Saya di sebagian besar waktu merasa tidak punya harapan hidup',
            'Akhir-akhir ini saya merasa mudah tersinggung',
            'Secara tiba-tiba saya kehilangan minat untuk beraktivitas',
            'Saya sering merasa senang dalam melewati hari-hari',
            'Saya merasa bahwa diri saya tidak berarti dan merasa bersalah di sebagian besar waktu',
            'Saya mengalami kesulitan untuk tidur hampir setiap hari',
            'Saya kehilangan berat badan padahal tidak sedang menjalani program diet, dan kehilangan selera makan di sebagian besar waktu',
            'Saya kehilangan minat terhadap aktivitas-aktivitas yang biasa dilakukan di sebagian besar waktu',
            'Saya sulit mendapatkan kesenangan dari aktivitas-aktivitas yang biasa dilakukan di sebagian besar waktu',
            'Saya sulit memusatkan perhatian di sebagian besar waktu',
            'Saya merasa percakapan adalah suatu pekerjaan yang melelahkan di sebagian besar waktu',
            'Saya merasa kesulitan dalam memikirkan cara menyelesaikan masalah di sebagian besar waktu',
            'Saya memiliki pikiran yang menyalahkan diri di sebagian besar waktu',
            'Saya mengabaikan kebersihkan dan penampilan diri di sebagian besar waktu',
            'Saya merasa berkecil hati di sebagian besar waktu',
            'Saya merasa tidak memiliki harapan di sebagian besar waktu',
            'Saya merasa pesimis di sebagian besar waktu',
            'Saya merasa lemah dan tidak bertenaga di sebagian besar waktu',
            'Saya mengalami peningkatan berat badan dan selera makan yang drastis di sebagian besar waktu',
            'Saya tidur terlalu lama hampir setiap hari',
            'Saya merasakan kesulitan yang lebih dalam melakukan hal-hal yang biasanya dilakukan di sebagian besar waktu',
            'Saya merasa lebih mudah tersinggung dibandingkan biasanya di sebgian waktu',
            'Saya memiliki keinginan untuk menyimpang dari pola hidup sehari-hari di sebagian besar waktu',
            'Saya merasa bahwa orang-orang akan merasa lebih baik apabila saya tiada di sebagian besar waktu',
            'Saya pernah punya pikiran untuk mengakhiri hidup'
        ] as $item) Symptom::create(['name' => $item]);
    }
}
