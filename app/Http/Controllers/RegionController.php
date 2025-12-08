<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Region;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $regions = Region::orderBy('id_region', 'desc')->get();
        return view('region.index', compact('regions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('region.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nom_region' => 'required|string|max:255',
            'description' => 'nullable|string',
            'localisation' => 'nullable|string|max:255',
            'superficie' => 'nullable|numeric',
            'population' => 'nullable|integer',
        ]);

        Region::create($data);

        return redirect()->route('region.index')->with('success', 'Région créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $region = Region::findOrFail($id);
        return view('region.show', compact('region'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $region = Region::findOrFail($id);
        return view('region.edit', compact('region'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id_region)
    {
        $region = Region::findOrFail($id_region);

        $data = $request->validate([
           
            'nom_region' => 'required|string|max:255',
            'description' => 'nullable|string',
            'localisation' => 'nullable|string|max:255',
            'superficie' => 'nullable|numeric',
            'population' => 'nullable|integer',
        ]);

        $region->update($data);

        return redirect()->route('region.index')->with('success', 'Région mise à jour.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $region = Region::findOrFail($id);
        $region->delete();

        return redirect()->route('region.index')->with('success', 'Région supprimée.');
    }
}
