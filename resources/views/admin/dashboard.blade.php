<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Culture Bénin</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <!-- Chart.js pour les graphiques -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        :root {
            --primary-color: #10b981;    /* Vert émeraude */
            --secondary-color: #1e293b;  /* Gris foncé */
            --accent-color: #3b82f6;     /* Bleu */
        }
        
        .sidebar {
            background: linear-gradient(180deg, var(--secondary-color) 0%, #0f172a 100%);
            color: white;
            min-height: 100vh;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
        }
        
        .sidebar-item {
            padding: 12px 20px;
            margin: 4px 12px;
            border-radius: 8px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .sidebar-item:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }
        
        .sidebar-item.active {
            background: var(--primary-color);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }
        
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }
        
        .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }
        
        .progress-ring {
            transform: rotate(-90deg);
        }
        
        .progress-ring-circle {
            stroke-linecap: round;
            transition: stroke-dashoffset 0.5s ease;
        }
        
        .table-row-hover:hover {
            background: #f8fafc;
        }
        
        .btn-primary {
            background: var(--primary-color);
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background: #0da271;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }
        
        .btn-secondary {
            background: white;
            color: var(--secondary-color);
            border: 1px solid #e2e8f0;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .btn-secondary:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }
        
        .card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
        }
        
        .badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .badge-success {
            background: #d1fae5;
            color: #065f46;
        }
        
        .badge-warning {
            background: #fef3c7;
            color: #92400e;
        }
        
        .badge-info {
            background: #dbeafe;
            color: #1e40af;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Container principal -->
    <div class="flex min-h-screen">
        
        <!-- Sidebar -->
        <div class="sidebar w-64 flex-shrink-0">
            <!-- Logo -->
            <div class="p-6 border-b border-gray-800">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-green-500 flex items-center justify-center">
                        <i class="bi bi-globe-americas text-white text-lg"></i>
                    </div>
                    <div>
                        <h2 class="font-bold text-lg">Culture Bénin</h2>
                        <p class="text-xs text-gray-400">Administration</p>
                    </div>
                </div>
            </div>
            
            <!-- Profil admin -->
            <div class="p-6 border-b border-gray-800">
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-r from-green-400 to-blue-500 flex items-center justify-center text-white font-bold">
                            {{ substr($user->prenom, 0, 1) }}{{ substr($user->nom, 0, 1) }}
                        </div>
                        <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-500 rounded-full border-2 border-gray-900"></div>
                    </div>
                    <div>
                        <h3 class="font-medium">{{ $user->prenom }} {{ $user->nom }}</h3>
                        <p class="text-sm text-gray-400">{{ $user->email }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Menu navigation -->
            <div class="p-4">
                <nav class="space-y-1">
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-item active">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                    
                    <a href="{{ route('utilisateurs.index') }}" class="sidebar-item">
                        <i class="bi bi-people"></i>
                        <span>Utilisateurs</span>
                        <span class="ml-auto badge">{{ $stats['users'] ?? 0 }}</span>
                    </a>
                    
                    <a href="{{ route('contenu.index') }}" class="sidebar-item">
                        <i class="bi bi-file-text"></i>
                        <span>Contenus</span>
                        <span class="ml-auto badge">{{ $stats['contents'] ?? 0 }}</span>
                    </a>
                    
                    <a href="{{ route('media.index') }}" class="sidebar-item">
                        <i class="bi bi-images"></i>
                        <span>Médias</span>
                    </a>
                    
                    <a href="{{ route('region.index') }}" class="sidebar-item">
                        <i class="bi bi-geo-alt"></i>
                        <span>Régions</span>
                    </a>
                    
                    <a href="{{ route('langues.index') }}" class="sidebar-item">
                        <i class="bi bi-translate"></i>
                        <span>Langues</span>
                    </a>
                    
                    <div class="pt-8 mt-8 border-t border-gray-800">
                        <a href="{{ route('contenus.mes-contenus') }}" class="sidebar-item">
                            <i class="bi bi-person-circle"></i>
                            <span>Mes contenus</span>
                        </a>
                        
                        <a href="/" class="sidebar-item">
                            <i class="bi bi-house"></i>
                            <span>Site public</span>
                        </a>
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="sidebar-item w-full text-left text-red-400 hover:text-red-300">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Déconnexion</span>
                            </button>
                        </form>
                    </div>
                </nav>
            </div>
            
            <!-- Version du site -->
            <div class="p-4 mt-auto text-center text-xs text-gray-500">
                <p>Version 1.0.0</p>
                <p>© {{ date('Y') }} Culture Bénin</p>
            </div>
        </div>
        
        <!-- Contenu principal -->
        <div class="flex-1 overflow-auto">
            <!-- Header -->
            <header class="bg-white border-b border-gray-200 px-8 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Dashboard Admin</h1>
                        <p class="text-gray-600">Bienvenue dans votre espace d'administration</p>
                    </div>
                    
                    <div class="flex items-center gap-4">
                        <div class="relative">
                            <button class="p-2 hover:bg-gray-100 rounded-lg">
                                <i class="bi bi-bell text-xl text-gray-600"></i>
                                <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">3</span>
                            </button>
                        </div>
                        
                        <div class="flex items-center gap-3">
                            <div>
                                <p class="text-sm font-medium">{{ $user->prenom }} {{ $user->nom }}</p>
                                <p class="text-xs text-gray-500">Administrateur</p>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Contenu -->
            <main class="p-8">
                <!-- Messages flash -->
                @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="bi bi-check-circle text-green-500 mr-2"></i>
                        <span class="text-green-800">{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
                @endif
                
                @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="bi bi-exclamation-triangle text-red-500 mr-2"></i>
                        <span class="text-red-800">{{ session('error') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-red-600 hover:text-red-800">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
                @endif
                
                <!-- Statistiques -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Carte Utilisateurs -->
                    <div class="stat-card">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <p class="text-sm text-gray-500">Utilisateurs</p>
                                <h3 class="text-2xl font-bold">{{ $stats['users'] ?? 0 }}</h3>
                            </div>
                            <div class="stat-icon bg-green-100 text-green-600">
                                <i class="bi bi-people"></i>
                            </div>
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="bi bi-arrow-up-right text-green-500 mr-1"></i>
                            <span>+12% ce mois</span>
                        </div>
                    </div>
                    
                    <!-- Carte Contenus -->
                    <div class="stat-card">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <p class="text-sm text-gray-500">Contenus</p>
                                <h3 class="text-2xl font-bold">{{ $stats['contents'] ?? 0 }}</h3>
                            </div>
                            <div class="stat-icon bg-blue-100 text-blue-600">
                                <i class="bi bi-file-text"></i>
                            </div>
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <i class="bi bi-arrow-up-right text-green-500 mr-1"></i>
                            <span>+24% ce mois</span>
                        </div>
                    </div>
                    
                    <!-- Carte Régions -->
                    <div class="stat-card">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <p class="text-sm text-gray-500">Régions</p>
                                <h3 class="text-2xl font-bold">{{ $stats['regions'] ?? 0 }}</h3>
                            </div>
                            <div class="stat-icon bg-purple-100 text-purple-600">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                        </div>
                        <div class="text-sm text-gray-600">
                            <span>Couvre tout le Bénin</span>
                        </div>
                    </div>
                    
                    <!-- Carte Langues -->
                    <div class="stat-card">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <p class="text-sm text-gray-500">Langues</p>
                                <h3 class="text-2xl font-bold">{{ $stats['languages'] ?? 0 }}</h3>
                            </div>
                            <div class="stat-icon bg-yellow-100 text-yellow-600">
                                <i class="bi bi-translate"></i>
                            </div>
                        </div>
                        <div class="text-sm text-gray-600">
                            <span>Support multi-langues</span>
                        </div>
                    </div>
                </div>
                
                <!-- Graphique et tableau -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Graphique -->
                    <div class="card">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="font-bold text-lg">Activité récente</h3>
                            <select class="text-sm border rounded-lg px-3 py-1">
                                <option>7 derniers jours</option>
                                <option>30 derniers jours</option>
                                <option>3 derniers mois</option>
                            </select>
                        </div>
                        <div class="h-64">
                            <canvas id="activityChart"></canvas>
                        </div>
                    </div>
                    
                    <!-- Derniers utilisateurs -->
                    <div class="card">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="font-bold text-lg">Derniers utilisateurs</h3>
                            <a href="{{ route('utilisateurs.index') }}" class="text-sm text-green-600 hover:text-green-800">
                                Voir tout →
                            </a>
                        </div>
                        <div class="space-y-4">
                            @php
                                $recentUsers = \App\Models\Utilisateur::orderBy('id_utilisateur', 'desc')
                                    ->limit(5)
                                    ->get();
                            @endphp
                            
                            @forelse($recentUsers as $userItem)
                            <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-r from-green-400 to-blue-500 flex items-center justify-center text-white font-bold">
                                        {{ substr($userItem->prenom, 0, 1) }}{{ substr($userItem->nom, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-medium">{{ $userItem->prenom }} {{ $userItem->nom }}</p>
                                        <p class="text-sm text-gray-500">{{ $userItem->email }}</p>
                                    </div>
                                </div>
                                <span class="badge {{ $userItem->id_role == 1 ? 'badge-success' : 'badge-info' }}">
                                    {{ $userItem->id_role == 1 ? 'Admin' : 'User' }}
                                </span>
                            </div>
                            @empty
                            <p class="text-gray-500 text-center py-4">Aucun utilisateur</p>
                            @endforelse
                        </div>
                    </div>
                </div>
                
                <!-- Actions rapides -->
                <div class="mt-8 card">
                    <h3 class="font-bold text-lg mb-6">Actions rapides</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <a href="{{ route('utilisateurs.create') }}" class="btn-primary text-center">
                            <i class="bi bi-person-plus mr-2"></i>
                            Ajouter utilisateur
                        </a>
                        
                        <a href="{{ route('contenu.create') }}" class="btn-secondary text-center">
                            <i class="bi bi-plus-circle mr-2"></i>
                            Nouveau contenu
                        </a>
                        
                        <a href="{{ route('media.create') }}" class="btn-secondary text-center">
                            <i class="bi bi-upload mr-2"></i>
                            Upload média
                        </a>
                        
                        <a href="{{ route('region.create') }}" class="btn-secondary text-center">
                            <i class="bi bi-plus-lg mr-2"></i>
                            Ajouter région
                        </a>
                    </div>
                </div>
                
                <!-- Derniers contenus -->
                <div class="mt-8 card">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="font-bold text-lg">Derniers contenus</h3>
                        <a href="{{ route('contenu.index') }}" class="text-sm text-green-600 hover:text-green-800">
                            Voir tout →
                        </a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="text-left text-gray-500 border-b">
                                    <th class="pb-3">Titre</th>
                                    <th class="pb-3">Auteur</th>
                                    <th class="pb-3">Date</th>
                                    <th class="pb-3">Statut</th>
                                    <th class="pb-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $recentContents = \App\Models\Contenu::with('auteur')
                                        ->orderBy('date_creation', 'desc')
                                        ->limit(5)
                                        ->get();
                                @endphp
                                
                                @forelse($recentContents as $content)
                                <tr class="border-b hover:bg-gray-50 table-row-hover">
                                    <td class="py-4">
                                        <p class="font-medium">{{ Str::limit($content->titre, 40) }}</p>
                                    </td>
                                    <td class="py-4">
                                        <p>{{ $content->auteur->prenom ?? 'Inconnu' }}</p>
                                    </td>
                                    <td class="py-4">
                                        <p class="text-gray-500">{{ \Carbon\Carbon::parse($content->date_creation)->format('d/m/Y') }}</p>
                                    </td>
                                    <td class="py-4">
                                        <span class="badge {{ $content->statut == 'publié' ? 'badge-success' : 'badge-warning' }}">
                                            {{ $content->statut }}
                                        </span>
                                    </td>
                                    <td class="py-4">
                                        <div class="flex items-center gap-2">
                                            <button class="p-1 hover:bg-gray-100 rounded">
                                                <i class="bi bi-eye text-blue-600"></i>
                                            </button>
                                            <button class="p-1 hover:bg-gray-100 rounded">
                                                <i class="bi bi-pencil text-green-600"></i>
                                            </button>
                                            <button class="p-1 hover:bg-gray-100 rounded">
                                                <i class="bi bi-trash text-red-600"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="py-8 text-center text-gray-500">
                                        Aucun contenu publié
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>
    
    <script>
        // Graphique d'activité
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('activityChart').getContext('2d');
            
            const activityChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
                    datasets: [{
                        label: 'Contenus publiés',
                        data: [12, 19, 8, 15, 22, 18, 25],
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        tension: 0.4,
                        fill: true
                    }, {
                        label: 'Nouveaux utilisateurs',
                        data: [3, 5, 2, 6, 4, 7, 9],
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
            
            // Auto-hide messages flash après 5 secondes
            setTimeout(() => {
                document.querySelectorAll('[class*="bg-green-50"], [class*="bg-red-50"]').forEach(el => {
                    el.style.opacity = '0';
                    setTimeout(() => el.remove(), 300);
                });
            }, 5000);
        });
    </script>
</body>
</html>