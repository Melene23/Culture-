@extends('layouts.app')

@section('title', 'Éditer un commentaire - Culture CMS')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-chat-text me-2"></i>Éditer le commentaire</h1>
    <a href="{{ route('commentaire.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-1"></i>Retour
    </a>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    Détails du commentaire
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('commentaire.update', $commentaire->id_commentaire) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="id_contenu" class="form-label">Contenu (ID)</label>
                            <input type="number" name="id_contenu" id="id_contenu" value="{{ old('id_contenu', $commentaire->id_contenu) }}" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="id_auteur" class="form-label">Auteur (ID)</label>
                            <input type="number" name="id_auteur" id="id_auteur" value="{{ old('id_auteur', $commentaire->id_auteur) }}" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="texte" class="form-label">Texte</label>
                            <textarea name="texte" id="texte" class="form-control" rows="4" required>{{ old('texte', $commentaire->texte) }}</textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('commentaire.index') }}" class="btn btn-secondary" title="Annuler">
                                <i class="bi bi-x-lg"></i> Annuler
                            </a>
                            <button type="submit" class="btn btn-primary" title="Enregistrer">
                                <i class="bi bi-save"></i> Enregistrer
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
