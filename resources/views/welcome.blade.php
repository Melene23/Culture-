<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BeninCulture | Plateforme du Patrimoine Béninois</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('favicon.ico') }}">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --benin-green: #008751;
            --benin-yellow: #FCD116;
            --benin-red: #E8112D;
        }
        
        * {
            font-family: 'Inter', sans-serif;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .hover-lift {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        
        .hover-lift:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        .search-shadow {
            box-shadow: 0 4px 20px rgba(0, 135, 81, 0.1);
        }
        
        .module-icon {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 16px;
            margin-bottom: 12px;
        }
        
        /* ANIMATIONS DE FOND */
        .background-animations {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
            pointer-events: none;
        }
        
        .floating-element {
            position: absolute;
            border-radius: 50%;
            background: linear-gradient(45deg, rgba(0, 135, 81, 0.05), rgba(252, 209, 22, 0.05));
            opacity: 0.3;
            animation: float 20s infinite ease-in-out;
        }
        
        .element-1 {
            width: 400px;
            height: 400px;
            top: -100px;
            left: -100px;
            animation-delay: 0s;
        }
        
        .element-2 {
            width: 300px;
            height: 300px;
            top: 60%;
            right: -50px;
            animation-delay: -5s;
        }
        
        .element-3 {
            width: 200px;
            height: 200px;
            bottom: 10%;
            left: 10%;
            animation-delay: -10s;
        }
        
        .element-4 {
            width: 350px;
            height: 350px;
            top: 20%;
            right: 15%;
            animation-delay: -7s;
        }
        
        .element-5 {
            width: 250px;
            height: 250px;
            bottom: 40%;
            left: 70%;
            animation-delay: -12s;
        }
        
        @keyframes float {
            0%, 100% {
                transform: translateY(0px) rotate(0deg) scale(1);
            }
            25% {
                transform: translateY(-30px) rotate(90deg) scale(1.05);
            }
            50% {
                transform: translateY(0px) rotate(180deg) scale(1);
            }
            75% {
                transform: translateY(30px) rotate(270deg) scale(0.95);
            }
        }
        
        /* Animation d'entrée */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
            opacity: 0;
        }
        
        /* Animation au scroll */
        .reveal-on-scroll {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.8s ease;
        }
        
        .reveal-on-scroll.revealed {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Pour le carousel */
        .carousel-slide {
            transition: transform 0.5s ease;
        }
        
        /* Pour les filtres */
        .filter-item {
            transition: all 0.3s ease;
        }
        /* Animation pour les messages flash */
            @keyframes fade-in {
                from {
                    opacity: 0;
                    transform: translateY(-20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
        }

        .animate-fade-in {
            animation: fade-in 0.3s ease-out;
        }

        /* Style pour le dropdown */
        .dropdown-menu {
            display: none;
            z-index: 1000;
        }

        .dropdown:hover .dropdown-menu {
            display: block;
        }
    </style>
</head>
<body class="gradient-bg min-h-screen">

    <!-- Messages Flash -->
    @if(session('success'))
    <div class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 max-w-md animate-fade-in">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <i class="bi bi-check-circle mr-2"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-xl hover:text-gray-300">
                &times;
            </button>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 max-w-md animate-fade-in">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <i class="bi bi-exclamation-triangle mr-2"></i>
                <span>{{ session('error') }}</span>
            </div>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-xl hover:text-gray-300">
                &times;
            </button>
        </div>
    </div>
    @endif
    
    <!-- Animations de fond -->
    <div class="background-animations">
        <div class="floating-element element-1"></div>
        <div class="floating-element element-2"></div>
        <div class="floating-element element-3"></div>
        <div class="floating-element element-4"></div>
        <div class="floating-element element-5"></div>
    </div>
    
    <!-- Navigation -->
    <nav class="bg-white/80 backdrop-blur-md border-b border-gray-100 sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-r from-green-700 to-emerald-600 flex items-center justify-center shadow-md">
                        <i class="bi bi-globe-americas text-white text-lg"></i>
                    </div>
                    <span class="text-xl font-bold text-gray-900">
                        Benin<span class="text-green-700">Culture</span>
                    </span>
                </div>
                
                <!-- Menu Desktop -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-gray-600 hover:text-green-600 font-medium">Fonctionnalités</a>
                    <a href="#carousel" class="text-gray-600 hover:text-green-600 font-medium">Galerie</a>
                    <a href="#filter" class="text-gray-600 hover:text-green-600 font-medium">Catégories</a>
                    <a href="#blog" class="text-gray-600 hover:text-green-600 font-medium">Actualités</a>
                </div>
                
               <!-- Boutons CTA -->
                <div class="flex items-center space-x-5">
                    @auth
                    <!-- Si connecté : montrer déconnexion et profil -->
                    <span class="text-gray-600 hidden md:block mr-2">
                        Bonjour, {{ Auth::user()->prenom }}
                    </span>
                    <a href="{{ route('dashboard') }}" class="bg-green-600 text-white px-5 py-2 rounded-full font-medium hover:bg-green-700 hover:shadow-lg transition">
                        Mon compte
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-green-600 text-white px-5 py-2 rounded-full font-medium hover:bg-green-700 hover:shadow-lg transition">
                            Déconnexion
                        </button>
                    </form>
                @else
                    <!-- Si non connecté : montrer connexion/inscription -->
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-green-600 font-medium hidden md:block">
                        Connexion
                    </a>
                    <a href="{{ route('register') }}" class="bg-green-600 text-white px-6 py-2 rounded-full font-medium hover:bg-green-700 hover:shadow-lg transition">
                        S'inscrire
                    </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <main class="container mx-auto px-4 py-8 md:py-16">
        <!-- En-tête centré -->
        <div class="text-center mb-12 fade-in-up">
            <h1 class="text-4xl md:text-6xl font-bold text-gray-900 mb-6 leading-tight">
                Explorez la richesse culturelle<br>
                <span class="text-green-600">du Bénin</span>
            </h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto mb-8">
                Une plateforme complète pour découvrir, partager et préserver 
                le patrimoine culturel de notre belle nation.
            </p>
        </div>

        <!-- Barre de recherche -->
        <div class="max-w-3xl mx-auto mb-16 fade-in-up" style="animation-delay: 0.1s">
            <form method="GET" action="{{ route('contenu.index') }}" class="relative">
                @csrf
                <input 
                    type="text" 
                    name="search"
                    placeholder="Rechercher une tradition, un art, une région culturelle..."
                    class="w-full px-6 py-4 rounded-2xl border-2 border-gray-200 bg-white search-shadow focus:outline-none focus:border-green-500 focus:shadow-lg transition text-lg placeholder-gray-400"
                    value="{{ request('search') }}"
                >
                <button type="submit" class="absolute right-3 top-3 bg-green-600 text-white p-3 rounded-full hover:bg-green-700 transition">
                    <i class="bi bi-search text-lg"></i>
                </button>
            </form>
            <div class="flex flex-wrap justify-center gap-3 mt-4">
                <span class="text-sm text-gray-500">Suggestions :</span>
                <a href="{{ route('contenu.index') }}?search=Vodoun" class="search-tag text-sm bg-gray-100 hover:bg-gray-200 px-3 py-1 rounded-full hover:no-underline">Vodoun</a>
                <a href="{{ route('contenu.index') }}?search=Dahomey" class="search-tag text-sm bg-gray-100 hover:bg-gray-200 px-3 py-1 rounded-full hover:no-underline">Dahomey</a>
                <a href="{{ route('contenu.index') }}?search=Artisanat" class="search-tag text-sm bg-gray-100 hover:bg-gray-200 px-3 py-1 rounded-full hover:no-underline">Artisanat</a>
                <a href="{{ route('contenu.index') }}?search=Musique" class="search-tag text-sm bg-gray-100 hover:bg-gray-200 px-3 py-1 rounded-full hover:no-underline">Musique</a>
            </div>
        </div>

        <!-- Grille de modules -->
        <div id="features" class="mb-20 fade-in-up reveal-on-scroll" style="animation-delay: 0.2s">
            <h2 class="text-2xl md:text-3xl font-bold text-center text-gray-800 mb-10">
                Accès rapide aux fonctionnalités
            </h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                <!-- Module Contenus -->
                <a href="{{ route('contenu.index') }}" 
                   class="glass-card rounded-2xl p-6 text-center hover-lift group">
                    <div class="module-icon bg-blue-100 group-hover:bg-blue-200 mx-auto">
                        <i class="bi bi-file-text text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-1">Contenus</h3>
                    <p class="text-sm text-gray-500">Articles culturels</p>
                </a>

                <!-- Module Médias -->
                <a href="{{ route('media.index') }}"
                   class="glass-card rounded-2xl p-6 text-center hover-lift group">
                    <div class="module-icon bg-purple-100 group-hover:bg-purple-200 mx-auto">
                        <i class="bi bi-images text-purple-600 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-1">Médias</h3>
                    <p class="text-sm text-gray-500">Photos & Vidéos</p>
                </a>

                <!-- Module Régions -->
                <a href="{{ route('region.index') }}"
                   class="glass-card rounded-2xl p-6 text-center hover-lift group">
                    <div class="module-icon bg-green-100 group-hover:bg-green-200 mx-auto">
                        <i class="bi bi-geo-alt text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-1">Régions</h3>
                    <p class="text-sm text-gray-500">Par localisation</p>
                </a>

                <!-- Module Utilisateurs -->
                <a href="{{ route('utilisateurs.index') }}"  
                   class="glass-card rounded-2xl p-6 text-center hover-lift group">
                    <div class="module-icon bg-yellow-100 group-hover:bg-yellow-200 mx-auto">
                        <i class="bi bi-people text-yellow-600 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-1">Communauté</h3>
                    <p class="text-sm text-gray-500">Utilisateurs</p>
                </a>

                <!-- Module Commentaires -->
               <a href="{{ route('commentaire.index') }}"  
                   class="glass-card rounded-2xl p-6 text-center hover-lift group">
                    <div class="module-icon bg-red-100 group-hover:bg-red-200 mx-auto">
                        <i class="bi bi-chat-text text-red-600 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-1">Commentaires</h3>
                    <p class="text-sm text-gray-500">Interactions</p>
                </a>

                <!-- Module Langues -->
               <a href="{{ route('langues.index') }}"  
                   class="glass-card rounded-2xl p-6 text-center hover-lift group">
                    <div class="module-icon bg-indigo-100 group-hover:bg-indigo-200 mx-auto">
                        <i class="bi bi-translate text-indigo-600 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-1">Langues</h3>
                    <p class="text-sm text-gray-500">Multi-langues</p>
                </a>
            </div>
        </div>
        <!-- Bouton Payer Premium - Amélioré -->
        @auth
        <div class="fixed top-20 right-4 z-50 animate-fade-in">
            <a href="{{ route('payment.checkout') }}" 
               class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-full font-bold hover:from-green-700 hover:to-emerald-700 shadow-2xl hover:shadow-green-500/50 transition-all duration-300 transform hover:scale-105">
                <i class="bi bi-star-fill mr-2 text-yellow-300"></i>
                <span>Passer Premium</span>
                <i class="bi bi-arrow-right ml-2"></i>
            </a>
        </div>
        @else
        <div class="fixed top-20 right-4 z-50 animate-fade-in">
            <a href="{{ route('register') }}" 
               class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white rounded-full font-bold hover:from-green-700 hover:to-emerald-700 shadow-2xl hover:shadow-green-500/50 transition-all duration-300 transform hover:scale-105">
                <i class="bi bi-star-fill mr-2 text-yellow-300"></i>
                <span>Rejoindre Premium</span>
                <i class="bi bi-arrow-right ml-2"></i>
            </a>
        </div>
        @endauth

        <!-- ==================== -->
        <!-- CAROUSEL D'IMAGES -->
        <!-- ==================== -->
        <section id="carousel" class="mb-20 py-12 relative overflow-hidden reveal-on-scroll">
            <div class="container mx-auto px-4 mb-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="mb-4 md:mb-0">
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900">
                            Trésors Culturels du Bénin
                        </h2>
                        <p class="text-gray-600 mt-2">
                            Découvrez la richesse visuelle de notre patrimoine
                        </p>
                    </div>
                    
                    <!-- Boutons de navigation -->
                    <div class="flex space-x-2">
                        <button id="carouselPrev" 
                                class="w-12 h-12 rounded-full bg-white shadow-lg flex items-center justify-center hover:bg-gray-50 transition-all duration-300 hover:scale-110">
                            <i class="bi bi-chevron-left text-xl text-gray-700"></i>
                        </button>
                        <button id="carouselNext" 
                                class="w-12 h-12 rounded-full bg-green-600 text-white shadow-lg flex items-center justify-center hover:bg-green-700 transition-all duration-300 hover:scale-110">
                            <i class="bi bi-chevron-right text-xl"></i>
                        </button>
                    </div>
                </div>
            </div>

         <!-- Conteneur du carousel -->
        <div class="relative">
            <!-- Track du carousel -->
            <div id="cultureCarousel" class="flex transition-transform duration-500 ease-out">
                <!-- Slide 1 -->
                <div class="min-w-full px-4">
                    <div class="relative rounded-3xl overflow-hidden shadow-2xl group">
                        <img src="{{ asset('images/culture/porte-non-retour.jpg') }}" 
                            alt="Porte du Non Retour - Ouidah" 
                            class="w-full h-[500px] object-cover transform group-hover:scale-105 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
                
                    <!-- Contenu superposé -->
                    <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
                        <div class="max-w-2xl">
                            <span class="inline-block bg-green-500 text-white px-4 py-1 rounded-full text-sm font-semibold mb-3">
                                Patrimoine Historique
                            </span>
                            <h3 class="text-3xl md:text-4xl font-bold mb-3">
                             Porte du Non Retour - Ouidah
                            </h3>
                            <p class="text-lg opacity-90 mb-4">
                                Mémorial symbolique de la traite négrière, classé au patrimoine mondial de l'UNESCO.
                            </p>
                            <a href="{{ route('contenu.index') }}?search=Porte+du+Non+Retour" class="inline-flex items-center text-white font-medium hover:text-green-300 transition">
                                En savoir plus <i class="bi bi-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="min-w-full px-4">
                <div class="relative rounded-3xl overflow-hidden shadow-2xl group">
                    <img src="{{ asset('images/culture/palais-royal-abomey.jpg') }}" 
                        alt="Palais Royal d'Abomey" 
                        class="w-full h-[500px] object-cover transform group-hover:scale-105 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
                
                    <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
                        <div class="max-w-2xl">
                            <span class="inline-block bg-yellow-500 text-white px-4 py-1 rounded-full text-sm font-semibold mb-3">
                                Royaume du Dahomey
                            </span>
                            <h3 class="text-3xl md:text-4xl font-bold mb-3">
                                Palais Royaux d'Abomey
                            </h3>
                            <p class="text-lg opacity-90 mb-4">
                                Ancienne capitale du Royaume du Dahomey, classée au patrimoine mondial de l'UNESCO.
                            </p>
                            <a href="{{ route('contenu.index') }}?search=Palais+Royal+Abomey" class="inline-flex items-center text-white font-medium hover:text-yellow-300 transition">
                                En savoir plus <i class="bi bi-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        
            <!-- Slide 3 -->
            <div class="min-w-full px-4">
                <div class="relative rounded-3xl overflow-hidden shadow-2xl group">
                    <img src="{{ asset('images/culture/ganvie.jpg') }}" 
                        alt="Village sur pilotis de Ganvié" 
                        class="w-full h-[500px] object-cover transform group-hover:scale-105 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
                
                    <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
                        <div class="max-w-2xl">
                            <span class="inline-block bg-red-500 text-white px-4 py-1 rounded-full text-sm font-semibold mb-3">
                                Patrimoine Vivant
                            </span>
                            <h3 class="text-3xl md:text-4xl font-bold mb-3">
                                Ganvié - La Venise de l'Afrique
                            </h3>
                            <p class="text-lg opacity-90 mb-4">
                                Village lacustre construit entièrement sur pilotis dans le lac Nokoué.
                            </p>
                            <a href="{{ route('contenu.index') }}?search=Ganvié" class="inline-flex items-center text-white font-medium hover:text-red-300 transition">
                                En savoir plus <i class="bi bi-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        
            <!-- Slide 4 -->
            <div class="min-w-full px-4">
                <div class="relative rounded-3xl overflow-hidden shadow-2xl group">
                    <img src="{{ asset('images/culture/fete-vodoun.jpg') }}" 
                        alt="Fête du Vodoun au Bénin" 
                        class="w-full h-[500px] object-cover transform group-hover:scale-105 transition-transform duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
                
                    <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
                        <div class="max-w-2xl">
                            <span class="inline-block bg-purple-500 text-white px-4 py-1 rounded-full text-sm font-semibold mb-3">
                                Spiritualité
                            </span>
                            <h3 class="text-3xl md:text-4xl font-bold mb-3">
                                Fête Nationale du Vodoun
                            </h3>
                            <p class="text-lg opacity-90 mb-4">
                                Célébration annuelle le 10 janvier honorant les traditions spirituelles vodoun.
                            </p>
                            <a href="{{ route('contenu.index') }}?search=Vodoun" class="inline-flex items-center text-white font-medium hover:text-purple-300 transition">
                                En savoir plus <i class="bi bi-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

                <!-- Indicateurs (points) -->
                <div class="flex justify-center mt-6 space-x-2">
                    <button class="carousel-dot w-3 h-3 rounded-full bg-gray-300 hover:bg-gray-400" data-index="0"></button>
                    <button class="carousel-dot w-3 h-3 rounded-full bg-gray-300 hover:bg-gray-400" data-index="1"></button>
                    <button class="carousel-dot w-3 h-3 rounded-full bg-gray-300 hover:bg-gray-400" data-index="2"></button>
                    <button class="carousel-dot w-3 h-3 rounded-full bg-gray-300 hover:bg-gray-400" data-index="3"></button>
                </div>
            </div>
        </section>

        <!-- ==================== -->
       <!-- SYSTÈME DE FILTRAGE -->
<!-- ==================== -->
<section id="filter" class="mb-20 py-12 reveal-on-scroll">
    <div class="container mx-auto px-4">
        <!-- En-tête -->
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Explorez par Catégorie
            </h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Filtrez notre collection culturelle selon vos centres d'intérêt
            </p>
        </div>

        <!-- Barre de filtres -->
        <div class="flex flex-wrap justify-center gap-3 mb-8">
            <button class="filter-btn active px-5 py-2 rounded-full font-medium transition-all duration-300 bg-green-600 text-white"
                    data-filter="all">
                <i class="bi bi-grid-3x3-gap mr-2"></i>Tout voir
            </button>
            <button class="filter-btn px-5 py-2 rounded-full bg-gray-100 hover:bg-gray-200 font-medium transition-all duration-300"
                    data-filter="histoire">
                <i class="bi bi-book mr-2"></i>Histoire
            </button>
            <button class="filter-btn px-5 py-2 rounded-full bg-gray-100 hover:bg-gray-200 font-medium transition-all duration-300"
                    data-filter="art">
                <i class="bi bi-palette mr-2"></i>Art & Artisanat
            </button>
            <button class="filter-btn px-5 py-2 rounded-full bg-gray-100 hover:bg-gray-200 font-medium transition-all duration-300"
                    data-filter="musique">
                <i class="bi bi-music-note-beamed mr-2"></i>Musique & Danse
            </button>
            <button class="filter-btn px-5 py-2 rounded-full bg-gray-100 hover:bg-gray-200 font-medium transition-all duration-300"
                    data-filter="cuisine">
                <i class="bi bi-egg-fried mr-2"></i>Cuisine
            </button>
            <button class="filter-btn px-5 py-2 rounded-full bg-gray-100 hover:bg-gray-200 font-medium transition-all duration-300"
                    data-filter="spiritualite">
                <i class="bi bi-stars mr-2"></i>Spiritualité
            </button>
            <button class="filter-btn px-5 py-2 rounded-full bg-gray-100 hover:bg-gray-200 font-medium transition-all duration-300"
                    data-filter="nature">
                <i class="bi bi-tree mr-2"></i>Nature
            </button>
        </div>

        <!-- Grille d'éléments à filtrer -->
        <div id="filterGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <!-- Élément 1 (Histoire) -->
            <div class="filter-item histoire fade-in-up" data-categories="histoire">
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover-lift transition-all duration-300 h-full">
                    <div class="h-48 overflow-hidden">
                        <img src="{{ asset('images/culture/amazones-dahomey.jpg') }}" 
                             alt="Amazones du Dahomey" 
                             class="w-full h-full object-cover transform hover:scale-110 transition-transform duration-700">
                    </div>
                    <div class="p-6">
                        <div class="flex items-center mb-3">
                            <span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">
                                Histoire
                            </span>
                            <span class="text-xs text-gray-500 ml-auto">
                                <i class="bi bi-clock mr-1"></i>12 min
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">
                            Les Amazones du Dahomey
                        </h3>
                        <p class="text-gray-600 mb-4">
                            Régiment exclusivement féminin du Royaume du Dahomey, l'une des unités militaires les plus redoutées.
                        </p>
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="bi bi-eye mr-1"></i>
                            <span class="mr-4">2.4k vues</span>
                            <i class="bi bi-chat mr-1"></i>
                            <span>78 commentaires</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Élément 2 (Art) -->
            <div class="filter-item art fade-in-up" data-categories="art">
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover-lift transition-all duration-300 h-full">
                    <div class="h-48 overflow-hidden">
                        <img src="{{ asset('images/culture/artisanat-beninois.jpg') }}" 
                             alt="Artisanat béninois" 
                             class="w-full h-full object-cover transform hover:scale-110 transition-transform duration-700">
                    </div>
                    <div class="p-6">
                        <div class="flex items-center mb-3">
                            <span class="inline-block bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs font-semibold">
                                Art
                            </span>
                            <span class="text-xs text-gray-500 ml-auto">
                                <i class="bi bi-clock mr-1"></i>10 min
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">
                            Artisanat Traditionnel
                        </h3>
                        <p class="text-gray-600 mb-4">
                            Sculptures, tissages, poteries et autres arts traditionnels béninois, symboles du raffinement artistique.
                        </p>
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="bi bi-eye mr-1"></i>
                            <span class="mr-4">1.8k vues</span>
                            <i class="bi bi-chat mr-1"></i>
                            <span>56 commentaires</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Élément 3 (Musique) -->
            <div class="filter-item musique fade-in-up" data-categories="musique">
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover-lift transition-all duration-300 h-full">
                    <div class="h-48 overflow-hidden">
                        <img src="{{ asset('images/culture/tambours-vodoun.jpg') }}" 
                             alt="Tambours Vodoun" 
                             class="w-full h-full object-cover transform hover:scale-110 transition-transform duration-700">
                    </div>
                    <div class="p-6">
                        <div class="flex items-center mb-3">
                            <span class="inline-block bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-xs font-semibold">
                                Musique
                            </span>
                            <span class="text-xs text-gray-500 ml-auto">
                                <i class="bi bi-clock mr-1"></i>15 min
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">
                            Tambours et Rythmes
                        </h3>
                        <p class="text-gray-600 mb-4">
                            Instruments traditionnels et rythmes sacrés utilisés dans les cérémonies vodoun.
                        </p>
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="bi bi-eye mr-1"></i>
                            <span class="mr-4">2.1k vues</span>
                            <i class="bi bi-chat mr-1"></i>
                            <span>89 commentaires</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Élément 4 (Cuisine) -->
            <div class="filter-item cuisine fade-in-up" data-categories="cuisine">
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover-lift transition-all duration-300 h-full">
                    <div class="h-48 overflow-hidden">
                        <img src="{{ asset('images/culture/cuisine-beninoise.jpg') }}" 
                             alt="Cuisine béninoise" 
                             class="w-full h-full object-cover transform hover:scale-110 transition-transform duration-700">
                    </div>
                    <div class="p-6">
                        <div class="flex items-center mb-3">
                            <span class="inline-block bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-semibold">
                                Cuisine
                            </span>
                            <span class="text-xs text-gray-500 ml-auto">
                                <i class="bi bi-clock mr-1"></i>18 min
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">
                            Gastronomie Béninoise
                        </h3>
                        <p class="text-gray-600 mb-4">
                            Plats traditionnels : Akassa, Gari, Pâte de maïs, Sauce arachide, Poisson braisé.
                        </p>
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="bi bi-eye mr-1"></i>
                            <span class="mr-4">3.2k vues</span>
                            <i class="bi bi-chat mr-1"></i>
                            <span>145 commentaires</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Élément 5 (Spiritualité) -->
            <div class="filter-item spiritualite fade-in-up" data-categories="spiritualite">
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover-lift transition-all duration-300 h-full">
                    <div class="h-48 overflow-hidden">
                        <img src="{{ asset('images/culture/ceremonie-vodoun.jpg') }}" 
                             alt="Cérémonie Vodoun" 
                             class="w-full h-full object-cover transform hover:scale-110 transition-transform duration-700">
                    </div>
                    <div class="p-6">
                        <div class="flex items-center mb-3">
                            <span class="inline-block bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full text-xs font-semibold">
                                Spiritualité
                            </span>
                            <span class="text-xs text-gray-500 ml-auto">
                                <i class="bi bi-clock mr-1"></i>20 min
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">
                            Le Vodoun Béninois
                        </h3>
                        <p class="text-gray-600 mb-4">
                            Origines, pratiques et significations de cette spiritualité ancestrale reconnue officiellement.
                        </p>
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="bi bi-eye mr-1"></i>
                            <span class="mr-4">3.4k vues</span>
                            <i class="bi bi-chat mr-1"></i>
                            <span>124 commentaires</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Élément 6 (Nature) -->
            <div class="filter-item nature fade-in-up" data-categories="nature">
                <div class="bg-white rounded-2xl overflow-hidden shadow-lg hover-lift transition-all duration-300 h-full">
                    <div class="h-48 overflow-hidden">
                        <img src="{{ asset('images/culture/parc-pendjari.jpg') }}" 
                             alt="Parc National de la Pendjari" 
                             class="w-full h-full object-cover transform hover:scale-110 transition-transform duration-700"
                             onerror="this.src='{{ asset('images/culture/ganvie.jpg') }}'">
                    </div>
                    <div class="p-6">
                        <div class="flex items-center mb-3">
                            <span class="inline-block bg-emerald-100 text-emerald-800 px-3 py-1 rounded-full text-xs font-semibold">
                                Nature
                            </span>
                            <span class="text-xs text-gray-500 ml-auto">
                                <i class="bi bi-clock mr-1"></i>7 min
                            </span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">
                            Parcs Nationaux
                        </h3>
                        <p class="text-gray-600 mb-4">
                            Réserves naturelles et biodiversité exceptionnelle du Bénin : Pendjari, W, etc.
                        </p>
                        <div class="flex items-center text-sm text-gray-500">
                            <i class="bi bi-eye mr-1"></i>
                            <span class="mr-4">945 vues</span>
                            <i class="bi bi-chat mr-1"></i>
                            <span>41 commentaires</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

        <!-- ==================== -->
        <!-- THÈMES CULTURELS -->
<!-- ==================== -->
<div id="themes" class="mb-20 reveal-on-scroll">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10">
        <div>
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">
                Thèmes Culturels Populaires
            </h2>
            <p class="text-gray-600">Explorez les différentes facettes de la culture béninoise</p>
        </div>
        <a href="{{ route('contenu.index') }}" class="mt-4 md:mt-0 text-green-600 font-medium hover:text-green-700 flex items-center">
            Voir tout <i class="bi bi-arrow-right ml-2"></i>
        </a>
    </div>
    
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Thème 1 -->
        <div class="bg-white rounded-2xl shadow-sm hover-lift overflow-hidden">
            <div class="h-48 relative overflow-hidden">
                <img src="{{ asset('images/culture/royaumes-benin.jpg') }}" 
                     alt="Royaumes du Bénin" 
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                <div class="absolute bottom-4 left-4">
                    <span class="bg-white text-green-700 px-3 py-1 rounded-full text-sm font-medium">
                        Histoire
                    </span>
                </div>
            </div>
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-2">Royaumes & Dynasties</h3>
                <p class="text-gray-600 mb-4">Dahomey, Porto-Novo, et les royaumes historiques du Bénin.</p>
                <div class="flex items-center text-sm text-gray-500">
                    <i class="bi bi-clock-history mr-1"></i>
                    <span>125 articles</span>
                </div>
            </div>
        </div>

        <!-- Thème 2 -->
        <div class="bg-white rounded-2xl shadow-sm hover-lift overflow-hidden">
            <div class="h-48 relative overflow-hidden">
                <img src="{{ asset('images/culture/vodoun-traditions.jpg') }}" 
                     alt="Vodoun Bénin" 
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                <div class="absolute bottom-4 left-4">
                    <span class="bg-white text-yellow-700 px-3 py-1 rounded-full text-sm font-medium">
                        Spiritualité
                    </span>
                </div>
            </div>
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-2">Vodoun & Traditions</h3>
                <p class="text-gray-600 mb-4">Patrimoine spirituel et cérémonies traditionnelles.</p>
                <div class="flex items-center text-sm text-gray-500">
                    <i class="bi bi-clock-history mr-1"></i>
                    <span>89 articles</span>
                </div>
            </div>
        </div>

        <!-- Thème 3 -->
        <div class="bg-white rounded-2xl shadow-sm hover-lift overflow-hidden">
            <div class="h-48 relative overflow-hidden">
                <img src="{{ asset('images/culture/arts-traditionnels.jpg') }}" 
                     alt="Artisanat béninois" 
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                <div class="absolute bottom-4 left-4">
                    <span class="bg-white text-red-700 px-3 py-1 rounded-full text-sm font-medium">
                        Art & Artisanat
                    </span>
                </div>
            </div>
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-900 mb-2">Arts Traditionnels</h3>
                <p class="text-gray-600 mb-4">Sculpture, tissage, poterie et autres arts béninois.</p>
                <div class="flex items-center text-sm text-gray-500">
                    <i class="bi bi-clock-history mr-1"></i>
                    <span>156 articles</span>
                </div>
            </div>
        </div>
    </div>
</div>

        <!-- ==================== -->
        <!-- STATISTIQUES -->
        <!-- ==================== -->
        <div id="stats" class="mb-20 reveal-on-scroll">
            <h2 class="text-2xl md:text-3xl font-bold text-center text-gray-800 mb-10">
                Notre Impact en Chiffres
            </h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="bg-white rounded-2xl p-6 text-center shadow-sm">
                    <div class="text-3xl md:text-4xl font-bold text-green-600 mb-2"><?php echo isset($stats['contenus']) ? $stats['contenus'] : '1,245'; ?></div>
                    <div class="text-gray-600">Contenus Culturels</div>
                </div>
                <div class="bg-white rounded-2xl p-6 text-center shadow-sm">
                    <div class="text-3xl md:text-4xl font-bold text-yellow-600 mb-2"><?php echo isset($stats['medias']) ? $stats['medias'] : '3,876'; ?></div>
                    <div class="text-gray-600">Médias Partagés</div>
                </div>
                <div class="bg-white rounded-2xl p-6 text-center shadow-sm">
                    <div class="text-3xl md:text-4xl font-bold text-red-600 mb-2"><?php echo isset($stats['utilisateurs']) ? $stats['utilisateurs'] : '892'; ?></div>
                    <div class="text-gray-600">Membres Actifs</div>
                </div>
                <div class="bg-white rounded-2xl p-6 text-center shadow-sm">
                    <div class="text-3xl md:text-4xl font-bold text-purple-600 mb-2"><?php echo isset($stats['commentaires']) ? $stats['commentaires'] : '2,543'; ?></div>
                    <div class="text-gray-600">Échanges Culturels</div>
                </div>
            </div>
        </div>

        <!-- ==================== -->
        <!-- BLOG & ACTUALITÉS -->
<!-- ==================== -->
<section id="blog" class="mb-20 reveal-on-scroll">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800">
                Actualités Culturelles
            </h2>
            <p class="text-gray-600">Les dernières nouvelles du patrimoine béninois</p>
        </div>
        <a href="{{ route('contenu.index') }}" class="text-green-600 font-medium hover:text-green-700 flex items-center">
            Voir toutes les actualités <i class="bi bi-arrow-right ml-2"></i>
        </a>
    </div>
    
    <div class="grid md:grid-cols-3 gap-6">
        <!-- Article 1 -->
        <article class="bg-white rounded-2xl shadow-sm overflow-hidden hover-lift">
            <div class="relative">
                <img src="{{ asset('images/culture/festival-vodoun-2024.jpg') }}" 
                     alt="Festival International" 
                     class="w-full h-48 object-cover">
                <span class="absolute top-4 left-4 bg-green-600 text-white px-3 py-1 rounded-full text-xs font-medium">
                    Événement
                </span>
            </div>
            <div class="p-6">
                <div class="flex items-center text-sm text-gray-500 mb-3">
                    <span class="flex items-center">
                        <i class="bi bi-calendar3 mr-1"></i>
                        15 Nov. 2024
                    </span>
                    <span class="mx-2">•</span>
                    <span class="flex items-center">
                        <i class="bi bi-clock mr-1"></i>
                        3 min de lecture
                    </span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">
                    Festival International du Vodoun 2024
                </h3>
                <p class="text-gray-600 mb-4">
                    Célébration annuelle à Ouidah rassemblant des milliers de participants 
                    pour honorer les traditions spirituelles du Bénin.
                </p>
                <div class="flex items-center justify-between">
                    <a href="{{ route('contenu.index') }}?search=Festival+Vodoun" class="text-green-600 font-medium hover:text-green-700 flex items-center">
                        Lire l'article <i class="bi bi-arrow-right ml-1"></i>
                    </a>
                    <span class="text-sm text-gray-500">
                        <i class="bi bi-eye mr-1"></i> 1.2k
                    </span>
                </div>
            </div>
        </article>
        
        <!-- Article 2 -->
        <article class="bg-white rounded-2xl shadow-sm overflow-hidden hover-lift">
            <div class="relative">
                <img src="{{ asset('images/culture/restauration-palais.jpg') }}" 
                     alt="Restoration Patrimoine" 
                     class="w-full h-48 object-cover">
                <span class="absolute top-4 left-4 bg-yellow-600 text-white px-3 py-1 rounded-full text-xs font-medium">
                    Patrimoine
                </span>
            </div>
            <div class="p-6">
                <div class="flex items-center text-sm text-gray-500 mb-3">
                    <span class="flex items-center">
                        <i class="bi bi-calendar3 mr-1"></i>
                        10 Nov. 2024
                    </span>
                    <span class="mx-2">•</span>
                    <span class="flex items-center">
                        <i class="bi bi-clock mr-1"></i>
                        4 min de lecture
                    </span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">
                    Restauration des Palais Royaux d'Abomey
                </h3>
                <p class="text-gray-600 mb-4">
                    Nouveau projet de restauration financé par l'UNESCO pour préserver 
                    ce site historique classé au patrimoine mondial.
                </p>
                <div class="flex items-center justify-between">
                    <a href="{{ route('contenu.index') }}?search=Restauration+Palais" class="text-green-600 font-medium hover:text-green-700 flex items-center">
                        Lire l'article <i class="bi bi-arrow-right ml-1"></i>
                    </a>
                    <span class="text-sm text-gray-500">
                        <i class="bi bi-eye mr-1"></i> 856
                    </span>
                </div>
            </div>
        </article>
        
        <!-- Article 3 -->
        <article class="bg-white rounded-2xl shadow-sm overflow-hidden hover-lift">
            <div class="relative">
                <img src="{{ asset('images/culture/musee-numerique.jpg') }}" 
                     alt="Musée Numérique de la Culture Béninoise" 
                     class="w-full h-48 object-cover">
                <span class="absolute top-4 left-4 bg-red-600 text-white px-3 py-1 rounded-full text-xs font-medium">
                    Innovation
                </span>
            </div>
            <div class="p-6">
                <div class="flex items-center text-sm text-gray-500 mb-3">
                    <span class="flex items-center">
                        <i class="bi bi-calendar3 mr-1"></i>
                        5 Nov. 2024
                    </span>
                    <span class="mx-2">•</span>
                    <span class="flex items-center">
                        <i class="bi bi-clock mr-1"></i>
                        5 min de lecture
                    </span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">
                    Musée Numérique de la Culture Béninoise
                </h3>
                <p class="text-gray-600 mb-4">
                    Premier musée entièrement numérique dédié à la préservation 
                    et diffusion du patrimoine culturel béninois.
                </p>
                <div class="flex items-center justify-between">
                    <a href="{{ route('contenu.index') }}?search=Musée+Numérique" class="text-green-600 font-medium hover:text-green-700 flex items-center">
                        Lire l'article <i class="bi bi-arrow-right ml-1"></i>
                    </a>
                    <span class="text-sm text-gray-500">
                        <i class="bi bi-eye mr-1"></i> 2.3k
                    </span>
                </div>
            </div>
        </article>
    </div>
</section>
            
            <!-- Newsletter -->
            <div class="mt-12 bg-gradient-to-r from-green-50 to-yellow-50 rounded-2xl p-8">
                <div class="text-center max-w-2xl mx-auto">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">
                        Restez informé de l'actualité culturelle
                    </h3>
                    <p class="text-gray-600 mb-6">
                        Recevez chaque mois les dernières actualités, événements et découvertes 
                        sur le patrimoine culturel béninois.
                    </p>
                    <form class="flex flex-col sm:flex-row gap-3 max-w-md mx-auto">
                        <input 
                            type="email" 
                            placeholder="Votre adresse email" 
                            class="flex-grow px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            required
                        >
                        <button 
                            type="submit" 
                            class="bg-green-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-green-700 transition"
                        >
                            S'abonner
                        </button>
                    </form>
                    <p class="text-sm text-gray-500 mt-4">
                        En vous abonnant, vous acceptez notre politique de confidentialité.
                    </p>
                </div>
            </div>
        </section>

        <!-- ==================== -->
        <!-- CALL TO ACTION -->
        <!-- ==================== -->
        <div class="bg-gradient-to-r from-green-600 via-yellow-500 to-red-600 rounded-3xl p-8 md:p-12 text-center text-white mb-20 reveal-on-scroll">
            <h2 class="text-2xl md:text-3xl font-bold mb-4">
                Rejoignez la communauté culturelle du Bénin
            </h2>
            <p class="text-lg mb-8 max-w-2xl mx-auto opacity-90">
                Contribuez à la préservation et à la promotion de notre riche patrimoine.
            </p>
                    <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('register') ?? '#' }}" 
                   class="bg-white text-gray-900 px-8 py-3 rounded-full font-bold hover:bg-gray-100 transition">
                   <i class="bi bi-person-plus mr-2"></i>Créer un compte
                </a>
                <a href="{{ route('login') ?? '#' }}" 
                   class="bg-transparent border-2 border-white px-8 py-3 rounded-full font-bold hover:bg-white/10 transition">
                   <i class="bi bi-box-arrow-in-right mr-2"></i>Se connecter
                </a>
                @auth
                <a href="{{ route('payment.checkout') }}" 
                   class="bg-yellow-400 text-gray-900 px-8 py-3 rounded-full font-bold hover:bg-yellow-300 transition shadow-lg">
                   <i class="bi bi-star-fill mr-2"></i>Passer Premium
                </a>
                @endauth
            </div>
        </div>
    </main>

    <!-- ==================== -->
    <!-- FOOTER -->
    <!-- ==================== -->
    <footer class="bg-gray-900 text-white pt-12 pb-8">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <div>
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 rounded-lg bg-gradient-to-r from-green-600 to-yellow-500 flex items-center justify-center mr-3">
                            <i class="bi bi-globe-americas text-white text-xl"></i>
                        </div>
                        <span class="text-xl font-bold">BeninCulture</span>
                    </div>
                    <p class="text-gray-400">
                        Plateforme de préservation et promotion du patrimoine culturel béninois.
                    </p>
                </div>
                
                <div>
                    <h4 class="text-lg font-bold mb-4">Explorer</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('contenu.index') }}" class="text-gray-400 hover:text-white">Thèmes Culturels</a></li>
                        <li><a href="{{ route('region.index') }}" class="text-gray-400 hover:text-white">Régions</a></li>
                        <li><a href="{{ route('utilisateurs.index') }}" class="text-gray-400 hover:text-white">Artistes</a></li>
                        <li><a href="{{ route('contenu.index') }}?search=Événement" class="text-gray-400 hover:text-white">Événements</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-lg font-bold mb-4">Ressources</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('contenu.index') }}" class="text-gray-400 hover:text-white">Documentation</a></li>
                        <li><a href="{{ route('contenu.index') }}" class="text-gray-400 hover:text-white">Blog</a></li>
                        <li><a href="{{ route('home') }}#faq" class="text-gray-400 hover:text-white">FAQ</a></li>
                        <li><a href="mailto:contact@beninculture.bj" class="text-gray-400 hover:text-white">Support</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-lg font-bold mb-4">Contact</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li class="flex items-center">
                            <i class="bi bi-geo-alt mr-2"></i>
                            <span>Cotonou, Bénin</span>
                        </li>
                        <li class="flex items-center">
                            <i class="bi bi-envelope mr-2"></i>
                            <span>contact@beninculture.bj</span>
                        </li>
                        <li class="flex items-center">
                            <i class="bi bi-phone mr-2"></i>
                            <span>+229 01 40 74 48 33</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="mb-4 md:mb-0">
                        <p class="text-gray-400">
                            &copy; 2025 BeninCulture. Tous droits réservés.
                        </p>
                    </div>
                    <div class="flex items-center space-x-6">
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="bi bi-facebook text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="bi bi-twitter text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="bi bi-instagram text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white">
                            <i class="bi bi-youtube text-xl"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- ==================== -->
    <!-- SCRIPTS -->
    <!-- ==================== -->
    <script>
        // Attendre que le DOM soit chargé
        document.addEventListener('DOMContentLoaded', function() {
            
            // ====================
            // ANIMATION AU SCROLL
            // ====================
            const revealElements = document.querySelectorAll('.reveal-on-scroll');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('revealed');
                    }
                });
            }, { threshold: 0.1 });
            
            revealElements.forEach(element => {
                observer.observe(element);
            });
            
            // ====================
            // CAROUSEL
            // ====================
            const carousel = document.getElementById('cultureCarousel');
            const slides = carousel.querySelectorAll('.min-w-full');
            const prevBtn = document.getElementById('carouselPrev');
            const nextBtn = document.getElementById('carouselNext');
            const dots = document.querySelectorAll('.carousel-dot');
            
            let currentIndex = 0;
            const totalSlides = slides.length;
            let autoPlayInterval;
            
            function goToSlide(index) {
                if (index < 0) index = totalSlides - 1;
                if (index >= totalSlides) index = 0;
                
                currentIndex = index;
                carousel.style.transform = `translateX(-${currentIndex * 100}%)`;
                
                // Mettre à jour les points
                dots.forEach((dot, i) => {
                    if (i === currentIndex) {
                        dot.classList.add('bg-green-600', 'scale-125');
                        dot.classList.remove('bg-gray-300');
                    } else {
                        dot.classList.remove('bg-green-600', 'scale-125');
                        dot.classList.add('bg-gray-300');
                    }
                });
            }
            
            // Navigation
            nextBtn.addEventListener('click', () => {
                goToSlide(currentIndex + 1);
                resetAutoPlay();
            });
            
            prevBtn.addEventListener('click', () => {
                goToSlide(currentIndex - 1);
                resetAutoPlay();
            });
            
            // Points indicateurs
            dots.forEach(dot => {
                dot.addEventListener('click', function() {
                    const index = parseInt(this.dataset.index);
                    goToSlide(index);
                    resetAutoPlay();
                });
            });
            
            // Auto-play
            function startAutoPlay() {
                autoPlayInterval = setInterval(() => {
                    goToSlide(currentIndex + 1);
                }, 5000); // Change toutes les 5 secondes
            }
            
            function resetAutoPlay() {
                clearInterval(autoPlayInterval);
                startAutoPlay();
            }
            
            // Démarrer l'auto-play
            startAutoPlay();
            
            // Pause au survol
            carousel.addEventListener('mouseenter', () => {
                clearInterval(autoPlayInterval);
            });
            
            carousel.addEventListener('mouseleave', () => {
                startAutoPlay();
            });
            
            // ====================
            // SYSTÈME DE FILTRAGE
            // ====================
            const filterButtons = document.querySelectorAll('.filter-btn');
            const filterItems = document.querySelectorAll('.filter-item');
            
            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Retirer la classe active de tous les boutons
                    filterButtons.forEach(btn => {
                        btn.classList.remove('active', 'bg-green-600', 'text-white');
                        btn.classList.add('bg-gray-100', 'hover:bg-gray-200');
                    });
                    
                    // Ajouter la classe active au bouton cliqué
                    this.classList.add('active', 'bg-green-600', 'text-white');
                    this.classList.remove('bg-gray-100', 'hover:bg-gray-200');
                    
                    // Récupérer la catégorie à filtrer
                    const filterValue = this.dataset.filter;
                    
                    // Filtrer les éléments
                    filterItems.forEach(item => {
                        if (filterValue === 'all' || item.dataset.categories.includes(filterValue)) {
                            item.style.display = 'block';
                            setTimeout(() => {
                                item.style.opacity = '1';
                                item.style.transform = 'translateY(0)';
                            }, 10);
                        } else {
                            item.style.opacity = '0';
                            item.style.transform = 'translateY(20px)';
                            setTimeout(() => {
                                item.style.display = 'none';
                            }, 300);
                        }
                    });
                });
            });
            
            // ====================
            // RECHERCHE PAR TAGS
            // ====================
            const searchTags = document.querySelectorAll('.search-tag');
            const searchInput = document.querySelector('input[type="text"]');
            
            searchTags.forEach(tag => {
                tag.addEventListener('click', function() {
                    searchInput.value = this.textContent;
                    searchInput.focus();
                });
            });
            
            // ====================
            // SMOOTH SCROLL
            // ====================
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href');
                    if (targetId === '#') return;
                    
                    const target = document.querySelector(targetId);
                    if (target) {
                        window.scrollTo({
                            top: target.offsetTop - 80,
                            behavior: 'smooth'
                        });
                    }
                });
            });
            
            // ====================
            // ANIMATION D'ENTRÉE
            // ====================
            const fadeElements = document.querySelectorAll('.fade-in-up');
            fadeElements.forEach((element, index) => {
                element.style.animationDelay = `${index * 0.1}s`;
            });
            
        });

        // Gestion du dropdown mobile
        document.addEventListener('DOMContentLoaded', function() {
            const dropdownBtn = document.querySelector('.dropdown button');
            const dropdownMenu = document.querySelector('.dropdown-menu');
    
            if (dropdownBtn && dropdownMenu) {
                dropdownBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                dropdownMenu.classList.toggle('hidden');
            });
        
            // Fermer le dropdown en cliquant ailleurs
            document.addEventListener('click', function() {
                dropdownMenu.classList.add('hidden');
            });
        }
    
        // Auto-hide des messages flash après 5 secondes
        setTimeout(function() {
            document.querySelectorAll('[class*="bg-green-500"], [class*="bg-red-500"]').forEach(function(el) {
                el.style.opacity = '0';
                setTimeout(function() {
                    el.remove();
                }, 300);
            });
        }, 5000);
        });

    </script>
</body>
</html>