<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use App\Models\Utilisateur;

class AuthController extends Controller
{
    // Afficher le formulaire de connexion
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Traiter la connexion (sans 2FA)
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        // Vérifier les identifiants
        $user = Utilisateur::where('email', $request->email)->first();
        
        if (!$user) {
            \Log::warning('Tentative de connexion échouée - Utilisateur non trouvé', [
                'email' => $request->email,
                'ip' => $request->ip()
            ]);
            
            return back()->withErrors([
                'email' => 'Email ou mot de passe incorrect.',
            ])->withInput();
        }
        
        // Vérifier le mot de passe (support pour Bcrypt et texte clair pour migration)
        $passwordValid = false;
        $needsRehash = false;
        
        // Essayer d'abord avec Hash::check() pour les mots de passe Bcrypt
        try {
            if (Hash::check($request->password, $user->mot_de_passe)) {
                $passwordValid = true;
                // Vérifier si le hash doit être mis à jour
                if (Hash::needsRehash($user->mot_de_passe)) {
                    $needsRehash = true;
                }
            }
        } catch (\Exception $e) {
            // Si Hash::check() échoue (format non Bcrypt), essayer comparaison directe
            // pour permettre la migration des anciens mots de passe
            if ($user->mot_de_passe === $request->password) {
                $passwordValid = true;
                $needsRehash = true; // Forcer le rehash car c'est en texte clair
            }
        }
        
        if (!$passwordValid) {
            \Log::warning('Tentative de connexion échouée - Mot de passe incorrect', [
                'email' => $request->email,
                'ip' => $request->ip()
            ]);
            
            return back()->withErrors([
                'email' => 'Email ou mot de passe incorrect.',
            ])->withInput();
        }
        
        // Mettre à jour le mot de passe si nécessaire (migration vers Bcrypt)
        if ($needsRehash) {
            $user->mot_de_passe = Hash::make($request->password);
            $user->save();
            \Log::info('Mot de passe migré vers Bcrypt', [
                'user_id' => $user->id_utilisateur,
                'email' => $user->email
            ]);
        }
        
        // Connecter l'utilisateur directement (sans remember me car la colonne n'existe pas encore)
        Auth::login($user);
        
        // Régénérer la session APRÈS la connexion (important pour la sécurité)
        $request->session()->regenerate();
        
        // Log de connexion réussie
        \Log::info('Connexion réussie', [
            'user_id' => $user->id_utilisateur,
            'email' => $user->email,
            'role' => $user->id_role,
            'ip' => $request->ip()
        ]);
        
        // REDIRECTION INTELLIGENTE (sans intended pour éviter les problèmes)
        if ($user->id_role == 1) {
            return redirect()->route('admin.dashboard')
                ->with('success', 'Bienvenue Administrateur ' . $user->prenom . ' !');
        } else {
            return redirect()->route('dashboard')
                ->with('success', 'Bienvenue ' . $user->prenom . ' ! Connecté avec succès.');
        }
    }

    // Déconnexion
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    // Formulaire "Mot de passe oublié"
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    // Envoi du lien de réinitialisation
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    }

    // Formulaire de réinitialisation
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    // Traitement de la réinitialisation
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'mot_de_passe' => Hash::make($password)
                ])->save();

                event(new PasswordReset($user));
            }
        );

        return $status == Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }

    // Afficher le formulaire d'inscription
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Traiter l'inscription
    public function register(Request $request)
    {
        $data = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:utilisateur,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Utilisateur::create([
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'email' => $data['email'],
            'mot_de_passe' => Hash::make($data['password']),
            'id_role' => 2, // Rôle utilisateur par défaut
            'id_langue' => 1, // Langue par défaut
            'sexe' => 'non-spécifié',
            'photo' => 'default.jpg', // Photo par défaut
            'statut' => 'actif',
            'date_naissance' => '1990-01-01', // Date par défaut
            'date_inscription' => now(),
        ]);

        Auth::login($user);

        // Rediriger vers la page d'accueil (welcome) après inscription
        return redirect('/');
    }
}