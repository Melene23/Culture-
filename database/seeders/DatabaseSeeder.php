<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        
        // Seeders dans l'ordre de dépendance
        $this->call([
            RoleSeeder::class,
            LangueSeeder::class,
            RegionSeeder::class,
            TypeContenuSeeder::class,
            TypeMediaSeeder::class,
            UtilisateurSeeder::class,
        ]);
    }
}
