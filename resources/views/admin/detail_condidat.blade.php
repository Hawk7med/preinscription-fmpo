@extends('layout')
@section('style')
<style>
    .content-side{
        display: flex;
        flex-direction: column;
        height: 40%;
    }
    .validation{
        justify-content: center;
    }
    iframe{
        width: 100%;
        height: 100vh;
    }
    .nav-item>a.active{
        border-radius: 5px 5px 0px 0px;
        color: white!important;
    }
    .logo-img{
        width: 80px;
    }
    .header{
        padding: 5px;
    }
    .actions{
        display: flex;
        flex-direction: column;
        justify-content: space-evenly;
        min-height: 250px !important;
        padding: 14px;
    }
    .actions a, .actions button{
        width: 100%;
    }
    .nav-infos{
        display: inline-block;
    }
    .nav-infos li{
        display: inline-block;
        margin: 0px!important;
        background: white;
        border-color: grey!important;
        border-radius: 3px 3px 0px 0px;
    }
    .nav-infos li a{
        margin: 0px!important;
        background: #2652c324;
        border-color: #cfcfcf!important;
        border-radius: 3px 3px 0px 0px;
        color: #1358bf;
    }

</style>
@endsection
@section('content')
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="header-content">
                <a href="index.php" class="logo">
                        <img src="{{ asset('/images/fmpo.png') }}" alt="Logo FMPO" class="logo-img">
                </a>
                <nav class="nav">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                        ← Retour au tableau de bord
                    </a>
                    <form action="{{ route('admin.logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="logout-btn btn btn-secondary">🚪 Déconnexion</button>
                    </form>
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main style="flex: 1; padding: 20px 0;">
        <div class="container-fluid">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div style="margin: 0 auto;" class="row">
                <!-- Student Header -->
                <div class="card mb-6 animate-fade-in-up col-md-3">
                    <div class="card-body">
                        <div class="flex flex-col justify-between content-side">
                            <div class="flex items-center gap-4">
                                <div style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 32px; font-weight: 700;">
                                    {{ strtoupper(substr($candidat->prenom, 0, 1) . substr($candidat->nom, 0, 1)) }}
                                </div>
                                <div>
                                    <h1 style="font-size: 28px; font-weight: 700; color: var(--neutral-800); margin-bottom: 4px;">
                                        {{ htmlspecialchars($candidat->prenom . ' ' . $candidat->nom) }}
                                    </h1>
                                    <p style="color: var(--neutral-600); font-size: 16px;">
                                        Candidature pour {{ ucfirst($candidat->niveau_etude) }} en {{ ucfirst($candidat->filiere) }}
                                    </p>
                                    <p style="color: var(--neutral-500); font-size: 14px;">
                                        Soumise le {{ date('d/m/Y à H:i', strtotime($candidat->date_inscription)) }}
                                    </p>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-4 validation">
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
                            </div>
                            
                            <!-- Actions -->
                            <div class="text-center mt-8 actions">
                                @if ($candidat->status === 'En Attente')
                                    <form method="POST" style="display: inline;" action="{{ route('admin.candidats.edit', $candidat->id) }}">
                                        @csrf
                                        <input type="hidden" name="status" value="Approuvée">
                                        <button type="submit" class="btn btn-outline-success">
                                            ✅ Approuver
                                        </button>
                                    </form>
                                    
                                    <form method="POST" style="display: inline;" action="{{ route('admin.candidats.edit', $candidat->id) }}">
                                        @csrf
                                        <input type="hidden" name="status" value="Rejetée">
                                        <button type="submit" class="btn btn-outline-danger">
                                            ❌ Rejeter
                                        </button>
                                    </form>
                                @elseif ($candidat->status === 'Rejetée')
                                    <form method="POST" style="display: inline;" action="{{ route('admin.candidats.edit', $candidat->id) }}">
                                        @csrf
                                        <input type="hidden" name="status" value="Approuvée">
                                        <button type="submit" class="btn btn-outline-success">
                                            ✅ Approuver
                                        </button>
                                    </form>
                                @elseif ($candidat->status === 'Approuvée')
                                    <form method="POST" style="display: inline;" action="{{ route('admin.candidats.edit', $candidat->id) }}">
                                        @csrf
                                        <input type="hidden" name="status" value="Rejetée">
                                        <button type="submit" class="btn btn-outline-danger">
                                            ❌ Rejeter
                                        </button>
                                    </form>
                                @endif
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary" style="margin-right: 16px;">
                                    📋 Retour à la liste
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <ul class="nav nav-tabs nav-infos" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#infos">Information Général</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#cin">CIN</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#baccalaureat">Baccalauréat</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#deug">Deug</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#relever_notes">Relevé de notes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#fiche_candidature">Fiche de candidature</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="infos" role="tabpanel">
                            <div class="pt-4">
                                <div class="grid grid-2">
                                    <!-- Informations Personnelles -->
                                    <div class="card animate-fade-in-up" style="animation-delay: 0.1s;">
                                        <div class="card-header">
                                            <h3 class="card-title">👤 Informations Personnelles</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label class="form-label">Nom complet</label>
                                                <div style="padding: 10px; background: var(--neutral-50); border-radius: var(--radius); color: var(--neutral-800); font-weight: 500;">
                                                    {{ htmlspecialchars($candidat->prenom . ' ' . $candidat->nom) }}
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="form-label">CNE</label>
                                                <div style="padding: 10px; background: var(--neutral-50); border-radius: var(--radius); color: var(--neutral-800);">
                                                    {{ htmlspecialchars($candidat->cne) }}
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="form-label">Date de naissance</label>
                                                <div style="padding: 10px; background: var(--neutral-50); border-radius: var(--radius); color: var(--neutral-800);">
                                                    {{ date('d/m/Y', strtotime($candidat->date_naissance)) }}
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="form-label">Lieu de naissance</label>
                                                <div style="padding: 10px; background: var(--neutral-50); border-radius: var(--radius); color: var(--neutral-800);">
                                                    {{ htmlspecialchars($candidat->lieu_naissance) }}
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="form-label">Email</label>
                                                <div style="padding: 10px; background: var(--neutral-50); border-radius: var(--radius); color: var(--neutral-800);">
                                                    {{ htmlspecialchars($candidat->email) }}
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="form-label">Téléphone</label>
                                                <div style="padding: 10px; background: var(--neutral-50); border-radius: var(--radius); color: var(--neutral-800);">
                                                    {{ htmlspecialchars($candidat->telephone) }}
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="form-label">Adresse</label>
                                                <div style="padding: 10px; background: var(--neutral-50); border-radius: var(--radius); color: var(--neutral-800);">
                                                    {{ nl2br(htmlspecialchars($candidat->adresse)) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Informations Académiques -->
                                    <div class="card animate-fade-in-up" style="animation-delay: 0.2s;">
                                        <div class="card-header">
                                            <h3 class="card-title">🎓 Informations Académiques</h3>
                                        </div>
                                        <div class="card-body">
                                            
                                            <div class="form-group">
                                                <label class="form-label">Année d'obtention du Bac</label>
                                                <div style="padding: 10px; background: var(--neutral-50); border-radius: var(--radius); color: var(--neutral-800);">
                                                    {{ htmlspecialchars($candidat->annee_bac) }}
                                                </div>
                                            </div>
                                            
                                            @if ($candidat->mention_bac)
                                            <div class="form-group">
                                                <label class="form-label">Mention du Bac</label>
                                                <div style="padding: 10px; background: var(--neutral-50); border-radius: var(--radius); color: var(--neutral-800);">
                                                    {{ ucfirst(str_replace('_', ' ', $candidat->mention_bac)) }}
                                                </div>
                                            </div>
                                            @endif
                                            @if ($candidat->serie_bac)
                                            <div class="form-group">
                                                <label class="form-label">Série du Bac</label>
                                                <div style="padding: 10px; background: var(--neutral-50); border-radius: var(--radius); color: var(--neutral-800);">
                                                    {{ ucfirst(str_replace('_', ' ', $candidat->serie_bac)) }}
                                                </div>
                                            </div>
                                            @endif
                                            @if ($candidat->academie)
                                            <div class="form-group">
                                                <label class="form-label">Académie</label>
                                                <div style="padding: 10px; background: var(--neutral-50); border-radius: var(--radius); color: var(--neutral-800);">
                                                    {{ ucfirst(str_replace('_', ' ', $candidat->academie)) }}
                                                </div>
                                            </div>
                                            @endif
                                            @if ($candidat->niveau_etude)
                                            <div class="form-group">
                                                <label class="form-label">Niveau d’études (année 2024-2025)</label>
                                                <div style="padding: 10px; background: var(--neutral-50); border-radius: var(--radius); color: var(--neutral-800);">
                                                    {{ ucfirst(str_replace('_', ' ', $candidat->niveau_etude)) }}
                                                </div>
                                            </div>
                                            @endif
                                            @if ($candidat->filiere)
                                            <div class="form-group">
                                                <label class="form-label">Filière</label>
                                                <div style="padding: 10px; background: var(--neutral-50); border-radius: var(--radius); color: var(--neutral-800);">
                                                    {{ ucfirst(str_replace('_', ' ', $candidat->filiere)) }}
                                                </div>
                                            </div>
                                            @endif
                                            @if ($candidat->nom_etablissement_origine)
                                            <div class="form-group">
                                                <label class="form-label">Nom de l’établissement d’origine</label>
                                                <div style="padding: 10px; background: var(--neutral-50); border-radius: var(--radius); color: var(--neutral-800);">
                                                    {{ ucfirst(str_replace('_', ' ', $candidat->nom_etablissement_origine)) }}
                                                </div>
                                            </div>
                                            @endif
                                            @if ($candidat->annee_premier_inscription_premiere_annee)
                                            <div class="form-group">
                                                <label class="form-label">Année de 1ère inscription en 1ère année</label>
                                                <div style="padding: 10px; background: var(--neutral-50); border-radius: var(--radius); color: var(--neutral-800);">
                                                    {{ ucfirst(str_replace('_', ' ', $candidat->annee_premier_inscription_premiere_annee)) }}
                                                </div>
                                            </div>
                                            @endif
                                            @if ($candidat->date_reussite_deug)
                                            <div class="form-group">
                                                <label class="form-label">Date de réussite en D.E.U.G, D.E.U.S.T ou C.E.U.S</label>
                                                <div style="padding: 10px; background: var(--neutral-50); border-radius: var(--radius); color: var(--neutral-800);">
                                                    {{ ucfirst(str_replace('_', ' ', $candidat->date_reussite_deug)) }}
                                                </div>
                                            </div>
                                            @endif
                                            @if ($candidat->moyenne_generale)
                                            <div class="form-group">
                                                <label class="form-label">Moyenne générale des 4 semestres (S1, S2, S3, S4) </label>
                                                <div style="padding: 10px; background: var(--neutral-50); border-radius: var(--radius); color: var(--neutral-800);">
                                                    {{ ucfirst(str_replace('_', ' ', $candidat->moyenne_generale)) }}
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <!-- Motivation -->
                                <div class="card mt-6 animate-fade-in-up" style="animation-delay: 0.4s;">
                                    <div class="card-header">
                                        <h3 class="card-title">💭 Lettre de Motivation</h3>
                                    </div>
                                    <div class="card-body">
                                        <div style="padding: 20px; background: var(--neutral-50); border-radius: var(--radius); border-left: 4px solid var(--primary); line-height: 1.8; color: var(--neutral-700);">
                                            {{ nl2br(htmlspecialchars($candidat->motivation)) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="cin">
                            <div class="pt-4">
                                <iframe src="{{ asset('storage/fichiers/'.$candidat->fichier_cin) }}" frameborder="0"></iframe>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="baccalaureat">
                            <div class="pt-4">
                                <iframe src="{{ asset('storage/fichiers/'.$candidat->fichier_bac) }}" frameborder="0"></iframe>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="deug">
                            <div class="pt-4">
                                <iframe src="{{ asset('storage/fichiers/'.$candidat->fichier_deug) }}" frameborder="0"></iframe>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="relever_notes">
                            <div class="pt-4">
                                <iframe src="{{ asset('storage/fichiers/'.$candidat->fichier_relever_notes) }}" frameborder="0"></iframe>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="fiche_candidature">
                            <div class="pt-4">
                                <iframe src="{{ asset('storage/fichiers/'.$candidat->fichier_fiche_candidature) }}" frameborder="0"></iframe>
                            </div>
                        </div>
                    </div> 
                </div> 
            </div>
        </div>
    </main>
@endsection
@section('scripts')
    <script>
        // Animation des sections
        const sections = document.querySelectorAll('.card');
        sections.forEach((section, index) => {
            section.style.opacity = '0';
            section.style.transform = 'translateY(30px)';
            section.style.transition = 'all 0.6s ease';
            
            setTimeout(() => {
                section.style.opacity = '1';
                section.style.transform = 'translateY(0)';
            }, index * 150);
        });

        // Confirmation pour les actions
        const actionButtons = document.querySelectorAll('button[type="submit"]');
        actionButtons.forEach(button => {
            if (button.textContent.includes('Rejeter')) {
                button.addEventListener('click', function(e) {
                    if (!confirm('Êtes-vous sûr de vouloir rejeter cette candidature ?')) {
                        e.preventDefault();
                    }
                });
            }
        });
    </script>
@endsection