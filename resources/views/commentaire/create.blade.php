@extends('layouts.modern')

@section('title', 'Créer un Commentaire - BeninCulture')

@section('content')
<div class="page-header-modern">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title">
                <i class="bi bi-chat-left-text me-2" style="color: var(--primary-color);"></i>Créer un Commentaire
            </h1>
            <p class="page-subtitle mb-0">Partagez votre avis sur un contenu</p>
        </div>
        <a href="{{ route('commentaire.index') }}" class="btn btn-secondary btn-modern">
            <i class="bi bi-arrow-left me-2"></i>Retour
        </a>
    </div>
</div>

<div class="modern-card">
    <div class="card-body p-4">
        @if ($errors->any())
            <div class="alert alert-danger alert-modern">
                <h5><i class="bi bi-exclamation-triangle me-2"></i>Erreurs de validation</h5>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('commentaire.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="id_contenu" class="form-label">
                    <i class="bi bi-file-text me-1"></i>Contenu <span class="text-danger">*</span>
                </label>
                <select name="id_contenu" id="id_contenu" class="form-select form-select-modern" required>
                    <option value="" disabled {{ old('id_contenu') ? '' : 'selected' }}>-- Sélectionner un contenu --</option>
                    @foreach($contenus as $contenu)
                        <option value="{{ $contenu->id_contenu }}" {{ old('id_contenu') == $contenu->id_contenu ? 'selected' : '' }}>
                            {{ $contenu->titre }}
                        </option>
                    @endforeach
                </select>
                @error('id_contenu')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-4">
                <label for="texte" class="form-label">
                    <i class="bi bi-chat-left me-1"></i>Commentaire <span class="text-danger">*</span>
                </label>
                <textarea name="texte" id="texte" class="form-control form-control-modern" rows="6" 
                          placeholder="Écrivez votre commentaire..." required>{{ old('texte') }}</textarea>
                @error('texte')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <label for="note" class="form-label">
                        <i class="bi bi-star me-1"></i>Note (sur 5)
                    </label>
                    <input type="number" name="note" id="note" value="{{ old('note', 0) }}" 
                           min="0" max="5" class="form-control form-control-modern">
                    @error('note')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6 mb-4">
                    <label for="date" class="form-label">
                        <i class="bi bi-calendar me-1"></i>Date
                    </label>
                    <input type="date" name="date" id="date" value="{{ old('date', now()->format('Y-m-d')) }}" 
                           class="form-control form-control-modern">
                    @error('date')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4 pt-4 border-top">
                <a href="{{ route('commentaire.index') }}" class="btn btn-secondary btn-modern">
                    <i class="bi bi-arrow-left me-2"></i>Annuler
                </a>
                <button type="submit" class="btn btn-primary-modern btn-modern">
                    <i class="bi bi-check-circle me-2"></i>Publier le commentaire
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
