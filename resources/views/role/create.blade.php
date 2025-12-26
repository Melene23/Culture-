@extends('layouts.modern')

@section('title', 'Créer un Rôle - BeninCulture')

@section('content')
<div class="page-header-modern">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title">
                <i class="bi bi-person-badge me-2" style="color: var(--primary-color);"></i>Créer un Rôle
            </h1>
            <p class="page-subtitle mb-0">Ajoutez un nouveau rôle utilisateur</p>
        </div>
        <a href="{{ route('role.index') }}" class="btn btn-secondary btn-modern">
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

        <form action="{{ route('role.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="nom" class="form-label">
                    <i class="bi bi-tag me-1"></i>Nom du rôle <span class="text-danger">*</span>
                </label>
                <input type="text" name="nom" id="nom" value="{{ old('nom') }}" 
                       class="form-control form-control-modern" placeholder="Ex: Administrateur, Modérateur" required>
                @error('nom')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="form-label">
                    <i class="bi bi-card-text me-1"></i>Description
                </label>
                <textarea name="description" id="description" class="form-control form-control-modern" rows="4" 
                          placeholder="Décrivez les permissions et responsabilités de ce rôle...">{{ old('description') }}</textarea>
                @error('description')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4 pt-4 border-top">
                <a href="{{ route('role.index') }}" class="btn btn-secondary btn-modern">
                    <i class="bi bi-arrow-left me-2"></i>Annuler
                </a>
                <button type="submit" class="btn btn-primary-modern btn-modern">
                    <i class="bi bi-check-circle me-2"></i>Créer le rôle
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
