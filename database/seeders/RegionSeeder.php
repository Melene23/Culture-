<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Region::create(['nom_region'=>'Île-de-France']);
        Region::create(['nom_region'=>'Provence-Alpes-Côte d\'Azur']);
        Region::create(['nom_region'=>'Auvergne-Rhône-Alpes']);
        Region::create(['nom_region'=>'Nouvelle-Aquitaine']);
        Region::create(['nom_region'=>'Occitanie']);
    }
}
