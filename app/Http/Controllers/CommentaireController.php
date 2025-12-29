<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commentaire;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class CommentaireController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $commentaires = Commentaire::orderBy('id_commentaire', 'desc')->get();
        return view('commentaire.index', compact('commentaires'));
    }

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
        $data['id_utilisateur'] = Auth::user()->id_utilisateur;

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