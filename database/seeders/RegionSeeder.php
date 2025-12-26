<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Region;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Region::firstOrCreate(
            ['nom_region' => 'Île-de-France'],
            ['description' => 'Région', 'localisation' => 'France', 'superficie' => '0', 'population' => '0']
        );
        Region::firstOrCreate(
            ['nom_region' => 'Provence-Alpes-Côte d\'Azur'],
            ['description' => 'Région', 'localisation' => 'France', 'superficie' => '0', 'population' => '0']
        );
        Region::firstOrCreate(
            ['nom_region' => 'Auvergne-Rhône-Alpes'],
            ['description' => 'Région', 'localisation' => 'France', 'superficie' => '0', 'population' => '0']
        );
        Region::firstOrCreate(
            ['nom_region' => 'Nouvelle-Aquitaine'],
            ['description' => 'Région', 'localisation' => 'France', 'superficie' => '0', 'population' => '0']
        );
        Region::firstOrCreate(
            ['nom_region' => 'Occitanie'],
            ['description' => 'Région', 'localisation' => 'France', 'superficie' => '0', 'population' => '0']
        );
    }
}
