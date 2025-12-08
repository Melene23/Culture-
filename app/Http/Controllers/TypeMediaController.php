<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TypeMedia;

class TypeMediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $types = TypeMedia::orderBy('id_type_media','desc')->get();
        return view('typemedia.index', compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('typemedia.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nom_media' => 'required|string|max:255',
        ]);

        TypeMedia::create($data);

        return redirect()->route('typemedia.index')->with('success','Type média créé.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $type = TypeMedia::findOrFail($id);
        return view('typemedia.show', compact('type'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $type = TypeMedia::findOrFail($id);
        return view('typemedia.edit', compact('type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $type = TypeMedia::findOrFail($id);

        $data = $request->validate([
            'nom_media' => 'required|string|max:255',
        ]);

        $type->update($data);

        return redirect()->route('typemedia.index')->with('success','Type média mis à jour.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $type = TypeMedia::findOrFail($id);
        $type->delete();
        return redirect()->route('typemedia.index')->with('success','Type média supprimé.');
    }
}
