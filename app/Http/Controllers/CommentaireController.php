<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commentaire;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class CommentaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $commentaires = Commentaire::orderBy('id_commentaire', 'desc')->get();
        return view('commentaire.index', compact('commentaires'));
    }

    // SUPPRIMER TOUT LE CONSTRUCTEUR - C'EST LA CAUSE DE L'ERREUR
    // public function __construct()
    // {
    //     // Restreindre la création/modification/suppression aux utilisateurs authentifiés
    //     $this->middleware('auth')->only(['create', 'store', 'edit', 'update', 'destroy']);
    // }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $contenus = \App\Models\Contenu::all();
        return view('commentaire.create', compact('contenus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'id_contenu' => 'required|integer',
            'texte' => 'required|string',
            'note' => 'nullable|integer',
            'date' => 'nullable|date',
        ]);

        // Assigner l'utilisateur connecté comme auteur
        $data['id_utilisateur'] = Auth::id();

        // valeur par défaut
        $data['note'] = $data['note'] ?? 0;
        $data['date'] = $data['date'] ?? now();

        Commentaire::create($data);

        return redirect()->route('commentaire.index')->with('success', 'Commentaire créé.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $commentaire = Commentaire::findOrFail($id);
        return view('commentaire.show', compact('commentaire'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $commentaire = Commentaire::findOrFail($id);
        return view('commentaire.edit', compact('commentaire'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $commentaire = Commentaire::findOrFail($id);

        $data = $request->validate([
            'id_contenu' => 'required|integer',
            'texte' => 'required|string',
        ]);

        $commentaire->update($data);

        return redirect()->route('commentaire.index')->with('success', 'Commentaire mis à jour.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $commentaire = Commentaire::findOrFail($id);
        $commentaire->delete();
        return redirect()->route('commentaire.index')->with('success', 'Commentaire supprimé.');
    }
}