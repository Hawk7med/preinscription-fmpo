<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un compte</title>
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
    <div class="main-content">
        <!-- Register Section -->
        <main style="flex: 1; display: flex; align-items: center; justify-content: center; padding: 40px 0;">
            <div style="width: 100%; max-width: 450px;">
                <div class="card animate-fade-in-up">
                    <div class="card-header text-center">
                        <div style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; color: white; font-size: 32px;">
                            ✨
                        </div>
                        <h1 class="card-title">Créer un compte</h1>
                        <p class="card-subtitle">Remplissez le formulaire pour vous inscrire</p>
                    </div>
                    
                    <div class="card-body">
                        <!-- Affichage des erreurs -->
                        @if ($errors->any())
                            <div class="error-message">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="success-message">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('admin.register') }}" method="POST" id="registerForm">
                            @csrf
                            
                            <div class="form-group">
                                <label for="name" class="form-label">Nom d'utilisateur</label>
                                <input type="text" id="name" name="name" class="form-input" 
                                       value="{{ old('name') }}" required placeholder="Choisissez un nom d'utilisateur">
                            </div>
                            
                            <div class="form-group">
                                <label for="email" class="form-label">Adresse email</label>
                                <input type="email" id="email" name="email" class="form-input" 
                                       value="{{ old('email') }}" required placeholder="Votre adresse email">
                            </div>
                            
                            <div class="form-group">
                                <label for="password" class="form-label">Mot de passe</label>
                                <input type="password" id="password" name="password" class="form-input" required 
                                       placeholder="Entrez un mot de passe">
                            </div>
                            
                            <div class="form-group">
                                <label for="password_confirmation" class="form-label">Confirmez le mot de passe</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" 
                                       class="form-input" required placeholder="Confirmez votre mot de passe">
                            </div>
                            
                            <div class="form-group">
                                <label for="role_id" class="form-label">Rôle</label>
                                <select name="role_id" id="role_id" class="form-input">
                                    <option value="">Utilisateur (par défaut)</option>
                                    <option value="1">Admin</option>
                                    <option value="2">Utilisateur</option>
                                </select>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-full" style="margin-top: 24px;">
                                🚀 Créer mon compte
                            </button>
                        </form>

                        <div style="margin-top: 16px; text-align: center; font-size: 14px;">
                            <p>Déjà inscrit ? <a href="{{ route('login') }}">Se connecter</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Animation du formulaire (comme la page de login)
        const form = document.getElementById('registerForm');
        const inputs = form.querySelectorAll('input, select');

        inputs.forEach((input, index) => {
            input.style.opacity = '0';
            input.style.transform = 'translateX(-20px)';
            input.style.transition = 'all 0.4s ease';
            
            setTimeout(() => {
                input.style.opacity = '1';
                input.style.transform = 'translateX(0)';
            }, index * 100 + 300);
        });

        // Focus effect
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
