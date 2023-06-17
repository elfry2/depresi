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
            'Saya merasa kesepian',
            'Saya merasa tidak punya harapan hidup',
            // 'Akhir-akhir ini saya merasa mudah tersinggung',
            // 'Secara tiba-tiba saya kehilangan minat untuk beraktivitas',
            // 'Saya sulit merasa senang dalam melewati hari-hari',
            // 'Saya merasa bahwa diri saya tidak berarti dan merasa bersalah',
            // 'Saya menarik diri dari orang lain',
            // 'Saya mengalami kesulitan untuk tidur hampir setiap hari',
            // 'Saya kehilangan berat badan secara drastis padahal tidak sedang menjalani program diet, dan kehilangan selera makan',
            // 'Saya kehilangan minat terhadap aktivitas-aktivitas yang biasa dilakukan',
            // 'Saya sulit mendapatkan kesenangan dari aktivitas-aktivitas yang biasa dilakukan',
            // 'Saya sulit memusatkan perhatian',
            // 'Saya merasa percakapan adalah suatu pekerjaan yang melelahkan',
            // 'Saya merasa kesulitan dalam memikirkan cara menyelesaikan masalah',
            // 'Saya memiliki pikiran yang menyalahkan diri sendiri',
            // 'Saya mengabaikan kebersihkan dan penampilan diri',
            // 'Saya merasa berkecil hati',
            // 'Saya merasa tidak memiliki harapan',
            // 'Saya merasa pesimis',
            // 'Saya merasa lemah dan tidak bertenaga',
            // 'Saya mengalami peningkatan berat badan dan selera makan yang drastis',
            // 'Saya tidur terlalu lama hampir setiap hari',
            // 'Saya menangis tanpa alasan yang jelas',
            // 'Saya merasakan kesulitan yang lebih dalam melakukan hal-hal yang biasanya dilakukan',
            // 'Saya merasa lebih mudah tersinggung dibandingkan biasanya di sebagian waktu',
            // 'Saya merasakan kesulitan yang lebih dalam membuat keputusan',
            // 'Saya memiliki keinginan untuk menyimpang dari pola hidup sehari-hari',
            // 'Saya cenderung menunda kegiatan yang tidak memberikan kepuasan segera',
            // 'Saya lebih menyukai kegiatan pasif',
            // 'Saya merasa bahwa orang-orang akan merasa lebih baik apabila saya tiada',
            'Saya pernah punya pikiran untuk mengakhiri hidup'
        ] as $item) Symptom::create(['name' => $item]);
    }
}
