<?php
// app/Services/Payment/StripeService.php

namespace App\Services\Payment;

use Illuminate\Support\Facades\Log;

class StripeService
{
    private $secretKey;
    private $publicKey;
    private $baseUrl = 'https://api.stripe.com/v1';
    
    public function __construct()
    {
        $this->secretKey = config('services.stripe.secret', '');
        $this->publicKey = config('services.stripe.key', '');
    }
    
    /**
     * Effectuer une requête HTTP avec cURL
     */
    private function makeRequest($method, $endpoint, $data = [])
    {
        $url = $this->baseUrl . $endpoint;
        
        $ch = curl_init();
        
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERPWD => $this->secretKey . ':',
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/x-www-form-urlencoded',
            ],
            CURLOPT_CUSTOMREQUEST => strtoupper($method),
        ]);
        
        if (in_array(strtoupper($method), ['POST', 'PUT', 'PATCH']) && !empty($data)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        }
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        
        curl_close($ch);
        
        if ($error) {
            Log::error('Stripe API cURL Error: ' . $error);
            return null;
        }
        
        $decodedResponse = json_decode($response, true);
        
        if ($httpCode >= 400) {
            Log::error('Stripe API Error', [
                'http_code' => $httpCode,
                'response' => $decodedResponse
            ]);
            return [
                'error' => $decodedResponse['error']['message'] ?? 'Erreur Stripe',
                'http_code' => $httpCode
            ];
        }
        
        return $decodedResponse;
    }
    
    /**
     * Créer une session de paiement Stripe Checkout
     */
    public function createCheckoutSession($amount, $currency, $description, $successUrl, $cancelUrl, $customerEmail = null, $metadata = [])
    {
        // Convertir le montant en centimes pour Stripe
        $amountInCents = (int)($amount * 100);
        
        $data = [
            'payment_method_types[]' => 'card',
            'line_items[0][price_data][currency]' => strtolower($currency),
            'line_items[0][price_data][product_data][name]' => $description,
            'line_items[0][price_data][unit_amount]' => $amountInCents,
            'line_items[0][quantity]' => 1,
            'mode' => 'payment',
            'success_url' => $successUrl,
            'cancel_url' => $cancelUrl,
        ];
        
        if ($customerEmail) {
            $data['customer_email'] = $customerEmail;
        }
        
        // Ajouter les métadonnées
        foreach ($metadata as $key => $value) {
            $data["metadata[{$key}]"] = $value;
        }
        
        $result = $this->makeRequest('POST', '/checkout/sessions', $data);
        
        if ($result && isset($result['id'])) {
            return [
                'success' => true,
                'session_id' => $result['id'],
                'checkout_url' => $result['url'],
                'session' => $result
            ];
        }
        
        return [
            'success' => false,
            'error' => $result['error'] ?? 'Impossible de créer la session de paiement',
            'details' => $result
        ];
    }
    
    /**
     * Récupérer une session de paiement
     */
    public function retrieveSession($sessionId)
    {
        $result = $this->makeRequest('GET', "/checkout/sessions/{$sessionId}");
        
        if ($result && isset($result['id'])) {
            return [
                'success' => true,
                'session' => $result,
                'status' => $result['payment_status'] ?? 'unknown',
                'paid' => $result['payment_status'] === 'paid'
            ];
        }
        
        return [
            'success' => false,
            'error' => 'Session non trouvée'
        ];
    }
    
    /**
     * Créer un PaymentIntent (pour paiement intégré)
     */
    public function createPaymentIntent($amount, $currency, $description, $metadata = [])
    {
        $amountInCents = (int)($amount * 100);
        
        $data = [
            'amount' => $amountInCents,
            'currency' => strtolower($currency),
            'description' => $description,
        ];
        
        foreach ($metadata as $key => $value) {
            $data["metadata[{$key}]"] = $value;
        }
        
        $result = $this->makeRequest('POST', '/payment_intents', $data);
        
        if ($result && isset($result['id'])) {
            return [
                'success' => true,
                'payment_intent_id' => $result['id'],
                'client_secret' => $result['client_secret'],
                'payment_intent' => $result
            ];
        }
        
        return [
            'success' => false,
            'error' => $result['error'] ?? 'Impossible de créer le PaymentIntent'
        ];
    }
    
    /**
     * Vérifier un PaymentIntent
     */
    public function retrievePaymentIntent($paymentIntentId)
    {
        $result = $this->makeRequest('GET', "/payment_intents/{$paymentIntentId}");
        
        if ($result && isset($result['id'])) {
            return [
                'success' => true,
                'payment_intent' => $result,
                'status' => $result['status'],
                'paid' => $result['status'] === 'succeeded'
            ];
        }
        
        return [
            'success' => false,
            'error' => 'PaymentIntent non trouvé'
        ];
    }
    
    /**
     * Mode test sans API réelle
     */
    public function createTestSession($amount, $description)
    {
        return [
            'success' => true,
            'session_id' => 'TEST-STRIPE-' . time() . '-' . rand(1000, 9999),
            'checkout_url' => url('/payment/test-success'),
            'test_mode' => true
        ];
    }
    
    /**
     * Obtenir la clé publique
     */
    public function getPublicKey()
    {
        return $this->publicKey;
    }
}

