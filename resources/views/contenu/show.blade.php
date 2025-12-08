@extends('layouts.modern')

@section('title', 'Détails du Contenu - BeninCulture')

@section('content')
<div class="page-header-modern">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title">
                <i class="bi bi-file-text me-2" style="color: var(--primary-color);"></i>{{ $contenu->titre }}
            </h1>
            <p class="page-subtitle mb-0">Détails du contenu culturel</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('contenu.index') }}" class="btn btn-outline-secondary btn-modern">
                <i class="bi bi-arrow-left me-2"></i>Retour
            </a>
            @auth
            @if(Auth::user()->id_utilisateur == $contenu->id_auteur || Auth::user()->id_role == 1)
            <a href="{{ route('contenu.edit', $contenu->id_contenu) }}" class="btn btn-primary-modern btn-modern">
                <i class="bi bi-pencil me-2"></i>Modifier
            </a>
            @endif
            @endauth
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="modern-card">
            <div class="card-header-modern">
                <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Informations du contenu</h5>
            </div>
            <div class="card-body p-4">
                <div class="mb-4">
                    <h4 class="mb-3">{{ $contenu->titre }}</h4>
                    <div class="text-muted mb-4" style="line-height: 1.8; white-space: pre-wrap;">{{ $contenu->texte }}</div>
                </div>
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center p-3 bg-light rounded">
                            <i class="bi bi-geo-alt-fill me-3" style="color: var(--primary-color); font-size: 1.5rem;"></i>
                            <div>
                                <small class="text-muted d-block">Région</small>
                                <strong>{{ $contenu->region?->nom_region ?? 'Non spécifiée' }}</strong>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="d-flex align-items-center p-3 bg-light rounded">
                            <i class="bi bi-translate me-3" style="color: var(--primary-color); font-size: 1.5rem;"></i>
                            <div>
                                <small class="text-muted d-block">Langue</small>
                                <strong>{{ $contenu->langue?->nom_langue ?? 'Non spécifiée' }}</strong>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="d-flex align-items-center p-3 bg-light rounded">
                            <i class="bi bi-calendar-check me-3" style="color: var(--primary-color); font-size: 1.5rem;"></i>
                            <div>
                                <small class="text-muted d-block">Date de création</small>
                                <strong>{{ $contenu->date_creation ? \Carbon\Carbon::parse($contenu->date_creation)->format('d/m/Y') : '-' }}</strong>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="d-flex align-items-center p-3 bg-light rounded">
                            <i class="bi bi-info-circle me-3" style="color: var(--primary-color); font-size: 1.5rem;"></i>
                            <div>
                                <small class="text-muted d-block">Statut</small>
                                <span class="badge-modern bg-{{ $contenu->statut == 'publié' ? 'success' : ($contenu->statut == 'en attente' ? 'warning' : 'secondary') }}">
                                    {{ ucfirst($contenu->statut) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    @if($contenu->auteur)
                    <div class="col-md-6">
                        <div class="d-flex align-items-center p-3 bg-light rounded">
                            <i class="bi bi-person-circle me-3" style="color: var(--primary-color); font-size: 1.5rem;"></i>
                            <div>
                                <small class="text-muted d-block">Auteur</small>
                                <strong>{{ $contenu->auteur->prenom }} {{ $contenu->auteur->nom }}</strong>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    @if($contenu->date_validation)
                    <div class="col-md-6">
                        <div class="d-flex align-items-center p-3 bg-light rounded">
                            <i class="bi bi-check-circle me-3" style="color: var(--primary-color); font-size: 1.5rem;"></i>
                            <div>
                                <small class="text-muted d-block">Date de validation</small>
                                <strong>{{ \Carbon\Carbon::parse($contenu->date_validation)->format('d/m/Y') }}</strong>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="modern-card">
            <div class="card-header-modern">
                <h5 class="mb-0"><i class="bi bi-gear me-2"></i>Actions</h5>
            </div>
            <div class="card-body p-4">
                <div class="d-grid gap-2">
                    <a href="{{ route('contenu.index') }}" class="btn btn-outline-secondary btn-modern">
                        <i class="bi bi-arrow-left me-2"></i>Retour à la liste
                    </a>
                    @auth
                    @if(Auth::user()->id_utilisateur == $contenu->id_auteur || Auth::user()->id_role == 1)
                    <a href="{{ route('contenu.edit', $contenu->id_contenu) }}" class="btn btn-warning btn-modern">
                        <i class="bi bi-pencil me-2"></i>Modifier
                    </a>
                    <form action="{{ route('contenu.destroy', $contenu->id_contenu) }}" 
                          method="POST" 
                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce contenu ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-modern w-100">
                            <i class="bi bi-trash me-2"></i>Supprimer
                        </button>
                    </form>
                    @endif
                    @endauth
                </div>
            </div>
        </div>
        
        @if($contenu->media && $contenu->media->count() > 0)
        <div class="modern-card mt-3">
            <div class="card-header-modern">
                <h5 class="mb-0"><i class="bi bi-images me-2"></i>Médias associés</h5>
            </div>
            <div class="card-body p-4">
                @foreach($contenu->media as $media)
                <div class="mb-3">
                    @if(str_contains($media->chemin, '.mp4') || str_contains($media->chemin, '.avi') || str_contains($media->chemin, '.mov'))
                        <video controls class="w-100 rounded" style="max-height: 200px;">
                            <source src="{{ asset($media->chemin) }}" type="video/mp4">
                        </video>
                    @else
                        <img src="{{ asset($media->chemin) }}" alt="Média" class="w-100 rounded" style="max-height: 200px; object-fit: cover;">
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
