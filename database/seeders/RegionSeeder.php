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
        Region::whereIn('nom_region', [
            'Île-de-France',
            'Provence-Alpes-Côte d\'Azur',
            'Auvergne-Rhône-Alpes',
            'Nouvelle-Aquitaine',
            'Occitanie',
        ])->delete();

        $regions = [
            'Alibori',
            'Atacora',
            'Atlantique',
            'Borgou',
            'Collines',
            'Couffo',
            'Donga',
            'Littoral',
            'Mono',
            'Ouémé',
            'Plateau',
            'Zou',
        ];

        foreach ($regions as $nom) {
            Region::firstOrCreate(
                ['nom_region' => $nom],
                ['description' => 'Département', 'localisation' => 'Bénin', 'superficie' => '0', 'population' => '0']
            );
        }
    }
}
