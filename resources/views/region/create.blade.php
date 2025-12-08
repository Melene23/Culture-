@extends('layouts.modern')

@section('title', 'Créer une Région - BeninCulture')

@section('content')
<div class="page-header-modern">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title">
                <i class="bi bi-geo-alt me-2" style="color: var(--primary-color);"></i>Créer une Région
            </h1>
            <p class="page-subtitle mb-0">Ajoutez une nouvelle région du Bénin</p>
        </div>
        <a href="{{ route('region.index') }}" class="btn btn-secondary btn-modern">
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

        <form action="{{ route('region.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="nom_region" class="form-label">
                    <i class="bi bi-building me-1"></i>Nom de la région <span class="text-danger">*</span>
                </label>
                <input type="text" name="nom_region" id="nom_region" value="{{ old('nom_region') }}" 
                       class="form-control form-control-modern" placeholder="Ex: Atlantique" required>
                @error('nom_region')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <label for="localisation" class="form-label">
                        <i class="bi bi-geo me-1"></i>Localisation
                    </label>
                    <input type="text" name="localisation" id="localisation" value="{{ old('localisation') }}" 
                           class="form-control form-control-modern" placeholder="Ex: Sud du Bénin">
                    @error('localisation')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-3 mb-4">
                    <label for="superficie" class="form-label">
                        <i class="bi bi-rulers me-1"></i>Superficie (km²)
                    </label>
                    <input type="number" step="any" name="superficie" id="superficie" value="{{ old('superficie') }}" 
                           class="form-control form-control-modern" placeholder="0.00">
                    @error('superficie')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-3 mb-4">
                    <label for="population" class="form-label">
                        <i class="bi bi-people me-1"></i>Population
                    </label>
                    <input type="number" name="population" id="population" value="{{ old('population') }}" 
                           class="form-control form-control-modern" placeholder="0">
                    @error('population')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label for="description" class="form-label">
                    <i class="bi bi-card-text me-1"></i>Description
                </label>
                <textarea name="description" id="description" class="form-control form-control-modern" rows="6" 
                          placeholder="Décrivez la région, ses caractéristiques culturelles, historiques...">{{ old('description') }}</textarea>
                @error('description')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4 pt-4 border-top">
                <a href="{{ route('region.index') }}" class="btn btn-secondary btn-modern">
                    <i class="bi bi-arrow-left me-2"></i>Annuler
                </a>
                <button type="submit" class="btn btn-primary-modern btn-modern">
                    <i class="bi bi-check-circle me-2"></i>Créer la région
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
