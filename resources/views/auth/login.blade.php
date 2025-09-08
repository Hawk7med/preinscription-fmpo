<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration </title>
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
    <div class="main-content">
        <!-- Login Section -->
        <main style="flex: 1; display: flex; align-items: center; justify-content: center; padding: 40px 0;">
            <div style="width: 100%; max-width: 400px;">
                <div class="card animate-fade-in-up">
                    <div class="card-header text-center">
                        <div style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; color: white; font-size: 32px;">
                            🔐
                        </div>
                        <h1 class="card-title">Espace Administration</h1>
                        <p class="card-subtitle">Connectez-vous pour accéder au tableau de bord</p>
                    </div>
                    
                    <div class="card-body">
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.login.process') }}" method="POST" id="loginForm">
                            @csrf
                            <div class="form-group">
                                <label for="username" class="form-label">Nom d'utilisateur</label>
                                <input type="text" id="username" name="username" class="form-input  @error('nom') is-invalid @enderror" required 
                                       placeholder="Entrez votre nom d'utilisateur">
                                @error('username')
                                <span class="invalid-feedback" role="alert" style="color:#F44336;">
                                <i class="fa fa-warning"></i> <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="password" class="form-label">Mot de passe</label>
                                <input type="password" id="password" name="password" class="form-input" required 
                                       placeholder="Entrez votre mot de passe">
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-full" style="margin-top: 24px;">
                                🚀 Se connecter
                            </button>
                        </form>

                    <div style="margin-top: 24px; padding: 16px; background: var(--neutral-50); border-radius: var(--radius); border: 1px solid var(--neutral-200);">
                        <p style="font-size: 14px; color: var(--neutral-600); text-align: center; margin-bottom: 8px;">
                            <strong>Accès réservé aux professionnels</strong>
                        </p>
                        <p style="font-size: 13px; color: var(--neutral-600); text-align: center;">
                            Veuillez saisir vos identifiants pour accéder à l’espace d’administration.
                        </p>
                    </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Animation du formulaire
        const form = document.getElementById('loginForm');
        const inputs = form.querySelectorAll('input');

        inputs.forEach((input, index) => {
            input.style.opacity = '0';
            input.style.transform = 'translateX(-20px)';
            input.style.transition = 'all 0.4s ease';
            
            setTimeout(() => {
                input.style.opacity = '1';
                input.style.transform = 'translateX(0)';
            }, index * 100 + 300);
        });

        // Validation en temps réel
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
                this.parentElement.style.transition = 'transform 0.2s ease';
            });

            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });
    </script>
</body>
</html>