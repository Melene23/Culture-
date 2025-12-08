@extends('layouts.modern')

@section('title', 'Créer un Utilisateur - BeninCulture')

@section('content')
<div class="page-header-modern">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title">
                <i class="bi bi-person-plus me-2" style="color: var(--primary-color);"></i>Créer un Utilisateur
            </h1>
            <p class="page-subtitle mb-0">Ajoutez un nouvel utilisateur au système</p>
        </div>
        <a href="{{ route('utilisateurs.index') }}" class="btn btn-secondary btn-modern">
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

        <form action="{{ route('utilisateurs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-4">
                    <label for="nom" class="form-label">
                        <i class="bi bi-person me-1"></i>Nom <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="nom" id="nom" value="{{ old('nom') }}" 
                           class="form-control form-control-modern" required>
                    @error('nom')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6 mb-4">
                    <label for="prenom" class="form-label">
                        <i class="bi bi-person me-1"></i>Prénom
                    </label>
                    <input type="text" name="prenom" id="prenom" value="{{ old('prenom') }}" 
                           class="form-control form-control-modern">
                    @error('prenom')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <label for="email" class="form-label">
                        <i class="bi bi-envelope me-1"></i>Email <span class="text-danger">*</span>
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" 
                           class="form-control form-control-modern" required>
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6 mb-4">
                    <label for="mot_de_passe" class="form-label">
                        <i class="bi bi-lock me-1"></i>Mot de passe <span class="text-danger">*</span>
                    </label>
                    <input type="password" name="mot_de_passe" id="mot_de_passe" 
                           class="form-control form-control-modern" minlength="6" required>
                    @error('mot_de_passe')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-4">
                    <label for="id_role" class="form-label">
                        <i class="bi bi-person-badge me-1"></i>Rôle <span class="text-danger">*</span>
                    </label>
                    <select name="id_role" id="id_role" class="form-select form-select-modern" required>
                        <option value="">-- Sélectionner un rôle --</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id_role }}" {{ old('id_role', 2) == $role->id_role ? 'selected' : '' }}>
                                {{ $role->nom }}
                                @if($role->description)
                                    - {{ Str::limit($role->description, 40) }}
                                @endif
                            </option>
                        @endforeach
                    </select>
                    <small class="text-muted">Les rôles sont définis dans les seeders du projet</small>
                    @error('id_role')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-4 mb-4">
                    <label for="id_langue" class="form-label">
                        <i class="bi bi-translate me-1"></i>Langue préférée
                    </label>
                    <select name="id_langue" id="id_langue" class="form-select form-select-modern">
                        <option value="">-- Sélectionner une langue --</option>
                        @foreach($langues as $langue)
                            <option value="{{ $langue->id_langue }}" {{ old('id_langue') == $langue->id_langue ? 'selected' : '' }}>
                                {{ $langue->nom_langue }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_langue')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-4 mb-4">
                    <label for="sexe" class="form-label">
                        <i class="bi bi-gender-ambiguous me-1"></i>Sexe
                    </label>
                    <select name="sexe" id="sexe" class="form-select form-select-modern">
                        <option value="">-- Sélectionner --</option>
                        <option value="M" {{ old('sexe') == 'M' ? 'selected' : '' }}>Masculin</option>
                        <option value="F" {{ old('sexe') == 'F' ? 'selected' : '' }}>Féminin</option>
                    </select>
                    @error('sexe')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <label for="date_naissance" class="form-label">
                        <i class="bi bi-calendar me-1"></i>Date de naissance
                    </label>
                    <input type="date" name="date_naissance" id="date_naissance" value="{{ old('date_naissance') }}" 
                           class="form-control form-control-modern">
                    @error('date_naissance')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6 mb-4">
                    <label for="statut" class="form-label">
                        <i class="bi bi-info-circle me-1"></i>Statut
                    </label>
                    <select name="statut" id="statut" class="form-select form-select-modern">
                        <option value="actif" {{ old('statut') == 'actif' ? 'selected' : '' }}>Actif</option>
                        <option value="inactif" {{ old('statut') == 'inactif' ? 'selected' : '' }}>Inactif</option>
                    </select>
                    @error('statut')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label for="photo" class="form-label">
                    <i class="bi bi-image me-1"></i>Photo de profil
                </label>
                <input type="file" name="photo" id="photo" accept="image/*" 
                       class="form-control form-control-modern">
                @error('photo')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4 pt-4 border-top">
                <a href="{{ route('utilisateurs.index') }}" class="btn btn-secondary btn-modern">
                    <i class="bi bi-arrow-left me-2"></i>Annuler
                </a>
                <button type="submit" class="btn btn-primary-modern btn-modern">
                    <i class="bi bi-check-circle me-2"></i>Créer l'utilisateur
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
