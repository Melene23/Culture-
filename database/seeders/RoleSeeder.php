<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Définir les rôles du système avec leurs descriptions
        $roles = [
            [
                'nom_role' => 'Admin',
                'description' => 'Administrateur avec accès complet au système et gestion de tous les utilisateurs'
            ],
            [
                'nom_role' => 'Auteur',
                'description' => 'Auteur pouvant créer, modifier et publier ses propres contenus culturels'
            ],
            [
                'nom_role' => 'Utilisateur',
                'description' => 'Utilisateur standard pouvant consulter les contenus et créer des commentaires'
            ],
            [
                'nom_role' => 'Modérateur',
                'description' => 'Modérateur pouvant valider, modérer et gérer les contenus de tous les utilisateurs'
            ],
        ];
        
        // Créer ou mettre à jour les rôles
        foreach ($roles as $roleData) {
            $role = Role::where('nom_role', $roleData['nom_role'])
                       ->orWhere('nom_role', strtolower($roleData['nom_role']))
                       ->orWhere('nom_role', ucfirst(strtolower($roleData['nom_role'])))
                       ->first();
            
            if ($role) {
                // Mettre à jour le rôle existant
                $role->update([
                    'nom_role' => $roleData['nom_role'],
                    'description' => $roleData['description']
                ]);
            } else {
                // Créer un nouveau rôle
                Role::create($roleData);
            }
        }
    }
}
