@extends('layouts.modern')

@section('title', 'Médias - BeninCulture')

@section('content')
<div class="page-header-modern">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title">
                <i class="bi bi-images me-2" style="color: var(--primary-color);"></i>Médias
            </h1>
            <p class="page-subtitle mb-0">Gérez vos médias (photos et vidéos)</p>
        </div>
        <a href="{{ route('media.create') }}" class="btn btn-primary-modern btn-modern">
            <i class="bi bi-plus-circle me-2"></i>Ajouter un média
        </a>
    </div>
</div>

@if(isset($medias) && $medias->count() > 0)
    <div class="modern-card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table modern-table mb-0">
                    <thead>
                        <tr>
                            <th><i class="bi bi-image me-2"></i>Média</th>
                            <th><i class="bi bi-file-text me-2"></i>Description</th>
                            <th><i class="bi bi-tag me-2"></i>Type</th>
                            <th class="text-center"><i class="bi bi-gear me-2"></i>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($medias as $media)
                        <tr>
                            <td>
                                @if(str_contains($media->chemin, '.mp4') || str_contains($media->chemin, '.avi') || str_contains($media->chemin, '.mov'))
                                    <i class="bi bi-camera-video-fill text-primary me-2"></i>Vidéo
                                @else
                                    <i class="bi bi-image-fill text-success me-2"></i>Image
                                @endif
                            </td>
                            <td>{{ $media->description ?? 'Aucune description' }}</td>
                            <td>
                                <span class="badge-modern bg-info">
                                    {{ $media->typeMedia?->nom_media ?? 'Non spécifié' }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('media.show', $media->id_media) }}" 
                                       class="btn btn-sm btn-info btn-icon-modern" 
                                       title="Voir">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('media.edit', $media->id_media) }}" 
                                       class="btn btn-sm btn-warning btn-icon-modern" 
                                       title="Modifier">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('media.destroy', $media->id_media) }}" 
                                          method="POST" 
                                          class="d-inline" 
                                          onsubmit="return confirm('Supprimer ce média ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-danger btn-icon-modern" 
                                                title="Supprimer">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@else
    <div class="modern-card">
        <div class="card-body">
            <div class="empty-state">
                <i class="bi bi-inbox"></i>
                <h4 class="mt-3 mb-2">Aucun média pour le moment</h4>
                <p class="text-muted mb-4">Commencez à ajouter des photos et vidéos !</p>
                <a href="{{ route('media.create') }}" class="btn btn-primary-modern btn-modern">
                    <i class="bi bi-plus-circle me-2"></i>Ajouter un média
                </a>
            </div>
        </div>
    </div>
@endif
@endsection
