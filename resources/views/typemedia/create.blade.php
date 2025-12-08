@extends('layouts.modern')

@section('title', 'Créer un Type de Média - BeninCulture')

@section('content')
<div class="page-header-modern">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title">
                <i class="bi bi-collection me-2" style="color: var(--primary-color);"></i>Créer un Type de Média
            </h1>
            <p class="page-subtitle mb-0">Ajoutez une nouvelle catégorie de média</p>
        </div>
        <a href="{{ route('typemedia.index') }}" class="btn btn-secondary btn-modern">
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

        <form action="{{ route('typemedia.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="nom_media" class="form-label">
                    <i class="bi bi-tag me-1"></i>Nom du type de média <span class="text-danger">*</span>
                </label>
                <input type="text" name="nom_media" id="nom_media" value="{{ old('nom_media') }}" 
                       class="form-control form-control-modern" placeholder="Ex: Image, Vidéo, Audio" required>
                @error('nom_media')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4 pt-4 border-top">
                <a href="{{ route('typemedia.index') }}" class="btn btn-secondary btn-modern">
                    <i class="bi bi-arrow-left me-2"></i>Annuler
                </a>
                <button type="submit" class="btn btn-primary-modern btn-modern">
                    <i class="bi bi-check-circle me-2"></i>Créer le type de média
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
