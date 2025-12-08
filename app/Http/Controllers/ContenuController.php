<?php

namespace App\Http\Controllers;

use App\Models\Contenu;
use App\Models\Region;
use App\Models\Langue;
use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class ContenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $query = Contenu::query();
    
    // Si recherche
    if ($request->has('search') && !empty($request->search)) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('titre', 'LIKE', "%{$search}%")
              ->orWhere('texte', 'LIKE', "%{$search}%");
        });
    }
    
    // Filtrer seulement les contenus publiés pour le public
    $query->where('statut', 'publié');
    
    $contenus = $query->orderBy('date_creation', 'desc')->paginate(12);
    
    return view('contenu.index', compact('contenus'));
}

    /**
     * Show the form for creating a new resource.
     */
public function create()
{
    // Charge toutes les données nécessaires
    $regions = Region::all();
    $langues = Langue::all();
    $contenus = Contenu::all();
    
    // Charger TypeMedia (table créée par migration)
    $typeMedias = \App\Models\TypeMedia::all();
    
    // Charger TypeContenu
    $typeContenus = \App\Models\TypeContenu::all();

    // Passe les données à la vue
    return view('contenu.create', [
        'regions' => $regions,
        'langues' => $langues,
        'contenus' => $contenus,
        'typeMedias' => $typeMedias,
        'typeContenus' => $typeContenus
    ]);
}
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'titre' => 'required|string|max:255',
            'id_region' => 'required|integer',
            'date_creation' => 'required|date',
            'texte' => 'required|string',
            'statut' => 'required|string|max:100',
            'id_langue' => 'required|integer',
            'id_type_contenu' => 'required|integer',
            'date_validation' => 'nullable|date',
            'id_moderateur' => 'nullable|integer',
            'parent_id' => 'nullable|integer',
            'media' => 'nullable|file|mimes:mp4,avi,mov,wmv,flv,webm,jpg,jpeg,png,gif|max:102400', // 100MB max pour vidéos
        ]);

        // Assigner automatiquement l'utilisateur connecté comme auteur
        $data['id_auteur'] = Auth::user()->id_utilisateur;
        
        // Si statut n'est pas fourni, mettre "en attente" par défaut
        if (empty($data['statut'])) {
            $data['statut'] = 'en attente';
        }

        // Convertir les champs vides en null pour les champs nullable
        if (empty($data['parent_id'])) {
            $data['parent_id'] = null;
        }
        if (empty($data['date_validation'])) {
            $data['date_validation'] = null;
        }
        if (empty($data['id_moderateur'])) {
            $data['id_moderateur'] = null;
        }

        // Log pour debug
        \Log::info('Données à insérer dans contenu', $data);

        try {
            // Créer le contenu
            $contenu = Contenu::create($data);
            \Log::info('Contenu créé avec succès', ['id' => $contenu->id_contenu]);
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la création du contenu', [
                'message' => $e->getMessage(),
                'data' => $data,
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withErrors(['error' => 'Erreur lors de la création du contenu: ' . $e->getMessage()])->withInput();
        }

        // Si un média (vidéo/image) est uploadé
        if ($request->hasFile('media')) {
            $file = $request->file('media');
            $path = $file->store('media', 'public');
            
            // Déterminer le type de média
            $extension = strtolower($file->getClientOriginalExtension());
            $isVideo = in_array($extension, ['mp4', 'avi', 'mov', 'wmv', 'flv', 'webm']);
            
            // Chercher le type de média dans la base de données
            $typeMediaName = $isVideo ? 'Vidéo' : 'Image';
            $typeMedia = \App\Models\TypeMedia::where('nom_media', $typeMediaName)->first();
            
            // Si le type n'existe pas, utiliser l'ID 1 par défaut
            $typeMediaId = $typeMedia ? $typeMedia->id_type_media : 1;
            
            // Créer l'entrée média
            \App\Models\media::create([
                'chemin' => 'storage/' . $path,
                'id_contenu' => $contenu->id_contenu,
                'id_type_media' => $typeMediaId,
                'description' => 'Média associé au contenu: ' . $contenu->titre,
            ]);
        }

        return redirect()->route('contenus.mes-contenus')->with('success', 'Contenu créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $contenu = Contenu::with(['region', 'langue', 'auteur', 'media'])->findOrFail($id);
        return view('contenu.show', compact('contenu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $contenu = Contenu::findOrFail($id);
        $regions = Region::all();
        $langues = Langue::all();
        $contenus = Contenu::where('id_contenu', '!=', $id)->get();
        $typeContenus = \App\Models\TypeContenu::all();
        
        return view('contenu.edit', compact('contenu', 'regions', 'langues', 'contenus', 'typeContenus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $contenu = Contenu::findOrFail($id);

        $data = $request->validate([
            'titre' => 'required|string|max:255',
            'id_region' => 'required|integer',
            'date_creation' => 'required|date',
            'texte' => 'required|string',
            'statut' => 'required|string|max:100',
            'id_langue' => 'required|integer',
            'id_type_contenu' => 'required|integer',
            'date_validation' => 'nullable|date',
            'id_moderateur' => 'nullable|integer',
            'parent_id' => 'nullable|integer',
        ]);

        // Convertir les champs vides en null
        if (empty($data['parent_id'])) {
            $data['parent_id'] = null;
        }
        if (empty($data['date_validation'])) {
            $data['date_validation'] = null;
        }
        if (empty($data['id_moderateur'])) {
            $data['id_moderateur'] = null;
        }

        $contenu->update($data);

        return redirect()->route('contenus.mes-contenus')->with('success', 'Contenu mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $contenu = Contenu::findOrFail($id);
        $contenu->delete();
        return redirect()->route('contenu.index')->with('success', 'Contenu supprimé.');
    }

    /**
     * Afficher les contenus de l'utilisateur connecté
     */
    public function mesContenus()
    {
        $user = Auth::user();
        $contenus = Contenu::where('id_auteur', $user->id_utilisateur)
            ->orderBy('date_creation', 'desc')
            ->paginate(15);
        
        return view('contenus.mes-contenus', compact('contenus'));
    }
}
