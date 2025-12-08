@extends('layouts.modern')

@section('title', 'Créer un Contenu - BeninCulture')

@section('content')
<div class="page-header-modern">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title">
                <i class="bi bi-plus-circle me-2" style="color: var(--primary-color);"></i>Créer un Nouveau Contenu
            </h1>
            <p class="page-subtitle mb-0">Partagez votre connaissance de la culture béninoise</p>
        </div>
        <a href="{{ route('contenus.mes-contenus') }}" class="btn btn-secondary btn-modern">
            <i class="bi bi-arrow-left me-2"></i>Retour
        </a>
    </div>
</div>

<div class="modern-card">
    <div class="card-body p-4">
        {{-- Affichage des erreurs globales --}}
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

        <form action="{{ route('contenu.store') }}" method="POST" enctype="multipart/form-data" id="contenuForm">
            @csrf

            {{-- Titre --}}
            <div class="mb-4">
                <label for="titre" class="form-label">
                    <i class="bi bi-type me-1"></i>Titre du contenu <span class="text-danger">*</span>
                </label>
                <input type="text" name="titre" id="titre" value="{{ old('titre') }}" 
                       class="form-control form-control-modern" placeholder="Ex: Les traditions vodoun du Bénin" required>
                @error('titre')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="row">
                {{-- Région --}}
                <div class="col-md-4 mb-4">
                    <label for="id_region" class="form-label">
                        <i class="bi bi-geo-alt me-1"></i>Région <span class="text-danger">*</span>
                    </label>
                    <select name="id_region" id="id_region" class="form-select form-select-modern" required>
                        <option value="" disabled {{ old('id_region') ? '' : 'selected' }}>-- Sélectionner une région --</option>
                        @foreach($regions as $region)
                            <option value="{{ $region->id_region }}" {{ old('id_region') == $region->id_region ? 'selected' : '' }}>
                                {{ $region->nom_region }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_region')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Langue --}}
                <div class="col-md-4 mb-4">
                    <label for="id_langue" class="form-label">
                        <i class="bi bi-translate me-1"></i>Langue <span class="text-danger">*</span>
                    </label>
                    <select name="id_langue" id="id_langue" class="form-select form-select-modern" required>
                        <option value="" disabled {{ old('id_langue') ? '' : 'selected' }}>-- Sélectionner une langue --</option>
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

                {{-- Type de contenu --}}
                <div class="col-md-4 mb-4">
                    <label for="id_type_contenu" class="form-label">
                        <i class="bi bi-tags me-1"></i>Type de contenu <span class="text-danger">*</span>
                    </label>
                    <select name="id_type_contenu" id="id_type_contenu" class="form-select form-select-modern" required>
                        <option value="" disabled {{ old('id_type_contenu') ? '' : 'selected' }}>-- Sélectionner un type --</option>
                        @foreach($typeContenus as $typeContenu)
                            <option value="{{ $typeContenu->id_type_contenu }}" {{ old('id_type_contenu') == $typeContenu->id_type_contenu ? 'selected' : '' }}>
                                {{ $typeContenu->nom_contenu }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_type_contenu')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            {{-- Texte --}}
            <div class="mb-4">
                <label for="texte" class="form-label">
                    <i class="bi bi-file-text me-1"></i>Description du contenu <span class="text-danger">*</span>
                </label>
                <textarea name="texte" id="texte" class="form-control form-control-modern" rows="8" 
                          placeholder="Décrivez votre contenu culturel en détail..." required>{{ old('texte') }}</textarea>
                @error('texte')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Upload de média (Vidéo ou Image) --}}
            <div class="mb-4">
                <label class="form-label">
                    <i class="bi bi-camera-video me-1"></i>Média (Vidéo ou Image)
                </label>
                <div class="file-upload-area-modern" id="uploadArea">
                    <i class="bi bi-cloud-upload display-4 text-muted mb-3"></i>
                    <p class="mb-2 fw-semibold">Glissez-déposez un fichier ici ou cliquez pour sélectionner</p>
                    <p class="text-muted small mb-0">
                        Formats acceptés: MP4, AVI, MOV, WMV, FLV, WEBM (vidéos) | JPG, PNG, GIF (images)
                        <br>Taille maximale: 100 MB
                    </p>
                    <input type="file" name="media" id="media" class="d-none" 
                           accept="video/*,image/*" onchange="handleFileSelect(this)">
                </div>
                <div id="fileInfo" class="mt-3" style="display: none;">
                    <div class="alert alert-info alert-modern">
                        <i class="bi bi-file-earmark me-2"></i>
                        <span id="fileName"></span>
                        <button type="button" class="btn btn-sm btn-link text-danger float-end" onclick="clearFile()">
                            <i class="bi bi-x-circle"></i> Retirer
                        </button>
                    </div>
                </div>
                @error('media')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="row">
                {{-- Date de création --}}
                <div class="col-md-6 mb-4">
                    <label for="date_creation" class="form-label">
                        <i class="bi bi-calendar me-1"></i>Date de création <span class="text-danger">*</span>
                    </label>
                    <input type="date" name="date_creation" id="date_creation" 
                           value="{{ old('date_creation', now()->format('Y-m-d')) }}" 
                           class="form-control form-control-modern" required>
                    @error('date_creation')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Statut --}}
                <div class="col-md-6 mb-4">
                    <label for="statut" class="form-label">
                        <i class="bi bi-info-circle me-1"></i>Statut <span class="text-danger">*</span>
                    </label>
                    <select name="statut" id="statut" class="form-select form-select-modern" required>
                        <option value="en attente" {{ old('statut') == 'en attente' ? 'selected' : '' }}>En attente</option>
                        <option value="publié" {{ old('statut') == 'publié' ? 'selected' : '' }}>Publié</option>
                        <option value="brouillon" {{ old('statut') == 'brouillon' ? 'selected' : '' }}>Brouillon</option>
                    </select>
                    @error('statut')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            {{-- Contenu parent (optionnel) --}}
            <div class="mb-4">
                <label for="parent_id" class="form-label">
                    <i class="bi bi-diagram-3 me-1"></i>Contenu parent (optionnel)
                </label>
                <select name="parent_id" id="parent_id" class="form-select form-select-modern">
                    <option value="" selected>-- Aucun contenu parent --</option>
                    @foreach($contenus as $contenu)
                        <option value="{{ $contenu->id_contenu }}" {{ old('parent_id') == $contenu->id_contenu ? 'selected' : '' }}>
                            {{ $contenu->titre }}
                        </option>
                    @endforeach
                </select>
                @error('parent_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Boutons --}}
            <div class="d-flex justify-content-between align-items-center mt-4 pt-4 border-top">
                <a href="{{ route('contenus.mes-contenus') }}" class="btn btn-secondary btn-modern">
                    <i class="bi bi-arrow-left me-2"></i>Annuler
                </a>
                <button type="submit" class="btn btn-primary-modern btn-modern">
                    <i class="bi bi-check-circle me-2"></i>Créer le contenu
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('styles')
<style>
    .file-upload-area-modern {
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        padding: 3rem 2rem;
        text-align: center;
        background: #f8fafc;
        transition: all 0.3s;
        cursor: pointer;
    }
    
    .file-upload-area-modern:hover {
        border-color: var(--primary-color);
        background: #f0fdf4;
        transform: translateY(-2px);
    }
    
    .file-upload-area-modern.dragover {
        border-color: var(--primary-color);
        background: #f0fdf4;
        box-shadow: 0 0 0 4px rgba(0, 135, 81, 0.1);
    }
</style>
@endsection

@section('scripts')
<script>
    const uploadArea = document.getElementById('uploadArea');
    const fileInput = document.getElementById('media');
    const fileInfo = document.getElementById('fileInfo');
    const fileName = document.getElementById('fileName');

    // Clic sur la zone d'upload
    uploadArea.addEventListener('click', () => fileInput.click());

    // Drag and drop
    uploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadArea.classList.add('dragover');
    });

    uploadArea.addEventListener('dragleave', () => {
        uploadArea.classList.remove('dragover');
    });

    uploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadArea.classList.remove('dragover');
        if (e.dataTransfer.files.length > 0) {
            fileInput.files = e.dataTransfer.files;
            handleFileSelect(fileInput);
        }
    });

    function handleFileSelect(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const fileSize = (file.size / (1024 * 1024)).toFixed(2);
            fileName.textContent = `${file.name} (${fileSize} MB)`;
            fileInfo.style.display = 'block';
        }
    }

    function clearFile() {
        fileInput.value = '';
        fileInfo.style.display = 'none';
    }
</script>
@endsection
