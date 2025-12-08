@extends('layouts.modern')

@section('title', 'Créer une Langue - BeninCulture')

@section('content')
<div class="page-header-modern">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title">
                <i class="bi bi-translate me-2" style="color: var(--primary-color);"></i>Créer une Langue
            </h1>
            <p class="page-subtitle mb-0">Ajoutez une nouvelle langue parlée au Bénin</p>
        </div>
        <a href="{{ route('langues.index') }}" class="btn btn-secondary btn-modern">
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

        <form action="{{ route('langues.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-4">
                    <label for="code_langue" class="form-label">
                        <i class="bi bi-code-square me-1"></i>Code de la langue
                    </label>
                    <input type="text" name="code_langue" id="code_langue" value="{{ old('code_langue') }}" 
                           class="form-control form-control-modern" placeholder="Ex: fr, fon, yor">
                    @error('code_langue')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6 mb-4">
                    <label for="nom_langue" class="form-label">
                        <i class="bi bi-translate me-1"></i>Nom de la langue <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="nom_langue" id="nom_langue" value="{{ old('nom_langue') }}" 
                           class="form-control form-control-modern" placeholder="Ex: Français, Fon, Yoruba" required>
                    @error('nom_langue')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label for="description" class="form-label">
                    <i class="bi bi-card-text me-1"></i>Description
                </label>
                <textarea name="description" id="description" class="form-control form-control-modern" rows="5" 
                          placeholder="Informations sur la langue, son origine, son utilisation...">{{ old('description') }}</textarea>
                @error('description')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4 pt-4 border-top">
                <a href="{{ route('langues.index') }}" class="btn btn-secondary btn-modern">
                    <i class="bi bi-arrow-left me-2"></i>Annuler
                </a>
                <button type="submit" class="btn btn-primary-modern btn-modern">
                    <i class="bi bi-check-circle me-2"></i>Créer la langue
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
