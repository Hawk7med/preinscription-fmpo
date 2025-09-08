@extends('layout')
@section('style')
<style>
    .modal-content {
        border: none;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    }

    .form-check {
        transition: all 0.3s ease;
    }

    .form-check:hover {
        background-color: #f8f9fa !important;
        transform: translateY(-1px);
    }

    .form-check-input:checked + .form-check-label {
        color: #198754;
    }

    .modal-header {
        border-bottom: none;
    }

    .modal-footer {
        border-top: 1px solid #e9ecef;
    }

    #exportStats .card {
        transition: transform 0.2s ease;
    }

    #exportStats .card:hover {
        transform: scale(1.05);
    }

    .spinner-border-sm {
        width: 1rem;
        height: 1rem;
    }
    .modal{
        max-width: 100%;
    }
</style>
@endsection
@section('content')
    <div class="main-content">
        <!-- Header -->
        <header class="header">
            <div class="container">
                <div class="header-content">
                    <a href="index.php" class="logo">
                         <img src="{{ asset('images/fmpo.png') }}" alt="Logo FMPO" class="logo-img">
                    </a>
                    <nav class="nav">
                        <span style="color: var(--neutral-600); font-weight: 500;">
                            👋 Bonjour,  - {{ auth()->user()->name }} >
                        </span>
                        <form action="{{ route('admin.logout') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="logout-btn btn btn-secondary">🚪 Déconnexion</button>
                        </form>
                    </nav>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main style="flex: 1; padding: 40px 0;">
            <div class="container">
                <!-- Page Title -->
                <div class="mb-8">
                    <h1 style="font-size: 32px; font-weight: 800; color: var(--neutral-800); margin-bottom: 8px;">
                        📊 Tableau de Bord
                    </h1>
                    <p style="color: var(--neutral-600); font-size: 16px;">
                        Gérez les pré-inscriptions et suivez les statistiques
                    </p>
                </div>

                <!-- Statistics Cards -->
                <div class="grid grid-4 mb-8" style="grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));">
                    <div class="card animate-fade-in-up">
                        <div class="card-body">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p style="color: var(--neutral-500); font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">
                                        Total Candidatures
                                    </p>
                                    <p style="font-size: 32px; font-weight: 800; color: var(--neutral-800); margin-top: 8px;">
                                        {{ $candidats->count() }}
                                    </p>
                                </div>
                                <div style="width: 56px; height: 56px; background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%); border-radius: var(--radius-lg); display: flex; align-items: center; justify-content: center; color: white; font-size: 24px;">
                                    👥
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card animate-fade-in-up" style="animation-delay: 0.1s;">
                        <div class="card-body">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p style="color: var(--neutral-500); font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">
                                        En Attente
                                    </p>
                                    <p style="font-size: 32px; font-weight: 800; color: var(--warning); margin-top: 8px;">
                                        {{ $en_attente->count() }}
                                    </p>
                                </div>
                                <div style="width: 56px; height: 56px; background: linear-gradient(135deg, var(--warning) 0%, #F59E0B 100%); border-radius: var(--radius-lg); display: flex; align-items: center; justify-content: center; color: white; font-size: 24px;">
                                    ⏳
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card animate-fade-in-up" style="animation-delay: 0.2s;">
                        <div class="card-body">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p style="color: var(--neutral-500); font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">
                                        Approuvées
                                    </p>
                                    <p style="font-size: 32px; font-weight: 800; color: var(--success); margin-top: 8px;">
                                        {{ $approuvees->count() }}
                                    </p>
                                </div>
                                <div style="width: 56px; height: 56px; background: linear-gradient(135deg, var(--success) 0%, #10B981 100%); border-radius: var(--radius-lg); display: flex; align-items: center; justify-content: center; color: white; font-size: 24px;">
                                    ✅
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card animate-fade-in-up" style="animation-delay: 0.3s;">
                        <div class="card-body">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p style="color: var(--neutral-500); font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">
                                        Rejetées
                                    </p>
                                    <p style="font-size: 32px; font-weight: 800; color: var(--error); margin-top: 8px;">
                                        {{ $rejetees->count() }}
                                    </p>
                                </div>
                                <div style="width: 56px; height: 56px; background: linear-gradient(135deg, var(--error) 0%, #EF4444 100%); border-radius: var(--radius-lg); display: flex; align-items: center; justify-content: center; color: white; font-size: 24px;">
                                    ❌
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Students List -->
                <div class="card animate-slide-in-right">
                    <div class="card-header">
                        <div class="flex items-center justify-between">
                            <div>
                                <h2 class="card-title">📋 Liste des Pré-inscriptions</h2>
                                <p class="card-subtitle">Gérez et consultez toutes les candidatures</p>
                            </div>
                            <div class="flex gap-4">
                                <a class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#exportModal" onclick="loadExportStats()">
                                    <span class="fa-solid fa-file-excel"></span> Exporter
                                </a>
                                <select id="statusFilter" style="padding: 8px 12px; border: 1px solid var(--neutral-200); border-radius: var(--radius); background: white;">
                                    <option value="">Tous les statuts</option>
                                    <option value="En Attente">En attente</option>
                                    <option value="Approuvée">Approuvées</option>
                                    <option value="Rejetée">Rejetées</option>
                                </select>
                                <input type="text" id="searchInput" placeholder="Rechercher..." style="padding: 8px 12px; border: 1px solid var(--neutral-200); border-radius: var(--radius); width: 200px;">
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-body" style="padding: 0;">
                        @if ($candidats)
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>👤 Candidat</th>
                                        <th>📧 Contact</th>
                                        <th class="text-center">ℹ️ CIN</th>
                                        <th class="text-center">📅 Date d'inscription</th>
                                        <th class="text-center">📊 Statut</th>
                                        <th class="text-center">⚡ Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="studentsTableBody">
                                    @foreach ($candidats as $candidat)
                                        <tr class="student-row" data-status="{{ $candidat->status }}" data-search="{{ strtolower($candidat->nom . ' ' . $candidat->prenom . ' ' . $candidat->email) }}">
                                            <td>
                                                <div>
                                                    <div style="font-weight: 600; color: var(--neutral-800);">
                                                        <?= htmlspecialchars($candidat->prenom . ' ' . $candidat->nom) ?>
                                                    </div>
                                                    <div style="font-size: 12px; color: var(--neutral-500);">
                                                        Né(e) le {{ date('d/m/Y', strtotime($candidat->date_naissance)) }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <div style="font-size: 14px; color: var(--neutral-800);">
                                                        <?= htmlspecialchars($candidat->email) ?>
                                                    </div>
                                                    <div style="font-size: 12px; color: var(--neutral-500);">
                                                        <?= htmlspecialchars($candidat->telephone) ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div>
                                                    <div style="font-size: 12px; color: var(--neutral-500);">
                                                        <?= ucfirst($candidat->cin) ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div style="font-size: 14px; color: var(--neutral-600);">
                                                    <?= date('d/m/Y H:i', strtotime($candidat->date_inscription)) ?>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                @php
                                                    $status_badge = $candidat->status == 'En Attente' ? 'pending' : 
                                                                    ($candidat->status == 'Approuvée' ? 'approved' : 'rejected');
                                                @endphp
                                                <span class="badge badge-{{ $status_badge }}">
                                                    <span class="status-indicator status-{{ $status_badge }}">
                                                        <span class="status-dot"></span>
                                                        {{ $candidat->status }}
                                                    </span>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('candidats.single', $candidat->id) }}" class="btn btn-primary" style="padding: 8px 16px; font-size: 12px;">
                                                    👁️ Voir détails
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div style="padding: 60px; text-align: center; color: var(--neutral-500);">
                                <div style="font-size: 48px; margin-bottom: 16px;">📝</div>
                                <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 8px;">Aucune pré-inscription</h3>
                                <p>Les nouvelles candidatures apparaîtront ici.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </main>
    </div>

