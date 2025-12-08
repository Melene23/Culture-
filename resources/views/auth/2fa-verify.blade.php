<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification - Culture CMS</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .hero-section { 
            background: linear-gradient(135deg, #008751 0%, #00a86b 100%); 
            min-height: 100vh; 
            display: flex; 
            align-items: center; 
            color: white; 
        }
        .feature-icon { 
            width: 80px; 
            height: 80px; 
            background: rgba(255, 255, 255, 0.2); 
            border-radius: 20px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            margin-bottom: 1rem; 
        }
        .btn-culture { 
            background: linear-gradient(135deg, #008751 0%, #00a86b 100%); 
            border: none; 
            color: white; 
            padding: 12px 30px; 
            border-radius: 25px; 
            font-weight: 600; 
        }
        .btn-culture:hover { 
            color: white; 
            transform: translateY(-2px); 
            box-shadow: 0 5px 15px rgba(0, 135, 81, 0.4); 
        }
        .card-auth { 
            border-radius: 16px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.12); 
        }
        .code-input {
            font-size: 32px;
            font-weight: bold;
            letter-spacing: 10px;
            text-align: center;
            border: 3px solid #008751;
            border-radius: 12px;
            padding: 15px;
        }
        .code-input:focus {
            border-color: #00a86b;
            box-shadow: 0 0 0 0.2rem rgba(0, 135, 81, 0.25);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ url('/') }}">
                <i class="bi bi-globe-europe-africa me-2 text-primary"></i>
                Culture
            </a>
            <div class="d-flex">
                <a href="{{ route('login') }}" class="btn btn-outline-secondary">Retour</a>
            </div>
        </div>
    </nav>

    <section class="hero-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="card card-auth p-4 bg-white text-dark">
                        <div class="text-center mb-4">
                            <div class="feature-icon mx-auto">
                                <i class="bi bi-shield-lock text-white fs-1"></i>
                            </div>
                            <h3 class="mt-3">Vérification en deux étapes</h3>
                            <p class="text-muted">Un code de vérification a été envoyé à votre adresse email</p>
                            <p class="text-muted small">
                                <i class="bi bi-envelope me-1"></i>
                                <strong>{{ session('2fa_email') }}</strong>
                            </p>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success">
                                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('auth.2fa.verify.submit') }}" id="2faForm">
                            @csrf
    
                            <div class="mb-4">
                                <label for="code" class="form-label text-center d-block">
                                    <strong>Code de vérification (6 chiffres)</strong>
                                </label>
                                <input type="text" 
                                    class="form-control code-input @error('code') is-invalid @enderror" 
                                    id="code" 
                                    name="code" 
                                    maxlength="6" 
                                    pattern="[0-9]{6}"
                                    placeholder="000000"
                                    required 
                                    autofocus
                                    autocomplete="off">
                                @error('code')
                                    <div class="invalid-feedback text-center">{{ $message }}</div>
                                @enderror
                                <small class="text-muted d-block text-center mt-2">
                                    Le code expire dans 10 minutes
                                </small>
                            </div>
    
                            <button type="submit" class="btn btn-culture w-100 mb-3">
                                <i class="bi bi-check-circle me-2"></i>Vérifier le code
                            </button>
                        </form>

                        <form method="POST" action="{{ route('auth.2fa.resend') }}" class="text-center">
                            @csrf
                            <button type="submit" class="btn btn-link text-decoration-none">
                                <i class="bi bi-arrow-clockwise me-1"></i>Renvoyer le code
                            </button>
                        </form>

                        <div class="mt-4 p-3 bg-light rounded">
                            <small class="text-muted">
                                <i class="bi bi-info-circle me-1"></i>
                                <strong>Conseil de sécurité :</strong> Ne partagez jamais ce code avec personne. 
                                Si vous n'avez pas demandé ce code, ignorez cet email.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-formatage du code (uniquement des chiffres)
        document.getElementById('code').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
            
            // Auto-submit quand 6 chiffres sont entrés
            if (this.value.length === 6) {
                document.getElementById('2faForm').submit();
            }
        });

        // Focus automatique sur le champ code
        document.getElementById('code').focus();
    </script>
</body>
</html>

