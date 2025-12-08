<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\media;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $medias = media::with('typeMedia')->orderBy('id_media', 'desc')->get();
        return view('media.index', compact('medias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $typeMedias = \App\Models\TypeMedia::all();
        $contenus = \App\Models\Contenu::all();
        return view('media.create', compact('typeMedias', 'contenus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'chemin' => 'required|file|max:10240',
            'id_type_media' => 'nullable|integer',
            'id_contenu' => 'nullable|integer',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('chemin')) {
            $path = $request->file('chemin')->store('media', 'public');
            $data['chemin'] = 'storage/' . $path;
        }

        media::create($data);

        return redirect()->route('media.index')->with('success', 'Média ajouté.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $media = media::findOrFail($id);
        return view('media.show', compact('media'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $media = media::findOrFail($id);
        return view('media.edit', compact('media'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $media = media::findOrFail($id);

        $data = $request->validate([
            'chemin' => 'nullable|file|max:10240',
            'id_type_media' => 'nullable|integer',
            'id_contenu' => 'nullable|integer',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('chemin')) {
            // supprimer ancien fichier si stocké dans storage
            if (!empty($media->chemin)) {
                // chemin peut contenir 'storage/...'
                $old = preg_replace('#^storage/#', '', $media->chemin);
                if (Storage::disk('public')->exists($old)) {
                    Storage::disk('public')->delete($old);
                }
            }
            $path = $request->file('chemin')->store('media', 'public');
            $data['chemin'] = 'storage/' . $path;
        }

        $media->update($data);

        return redirect()->route('media.index')->with('success', 'Média mis à jour.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $media = media::findOrFail($id);
        if (!empty($media->chemin)) {
            $old = preg_replace('#^storage/#', '', $media->chemin);
            if (Storage::disk('public')->exists($old)) {
                Storage::disk('public')->delete($old);
            }
        }
        $media->delete();
        return redirect()->route('media.index')->with('success', 'Média supprimé.');
    }
}
