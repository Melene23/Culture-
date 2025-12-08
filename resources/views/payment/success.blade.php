{{-- resources/views/payment/success.blade.php --}}
@extends('layouts.app')

@section('title', 'Paiement réussi - Culture Bénin')

@section('content')
<div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <div class="text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                <i class="bi bi-check-circle text-green-600 text-2xl"></i>
            </div>
            <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                Paiement réussi !
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Merci pour votre achat. Votre abonnement est maintenant actif.
            </p>
        </div>

        <div class="mt-8 bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
            <div class="text-center">
                <div class="mb-6">
                    <i class="bi bi-gift text-4xl text-green-500 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Bienvenue dans l'espace premium !</h3>
                    <p class="text-gray-600">
                        Vous avez maintenant accès à tous les contenus exclusifs de Culture Bénin.
                    </p>
                </div>

                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                    <div class="flex items-center">
                        <i class="bi bi-info-circle text-green-600 mr-2"></i>
                        <p class="text-sm text-green-700">
                            Un email de confirmation vous a été envoyé avec les détails de votre abonnement.
                        </p>
                    </div>
                </div>

                <div class="space-y-4">
                    <a href="{{ route('premium.dashboard') }}" 
                       class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <i class="bi bi-stars mr-2"></i>
                        Accéder au contenu premium
                    </a>
                    
                    <a href="{{ route('home') }}" 
                       class="w-full flex justify-center py-3 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <i class="bi bi-house mr-2"></i>
                        Retour à l'accueil
                    </a>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-200">
                    <p class="text-xs text-gray-500">
                        Besoin d'aide ? 
                        <a href="mailto:support@culturebenin.bj" class="text-green-600 hover:text-green-500">
                            Contactez notre support
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection