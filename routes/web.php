<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Importez TOUS vos contrôleurs
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContenuController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\LanguesController;
use App\Http\Controllers\UtilisateurController;
use App\Http\Controllers\CommentaireController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TypeMediaController;
use App\Http\Controllers\TypeContenuController;
use App\Http\Controllers\PaymentController;

// =================== ROUTES PUBLIQUES ===================
Route::get('/', function () {
    return view('welcome');
})->name('home');

// =================== VOS VRAIES ROUTES RESOURCE ===================
Route::resource('langues', LanguesController::class);
Route::resource('region', RegionController::class);
Route::resource('contenu', ContenuController::class);
Route::resource('media', MediaController::class);
Route::resource('utilisateurs', UtilisateurController::class);
Route::resource('commentaire', CommentaireController::class);
Route::resource('role', RoleController::class);
Route::resource('typemedia', TypeMediaController::class);
Route::resource('typecontenu', TypeContenuController::class);

// =================== AUTHENTIFICATION ===================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
});

// Déconnexion
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// =================== ROUTES CONNECTÉES ===================
Route::middleware(['auth'])->group(function () {
    
    // PROFIL
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    
    // MES CONTENUS (utilisateurs normaux)
    Route::get('/mes-contenus', [ContenuController::class, 'mesContenus'])
        ->name('contenus.mes-contenus');
    
    // DASHBOARD VISITEUR
    Route::get('/dashboard', function () {
        $user = Auth::user();
        
        if ($user->id_role == 1) { // Admin
            return redirect()->route('admin.dashboard');
        }
        
        // Statistiques personnelles
        $stats = [
            'mes_contenus' => \App\Models\Contenu::where('id_auteur', $user->id_utilisateur)->count(),
            'contenus_publies' => \App\Models\Contenu::where('id_auteur', $user->id_utilisateur)->where('statut', 'publié')->count(),
            'contenus_en_attente' => \App\Models\Contenu::where('id_auteur', $user->id_utilisateur)->where('statut', 'en attente')->count(),
            'mes_commentaires' => \App\Models\Commentaire::where('id_utilisateur', $user->id_utilisateur)->count(),
            'derniers_contenus' => \App\Models\Contenu::where('id_auteur', $user->id_utilisateur)->orderBy('date_creation', 'desc')->limit(5)->get(),
        ];
        
        return view('visitor.dashboard', [
            'user' => $user,
            'stats' => $stats
        ]);
    })->name('dashboard');
});

// =================== ROUTES ADMIN PROTÉGÉES ===================
Route::prefix('admin')->name('admin.')->group(function () {
    
    // TOUTES les routes admin avec vérification manuelle
    Route::middleware(['auth'])->group(function () {
        
        Route::get('/dashboard', function() {
            $user = auth()->user();
            
            // VÉRIFICATION STRICTE DU RÔLE ADMIN
            if ($user->id_role != 1) {
                // Log de tentative non autorisée
                \Log::warning('Tentative accès admin non autorisée', [
                    'user_id' => $user->id_utilisateur,
                    'email' => $user->email,
                    'role' => $user->id_role
                ]);
                
                return redirect('/')
                    ->with('error', 'Accès réservé aux administrateurs.')
                    ->with('alert-type', 'danger');
            }
            
            // Statistiques
            $stats = [
                'users' => \App\Models\Utilisateur::count(),
                'contents' => \App\Models\Contenu::count(),
                'regions' => \App\Models\Region::count() ?? 0,
                'languages' => \App\Models\Langue::count() ?? 0,
            ];
            
            return view('admin.dashboard', [
                'user' => $user,
                'stats' => $stats
            ]);
        })->name('dashboard');
        
        // Autres routes admin avec la même protection
        Route::get('/users', function() {
            $user = auth()->user();
            if ($user->id_role != 1) {
                return redirect('/')->with('error', 'Accès non autorisé');
            }
            $users = \App\Models\Utilisateur::with('role')->paginate(10);
            return view('admin.users.index', compact('users'));
        })->name('users.index');
        
        Route::get('/contents', function() {
            $user = auth()->user();
            if ($user->id_role != 1) {
                return redirect('/')->with('error', 'Accès non autorisé');
            }
            $contents = \App\Models\Contenu::with('auteur', 'region')->paginate(15);
            return view('admin.contents.index', compact('contents'));
        })->name('contents.index');
    });
});

// =================== ROUTES DE TEST (optionnelles) ===================
Route::get('/test-auth', function() {
    if (Auth::check()) {
        $user = Auth::user();
        return "Connecté : {$user->email}";
    }
    return "Non connecté";
})->name('test-auth');

// =================== ROUTES DE PAIEMENT ===================
// Page de checkout accessible à tous (authentification optionnelle)
Route::prefix('paiement')->name('payment.')->group(function () {
    Route::get('/', [PaymentController::class, 'checkoutPage'])->name('checkout');
    Route::post('/process', [PaymentController::class, 'processPayment'])->name('process');
    Route::get('/callback/{reference}', [PaymentController::class, 'callback'])->name('callback');
    Route::get('/cancel/{reference}', [PaymentController::class, 'cancel'])->name('cancel');
    Route::get('/success', [PaymentController::class, 'success'])->name('success');
    Route::get('/failed', [PaymentController::class, 'failed'])->name('failed');
    
    // Historique des paiements nécessite une authentification
    Route::middleware(['auth'])->group(function () {
        Route::get('/history', [PaymentController::class, 'history'])->name('history');
    });
});
