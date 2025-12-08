<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin - Culture Bénin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <span class="navbar-brand">Admin Culture Bénin</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-light">Déconnexion</button>
            </form>
        </div>
    </nav>
    
    <div class="container mt-4">
        <h1>Dashboard Administrateur</h1>
        <p>Bienvenue {{ auth()->user()->prenom }} !</p>
        
        <div class="row mt-4">
            <div class="col-md-3">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <h5 class="card-title">Utilisateurs</h5>
                        <p class="card-text">{{ \App\Models\Utilisateur::count() }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <h5 class="card-title">Contenus</h5>
                        <p class="card-text">{{ \App\Models\Contenu::count() }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-4">
            <h3>Actions rapides</h3>
            <a href="{{ route('admin.utilisateurs') }}" class="btn btn-primary">
                Gérer les utilisateurs
            </a>
            <a href="{{ route('admin.contenus.index') }}" class="btn btn-secondary">
                Gérer les contenus
            </a>
            <a href="/mes-contenus" class="btn btn-info">
                Voir mes contenus
            </a>
        </div>
    </div>
</body>
</html>