<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Utilisateur;

class UtilisateurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = env('ADMIN_EMAIL', 'mauricecomlan@uac.bj');
        $plainPassword = env('ADMIN_PASSWORD', 'Eneam123');

        $existing = Utilisateur::where('email', $email)->first();

        $payload = [
            'nom' => 'Maurice',
            'prenom' => 'Comlan',
            'email' => $email,
            'mot_de_passe' => Hash::make($plainPassword),
            'id_role' => 1,
            'id_langue' => 1,
            'sexe' => 'non-spécifié',
            'photo' => 'default.jpg',
            'statut' => 'actif',
            'date_naissance' => '1990-01-01',
        ];

        if ($existing) {
            $existing->fill($payload);
            $existing->save();
            return;
        }

        Utilisateur::create($payload);
    }
}
