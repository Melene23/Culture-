{{-- resources/views/payment/failed.blade.php --}}
@extends('layouts.app')

@section('title', 'Paiement échoué - Culture Bénin')

@section('content')
<div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <div class="text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <i class="bi bi-x-circle text-red-600 text-2xl"></i>
            </div>
            <h2 class="mt-6 text-3xl font-extrabold text-gray-900">
                Paiement échoué
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Une erreur est survenue lors du traitement de votre paiement.
            </p>
        </div>

        <div class="mt-8 bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
            <div class="text-center">
                <div class="mb-6">
                    <i class="bi bi-emoji-frown text-4xl text-red-500 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Oups ! Quelque chose s'est mal passé</h3>
                    <p class="text-gray-600 mb-4">
                        Votre paiement n'a pas pu être traité. Cela peut être dû à :
                    </p>
                    <ul class="text-sm text-gray-600 text-left space-y-2 mb-6">
                        <li class="flex items-center">
                            <i class="bi bi-dot text-red-500 mr-2"></i>
                            Problème de connexion avec votre opérateur mobile
                        </li>
                        <li class="flex items-center">
                            <i class="bi bi-dot text-red-500 mr-2"></i>
                            Solde insuffisant sur votre compte
                        </li>
                        <li class="flex items-center">
                            <i class="bi bi-dot text-red-500 mr-2"></i>
                            Délai d'expiration dépassé
                        </li>
                        <li class="flex items-center">
                            <i class="bi bi-dot text-red-500 mr-2"></i>
                            Problème technique temporaire
                        </li>
                    </ul>
                </div>

                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                    <div class="flex items-center">
                        <i class="bi bi-exclamation-triangle text-yellow-600 mr-2"></i>
                        <p class="text-sm text-yellow-700">
                            Votre compte n'a pas été débité. Vous pouvez réessayer en toute sécurité.
                        </p>
                    </div>
                </div>

                <div class="space-y-4">
                    <a href="{{ route('payment.checkout') }}" 
                       class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <i class="bi bi-arrow-clockwise mr-2"></i>
                        Réessayer le paiement
                    </a>
                    
                    <a href="{{ route('home') }}" 
                       class="w-full flex justify-center py-3 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <i class="bi bi-house mr-2"></i>
                        Retour à l'accueil
                    </a>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-200">
                    <p class="text-xs text-gray-500">
                        Le problème persiste ? 
                        <a href="mailto:support@culturebenin.bj" class="text-green-600 hover:text-green-500">
                            Contactez notre support
                        </a>
                        ou appelez le <strong>229 61 23 45 67</strong>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection