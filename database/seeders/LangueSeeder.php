<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Langue;

class LangueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Langue::firstOrCreate(
            ['code_langue' => 'fr'],
            ['nom_langue' => 'Français', 'description' => 'Langue française']
        );
        Langue::firstOrCreate(
            ['code_langue' => 'en'],
            ['nom_langue' => 'Anglais', 'description' => 'Langue anglaise']
        );
        Langue::firstOrCreate(
            ['code_langue' => 'es'],
            ['nom_langue' => 'Espagnol', 'description' => 'Langue espagnole']
        );
    }
}
