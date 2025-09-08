<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pré-inscription - </title>
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .badge{
            color: rgb(51, 51, 51);
        }
        .logo-img {
            width: 150px;
            height: auto;
            background: transparent;
        }
        .alert {
            position: relative;
            overflow: hidden;
            animation: slideInDown 0.5s ease-out;
        }

        .progress-bar-timer {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 4px;
            background-color: rgba(255, 255, 255, 0.4);
            border-radius: 0;
            transition: none;
            width: 100%;
        }

        @keyframes slideInDown {
            from {
                transform: translateY(-100%);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes slideOutUp {
            from {
                transform: translateY(0);
                opacity: 1;
            }
            to {
                transform: translateY(-100%);
                opacity: 0;
            }
        }

        .alert-fade-out {
            animation: slideOutUp 0.5s ease-in forwards;
        }

        .is-invalid{
            border-color: red!important;
        }
    </style>
    @yield('style')
</head>
<body>
    <div class="main-content">
         @yield('content')
         
    </div>
    @yield('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script>
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
        var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl)
        })

        document.addEventListener('DOMContentLoaded', function() {
            // Ajouter la barre de progression à toutes les alertes existantes
            const alerts = document.querySelectorAll('.alert');
            
            alerts.forEach(function(alert) {
                // Ajouter la barre de progression
                const progressBar = document.createElement('div');
                progressBar.className = 'progress-bar-timer';
                alert.appendChild(progressBar);
                
                // Démarrer le timer
                startProgressTimer(alert, 5000); // 5 secondes
            });
        });

        function startProgressTimer(alertElement, duration) {
            const progressBar = alertElement.querySelector('.progress-bar-timer');
            
            if (!progressBar) return;
            
            let startTime = Date.now();
            
            const updateProgress = function() {
                const elapsed = Date.now() - startTime;
                const remaining = Math.max(0, duration - elapsed);
                const percentage = (remaining / duration) * 100;
                
                progressBar.style.width = percentage + '%';
                
                if (remaining > 0) {
                    requestAnimationFrame(updateProgress);
                } else {
                    hideAlert(alertElement);
                }
            };
            
            requestAnimationFrame(updateProgress);
        }

        function hideAlert(alertElement) {
            alertElement.classList.add('alert-fade-out');
            
            setTimeout(function() {
                if (alertElement.parentNode) {
                    alertElement.parentNode.removeChild(alertElement);
                }
            }, 500);
        }
    </script>
</body>
</html>