
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> - Pré-inscription</title>
     <link rel="stylesheet" href="assets/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
</head>
<body>
    <div class="main-content">
        <!-- Header -->
        @php
            $active = 'home';
        @endphp
         @include('partials.navbar')

        <!-- Hero Section -->
        <section class="hero">
            <div class="container">
                <div class="hero-content animate-fade-in-up">
                    <h1>Bienvenue à l'Université a Faculté de Médecine et de Pharmacie d’Oujda (FMPO)</h1>
                    <p>Commencez votre parcours académique avec nous.<br>Déposez votre candidature dès maintenant pour la préinscription au concours Passerelle FMPO – rentrée 2025.</p>
                    <a style="margin-bottom: 15px;" class="btn btn-warning" href="{{ asset('storage/fichiers/Fiche-de-candidature Oujda.pdf') }}" download>
                        <span class="fa fa-download"></span>
                        Veuillez télécharger la fiche de candidature
                    </a>
                    <br>
                    <a href="/confirme_preregistration" class="btn btn-primary"  style="background: white; color: var(--primary); font-size: 18px; padding: 16px 32px;">
                         Commencer ma pré-inscription
                    </a>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section style="padding: 80px 0; background: white;">
            <div class="container">
                <div class="text-center mb-8">
                    <h2 style="font-size: 36px; font-weight: 700; color: var(--neutral-800); margin-bottom: 16px;">
                        Processus de Pré-inscription
                    </h2>
                    <p style="font-size: 18px; color: var(--neutral-600); max-width: 600px; margin: 0 auto;">
                        Un processus simple et sécurisé en quelques étapes
                    </p>
                </div>

                <div class="grid grid-3">
                    <div class="card animate-fade-in-up" style="animation-delay: 0.1s;">
                        <div class="card-body text-center">
                            <div style="width: 64px; height: 64px; background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; color: white; font-size: 24px;">
                                📋
                            </div>
                            <h3 style="font-size: 20px; font-weight: 700; margin-bottom: 12px; color: var(--neutral-800);">
                                1. Remplir le formulaire
                            </h3>
                            <p style="color: var(--neutral-600);">
                                Complétez vos informations personnelles et académiques en quelques minutes.
                            </p>
                        </div>
                    </div>

                    <div class="card animate-fade-in-up" style="animation-delay: 0.2s;">
                        <div class="card-body text-center">
                            <div style="width: 64px; height: 64px; background: linear-gradient(135deg, var(--secondary) 0%, #10B981 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; color: white; font-size: 24px;">
                                📄
                            </div>
                            <h3 style="font-size: 20px; font-weight: 700; margin-bottom: 12px; color: var(--neutral-800);">
                                2. Joindre les documents
                            </h3>
                            <p style="color: var(--neutral-600);">
                                Téléchargez votre Baccalauréat, DEUG et relevés de notes en format PDF.
                            </p>
                        </div>
                    </div>

                    <div class="card animate-fade-in-up" style="animation-delay: 0.3s;">
                        <div class="card-body text-center">
                            <div style="width: 64px; height: 64px; background: linear-gradient(135deg, var(--accent) 0%, #F97316 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; color: white; font-size: 24px;">
                                ✅
                            </div>
                            <h3 style="font-size: 20px; font-weight: 700; margin-bottom: 12px; color: var(--neutral-800);">
                                3. Validation
                            </h3>
                            <p style="color: var(--neutral-600);">
                                Notre équipe examine votre dossier .
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section style="padding: 80px 0; background: var(--neutral-50);">
            <div class="container text-center">
                <h2 style="font-size: 32px; font-weight: 700; color: var(--neutral-800); margin-bottom: 16px;">
                    Prêt à commencer ?
                </h2>
                <p style="font-size: 18px; color: var(--neutral-600); margin-bottom: 32px;">
                    Rejoignez des milliers d'étudiants qui ont choisi l'excellence académique.
                </p>
                <a href="/confirme_preregistration" class="btn btn-primary" style="font-size: 18px; padding: 16px 32px;">
                    🚀 Commencer ma pré-inscription
                </a>
            </div>
        </section>
    </div>

    <script>
        // Animation au scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            card.style.transition = 'all 0.6s ease';
            observer.observe(card);
        });
    </script>
</body>
</html>