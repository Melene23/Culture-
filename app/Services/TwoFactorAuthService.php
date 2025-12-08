<?php

namespace App\Services;

use App\Models\TwoFactorCode;
use App\Mail\TwoFactorCodeMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TwoFactorAuthService
{
    /**
     * Générer et envoyer un code 2FA
     */
    public function generateAndSendCode($user, $ipAddress = null)
    {
        try {
            // Nettoyer les anciens codes expirés
            TwoFactorCode::cleanExpired();
            
            // Générer un code à 6 chiffres
            $code = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
            
            // Marquer les anciens codes comme utilisés
            if (\Illuminate\Support\Facades\Schema::hasTable('two_factor_auth_codes')) {
                TwoFactorCode::where('email', $user->email)
                    ->where('used', false)
                    ->update(['used' => true]);
            }
            
            // Créer un nouveau code
            $twoFactorCode = TwoFactorCode::create([
            'user_id' => $user->id_utilisateur ?? $user->id,
            'email' => $user->email,
            'code' => $code,
            'expires_at' => Carbon::now()->addMinutes(10), // Code valide 10 minutes
            'used' => false,
                'ip_address' => $ipAddress,
            ]);
            
            // Envoyer le code par email
            Mail::to($user->email)->send(new TwoFactorCodeMail(
                $code,
                $user->prenom . ' ' . $user->nom
            ));
            
            return [
                'success' => true,
                'code_id' => $twoFactorCode->id,
                'expires_at' => $twoFactorCode->expires_at,
            ];
        } catch (\Exception $e) {
            \Log::error('Erreur envoi code 2FA', [
                'email' => $user->email,
                'error' => $e->getMessage()
            ]);
            
            return [
                'success' => false,
                'error' => 'Impossible d\'envoyer le code par email. Veuillez réessayer.',
            ];
        }
    }
    
    /**
     * Vérifier un code 2FA
     */
    public function verifyCode($email, $code)
    {
        try {
            // Nettoyer les codes expirés
            TwoFactorCode::cleanExpired();
            
            if (!\Illuminate\Support\Facades\Schema::hasTable('two_factor_auth_codes')) {
                return [
                    'success' => false,
                    'error' => 'Système 2FA non disponible.',
                ];
            }
            
            $twoFactorCode = TwoFactorCode::where('email', $email)
                ->where('code', $code)
                ->where('used', false)
                ->where('expires_at', '>', now())
                ->first();
        
            if (!$twoFactorCode) {
                return [
                    'success' => false,
                    'error' => 'Code invalide ou expiré.',
                ];
            }
            
            // Marquer le code comme utilisé
            $twoFactorCode->markAsUsed();
            
            return [
                'success' => true,
                'user_id' => $twoFactorCode->user_id,
            ];
        } catch (\Exception $e) {
            \Log::error('Erreur vérification code 2FA', [
                'email' => $email,
                'error' => $e->getMessage()
            ]);
            
            return [
                'success' => false,
                'error' => 'Erreur lors de la vérification du code.',
            ];
        }
    }
    
    /**
     * Vérifier si un code est en attente pour cet email
     */
    public function hasPendingCode($email)
    {
        try {
            if (!\Illuminate\Support\Facades\Schema::hasTable('two_factor_auth_codes')) {
                return false;
            }
            
            return TwoFactorCode::where('email', $email)
                ->where('used', false)
                ->where('expires_at', '>', now())
                ->exists();
        } catch (\Exception $e) {
            \Log::warning('Erreur vérification code en attente', [
                'email' => $email,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }
}

