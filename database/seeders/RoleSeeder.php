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
                'id' => 1,
                'nom' => 'Admin',
                'description' => 'Administrateur avec accès complet au système et gestion de tous les utilisateurs'
            ],
            [
                'id' => 2,
                'nom' => 'Auteur',
                'description' => 'Auteur pouvant créer, modifier et publier ses propres contenus culturels'
            ],
            [
                'id' => 3,
                'nom' => 'Utilisateur',
                'description' => 'Utilisateur standard pouvant consulter les contenus et créer des commentaires'
            ],
            [
                'id' => 4,
                'nom' => 'Modérateur',
                'description' => 'Modérateur pouvant valider, modérer et gérer les contenus de tous les utilisateurs'
            ],
        ];
        
        // Créer ou mettre à jour les rôles
        foreach ($roles as $roleData) {
            $role = Role::find($roleData['id']);
            
            if ($role) {
                // Mettre à jour le rôle existant
                $role->update([
                    'nom' => $roleData['nom'],
                    'description' => $roleData['description']
                ]);
            } else {
                // Créer un nouveau rôle
                Role::create($roleData);
            }
        }
    }
}
