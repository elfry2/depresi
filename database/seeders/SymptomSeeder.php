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
            'Mood depresif di sebagian besar waktu, hampir setiap hari dalam dua minggu terakhir',
            'Minat dan kesenangan yang berkurang tajam terhadap sebagian besar, jika tidak semua, aktivitas di sebagian besar waktu, nyaris setiap hari dalam dua minggu terakhir',
            'Penurunan atau peningkatan berat badan lebih dari 5% dalam satu bulan terakhir padahal tidak sedang berdiet, atau penurunan atau peningkatan nafsu makan nyaris setiap hari dalam dua minggu terakhir',
            'Kesulitan untuk tidur atau terlalu banyak tidur hampir setiap hari dalam dua minggu terakhir',
            'Agitasi atau retardasi psikomotorik hampir setiap hari dalam dua minggu terakhir',
            'Kelelahan atau kehilangan energi hampir setiap hari dalam dua minggu terakhir',
            'Perasaan bahwa diri anda tidak berharga, atau rasa bersalah yang berlebihan atau tidak pada tempatnya hampir setiap hari dalam dua minggu terakhir',
            'Kesulitan untuk berpikir dan berkonsentrasi, atau kesulitan berlebih dalam mengambil keputusan hampir setiap hari dalam dua minggu terakhir',
            'Pikiran tentang kematian yang berulang kali timbul (bukan hanya ketakutan), ideasi atau usaha bunuh diri yang berulang kali timbul tanpa atau dengan rencana spesifik dalam dua minggu terakhir',
            'Peningkatan kondisi mental dan energi yang tidak normal dalam dua minggu terakhir',
            'Kesulitan untuk membedakan mana hal yang bersifat kenyataan dan mana yang merupakan imajinasi dalam dua minggu terakhir',
            'Lebih tertekan di pagi hari hampir setiap hari dalam dua minggu terakhir',
            'Baru saja melahirkan dalam satu bulan terakhir',
            'Perubahan mood yang terjadi saat pergantian musim, atau merasa lebih tertekan pada musim yang lebih dingin',
            'Simtom-simtom tersebut telah dirasakan sejak dua tahun terakhir dan tidak pernah absen selama lebih dari dua bulan',
            'Penurunan dan peningkatan kondisi mental dan energi secara bergantian dalam dua bulan terakhir'



        ] as $item) {
            Symptom::create(['name' => $item]);
        }
    }
}
