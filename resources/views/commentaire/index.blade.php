@extends('layouts.modern')

@section('title', 'Commentaires - BeninCulture')

@section('content')
<div class="page-header-modern">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title">
                <i class="bi bi-chat-text me-2" style="color: var(--primary-color);"></i>Commentaires
            </h1>
            <p class="page-subtitle mb-0">Gérez tous les commentaires</p>
        </div>
        <a href="{{ route('commentaire.create') }}" class="btn btn-primary-modern btn-modern">
            <i class="bi bi-plus-circle me-2"></i>Ajouter un commentaire
        </a>
    </div>
</div>

@if(isset($commentaires) && $commentaires->count() > 0)
    <div class="modern-card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table modern-table mb-0" id="commentaires-table">
                    <thead>
                        <tr>
                            <th><i class="bi bi-hash me-2"></i>ID</th>
                            <th><i class="bi bi-file-text me-2"></i>Texte</th>
                            <th><i class="bi bi-person me-2"></i>Auteur</th>
                            <th><i class="bi bi-star me-2"></i>Note</th>
                            <th><i class="bi bi-calendar me-2"></i>Date</th>
                            <th class="text-center"><i class="bi bi-gear me-2"></i>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($commentaires as $c)
                        <tr>
                            <td><strong>#{{ $c->id_commentaire ?? $c->id }}</strong></td>
                            <td>{{ Str::limit($c->texte ?? '-', 50) }}</td>
                            <td>{{ $c->utilisateur?->prenom . ' ' . $c->utilisateur?->nom ?? 'Utilisateur supprimé' }}</td>
                            <td>
                                @if(isset($c->note))
                                    <span class="badge-modern bg-warning">
                                        <i class="bi bi-star-fill me-1"></i>{{ $c->note }}/5
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $c->date ? \Carbon\Carbon::parse($c->date)->format('d/m/Y') : ($c->created_at ? $c->created_at->format('d/m/Y') : '-') }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('commentaire.show', $c->id_commentaire ?? $c->id) }}" 
                                       class="btn btn-sm btn-info btn-icon-modern" 
                                       title="Voir">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('commentaire.edit', $c->id_commentaire ?? $c->id) }}" 
                                       class="btn btn-sm btn-warning btn-icon-modern" 
                                       title="Modifier">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('commentaire.destroy', $c->id_commentaire ?? $c->id) }}" 
                                          method="POST" 
                                          class="d-inline" 
                                          onsubmit="return confirm('Supprimer ce commentaire ?');">
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
                <h4 class="mt-3 mb-2">Aucun commentaire</h4>
                <p class="text-muted mb-4">Il n'y a pas encore de commentaires.</p>
            </div>
        </div>
    </div>
@endif
@endsection

@section('scripts')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css" />
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function () {
    $('#commentaires-table').DataTable({
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.5/i18n/fr-FR.json'
        },
        responsive: true,
        pageLength: 10
    });
});
</script>
@endsection
