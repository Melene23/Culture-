<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TypeContenu;

class TypeContenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $types = TypeContenu::orderBy('id_type_contenu','desc')->get();
        return view('typecontenu.index', compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('typecontenu.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nom_contenu' => 'required|string|max:255',
        ]);

        TypeContenu::create($data);

        return redirect()->route('typecontenu.index')->with('success','Type de contenu créé.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $type = TypeContenu::findOrFail($id);
        return view('typecontenu.show', compact('type'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $type = TypeContenu::findOrFail($id);
        return view('typecontenu.edit', compact('type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $type = TypeContenu::findOrFail($id);

        $data = $request->validate([
            'nom_contenu' => 'required|string|max:255',
        ]);

        $type->update($data);

        return redirect()->route('typecontenu.index')->with('success','Type de contenu mis à jour.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $type = TypeContenu::findOrFail($id);
        $type->delete();
        return redirect()->route('typecontenu.index')->with('success','Type de contenu supprimé.');
    }
}
