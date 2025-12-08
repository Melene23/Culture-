<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LangueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        langue::create(['nom_langue'=>'Français']);
        langue::create(['nom_langue'=>'Anglais']);
        langue::create(['nom_langue'=>'Espagnol']);
    }
}
