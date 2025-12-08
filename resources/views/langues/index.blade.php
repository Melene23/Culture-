@extends('layouts.modern')

@section('title', 'Langues - BeninCulture')

@section('content')
<div class="page-header-modern">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title">
                <i class="bi bi-translate me-2" style="color: var(--primary-color);"></i>Langues
            </h1>
            <p class="page-subtitle mb-0">Gérez les langues disponibles</p>
        </div>
        <a href="{{ route('langues.create') }}" class="btn btn-primary-modern btn-modern">
            <i class="bi bi-plus-circle me-2"></i>Ajouter une langue
        </a>
    </div>
</div>

@if(isset($langues) && $langues->count() > 0)
    <div class="row g-4">
        @foreach($langues as $langue)
        <div class="col-md-6 col-lg-4">
            <div class="modern-card h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <div>
                            <h5 class="mb-1">
                                <i class="bi bi-translate me-2" style="color: var(--primary-color);"></i>
                                {{ $langue->nom_langue }}
                            </h5>
                            @if($langue->code_langue)
                            <span class="badge-modern bg-info">{{ $langue->code_langue }}</span>
                            @endif
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('langues.show', $langue->id_langue) }}" 
                               class="btn btn-sm btn-info btn-icon-modern" 
                               title="Voir">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('langues.edit', $langue->id_langue) }}" 
                               class="btn btn-sm btn-warning btn-icon-modern" 
                               title="Modifier">
                                <i class="bi bi-pencil"></i>
                            </a>
                        </div>
                    </div>
                    @if($langue->description)
                    <p class="text-muted small mb-0">{{ Str::limit($langue->description, 100) }}</p>
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
                <h4 class="mt-3 mb-2">Aucune langue enregistrée</h4>
                <p class="text-muted mb-4">Commencez à ajouter les langues du Bénin !</p>
                <a href="{{ route('langues.create') }}" class="btn btn-primary-modern btn-modern">
                    <i class="bi bi-plus-circle me-2"></i>Ajouter une langue
                </a>
            </div>
        </div>
    </div>
@endif
@endsection
