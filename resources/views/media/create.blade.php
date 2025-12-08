@extends('layouts.modern')

@section('title', 'Créer un Média - BeninCulture')

@section('content')
<div class="page-header-modern">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title">
                <i class="bi bi-cloud-upload me-2" style="color: var(--primary-color);"></i>Ajouter un Média
            </h1>
            <p class="page-subtitle mb-0">Téléchargez une image ou une vidéo pour enrichir vos contenus</p>
        </div>
        <a href="{{ route('media.index') }}" class="btn btn-secondary btn-modern">
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

        <form action="{{ route('media.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="chemin" class="form-label">
                    <i class="bi bi-file-earmark me-1"></i>Fichier <span class="text-danger">*</span>
                </label>
                <div class="file-upload-area-modern" id="uploadArea">
                    <i class="bi bi-cloud-upload display-4 text-muted mb-3"></i>
                    <p class="mb-2 fw-semibold">Glissez-déposez un fichier ici ou cliquez pour sélectionner</p>
                    <p class="text-muted small mb-0">
                        Formats acceptés: Images (JPG, PNG, GIF) | Vidéos (MP4, AVI, MOV)
                        <br>Taille maximale: 10 MB
                    </p>
                    <input type="file" name="chemin" id="chemin" class="d-none" required>
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
                @error('chemin')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <label for="id_type_media" class="form-label">
                        <i class="bi bi-tags me-1"></i>Type de média
                    </label>
                    <select name="id_type_media" id="id_type_media" class="form-select form-select-modern">
                        <option value="">-- Sélectionner un type --</option>
                        @foreach($typeMedias as $typeMedia)
                            <option value="{{ $typeMedia->id_type_media }}" {{ old('id_type_media') == $typeMedia->id_type_media ? 'selected' : '' }}>
                                {{ $typeMedia->nom_media }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_type_media')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6 mb-4">
                    <label for="id_contenu" class="form-label">
                        <i class="bi bi-file-text me-1"></i>Contenu associé
                    </label>
                    <select name="id_contenu" id="id_contenu" class="form-select form-select-modern">
                        <option value="">-- Aucun contenu --</option>
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
            </div>

            <div class="mb-4">
                <label for="description" class="form-label">
                    <i class="bi bi-card-text me-1"></i>Description
                </label>
                <textarea name="description" id="description" class="form-control form-control-modern" rows="4" 
                          placeholder="Décrivez le média...">{{ old('description') }}</textarea>
                @error('description')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4 pt-4 border-top">
                <a href="{{ route('media.index') }}" class="btn btn-secondary btn-modern">
                    <i class="bi bi-arrow-left me-2"></i>Annuler
                </a>
                <button type="submit" class="btn btn-primary-modern btn-modern">
                    <i class="bi bi-check-circle me-2"></i>Ajouter le média
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
    const fileInput = document.getElementById('chemin');
    const fileInfo = document.getElementById('fileInfo');
    const fileName = document.getElementById('fileName');

    uploadArea.addEventListener('click', () => fileInput.click());

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

    fileInput.addEventListener('change', function() {
        handleFileSelect(this);
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
