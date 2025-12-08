@extends('layouts.modern')

@section('title', 'Régions - BeninCulture')

@section('content')
<div class="page-header-modern">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title">
                <i class="bi bi-geo-alt me-2" style="color: var(--primary-color);"></i>Régions
            </h1>
            <p class="page-subtitle mb-0">Gérez les régions du Bénin</p>
        </div>
        <a href="{{ route('region.create') }}" class="btn btn-primary-modern btn-modern">
            <i class="bi bi-plus-circle me-2"></i>Ajouter une région
        </a>
    </div>
</div>

@if(isset($regions) && $regions->count() > 0)
    <div class="row g-4">
        @foreach($regions as $region)
        <div class="col-md-6 col-lg-4">
            <div class="modern-card h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <div>
                            <h5 class="mb-1">{{ $region->nom_region }}</h5>
                            @if($region->description)
                            <p class="text-muted small mb-0">{{ Str::limit($region->description, 100) }}</p>
                            @endif
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('region.show', $region->id_region) }}" 
                               class="btn btn-sm btn-info btn-icon-modern" 
                               title="Voir">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('region.edit', $region->id_region) }}" 
                               class="btn btn-sm btn-warning btn-icon-modern" 
                               title="Modifier">
                                <i class="bi bi-pencil"></i>
                            </a>
                        </div>
                    </div>
                    @if($region->localisation)
                    <div class="d-flex align-items-center text-muted small">
                        <i class="bi bi-geo-alt me-2"></i>
                        <span>{{ $region->localisation }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
@else
    <div class="modern-card">
        <div class="card-body">
            <div class="empty-state">
                <i class="bi bi-inbox"></i>
                <h4 class="mt-3 mb-2">Aucune région enregistrée</h4>
                <p class="text-muted mb-4">Commencez à ajouter les régions du Bénin !</p>
                <a href="{{ route('region.create') }}" class="btn btn-primary-modern btn-modern">
                    <i class="bi bi-plus-circle me-2"></i>Ajouter une région
                </a>
            </div>
        </div>
    </div>
@endif
@endsection
