@extends('layouts.modern')

@section('title', 'Mon Tableau de Bord - BeninCulture')

@section('content')
<div class="page-header-modern">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title">
                <i class="bi bi-speedometer2 me-2" style="color: var(--primary-color);"></i>Mon Tableau de Bord
            </h1>
            <p class="page-subtitle mb-0">Bienvenue, {{ $user->prenom }} {{ $user->nom }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('payment.checkout') }}" class="btn btn-success btn-modern">
                <i class="bi bi-credit-card me-2"></i>Passer Premium
            </a>
            <a href="{{ route('contenu.create') }}" class="btn btn-primary-modern btn-modern">
                <i class="bi bi-plus-circle me-2"></i>Nouveau contenu
            </a>
        </div>
    </div>
</div>

<!-- Statistiques -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="modern-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="stat-icon-modern bg-primary text-white">
                            <i class="bi bi-file-text"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted mb-1">Mes Contenus</h6>
                        <h3 class="mb-0">{{ $stats['mes_contenus'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="modern-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="stat-icon-modern bg-success text-white">
                            <i class="bi bi-check-circle"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted mb-1">Publiés</h6>
                        <h3 class="mb-0">{{ $stats['contenus_publies'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="modern-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="stat-icon-modern bg-warning text-white">
                            <i class="bi bi-clock-history"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted mb-1">En attente</h6>
                        <h3 class="mb-0">{{ $stats['contenus_en_attente'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="modern-card">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="stat-icon-modern bg-info text-white">
                            <i class="bi bi-chat-left-text"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-muted mb-1">Commentaires</h6>
                        <h3 class="mb-0">{{ $stats['mes_commentaires'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Actions rapides -->
    <div class="col-md-4 mb-4">
        <div class="modern-card">
            <div class="card-header-modern">
                <h5 class="mb-0"><i class="bi bi-lightning-charge me-2"></i>Actions rapides</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('contenu.create') }}" class="btn btn-primary-modern btn-modern">
                        <i class="bi bi-plus-circle me-2"></i>Créer un contenu
                    </a>
                    <a href="{{ route('contenus.mes-contenus') }}" class="btn btn-outline-primary btn-modern">
                        <i class="bi bi-file-text me-2"></i>Mes contenus
                    </a>
                    <a href="{{ route('commentaire.create') }}" class="btn btn-outline-info btn-modern">
                        <i class="bi bi-chat-left-text me-2"></i>Ajouter un commentaire
                    </a>
                    <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary btn-modern">
                        <i class="bi bi-person-circle me-2"></i>Mon profil
                    </a>
                    <a href="{{ route('payment.checkout') }}" class="btn btn-success btn-modern">
                        <i class="bi bi-star me-2"></i>Passer Premium
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Derniers contenus -->
    <div class="col-md-8 mb-4">
        <div class="modern-card">
            <div class="card-header-modern d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Derniers contenus</h5>
                <a href="{{ route('contenus.mes-contenus') }}" class="btn btn-sm btn-light">Voir tout</a>
            </div>
            <div class="card-body p-0">
                @if($stats['derniers_contenus']->count() > 0)
                    <div class="table-responsive">
                        <table class="table modern-table mb-0">
                            <thead>
                                <tr>
                                    <th>Titre</th>
                                    <th>Date</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stats['derniers_contenus'] as $contenu)
                                <tr>
                                    <td>
                                        <strong>{{ Str::limit($contenu->titre, 40) }}</strong>
                                    </td>
                                    <td>
                                        <span class="text-muted">
                                            {{ \Carbon\Carbon::parse($contenu->date_creation)->format('d/m/Y') }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge-modern bg-{{ $contenu->statut == 'publié' ? 'success' : ($contenu->statut == 'en attente' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst($contenu->statut) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('contenu.show', $contenu->id_contenu) }}" 
                                               class="btn btn-sm btn-info btn-icon-modern" title="Voir">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('contenu.edit', $contenu->id_contenu) }}" 
                                               class="btn btn-sm btn-warning btn-icon-modern" title="Modifier">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state p-4">
                        <i class="bi bi-inbox"></i>
                        <h5 class="mt-3 mb-2">Aucun contenu</h5>
                        <p class="text-muted mb-3">Commencez à créer votre premier contenu !</p>
                        <a href="{{ route('contenu.create') }}" class="btn btn-primary-modern btn-modern">
                            <i class="bi bi-plus-circle me-2"></i>Créer un contenu
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .stat-icon-modern {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }
</style>
@endsection

