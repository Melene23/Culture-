<?php
// app/Services/Payment/FedaPayService.php

namespace App\Services\Payment;

use Illuminate\Support\Facades\Log;

class FedaPayService
{
    private $apiKey;
    private $baseUrl;
    
    public function __construct()
    {
        $this->apiKey = config('services.fedapay.api_key', '');
        $this->baseUrl = env('FEDAPAY_MODE', 'sandbox') === 'live' 
            ? 'https://api.fedapay.com/v1' 
            : 'https://sandbox-api.fedapay.com/v1';
    }
    
    /**
     * Effectuer une requête HTTP avec file_get_contents
     */
    private function makeRequest($method, $endpoint, $data = [])
    {
        $url = $this->baseUrl . $endpoint;
        
        // Préparer les headers
        $headers = [
            'Authorization: Bearer ' . $this->apiKey,
            'Content-Type: application/json',
            'Accept: application/json',
        ];
        
        // Options pour le contexte stream
        $options = [
            'http' => [
                'method' => strtoupper($method),
                'header' => implode("\r\n", $headers),
                'ignore_errors' => true, // Pour lire la réponse même en cas d'erreur HTTP
                'timeout' => 30,
            ]
        ];
        
        // Ajouter le contenu pour POST/PUT
        if (in_array(strtoupper($method), ['POST', 'PUT', 'PATCH']) && !empty($data)) {
            $options['http']['content'] = json_encode($data);
        }
        
        // Créer le contexte
        $context = stream_context_create($options);
        
        try {
            // Faire la requête
            $response = @file_get_contents($url, false, $context);
            
            if ($response === false) {
                $error = error_get_last();
                Log::error('FedaPay API Error - file_get_contents failed: ' . ($error['message'] ?? 'Unknown error'));
                return null;
            }
            
            // Décoder la réponse JSON
            $decodedResponse = json_decode($response, true);
            
            // Vérifier les erreurs JSON
            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error('FedaPay JSON decode error: ' . json_last_error_msg());
                return null;
            }
            
            return $decodedResponse;
            
        } catch (\Exception $e) {
            Log::error('FedaPay API Exception: ' . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Créer une transaction
     */
    public function createTransaction($amount, $description, $callbackUrl, $cancelUrl = null, $customerData = [])
    {

        // Mode développement/test
        if (env('APP_ENV') === 'local' || env('FEDAPAY_MODE') === 'test') {
            return $this->createTestTransaction($amount, $description);
        }

        $data = [
            'amount' => $amount * 100, // Convertir en centimes
            'currency' => ['iso' => 'XOF'],
            'description' => $description,
            'callback_url' => $callbackUrl,
            'callback_url' => $cancelUrl ?? $callbackUrl,
        ];
        
        // Ajouter les informations client si fournies
        if (!empty($customerData)) {
            $data['customer'] = $customerData;
        }
        
        // Ajouter des métadonnées pour le suivi
        $data['metadata'] = [
            'source' => 'Culture Bénin',
            'timestamp' => time(),
        ];
        
        $result = $this->makeRequest('POST', '/transactions', $data);
        
        if ($result && isset($result['data'])) {
            return [
                'success' => true,
                'transaction_id' => $result['data']['id'],
                'transaction' => $result['data'],
                'payment_url' => $this->generatePaymentUrl($result['data']['id'])
            ];
        }
        
        // Log détaillé en cas d'erreur
        Log::error('FedaPay createTransaction failed', [
            'response' => $result,
            'data_sent' => $data
        ]);
        
        return [
            'success' => false,
            'error' => 'Impossible de créer la transaction',
            'details' => $result ?? 'No response'
        ];
    }
    
    /**
     * Vérifier une transaction
     */
    public function verifyTransaction($transactionId)
    {
        $result = $this->makeRequest('GET', "/transactions/{$transactionId}");
        
        if ($result && isset($result['data'])) {
            return [
                'success' => true,
                'status' => $result['data']['status'],
                'transaction' => $result['data']
            ];
        }
        
        return [
            'success' => false,
            'error' => 'Transaction non trouvée'
        ];
    }
    
    /**
     * Générer l'URL de paiement FedaPay
     */
    private function generatePaymentUrl($transactionId)
    {
        // URL pour le sandbox
        if (env('FEDAPAY_MODE', 'sandbox') === 'sandbox') {
            return "https://sandbox-checkout.fedapay.com/{$transactionId}";
        }
        
        // URL pour la production
        return "https://checkout.fedapay.com/{$transactionId}";
    }
    
    /**
     * Tester la connexion à l'API
     */
    public function testConnection()
    {
        try {
            $result = $this->makeRequest('GET', '/accounts/balance');
            return [
                'success' => $result !== null,
                'message' => $result ? 'Connexion API réussie' : 'Échec de connexion',
                'data' => $result
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Exception: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * Mode test sans API réelle
     */
    public function createTestTransaction($amount, $description)
    {
        // Pour le développement sans connexion internet
        return [
            'success' => true,
            'transaction_id' => 'TEST-' . time() . '-' . rand(1000, 9999),
            'payment_url' => url('/payment/test-success'), // URL de test locale
            'test_mode' => true
        ];
    }
}