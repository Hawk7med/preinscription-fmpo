<?php
// Vérifier l'authentification
/*if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index.php?page=admin');
    exit;
}*/

// Charger les données des étudiants
$students_file = 'data/students.json';
$students = [];
if (file_exists($students_file)) {
    $students = json_decode(file_get_contents($students_file), true) ?? [];
}

// Statistiques
$total_students = count($students);
$pending_count = count(array_filter($students, fn($s) => $s['status'] === 'pending'));
$approved_count = count(array_filter($students, fn($s) => $s['status'] === 'approved'));
$rejected_count = count(array_filter($students, fn($s) => $s['status'] === 'rejected'));
?>

@extends('layout')
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
                            <button type="submit" class="logout-btn">🚪 Déconnexion</button>
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
                                        <?= $pending_count ?>
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
                                        <?= $approved_count ?>
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
                                        <?= $rejected_count ?>
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
                                <select id="statusFilter" style="padding: 8px 12px; border: 1px solid var(--neutral-200); border-radius: var(--radius); background: white;">
                                    <option value="">Tous les statuts</option>
                                    <option value="pending">En attente</option>
                                    <option value="approved">Approuvées</option>
                                    <option value="rejected">Rejetées</option>
                                </select>
                                <input type="text" id="searchInput" placeholder="Rechercher..." style="padding: 8px 12px; border: 1px solid var(--neutral-200); border-radius: var(--radius); width: 200px;">
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-body" style="padding: 0;">
                        <?php if (empty($candidats)): ?>
                            <div style="padding: 60px; text-align: center; color: var(--neutral-500);">
                                <div style="font-size: 48px; margin-bottom: 16px;">📝</div>
                                <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 8px;">Aucune pré-inscription</h3>
                                <p>Les nouvelles candidatures apparaîtront ici.</p>
                            </div>
                        <?php else: ?>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>👤 Candidat</th>
                                        <th>📧 Contact</th>
                                        <th>ℹ️ CIN</th>
                                        <th>📅 Date d'inscription</th>
                                        <th>📊 Statut</th>
                                        <th>⚡ Actions</th>
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
                                            <td>
                                                <div>
                                                    <div style="font-size: 12px; color: var(--neutral-500);">
                                                        <?= ucfirst($candidat->cin) ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div style="font-size: 14px; color: var(--neutral-600);">
                                                    <?= date('d/m/Y H:i', strtotime($candidat->date_inscription)) ?>
                                                </div>
                                            </td>
                                            <td>
                                                @php
                                                    $status_badge = $candidat->status == 'En attente' ? 'pending' : 
                                                                    ($candidat->status == 'Approuvée' ? 'approved' : 'rejected');
                                                @endphp
                                                <span class="badge badge-{{ $status_badge }}">
                                                    <span class="status-indicator status-{{ $status_badge }}">
                                                        <span class="status-dot"></span>
                                                        {{ $candidat->status }}
                                                    </span>
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('candidats.single', $candidat->id) }}" class="btn btn-primary" style="padding: 8px 16px; font-size: 12px;">
                                                    👁️ Voir détails
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </main>
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
    </script>

@endsection