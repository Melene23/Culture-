<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;


class UtilisateurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $utilisateurs = Utilisateur::orderBy('id_utilisateur', 'desc')->get();
        return view('utilisateurs.index', compact('utilisateurs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = \App\Models\Role::all();
        $langues = \App\Models\Langue::all();
        return view('utilisateurs.create', compact('roles', 'langues'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nom' => 'required|string|max:150',
            'prenom' => 'nullable|string|max:150',
            'email' => 'required|email|unique:utilisateurs,email',
            'mot_de_passe' => 'required|string|min:6',
            'id_role' => 'nullable|integer',
            'id_langue' => 'nullable|integer',
            'sexe' => 'nullable|string|max:20',
            'photo' => 'nullable|image|max:2048',
            'statut' => 'nullable|string|max:100',
            'date_naissance' => 'nullable|date',
            'date_inscription' => 'nullable|date',
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('utilisateurs', 'public');
            $data['photo'] = $path;
        }

        // hash password before saving
        $data['mot_de_passe'] = Hash::make($data['mot_de_passe']);

        Utilisateur::create($data);

        return redirect()->route('utilisateurs.index')->with('success', 'Utilisateur créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id_utilisateur)
    {
         $utilisateur = Utilisateur::findOrFail($id_utilisateur);
        return view('utilisateurs.show', compact('utilisateur'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id_utilisateur)
    {
        $utilisateur = Utilisateur::findOrFail($id_utilisateur);
        return view('utilisateurs.edit', compact('utilisateur'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id_utilisateur)
    {
        $utilisateur = Utilisateur::findOrFail($id_utilisateur);

        $data = $request->validate([
            'nom' => 'required|string|max:150',
            'prenom' => 'nullable|string|max:150',
            'email' => 'required|email|unique:utilisateurs,email,' . $utilisateur->id_utilisateur . ',id_utilisateur',
            'mot_de_passe' => 'nullable|string|min:6',
            'id_role' => 'nullable|integer',
            'id_langue' => 'nullable|integer',
            'sexe' => 'nullable|string|max:20',
            'photo' => 'nullable|image|max:2048',
            'statut' => 'nullable|string|max:100',
            'date_naissance' => 'nullable|date',
        ]);

        if ($request->hasFile('photo')) {
            // supprimer l'ancienne photo si présente
            if (!empty($utilisateur->photo) && Storage::disk('public')->exists($utilisateur->photo)) {
                Storage::disk('public')->delete($utilisateur->photo);
            }
            $path = $request->file('photo')->store('utilisateurs', 'public');
            $data['photo'] = $path;
        }

        // ne pas écraser le mot de passe si non fourni
        if (!empty($data['mot_de_passe'])) {
            $data['mot_de_passe'] = Hash::make($data['mot_de_passe']);
        } else {
            unset($data['mot_de_passe']);
        }

        $utilisateur->update($data);

        return redirect()->route('utilisateurs.index')->with('success', 'Utilisateur mis à jour.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id_utilisateur)
    {
        $utilisateur = Utilisateur::findOrFail($id_utilisateur);

        if (!empty($utilisateur->photo) && Storage::disk('public')->exists($utilisateur->photo)) {
            Storage::disk('public')->delete($utilisateur->photo);
        }

        $utilisateur->delete();

        return redirect()->route('utilisateurs.index')->with('success', 'Utilisateur supprimé.');
    }
}
