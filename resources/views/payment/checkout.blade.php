{{-- resources/views/payment/checkout.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement - Culture Bénin</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <style>
        .payment-card {
            background: white;
            border-radius: 16px;
            padding: 32px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            border: 1px solid #e2e8f0;
        }
        
        .btn-pay {
            background: linear-gradient(135deg, #10b981 0%, #0da271 100%);
            color: white;
            padding: 16px 32px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            font-size: 16px;
        }
        
        .btn-pay:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.3);
        }
        
        .plan-card {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 24px;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .plan-card:hover {
            border-color: #10b981;
            transform: translateY(-4px);
        }
        
        .plan-card.selected {
            border-color: #10b981;
            background: #f0fdf4;
        }
        
        .payment-method {
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .payment-method:hover {
            border-color: #10b981;
        }
        
        .payment-method.selected {
            border-color: #10b981;
            background: #f0fdf4;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-green-500 flex items-center justify-center">
                        <i class="bi bi-globe-americas text-white text-lg"></i>
                    </div>
                    <span class="text-xl font-bold">
                        Culture<span class="text-green-600">Bénin</span>
                    </span>
                </div>
                
                <div class="flex items-center gap-4">
                    <span class="text-gray-600 font-medium">
                        <i class="bi bi-lock-fill mr-1"></i>Paiement sécurisé
                    </span>
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Contenu principal -->
    <main class="container mx-auto px-6 py-8">
        <div class="max-w-4xl mx-auto">
            
            <!-- Carte de paiement -->
            <div class="payment-card">
                <!-- En-tête -->
                <div class="text-center mb-8">
                    <div class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-4">
                        <i class="bi bi-credit-card text-green-600 text-2xl"></i>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-800 mb-2">Paiement sécurisé</h1>
                    <p class="text-gray-600">Accédez aux contenus premium de Culture Bénin</p>
                </div>
                
                <!-- Messages d'erreur -->
                @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg flex items-center justify-between">
                    <div class="flex items-center gap-2 text-red-700">
                        <i class="bi bi-exclamation-triangle"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
                @endif
                
                <!-- Forfaits -->
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Choisissez votre forfait</h2>
                    <div class="grid md:grid-cols-3 gap-4">
                        <!-- Forfait Basic -->
                        <div class="plan-card" onclick="selectPlan(2500, 'basic')">
                            <div class="text-center">
                                <h3 class="font-bold text-lg mb-2">Basic</h3>
                                <div class="my-3">
                                    <span class="text-2xl font-bold">2.500</span>
                                    <span class="text-gray-600">FCFA</span>
                                </div>
                                <p class="text-sm text-gray-600 mb-4">/ mois</p>
                                <ul class="text-sm text-gray-700 space-y-1">
                                    <li>✓ Accès au catalogue complet</li>
                                    <li>✓ 10 téléchargements/mois</li>
                                    <li>✓ Support email</li>
                                </ul>
                            </div>
                        </div>
                        
                        <!-- Forfait Premium -->
                        <div class="plan-card selected" onclick="selectPlan(5000, 'premium')">
                            <div class="text-center">
                                <span class="bg-green-500 text-white px-2 py-1 rounded text-xs">Populaire</span>
                                <h3 class="font-bold text-lg mt-2 mb-2">Premium</h3>
                                <div class="my-3">
                                    <span class="text-2xl font-bold">5.000</span>
                                    <span class="text-gray-600">FCFA</span>
                                </div>
                                <p class="text-sm text-gray-600 mb-4">/ mois</p>
                                <ul class="text-sm text-gray-700 space-y-1">
                                    <li>✓ Tous avantages Basic</li>
                                    <li>✓ Téléchargements illimités</li>
                                    <li>✓ Contenu exclusif</li>
                                    <li>✓ Support prioritaire</li>
                                </ul>
                            </div>
                        </div>
                        
                        <!-- Forfait Pro -->
                        <div class="plan-card" onclick="selectPlan(10000, 'pro')">
                            <div class="text-center">
                                <h3 class="font-bold text-lg mb-2">Pro</h3>
                                <div class="my-3">
                                    <span class="text-2xl font-bold">10.000</span>
                                    <span class="text-gray-600">FCFA</span>
                                </div>
                                <p class="text-sm text-gray-600 mb-4">/ mois</p>
                                <ul class="text-sm text-gray-700 space-y-1">
                                    <li>✓ Tous avantages Premium</li>
                                    <li>✓ API d'accès</li>
                                    <li>✓ Contenu personnalisé</li>
                                    <li>✓ Support 24/7</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Formulaire de paiement -->
                <form method="POST" action="{{ route('payment.process') }}" id="paymentForm">
                    @csrf
                    
                    <input type="hidden" name="amount" id="amount" value="5000">
                    <input type="hidden" name="plan_type" id="plan_type" value="premium">
                    <input type="hidden" name="payment_provider" id="payment_provider" value="fedapay">
                    
                    <!-- Sélection du provider de paiement -->
                    <div class="mb-6">
                        <label class="block text-gray-700 font-medium mb-3">Plateforme de paiement</label>
                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="payment-method selected" onclick="selectProvider('fedapay')">
                                <input type="radio" id="provider_fedapay" name="payment_provider" value="fedapay" checked class="hidden">
                                <label for="provider_fedapay" class="flex items-center cursor-pointer">
                                    <div class="w-12 h-12 rounded-lg bg-green-600 flex items-center justify-center mr-3">
                                        <i class="bi bi-wallet2 text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium">FedaPay</p>
                                        <p class="text-sm text-gray-600">MTN MoMo, Moov Flooz</p>
                                    </div>
                                </label>
                            </div>
                            
                            <div class="payment-method" onclick="selectProvider('stripe')">
                                <input type="radio" id="provider_stripe" name="payment_provider" value="stripe" class="hidden">
                                <label for="provider_stripe" class="flex items-center cursor-pointer">
                                    <div class="w-12 h-12 rounded-lg bg-indigo-600 flex items-center justify-center mr-3">
                                        <i class="bi bi-credit-card text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium">Stripe</p>
                                        <p class="text-sm text-gray-600">Cartes bancaires internationales</p>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-6" id="fedapay-methods">
                        <label class="block text-gray-700 font-medium mb-3">Méthode de paiement</label>
                        
                        <div class="space-y-3">
                            <!-- MTN Mobile Money -->
                            <div class="payment-method selected" onclick="selectPaymentMethod('mtn')">
                                <input type="radio" id="method_mtn" name="payment_method" value="mtn" checked class="hidden">
                                <label for="method_mtn" class="flex items-center cursor-pointer">
                                    <div class="w-10 h-10 rounded-lg bg-yellow-500 flex items-center justify-center mr-3">
                                        <i class="bi bi-phone text-white text-lg"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium">MTN Mobile Money</p>
                                        <p class="text-sm text-gray-600">Paiement via MTN MoMo</p>
                                    </div>
                                </label>
                            </div>
                            
                            <!-- Moov Money -->
                            <div class="payment-method" onclick="selectPaymentMethod('moov')">
                                <input type="radio" id="method_moov" name="payment_method" value="moov" class="hidden">
                                <label for="method_moov" class="flex items-center cursor-pointer">
                                    <div class="w-10 h-10 rounded-lg bg-orange-500 flex items-center justify-center mr-3">
                                        <i class="bi bi-phone text-white text-lg"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium">Moov Money</p>
                                        <p class="text-sm text-gray-600">Paiement via Moov Flooz</p>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-6 hidden" id="stripe-methods">
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex items-start gap-3">
                                <i class="bi bi-info-circle text-blue-600 text-xl"></i>
                                <div>
                                    <p class="font-medium text-blue-800 mb-1">Paiement par carte bancaire</p>
                                    <p class="text-sm text-blue-700">Vous serez redirigé vers Stripe pour effectuer le paiement de manière sécurisée. Les cartes Visa, MasterCard et American Express sont acceptées.</p>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="payment_method" value="card" id="stripe_payment_method">
                    </div>
                    
                    <!-- Informations client -->
                    <div class="mb-6">
                        <label class="block text-gray-700 font-medium mb-3">Informations de contact</label>
                        
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm text-gray-600 mb-2">Numéro de téléphone</label>
                                <input type="tel" name="phone" 
                                       class="w-full p-3 border border-gray-300 rounded-lg"
                                       placeholder="Ex: 229 61 23 45 67"
                                       required>
                            </div>
                            
                            <div>
                                <label class="block text-sm text-gray-600 mb-2">Adresse email</label>
                                <input type="email" name="email" 
                                       class="w-full p-3 border border-gray-300 rounded-lg"
                                       value="{{ auth()->user()->email ?? '' }}"
                                       required>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Résumé -->
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 mb-6">
                        <h3 class="font-semibold text-gray-800 mb-4">Résumé de votre commande</h3>
                        
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Forfait :</span>
                                <span class="font-medium" id="plan_summary">Premium (1 mois)</span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span class="text-gray-600">Méthode :</span>
                                <span class="font-medium" id="method_summary">MTN Mobile Money</span>
                            </div>
                            
                            <div class="border-t border-gray-300 pt-3">
                                <div class="flex justify-between text-lg font-bold">
                                    <span>Total à payer :</span>
                                    <span id="total_amount">5.000 FCFA</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Bouton de paiement -->
                    <button type="submit" class="btn-pay">
                        <i class="bi bi-lock"></i>
                        Payer maintenant
                    </button>
                    
                    <!-- Sécurité -->
                    <div class="mt-4 text-center">
                        <p class="text-sm text-gray-600">
                            <i class="bi bi-shield-check text-green-600"></i>
                            Paiement 100% sécurisé via FedaPay / Stripe
                        </p>
                    </div>
                </form>
            </div>
            
            <!-- Informations -->
            <div class="mt-6 p-6 bg-blue-50 border border-blue-200 rounded-lg">
                <div class="flex items-start gap-3">
                    <i class="bi bi-info-circle text-blue-500 text-xl mt-1"></i>
                    <div>
                        <h3 class="font-medium text-blue-800 mb-1">Comment procéder au paiement</h3>
                        <ul class="text-blue-700 text-sm space-y-1">
                            <li>1. Sélectionnez votre forfait et cliquez sur "Payer maintenant"</li>
                            <li>2. Vous serez redirigé vers la plateforme de paiement sécurisée</li>
                            <li>3. Suivez les instructions pour compléter le paiement</li>
                            <li>4. Vous recevrez une confirmation par SMS/Email</li>
                            <li>5. Votre accès premium sera activé automatiquement</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <!-- Pied de page -->
    <footer class="mt-12 border-t border-gray-200">
        <div class="container mx-auto px-6 py-6">
            <div class="flex flex-col md:flex-row items-center justify-between text-gray-500 text-sm">
                <p>© {{ date('Y') }} Culture Bénin - Tous droits réservés</p>
                <p>Version 1.0.0</p>
            </div>
        </div>
    </footer>
    
    <script>
        // Sélection du provider
        function selectProvider(provider) {
            document.querySelectorAll('[onclick^="selectProvider"]').forEach(item => {
                item.classList.remove('selected');
            });
            event.currentTarget.classList.add('selected');
            
            document.getElementById('payment_provider').value = provider;
            document.getElementById(`provider_${provider}`).checked = true;
            
            // Afficher/masquer les méthodes selon le provider
            if (provider === 'fedapay') {
                document.getElementById('fedapay-methods').classList.remove('hidden');
                document.getElementById('stripe-methods').classList.add('hidden');
                document.getElementById('method_mtn').checked = true;
                document.getElementById('method_summary').textContent = 'MTN Mobile Money';
            } else {
                document.getElementById('fedapay-methods').classList.add('hidden');
                document.getElementById('stripe-methods').classList.remove('hidden');
                document.getElementById('stripe_payment_method').value = 'card';
                document.getElementById('method_summary').textContent = 'Carte Bancaire (Stripe)';
            }
        }
        
        // Sélection du forfait
        function selectPlan(amount, planType) {
            document.getElementById('amount').value = amount;
            document.getElementById('plan_type').value = planType;
            
            // Mettre à jour l'affichage
            document.getElementById('total_amount').textContent = amount.toLocaleString() + ' FCFA';
            
            // Mettre à jour le résumé du forfait
            let planName = 'Basic';
            if (planType === 'premium') planName = 'Premium';
            if (planType === 'pro') planName = 'Pro';
            document.getElementById('plan_summary').textContent = `${planName} (1 mois)`;
            
            // Mettre à jour l'apparence des cartes
            document.querySelectorAll('.plan-card').forEach(card => {
                card.classList.remove('selected');
            });
            event.currentTarget.classList.add('selected');
        }
        
        // Sélection de la méthode de paiement
        function selectPaymentMethod(method) {
            // Ne sélectionner que les méthodes FedaPay
            document.querySelectorAll('#fedapay-methods .payment-method').forEach(item => {
                item.classList.remove('selected');
            });
            event.currentTarget.classList.add('selected');
            
            // Mettre à jour le résumé
            let methodName = 'MTN Mobile Money';
            if (method === 'moov') methodName = 'Moov Money';
            document.getElementById('method_summary').textContent = methodName;
            
            // Cocher le radio correspondant
            document.getElementById(`method_${method}`).checked = true;
        }
        
        // Validation du formulaire
        document.getElementById('paymentForm').addEventListener('submit', function(e) {
            const phone = document.querySelector('input[name="phone"]').value;
            const email = document.querySelector('input[name="email"]').value;
            
            if (!phone || !email) {
                e.preventDefault();
                alert('Veuillez remplir toutes les informations de contact.');
                return false;
            }
            
            // Afficher un message de chargement
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Traitement en cours...';
            submitBtn.disabled = true;
        });
    </script>
</body>
</html>

