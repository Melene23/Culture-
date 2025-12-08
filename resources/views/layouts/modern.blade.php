<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BeninCulture')</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #008751;
            --primary-dark: #007040;
            --primary-light: #00a86b;
            --secondary-color: #FCD116;
            --accent-color: #E8112D;
            --bg-gradient: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        }
        
        * {
            font-family: 'Inter', sans-serif;
        }
        
        body {
            background: var(--bg-gradient);
            min-height: 100vh;
            padding-top: 70px;
        }
        
        /* Navigation moderne */
        .modern-nav {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
            border-bottom: 1px solid rgba(0, 135, 81, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }
        
        .nav-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: #1a1a1a;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .nav-brand .logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }
        
        .nav-brand span {
            color: var(--primary-color);
        }
        
        .nav-link-custom {
            color: #4a5568;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.3s;
            text-decoration: none;
        }
        
        .nav-link-custom:hover {
            background: rgba(0, 135, 81, 0.1);
            color: var(--primary-color);
        }
        
        /* Cards modernes */
        .modern-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: none;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .modern-card:hover {
            box-shadow: 0 8px 30px rgba(0, 0, 81, 0.12);
            transform: translateY(-2px);
        }
        
        .card-header-modern {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            color: white;
            padding: 1.25rem 1.5rem;
            border: none;
            font-weight: 600;
        }
        
        /* Tables modernes */
        .modern-table {
            background: white;
            border-radius: 12px;
            overflow: hidden;
        }
        
        .modern-table thead {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        }
        
        .modern-table th {
            font-weight: 600;
            color: #2d3748;
            border-bottom: 2px solid var(--primary-color);
            padding: 1rem;
        }
        
        .modern-table td {
            padding: 1rem;
            vertical-align: middle;
        }
        
        .modern-table tbody tr {
            transition: all 0.2s;
        }
        
        .modern-table tbody tr:hover {
            background: rgba(0, 135, 81, 0.05);
        }
        
        /* Boutons modernes */
        .btn-modern {
            border-radius: 10px;
            padding: 0.625rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s;
            border: none;
        }
        
        .btn-primary-modern {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-light) 100%);
            color: white;
        }
        
        .btn-primary-modern:hover {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-color) 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 135, 81, 0.3);
            color: white;
        }
        
        .btn-icon-modern {
            width: 38px;
            height: 38px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            transition: all 0.3s;
        }
        
        .btn-icon-modern:hover {
            transform: scale(1.1) translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        
        /* Badges modernes */
        .badge-modern {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.875rem;
        }
        
        /* Formulaires modernes */
        .form-control-modern, .form-select-modern {
            border-radius: 10px;
            border: 2px solid #e2e8f0;
            padding: 0.75rem 1rem;
            transition: all 0.3s;
        }
        
        .form-control-modern:focus, .form-select-modern:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(0, 135, 81, 0.15);
            outline: none;
        }
        
        /* Page header */
        .page-header-modern {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }
        
        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: #1a1a1a;
            margin: 0;
        }
        
        .page-subtitle {
            color: #718096;
            margin-top: 0.5rem;
        }
        
        /* Alerts modernes */
        .alert-modern {
            border-radius: 12px;
            border: none;
            padding: 1rem 1.5rem;
        }
        
        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #718096;
        }
        
        .empty-state i {
            font-size: 4rem;
            color: #cbd5e0;
            margin-bottom: 1rem;
        }
    </style>
    
    @yield('styles')
</head>
<body>
    <!-- Navigation moderne -->
    <nav class="modern-nav">
        <div class="container-fluid px-4">
            <div class="d-flex justify-content-between align-items-center" style="height: 70px;">
                <!-- Logo -->
                <a href="{{ url('/') }}" class="nav-brand">
                    <div class="logo-icon">
                        <i class="bi bi-globe-americas"></i>
                    </div>
                    <span>Benin<span style="color: var(--primary-color);">Culture</span></span>
                </a>
                
                <!-- Menu -->
                <div class="d-flex align-items-center gap-4">
                    @auth
                        <span class="text-muted">Bonjour, <strong>{{ Auth::user()->prenom }}</strong></span>
                        <a href="{{ route('dashboard') }}" class="btn btn-primary-modern btn-modern">
                            <i class="bi bi-person-circle me-2"></i>Mon compte
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-modern">
                                <i class="bi bi-box-arrow-right me-2"></i>Déconnexion
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="nav-link-custom">Connexion</a>
                        <a href="{{ route('register') }}" class="btn btn-primary-modern btn-modern">
                            <i class="bi bi-person-plus me-2"></i>S'inscrire
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Messages Flash -->
    @if(session('success'))
    <div class="container-fluid px-4 mt-3">
        <div class="alert alert-success alert-modern alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    @endif
    
    @if(session('error'))
    <div class="container-fluid px-4 mt-3">
        <div class="alert alert-danger alert-modern alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    @endif
    
    <!-- Contenu principal -->
    <main class="container-fluid px-4 py-4">
        @yield('content')
    </main>
    
    <!-- Footer moderne -->
    <footer class="mt-5 py-4" style="background: white; border-top: 1px solid #e2e8f0;">
        <div class="container-fluid px-4">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0 text-muted">
                        <i class="bi bi-globe-americas me-2"></i>
                        <strong>BeninCulture</strong> - Plateforme du Patrimoine Béninois
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0 text-muted">&copy; {{ date('Y') }} BeninCulture. Tous droits réservés.</p>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    @yield('scripts')
</body>
</html>

