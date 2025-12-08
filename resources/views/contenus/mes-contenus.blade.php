@extends('layouts.modern')

@section('title', 'Mes Contenus - BeninCulture')

@section('content')
<div class="page-header-modern">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title">
                <i class="bi bi-file-text me-2" style="color: var(--primary-color);"></i>Mes Contenus
            </h1>
            <p class="page-subtitle mb-0">Gérez vos contenus culturels publiés</p>
        </div>
        <a href="{{ route('contenu.create') }}" class="btn btn-primary-modern btn-modern">
            <i class="bi bi-plus-circle me-2"></i>Créer un contenu
        </a>
    </div>
</div>

@if(isset($contenus) && $contenus->count() > 0)
    <div class="modern-card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table modern-table mb-0">
                    <thead>
                        <tr>
                            <th><i class="bi bi-type me-2"></i>Titre</th>
                            <th><i class="bi bi-calendar me-2"></i>Date</th>
                            <th><i class="bi bi-info-circle me-2"></i>Statut</th>
                            <th class="text-center"><i class="bi bi-gear me-2"></i>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contenus as $contenu)
                        <tr>
                            <td>
                                <strong>{{ $contenu->titre }}</strong>
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
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('contenu.show', $contenu->id_contenu) }}" 
                                       class="btn btn-sm btn-info btn-icon-modern" 
                                       title="Voir" 
                                       aria-label="Voir">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('contenu.edit', $contenu->id_contenu) }}" 
                                       class="btn btn-sm btn-warning btn-icon-modern" 
                                       title="Modifier" 
                                       aria-label="Modifier">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('contenu.destroy', $contenu->id_contenu) }}" 
                                          method="POST" 
                                          class="d-inline" 
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce contenu ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-danger btn-icon-modern" 
                                                title="Supprimer" 
                                                aria-label="Supprimer">
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
                <h4 class="mt-3 mb-2">Aucun contenu pour le moment</h4>
                <p class="text-muted mb-4">Commencez à partager votre connaissance de la culture béninoise !</p>
                <a href="{{ route('contenu.create') }}" class="btn btn-primary-modern btn-modern btn-lg">
                    <i class="bi bi-plus-circle me-2"></i>Créer mon premier contenu
                </a>
            </div>
        </div>
    </div>
@endif
@endsection