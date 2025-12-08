@extends('layouts.modern')

@section('title', 'Contenus - BeninCulture')

@section('content')
<div class="page-header-modern">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title">
                <i class="bi bi-collection me-2" style="color: var(--primary-color);"></i>Tous les Contenus
            </h1>
            <p class="page-subtitle mb-0">Explorez tous les contenus culturels publiés</p>
        </div>
        <div class="d-flex gap-2">
            @auth
            <a href="{{ route('payment.checkout') }}" class="btn btn-success btn-modern">
                <i class="bi bi-star-fill me-2"></i>Passer Premium
            </a>
            <a href="{{ route('contenu.create') }}" class="btn btn-primary-modern btn-modern">
                <i class="bi bi-plus-circle me-2"></i>Créer un contenu
            </a>
            @else
            <a href="{{ route('register') }}" class="btn btn-success btn-modern">
                <i class="bi bi-star-fill me-2"></i>Rejoindre Premium
            </a>
            @endauth
        </div>
    </div>
</div>

<div class="modern-card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table modern-table mb-0" id="contenus-table">
                <thead>
                    <tr>
                        <th><i class="bi bi-type me-2"></i>Titre</th>
                        <th><i class="bi bi-geo-alt me-2"></i>Région</th>
                        <th><i class="bi bi-translate me-2"></i>Langue</th>
                        <th><i class="bi bi-info-circle me-2"></i>Statut</th>
                        <th><i class="bi bi-person me-2"></i>Auteur</th>
                        <th><i class="bi bi-calendar me-2"></i>Date</th>
                        <th class="text-center"><i class="bi bi-gear me-2"></i>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($contenus as $contenu)
                        <tr>
                            <td><strong>{{ $contenu->titre ?? '-' }}</strong></td>
                            <td>{{ $contenu->region?->nom_region ?? '-' }}</td>
                            <td>{{ $contenu->langue?->nom_langue ?? '-' }}</td>
                            <td>
                                @if($contenu->statut == 'publié')
                                    <span class="badge-modern bg-success">Publié</span>
                                @elseif($contenu->statut == 'brouillon')
                                    <span class="badge-modern bg-warning">Brouillon</span>
                                @else
                                    <span class="badge-modern bg-secondary">{{ $contenu->statut ?? '-' }}</span>
                                @endif
                            </td>
                            <td>{{ $contenu->auteur?->prenom . ' ' . $contenu->auteur?->nom ?? '-' }}</td>
                            <td>{{ $contenu->date_creation ? \Carbon\Carbon::parse($contenu->date_creation)->format('d/m/Y') : '-' }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('contenu.show', $contenu->id_contenu) }}" 
                                       class="btn btn-sm btn-info btn-icon-modern" 
                                       title="Voir">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    @auth
                                    @if(Auth::user()->id_utilisateur == $contenu->id_auteur || Auth::user()->id_role == 1)
                                    <a href="{{ route('contenu.edit', $contenu->id_contenu) }}" 
                                       class="btn btn-sm btn-warning btn-icon-modern" 
                                       title="Modifier">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('contenu.destroy', $contenu->id_contenu) }}" 
                                          method="POST" 
                                          class="d-inline" 
                                          onsubmit="return confirm('Supprimer ce contenu ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-danger btn-icon-modern" 
                                                title="Supprimer">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                    @endauth
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="bi bi-inbox"></i>
                                    <p class="mt-3 mb-0">Aucun contenu trouvé.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css" />

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function () {
    $('#contenus-table').DataTable({
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.5/i18n/fr-FR.json'
        },
        responsive: true,
        pageLength: 10,
        lengthMenu: [5, 10, 15, 25, 50],
        // IMPORTANT : Désactiver le chargement serveur
        processing: false,
        serverSide: false // DataTables utilisera les données HTML existantes
    });
});
</script>
@endsection