<?php
// app/Http/Controllers/PaymentController.php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Services\Payment\FedaPayService;
use App\Services\Payment\StripeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    protected $fedapayService;
    protected $stripeService;
    
    public function __construct()
    {
        // Seulement l'historique nécessite une authentification
        $this->middleware('auth')->only(['history']);
        $this->fedapayService = new FedaPayService();
        $this->stripeService = new StripeService();
    }
    
    /**
     * Afficher la page de paiement
     */
    public function checkoutPage()
    {
        return view('payment.checkout');
    }
    
    /**
     * Traiter le paiement
     */
    public function processPayment(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:500',
            'plan_type' => 'required|string',
            'payment_provider' => 'required|string|in:fedapay,stripe',
            'payment_method' => 'required|string|in:mtn,moov,card',
            'phone' => 'required|string|min:8',
            'email' => 'required|email'
        ]);
        
        $user = Auth::user();
        
        // Créer un enregistrement de paiement
        $payment = Payment::create([
            'user_id' => $user ? ($user->id_utilisateur ?? $user->id) : null,
            'reference' => 'CULT-' . date('YmdHis') . '-' . strtoupper(Str::random(6)),
            'amount' => $request->amount,
            'currency' => $request->payment_provider === 'stripe' ? 'USD' : 'XOF',
            'status' => 'pending',
            'payment_method' => $request->payment_method,
            'description' => "Abonnement {$request->plan_type} - Culture Bénin",
            'customer_info' => [
                'name' => $user ? ($user->prenom . ' ' . $user->nom) : 'Client',
                'email' => $request->email,
                'phone' => $request->phone,
                'user_id' => $user ? ($user->id_utilisateur ?? $user->id) : null
            ],
            'metadata' => [
                'plan_type' => $request->plan_type,
                'payment_provider' => $request->payment_provider,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]
        ]);
        
        // Générer l'URL de callback
        $callbackUrl = route('payment.callback', $payment->reference);
        $cancelUrl = route('payment.cancel', $payment->reference);
        
        // Traiter selon le provider choisi
        if ($request->payment_provider === 'stripe') {
            // Utiliser Stripe pour les paiements par carte
            $result = $this->stripeService->createCheckoutSession(
                amount: $request->amount,
                currency: 'USD',
                description: $payment->description,
                successUrl: $callbackUrl,
                cancelUrl: $cancelUrl,
                customerEmail: $request->email,
                metadata: [
                    'payment_reference' => $payment->reference,
                    'user_id' => $user->id_utilisateur ?? $user->id,
                    'plan_type' => $request->plan_type
                ]
            );
            
            if (!$result['success']) {
                // Mode test
                if (env('APP_ENV') === 'local') {
                    $testResult = $this->stripeService->createTestSession(
                        $request->amount,
                        $payment->description
                    );
                    
                    if ($testResult['success']) {
                        $payment->update([
                            'fedapay_id' => $testResult['session_id'],
                            'metadata' => array_merge(
                                $payment->metadata ?? [],
                                ['test_mode' => true, 'payment_url' => $testResult['checkout_url'], 'stripe_session_id' => $testResult['session_id']]
                            )
                        ]);
                        
                        return redirect($testResult['checkout_url']);
                    }
                }
                
                $payment->update(['status' => 'failed']);
                
                return redirect()->route('payment.failed')
                    ->with('error', 'Erreur lors de l\'initialisation du paiement Stripe: ' . 
                           ($result['error'] ?? 'Problème de connexion avec le service de paiement'));
            }
            
            // Mettre à jour le paiement avec l'ID Stripe
            $payment->update([
                'fedapay_id' => $result['session_id'], // Réutiliser ce champ pour Stripe
                'metadata' => array_merge(
                    $payment->metadata ?? [],
                    ['payment_url' => $result['checkout_url'], 'stripe_session_id' => $result['session_id']]
                )
            ]);
            
            return redirect($result['checkout_url']);
        } else {
            // Utiliser FedaPay pour MTN/Moov
        $result = $this->fedapayService->createTransaction(
            amount: $request->amount,
            description: $payment->description,
            callbackUrl: $callbackUrl,
            cancelUrl: $cancelUrl,
            customerData: [
                    'firstname' => $user->prenom ?? explode(' ', $user->nom)[0] ?? 'User',
                    'lastname' => $user->nom ?? explode(' ', $user->nom)[1] ?? '',
                'email' => $request->email,
                'phone_number' => $request->phone
            ]
        );
        
        if (!$result['success']) {
            // Mode test si l'API ne répond pas
            if (env('APP_ENV') === 'local' || env('FEDAPAY_MODE') === 'test') {
                $testResult = $this->fedapayService->createTestTransaction(
                    $request->amount,
                    $payment->description
                );
                
                if ($testResult['success']) {
                    $payment->update([
                        'fedapay_id' => $testResult['transaction_id'],
                        'metadata' => array_merge(
                            $payment->metadata ?? [],
                            ['test_mode' => true, 'payment_url' => $testResult['payment_url']]
                        )
                    ]);
                    
                    return redirect($testResult['payment_url']);
                }
            }
            
            $payment->update(['status' => 'failed']);
            
            return redirect()->route('payment.failed')
                ->with('error', 'Erreur lors de l\'initialisation du paiement: ' . 
                       ($result['error'] ?? 'Problème de connexion avec le service de paiement'));
        }
        
        // Mettre à jour le paiement avec l'ID FedaPay
        $payment->update([
            'fedapay_id' => $result['transaction_id'],
            'metadata' => array_merge(
                $payment->metadata ?? [],
                ['payment_url' => $result['payment_url']]
            )
        ]);
        
        return redirect($result['payment_url']);
        }
    }
    
    /**
     * Callback de FedaPay
     */
    public function callback(Request $request, $reference)
    {
        $payment = Payment::where('reference', $reference)->firstOrFail();
        
        // Si en mode test, marquer directement comme réussi
        if (isset($payment->metadata['test_mode']) && $payment->metadata['test_mode'] === true) {
            $payment->update([
                'status' => 'completed',
                'paid_at' => now()
            ]);
            
            // Activer les fonctionnalités premium
            $this->activatePremiumFeatures($payment->user, $payment);
            
            return redirect()->route('payment.success');
        }
        
        // Vérifier selon le provider utilisé
        $provider = $payment->metadata['payment_provider'] ?? 'fedapay';
        
        if ($provider === 'stripe') {
            // Vérifier avec Stripe
            $sessionId = $payment->metadata['stripe_session_id'] ?? $payment->fedapay_id;
            $verification = $this->stripeService->retrieveSession($sessionId);
            
            if ($verification['success'] && $verification['paid']) {
                $payment->update([
                    'status' => 'completed',
                    'paid_at' => now(),
                    'metadata' => array_merge(
                        $payment->metadata ?? [],
                        ['verified_at' => now(), 'stripe_status' => $verification['status']]
                    )
                ]);
                
                // Activer les fonctionnalités premium
                $this->activatePremiumFeatures($payment->user, $payment);
                
                return redirect()->route('payment.success')
                    ->with('success', 'Paiement effectué avec succès!');
            }
        } else {
            // Vérifier avec FedaPay
        $verification = $this->fedapayService->verifyTransaction($payment->fedapay_id);
        
        if ($verification['success'] && in_array($verification['status'], ['approved', 'completed'])) {
            $payment->update([
                'status' => 'completed',
                'paid_at' => now(),
                'metadata' => array_merge(
                    $payment->metadata ?? [],
                    ['verified_at' => now(), 'fedapay_status' => $verification['status']]
                )
            ]);
            
            // Activer les fonctionnalités premium
            $this->activatePremiumFeatures($payment->user, $payment);
            
            return redirect()->route('payment.success')
                ->with('success', 'Paiement effectué avec succès!');
            }
        }
        
        // Paiement échoué
        $payment->update([
            'status' => 'failed',
            'metadata' => array_merge(
                $payment->metadata ?? [],
                ['verification_failed' => true, 'verification_response' => $verification ?? []]
            )
        ]);
        
        return redirect()->route('payment.failed')
            ->with('error', 'Le paiement a échoué ou a été annulé.');
    }
    
    /**
     * Annulation de paiement
     */
    public function cancel(Request $request, $reference)
    {
        $payment = Payment::where('reference', $reference)->firstOrFail();
        $payment->update(['status' => 'cancelled']);
        
        return redirect()->route('payment.checkout')
            ->with('info', 'Paiement annulé. Vous pouvez réessayer quand vous voulez.');
    }
    
    /**
     * Page de succès
     */
    public function success()
    {
        return view('payment.success');
    }
    
    /**
     * Page d'échec
     */
    public function failed()
    {
        return view('payment.failed');
    }
    
    /**
     * Activer les fonctionnalités premium
     */
    private function activatePremiumFeatures($user, $payment)
    {
        // Vérifier si l'utilisateur a les colonnes nécessaires
        $userData = [];
        
        // Ajouter les champs premium si la table les supporte
        if (Schema::hasColumn('utilisateur', 'is_premium')) {
            $userData['is_premium'] = true;
        }
        if (Schema::hasColumn('utilisateur', 'premium_until')) {
            $userData['premium_until'] = now()->addMonth();
        }
        if (Schema::hasColumn('utilisateur', 'last_payment_id')) {
            $userData['last_payment_id'] = $payment->id;
        }
        if (Schema::hasColumn('utilisateur', 'plan_type')) {
            $userData['plan_type'] = $payment->metadata['plan_type'] ?? 'premium';
        }
        
        if (!empty($userData)) {
            $user->update($userData);
        }
        
        // Ajouter un rôle premium si vous utilisez Spatie Permissions
        if (method_exists($user, 'assignRole')) {
            $user->assignRole('premium');
        }
        
        // TODO: Envoyer un email de confirmation
        // Mail::to($user->email)->send(new PaymentConfirmation($payment));
        
        // TODO: Notifier l'administrateur
        // Notification::send($adminUsers, new NewPremiumUser($user, $payment));
    }
    
    /**
     * Historique des paiements
     */
    public function history()
    {
        $payments = Payment::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('payment.history', compact('payments'));
    }
}