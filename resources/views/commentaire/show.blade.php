@extends('layouts.app')

@section('title', 'Détails du commentaire')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-chat-text me-2"></i>Détails du commentaire</h1>
    <a href="{{ route('commentaire.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-1"></i>Retour
    </a>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">Informations du commentaire</div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">Contenu (ID)</dt>
                        <dd class="col-sm-8">{{ $commentaire->id_contenu ?? '-' }}</dd>

                        <dt class="col-sm-4">Auteur (ID)</dt>
                        <dd class="col-sm-8">{{ $commentaire->id_auteur ?? '-' }}</dd>

                        <dt class="col-sm-4">Texte</dt>
                        <dd class="col-sm-8">{{ $commentaire->texte ?? '-' }}</dd>

                        <dt class="col-sm-4">Date</dt>
                        <dd class="col-sm-8">{{ $commentaire->created_at ?? '-' }}</dd>
                    </dl>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('commentaire.index') }}" class="btn btn-secondary">Retour</a>
                        <div>
                            <a href="{{ route('commentaire.edit', $commentaire->id_commentaire) }}" class="btn btn-primary me-2">
                                Éditer
                            </a>
                            <form action="{{ route('commentaire.destroy', $commentaire->id_commentaire) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce commentaire ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="bi bi-trash"></i> Supprimer
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
