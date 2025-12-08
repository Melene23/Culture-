@extends('layouts.modern')

@section('title', 'Modifier le Contenu - BeninCulture')

@section('content')
<div class="page-header-modern">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title">
                <i class="bi bi-pencil-square me-2" style="color: var(--primary-color);"></i>Modifier le contenu
            </h1>
            <p class="page-subtitle mb-0">Modifiez les informations de votre contenu culturel</p>
        </div>
        <a href="{{ route('contenu.index') }}" class="btn btn-outline-secondary btn-modern">
            <i class="bi bi-arrow-left me-2"></i>Retour
        </a>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="modern-card">
            <div class="card-header-modern">
                <h5 class="mb-0"><i class="bi bi-file-text me-2"></i>Formulaire de modification</h5>
            </div>
            <div class="card-body p-4">
                @if ($errors->any())
                    <div class="alert alert-danger alert-modern">
                        <h6><i class="bi bi-exclamation-triangle me-2"></i>Erreurs de validation</h6>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('contenu.update', $contenu->id_contenu) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="titre" class="form-label">
                            <i class="bi bi-type me-1"></i>Titre du contenu
                        </label>
                        <input type="text" name="titre" id="titre" 
                               value="{{ old('titre', $contenu->titre) }}" 
                               class="form-control form-control-modern" required>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <label for="id_region" class="form-label">
                                <i class="bi bi-geo-alt me-1"></i>Région
                            </label>
                            <select name="id_region" id="id_region" class="form-select form-select-modern" required>
                                <option value="" disabled>-- Sélectionner une région --</option>
                                @foreach($regions as $region)
                                    <option value="{{ $region->id_region }}" {{ old('id_region', $contenu->id_region) == $region->id_region ? 'selected' : '' }}>
                                        {{ $region->nom_region }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mb-4">
                            <label for="id_langue" class="form-label">
                                <i class="bi bi-translate me-1"></i>Langue
                            </label>
                            <select name="id_langue" id="id_langue" class="form-select form-select-modern" required>
                                <option value="" disabled>-- Sélectionner une langue --</option>
                                @foreach($langues as $langue)
                                    <option value="{{ $langue->id_langue }}" {{ old('id_langue', $contenu->id_langue) == $langue->id_langue ? 'selected' : '' }}>
                                        {{ $langue->nom_langue }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mb-4">
                            <label for="id_type_contenu" class="form-label">
                                <i class="bi bi-tags me-1"></i>Type de contenu
                            </label>
                            <select name="id_type_contenu" id="id_type_contenu" class="form-select form-select-modern" required>
                                <option value="" disabled>-- Sélectionner un type --</option>
                                @foreach($typeContenus as $typeContenu)
                                    <option value="{{ $typeContenu->id_type_contenu }}" {{ old('id_type_contenu', $contenu->id_type_contenu) == $typeContenu->id_type_contenu ? 'selected' : '' }}>
                                        {{ $typeContenu->nom_contenu }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="texte" class="form-label">
                            <i class="bi bi-file-text me-1"></i>Description du contenu
                        </label>
                        <textarea name="texte" id="texte" class="form-control form-control-modern" rows="6" required>{{ old('texte', $contenu->texte) }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="date_creation" class="form-label">
                                <i class="bi bi-calendar me-1"></i>Date de création
                            </label>
                            <input type="date" name="date_creation" id="date_creation" 
                                   value="{{ old('date_creation', $contenu->date_creation) }}" 
                                   class="form-control form-control-modern" required>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="statut" class="form-label">
                                <i class="bi bi-info-circle me-1"></i>Statut
                            </label>
                            <select name="statut" id="statut" class="form-select form-select-modern" required>
                                <option value="en attente" {{ old('statut', $contenu->statut) == 'en attente' ? 'selected' : '' }}>En attente</option>
                                <option value="publié" {{ old('statut', $contenu->statut) == 'publié' ? 'selected' : '' }}>Publié</option>
                                <option value="brouillon" {{ old('statut', $contenu->statut) == 'brouillon' ? 'selected' : '' }}>Brouillon</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="parent_id" class="form-label">
                            <i class="bi bi-diagram-3 me-1"></i>Contenu parent (optionnel)
                        </label>
                        <select name="parent_id" id="parent_id" class="form-select form-select-modern">
                            <option value="" selected>-- Aucun contenu parent --</option>
                            @foreach($contenus as $c)
                                <option value="{{ $c->id_contenu }}" {{ old('parent_id', $contenu->parent_id) == $c->id_contenu ? 'selected' : '' }}>
                                    {{ $c->titre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                        <a href="{{ route('contenu.index') }}" class="btn btn-outline-secondary btn-modern">
                            <i class="bi bi-x-lg me-2"></i>Annuler
                        </a>
                        <button type="submit" class="btn btn-primary-modern btn-modern">
                            <i class="bi bi-check-circle me-2"></i>Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
