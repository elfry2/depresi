<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // $table->string('name');
        // $table->string('email')->unique();
        // $table->timestamp('email_verified_at')->nullable();
        // $table->string('password');
        // $table->string('role')->default('knowledge_engineer');
        // $table->rememberToken();
        // $table->timestamps();

        foreach([
            RoleSeeder::class,
            UserSeeder::class,
            ExpertSeeder::class,
            DiseaseSeeder::class,
            SymptomSeeder::class,
            ProbabilitySeeder::class,
            RuleSeeder::class,
            AltRuleSeeder::class,
            FrequencySeeder::class,
        ] as $seeder) (new $seeder)->run();
    }
}
