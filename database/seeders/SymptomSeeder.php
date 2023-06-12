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
            'Kesedihan yang cukup besar dalam dua minggu terakhir',
            'Tidak bersemangat dalam dua minggu terakhir',
            'Menarik diri dari orang lain di sebagian besar waktu selama sekurang-kurangnya dua minggu terakhir',
            'Kesulitan untuk tidur hampir setiap hari selama sekurang-kurangnya dua minggu terakhir',
            'Penurunan nafsu makan dalam dua minggu terakhir',
            'Kehilangan hasrat seksual di sebagian besar waktu selama sekurang-kurangnya dua minggu terakhir',
            'Kehilangan minat pada aktivitas-aktivitas yang biasa dilakukan di sebagian besar waktu selama sekurang-kurangnya dua minggu terakhir',
            'Tidak mendapatkan kesenangan dari aktivitas-aktivitas yang biasa dilakukan di sebagian besar waktu selama sekurang-kurangnya dua minggu terakhir',
            'Sulit memusatkan perhatian di sebagian besar waktu selama sekurang-kurangnya dua minggu terakhir',
            'Jika sedang membaca, sulit memahami apa yang dibaca di sebagian besar waktu selama sekurang-kurangnya dua minggu terakhir',
            'Jika sedang berbicara dengan orang lain, sulit memahami apa yang dikatakan lawan bicara di sebagian besar waktu selama sekurang-kurangnya dua minggu terakhir',
            'Merasa percakapan adalah suatu pekerjaan yang melelahkan di sebagian besar waktu selama sekurang-kurangnya dua minggu terakhir',
            'Berbicara dengan lambat di sebagian besar waktu selama sekurang-kurangnya dua minggu terakhir',
            'Berbicara sangat sedikit di sebagian besar waktu selama sekurang-kurangnya dua minggu terakhir',
            'Berbicara dengan nada suara rendah dan monoton di sebagian besar waktu selama sekurang-kurangnya dua minggu terakhir',
            'Lebih suka sendirian dan berdiam diri di sebagian besar waktu selama sekurang-kurangnya dua minggu terakhir',
            'Merasa sangat bersemangat dan tidak dapat duduk tenang di sebagian besar waktu selama sekurang-kurangnya dua minggu terakhir',
            'Bergerak cepat dan terburu-buru di sebagian besar waktu selama sekurang-kurangnya dua minggu terakhir',
            'Impuls untuk meremas tangan hampir setiap hari selama sekurang-kurangnya dua minggu terakhir',
            'Mengeluarkan suara mengeluh dan menyampaikan keluhan hampir setiap hari selama sekurang-kurangnya dua minggu terakhir',
            'Kesulitan dalam memikirkan cara menyelesaikan masalah di sebagian besar waktu selama sekurang-kurangnya dua minggu terakhir',
            'Pikiran menyalahkan diri sendiri di sebagian besar waktu selama sekurang-kurangnya dua minggu terakhir',
            'Mengabaikan kebersihan dan penampilan diri di sebagian besar waktu selama sekurang-kurangnya dua minggu terakhir',
            'Mengeluhkan simtom-simtom somatik tanpa gangguan fisik yang jelas hampir setiap hari selama sekurang-kurangnya dua minggu terakhir',
            'Sangat berkecil hati di sebagian besar waktu selama sekurang-kurangnya dua minggu terakhir',
            'Merasa tidak memiliki harapan di sebagian besar waktu selama sekurang-kurangnya dua minggu terakhir',
            'Tidak memiliki inisiatif di sebagian besar waktu selama sekurang-kurangnya dua minggu terakhir',
            'Selalu merasa khawatir di sebagian besar waktu selama sekurang-kurangnya dua minggu terakhir',
            'Merasa pesimis di sebagian besar waktu selama sekurang-kurangnya dua minggu terakhir',
            'Gangguan memori jangka pendek hampir setiap hari selama sekurang-kurangnya dua minggu terakhir',
            'Sakit kepala hampir setiap hari selama sekurang-kurangnya dua minggu terakhir',
            'Merasa lemah dan tidak bertenaga di sebagian besar waktu selama sekurang-kurangnya dua minggu terakhir',
            'Peningkatan drastis berat badan dan selera makan di sebagian besar waktu selama sekurang-kurangnya dua minggu terakhir',
            'Tidur terlalu lama hampir setiap hari selama sekurang-kurangnya dua minggu terakhir',
            'Merasa tertekan di pagi hari hampir setiap hari selama sekurang-kurangnya dua minggu terakhir',
            'Menangis tanpa alasan yang jelas hampir setiap hari selama sekurang-kurangnya dua minggu terakhir',
            'Mengalami masalah konstipasi hampir setiap hari selama sekurang-kurangnya dua minggu terakhir',
            'Detak jantung yang lebih cepat daripada biasanya hampir setiap hari selama sekurang-kurangnya dua minggu terakhir',
            'Merasakan kesulitan yang lebih dalam melakukan hal-hal yang biasanya dilakukan di sebagian besar waktu selama sekurang-kurangnya dua minggu terakhir',
            'Lebih mudah tersinggung dibandingkan biasanya di sebagian besar waktu selama sekurang-kurangnya dua minggu terakhir',
            'Kesulitan yang lebih dalam membuat keputusan di sebagian besar waktu selama sekurang-kurangnya dua minggu terakhir',
            'Memiliki keinginan untuk menyimpang dari pola hidup sehari-hari di sebagian besar waktu selama sekurang-kurangnya dua minggu terakhir',
            'Cenderung menunda kegiatan yang tidak memberi kepuasan segera di sebagian besar waktu selama sekurang-kurangnya dua minggu terakhir',
            'Lebih menyukai kegiatan pasif di sebagian besar waktu selama sekurang-kurangnya dua minggu terakhir',
            'Peningkatan intensitas simtom-simtom lainnya pada musim tertentu di sebagian besar waktu selama sekurang-kurangnya dua minggu terakhir',
            'Baru saja melahirkan dalam periode paling lama empat minggu terakhir',
            'Mengalami berbagai periode mood tertekan ringan disertai hipomania selama sekurang-kurangnya dua bulan terakhir',
            'Berhalusinasi hampir setiap hari selama sekurang-kurangnya dua minggu terakhir',
            'Merasa bahwa orang-orang akan merasa lebih baik jika ia tiada di sebagian besar waktu selama sekurang-kurangnya dua minggu terakhir',
            'Gejala-gejala tersebut dialami di sebagian besar waktu selama sekurang-kurangnya dua bulan terakhir',
            'Pikiran tentang kematian yang berulang kali timbul (bukan hanya takut mati), ideasi bunuh diri yang berulang kali timbul tanpa tencana spesifik, atau usaha bunuh diri atau rencana spesifik untuk melakukan bunuh diri'
        ] as $item) {
            Symptom::create(['name' => $item]);
        }
    }
}
