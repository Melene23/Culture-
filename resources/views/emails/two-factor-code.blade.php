<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code de vérification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #008751 0%, #00a86b 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .code-box {
            background: white;
            border: 3px solid #008751;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            margin: 20px 0;
            font-size: 32px;
            font-weight: bold;
            letter-spacing: 5px;
            color: #008751;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            color: #666;
            font-size: 12px;
        }
        .warning {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🔐 Code de vérification</h1>
        <p>BeninCulture - Sécurité de votre compte</p>
    </div>
    
    <div class="content">
        @if($userName)
            <p>Bonjour <strong>{{ $userName }}</strong>,</p>
        @else
            <p>Bonjour,</p>
        @endif
        
        <p>Vous avez demandé à vous connecter à votre compte BeninCulture. Utilisez le code suivant pour compléter votre authentification :</p>
        
        <div class="code-box">
            {{ $code }}
        </div>
        
        <div class="warning">
            <strong>⚠️ Important :</strong>
            <ul style="margin: 10px 0; padding-left: 20px;">
                <li>Ce code est valide pendant <strong>10 minutes</strong> uniquement</li>
                <li>Ne partagez jamais ce code avec personne</li>
                <li>Si vous n'avez pas demandé ce code, ignorez cet email</li>
            </ul>
        </div>
        
        <p>Si vous n'avez pas demandé ce code, veuillez ignorer cet email ou contacter le support si vous avez des préoccupations.</p>
    </div>
    
    <div class="footer">
        <p>© {{ date('Y') }} BeninCulture - Tous droits réservés</p>
        <p>Cet email a été envoyé automatiquement, merci de ne pas y répondre.</p>
    </div>
</body>
</html>