<!-- Modal d'exportation -->
<div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="exportModalLabel">
                    <i class="fas fa-file-excel me-2"></i>
                    Exporter les candidats
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form id="exportForm" action="{{ route('admin.candidats.export') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <!-- Statistiques rapides -->
                        <div class="col-12 mb-4">
                            <h6 class="text-muted mb-3">📊 Statistiques actuelles :</h6>
                            <div class="row" id="exportStats">
                                <div class="col-6 col-md-3 mb-2">
                                    <div class="card border-0 bg-light text-center p-2">
                                        <small class="text-muted">Total</small>
                                        <strong class="text-primary" id="stat-total">-</strong>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3 mb-2">
                                    <div class="card border-0 bg-warning bg-opacity-10 text-center p-2">
                                        <small class="text-muted">En Attente</small>
                                        <strong class="text-warning" id="stat-attente">-</strong>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3 mb-2">
                                    <div class="card border-0 bg-success bg-opacity-10 text-center p-2">
                                        <small class="text-muted">Approuvées</small>
                                        <strong class="text-success" id="stat-approuvees">-</strong>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3 mb-2">
                                    <div class="card border-0 bg-danger bg-opacity-10 text-center p-2">
                                        <small class="text-muted">Rejetées</small>
                                        <strong class="text-danger" id="stat-rejetees">-</strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Choix du statut -->
                        <div class="col-12">
                            <h6 class="text-muted mb-3">🎯 Choisissez le type d'exportation :</h6>
                            
                            <div class="form-check mb-3 p-3 border rounded bg-light">
                                <input class="form-check-input" type="radio" name="status" value="tous" id="export-tous" checked>
                                <label class="form-check-label fw-bold" for="export-tous">
                                    <i class="fas fa-list-ul text-primary me-2"></i>
                                    Tous les candidats
                                </label>
                                <div class="text-muted small mt-1">
                                    Exporter tous les candidats avec leur statut affiché dans le fichier
                                </div>
                            </div>

                            <div class="form-check mb-3 p-3 border rounded">
                                <input class="form-check-input" type="radio" name="status" value="En Attente" id="export-attente">
                                <label class="form-check-label fw-bold text-warning" for="export-attente">
                                    <i class="fas fa-clock text-warning me-2"></i>
                                    Candidats en attente uniquement
                                </label>
                                <div class="text-muted small mt-1">
                                    Exporter uniquement les candidats avec le statut "En Attente"
                                </div>
                            </div>

                            <div class="form-check mb-3 p-3 border rounded">
                                <input class="form-check-input" type="radio" name="status" value="Approuvée" id="export-approuvees">
                                <label class="form-check-label fw-bold text-success" for="export-approuvees">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    Candidats approuvés uniquement
                                </label>
                                <div class="text-muted small mt-1">
                                    Exporter uniquement les candidats avec le statut "Approuvée"
                                </div>
                            </div>

                            <div class="form-check mb-3 p-3 border rounded">
                                <input class="form-check-input" type="radio" name="status" value="Rejetée" id="export-rejetees">
                                <label class="form-check-label fw-bold text-danger" for="export-rejetees">
                                    <i class="fas fa-times-circle text-danger me-2"></i>
                                    Candidats rejetés uniquement
                                </label>
                                <div class="text-muted small mt-1">
                                    Exporter uniquement les candidats avec le statut "Rejetée"
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>
                        Annuler
                    </button>
                    <button type="submit" class="btn btn-success" id="exportBtn">
                        <i class="fas fa-download me-2"></i>
                        <span class="btn-text">Exporter Excel</span>
                        <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    <script>
        // Filtrage et recherche
        const statusFilter = document.getElementById('statusFilter');
        const searchInput = document.getElementById('searchInput');
        const rows = document.querySelectorAll('.student-row');

        function filterTable() {
            const statusValue = statusFilter.value;
            const searchValue = searchInput.value.toLowerCase();

            rows.forEach(row => {
                const status = row.dataset.status;
                const searchText = row.dataset.search;
                
                const statusMatch = !statusValue || status === statusValue;
                const searchMatch = !searchValue || searchText.includes(searchValue);
                
                if (statusMatch && searchMatch) {
                    row.style.display = '';
                    row.style.animation = 'fadeInUp 0.3s ease';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        statusFilter.addEventListener('change', filterTable);
        searchInput.addEventListener('input', filterTable);

        // Animation des cartes statistiques
        const statCards = document.querySelectorAll('.grid .card');
        statCards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            card.style.transition = 'all 0.6s ease';
            
            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });

        // Animation du tableau
        setTimeout(() => {
            const table = document.querySelector('.table');
            if (table) {
                table.style.opacity = '0';
                table.style.transform = 'translateY(30px)';
                table.style.transition = 'all 0.6s ease';
                
                setTimeout(() => {
                    table.style.opacity = '1';
                    table.style.transform = 'translateY(0)';
                }, 500);
            }
        }, 400);

        // Charger les statistiques lors de l'ouverture de la modal
        function loadExportStats() {
            fetch('{{ route("admin.candidats.export.stats") }}')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('stat-total').textContent = data.total || 0;
                    document.getElementById('stat-attente').textContent = data.en_attente || 0;
                    document.getElementById('stat-approuvees').textContent = data.approuvees || 0;
                    document.getElementById('stat-rejetees').textContent = data.rejetees || 0;
                })
                .catch(error => {
                    console.error('Erreur lors du chargement des statistiques:', error);
                });
        }

        // Gestion de la soumission du formulaire d'exportation
        document.getElementById('exportForm').addEventListener('submit', function(e) {
            const exportBtn = document.getElementById('exportBtn');
            const btnText = exportBtn.querySelector('.btn-text');
            const spinner = exportBtn.querySelector('.spinner-border');
            
            // Désactiver le bouton et afficher le spinner
            exportBtn.disabled = true;
            btnText.textContent = 'Exportation en cours...';
            spinner.classList.remove('d-none');
            
            // Créer un formulaire temporaire pour la soumission
            const form = e.target;
            const formData = new FormData(form);
            
            // Empêcher la soumission normale
            e.preventDefault();
            
            // Faire la requête
            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            })
            .then(response => {
                if (response.ok) {
                    return response.blob();
                } else {
                    return response.json().then(data => {
                        throw new Error(data.message || 'Erreur lors de l\'exportation');
                    });
                }
            })
            .then(blob => {
                // Créer un lien de téléchargement
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.style.display = 'none';
                a.href = url;
                a.download = 'candidats_' + new Date().toISOString().slice(0,19).replace(/:/g, '-') + '.xlsx';
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
                
                // Fermer la modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('exportModal'));
                modal.hide();
                
                // Afficher un message de succès
                showToast('Exportation réussie !', 'Le fichier Excel a été téléchargé avec succès.', 'success');
            })
            .catch(error => {
                console.error('Erreur:', error);
                showToast('Erreur d\'exportation', error.message, 'error');
            })
            .finally(() => {
                // Réactiver le bouton
                exportBtn.disabled = false;
                btnText.textContent = 'Exporter Excel';
                spinner.classList.add('d-none');
            });
        });

        // Fonction pour afficher les notifications toast
        function showToast(title, message, type = 'info') {
            // Si vous utilisez une bibliothèque de notification comme Toastr
            if (typeof toastr !== 'undefined') {
                toastr[type](message, title);
            } else {
                // Fallback avec alert
                alert(title + ': ' + message);
            }
        }

        // Mettre à jour le texte du bouton selon la sélection
        document.querySelectorAll('input[name="status"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const exportBtn = document.getElementById('exportBtn');
                const btnText = exportBtn.querySelector('.btn-text');
                
                if (this.value === 'tous') {
                    btnText.textContent = 'Exporter Tous';
                } else {
                    btnText.textContent = `Exporter ${this.value}`;
                }
            });
        });
    </script>

@endsection