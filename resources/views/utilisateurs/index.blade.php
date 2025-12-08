@extends('layouts.modern')

@section('title', 'Utilisateurs - BeninCulture')

@section('content')
<div class="page-header-modern">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title">
                <i class="bi bi-people me-2" style="color: var(--primary-color);"></i>Utilisateurs
            </h1>
            <p class="page-subtitle mb-0">Gérez les utilisateurs de la plateforme</p>
        </div>
        <a href="{{ route('utilisateurs.create') }}" class="btn btn-primary-modern btn-modern">
            <i class="bi bi-plus-circle me-2"></i>Ajouter un utilisateur
        </a>
    </div>
</div>

@if(isset($utilisateurs) && $utilisateurs->count() > 0)
    <div class="modern-card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table modern-table mb-0">
                    <thead>
                        <tr>
                            <th><i class="bi bi-person me-2"></i>Nom</th>
                            <th><i class="bi bi-envelope me-2"></i>Email</th>
                            <th><i class="bi bi-gender-ambiguous me-2"></i>Sexe</th>
                            <th><i class="bi bi-image me-2"></i>Photo</th>
                            <th><i class="bi bi-shield-check me-2"></i>Rôle</th>
                            <th><i class="bi bi-info-circle me-2"></i>Statut</th>
                            <th class="text-center"><i class="bi bi-gear me-2"></i>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($utilisateurs as $utilisateur)
                        <tr>
                            <td>
                                <strong>{{ $utilisateur->prenom }} {{ $utilisateur->nom }}</strong>
                            </td>
                            <td>{{ $utilisateur->email }}</td>
                            <td>
                                <span class="badge-modern bg-{{ $utilisateur->sexe == 'M' ? 'primary' : 'danger' }}">
                                    {{ $utilisateur->sexe == 'M' ? 'Masculin' : 'Féminin' }}
                                </span>
                            </td>
                            <td>
                                @if($utilisateur->photo)
                                    <img src="{{ asset('storage/photos/' . $utilisateur->photo) }}" 
                                         alt="Photo de {{ $utilisateur->nom }}" 
                                         class="rounded-circle" 
                                         style="width: 40px; height: 40px; object-fit: cover;">
                                @else
                                    <div class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center text-white" 
                                         style="width: 40px; height: 40px;">
                                        <i class="bi bi-person"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <span class="badge-modern bg-info">
                                    {{ $utilisateur->role?->nom_role ?? 'Non défini' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge-modern bg-{{ $utilisateur->statut ? 'success' : 'secondary' }}">
                                    {{ $utilisateur->statut ? 'Actif' : 'Inactif' }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('utilisateurs.show', $utilisateur->id_utilisateur) }}" 
                                       class="btn btn-sm btn-info btn-icon-modern" 
                                       title="Voir">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('utilisateurs.edit', $utilisateur->id_utilisateur) }}" 
                                       class="btn btn-sm btn-warning btn-icon-modern" 
                                       title="Modifier">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('utilisateurs.destroy', $utilisateur->id_utilisateur) }}" 
                                          method="POST" 
                                          class="d-inline" 
                                          onsubmit="return confirm('Supprimer cet utilisateur ?');">
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
                <h4 class="mt-3 mb-2">Aucun utilisateur</h4>
                <p class="text-muted mb-4">Il n'y a pas encore d'utilisateurs enregistrés.</p>
                <a href="{{ route('utilisateurs.create') }}" class="btn btn-primary-modern btn-modern">
                    <i class="bi bi-plus-circle me-2"></i>Ajouter un utilisateur
                </a>
            </div>
        </div>
    </div>
@endif
@endsection
