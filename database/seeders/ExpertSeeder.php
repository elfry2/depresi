<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Expert;

class ExpertSeeder extends Seeder
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
                'name' => 'Gita Yolanda, M.Psi., Psikolog',
                'address' => 'Jl. Sukarno Hatta Kompleks Damai Langgeng Blok B No. 22',
                'phone_number' => 6285292856052,
                'has_whatsapp' => 1,
                'path_to_photo' => 'expert-photos/WhatsApp Image 2023-05-10 at 08.47.20.jpeg'
            ],
            [
                'name' => 'Fara Ulfa, M.Psi., Psikolog',
                'address' => 'Yayasan Praktik Psikolog Indonesia, Jl. Todak No. 18, Pekanbaru',
                'phone_number' => 6281364286335,
                'has_whatsapp' => 1,
                'path_to_photo' => 'expert-photos/WhatsApp Image 2023-05-10 at 08.01.49 Cropped.jpg'
            ]
        ] as $expert) Expert::create($expert);
    }
}
