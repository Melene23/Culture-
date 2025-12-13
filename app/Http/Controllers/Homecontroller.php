<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contenu;
use App\Models\media as Media;
use App\Models\Utilisateur;
use App\Models\commentaire as Commentaire;

class Homecontroller extends Controller
{
    public function index()
    {
        try {
            $contenus_count = Contenu::where('statut', 'publié')->count();
            $medias_count = Media::count();
            $utilisateurs_count = Utilisateur::where('statut', 'actif')->count();
            $commentaires_count = Commentaire::count();
        } catch (\Exception $e) {
            \Log::error('Erreur lors du chargement des statistiques: ' . $e->getMessage());
            $contenus_count = 0;
            $medias_count = 0;
            $utilisateurs_count = 0;
            $commentaires_count = 0;
        }

        // Utiliser uniquement les données réelles de la base de données
        $stats = [
            'contenus' => $contenus_count,
            'medias' => $medias_count,
            'utilisateurs' => $utilisateurs_count,
            'commentaires' => $commentaires_count,
        ];

        return view('welcome', compact('stats'));
    }

    function edit ($id) {
        return view('langues.edit', compact('id'));
    }
}
