<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TwoFactorCode extends Model
{
    protected $fillable = [
        'user_id',
        'email',
        'code',
        'expires_at',
        'used',
        'ip_address',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'used' => 'boolean',
    ];

    /**
     * Vérifier si le code est valide
     */
    public function isValid()
    {
        return !$this->used && $this->expires_at->isFuture();
    }

    /**
     * Marquer le code comme utilisé
     */
    public function markAsUsed()
    {
        $this->update(['used' => true]);
    }

    /**
     * Relation avec l'utilisateur
     */
    public function user()
    {
        return $this->belongsTo(Utilisateur::class, 'user_id', 'id_utilisateur');
    }

    /**
     * Nettoyer les codes expirés
     */
    public static function cleanExpired()
    {
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('two_factor_auth_codes')) {
                static::where('expires_at', '<', now())->delete();
            }
        } catch (\Exception $e) {
            // Si la table n'existe pas, on ignore l'erreur
            \Log::warning('Impossible de nettoyer les codes 2FA expirés', [
                'error' => $e->getMessage()
            ]);
        }
    }
}
