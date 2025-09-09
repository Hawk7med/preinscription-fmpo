@extends('layout')
@section('style')
    <style>
        #label_moyenne, #moyennes{
            display: flex;
        }
        #division{
            display: flex;
            flex-direction: column;
            text-align: center;
            margin-top: -7px;
        }
        #division hr{
            margin: 1px;
        }
        #formConfirmation{
            width: 50%;
            margin: 100px auto;
            background: #fff3cd;
            color: #664d03;
            padding: 30px;
            border-radius: 9px;
            box-shadow: 0px 0px 5px lightgrey;
            border: 1px solid #664d033b;
        }
        #formConfirmation button{
            float: right;
        }
        #formConfirmation strong{
            font-size: 20px!important;
            margin-bottom: 10px!important;
            display: block;
        }
        #formConfirmation p{
            text-align: justify;
            margin-bottom: 50px;
        }
    </style>
@endsection
@section('content')
    <!-- Header -->
    @php
        $active = 'preinscription';
        @endphp
    @include('partials.navbar')
    <!-- Main Content -->
    <main style="flex: 1; padding: 40px 0;">
        <div class="container">
            <div style="max-width: 800px; margin: 0 auto;">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
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
                <div class="card animate-fade-in-up">
                    <div class="card-header text-center">
                        <h1 class="card-title" style="font-size: 28px; color: var(--primary);">
                                Formulaire de Pré-inscription
                        </h1>
                        <p class="card-subtitle">
                            Veuillez remplir tous les champs requis pour votre pré-inscription
                        </p>
                    </div>
                    
                    <div class="card-body">
                        {{ old('fichier_bac') }}
                        <form action="{{ route('candidats.add') }}" method="POST" enctype="multipart/form-data" id="preregistrationForm">
                            @csrf
                            <!-- Informations Personnelles -->
                            <fieldset style="border: none; margin-bottom: 32px;">
                                <legend style="font-size: 20px; font-weight: 700; color: var(--neutral-800); margin-bottom: 24px; padding: 0;">
                                    👤 Informations Personnelles
                                </legend>
                                
                                <div class="grid grid-2">
                                    <div class="form-group">
                                        <label for="nom" class="form-label">Nom *</label>
                                        <input type="text" id="nom" name="nom" class="form-control @error('nom') is-invalid @enderror"  value="{{ old('nom') }}">
                                        @error('nom')
                                        <span class="invalid-feedback" role="alert" style="color:#F44336;">
                                        <i class="fa fa-warning"></i> <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="prenom" class="form-label">Prénom *</label>
                                        <input type="text" id="prenom" name="prenom" class="form-control @error('prenom') is-invalid @enderror"  value="{{ old('prenom') }}">
                                        @error('prenom')
                                        <span class="invalid-feedback" role="alert" style="color:#F44336;">
                                        <i class="fa fa-warning"></i> <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="grid grid-2">
                                    <div class="form-group">
                                        <label for="cin" class="form-label">CIN *</label>
                                        <input type="cin" id="cin" name="cin" class="form-control @error('cin') is-invalid @enderror"  value="{{ old('cin') }}">
                                        @error('cin')
                                        <span class="invalid-feedback" role="alert" style="color:#F44336;">
                                        <i class="fa fa-warning"></i> <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        <small class="form-text text-muted" style="color:#555;">
            📄 La copie de la CIN doit être <strong>photocopiée et légalisée</strong>.
        </small>
                                    </div>

                                    <div class="form-group">
                                        <label for="sexe" class="form-label">Sexe *</label>
                                        <select id="sexe" name="sexe" class="form-control @error('sexe') is-invalid @enderror">
                                            <option value="">-- Sélectionnez votre sexe --</option>
                                            <option value="Homme" {{ old('sexe') == 'Homme' ? 'selected' : '' }}>Homme</option>
                                            <option value="Femme" {{ old('sexe') == 'Femme' ? 'selected' : '' }}>Femme</option>
                                        </select>
                                        @error('sexe')
                                        <span class="invalid-feedback" role="alert" style="color:#F44336;">
                                        <i class="fa fa-warning"></i> <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="email" class="form-label">Email *</label>
                                        <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror"  value="{{ old('email') }}">
                                        @error('email')
                                        <span class="invalid-feedback" role="alert" style="color:#F44336;">
                                        <i class="fa fa-warning"></i> <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="telephone" class="form-label">Téléphone *</label>
                                        <input type="tel" id="telephone" name="telephone" class="form-control @error('telephone') is-invalid @enderror"  value="{{ old('telephone') }}">
                                        @error('telephone')
                                        <span class="invalid-feedback" role="alert" style="color:#F44336;">
                                        <i class="fa fa-warning"></i> <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="grid grid-2">
                                    <div class="form-group">
                                        <label for="date_naissance" class="form-label">Date de naissance *</label>
                                        <input type="date" id="date_naissance" name="date_naissance" class="form-control @error('date_naissance') is-invalid @enderror"  value="{{ old('date_naissance') }}">
                                        @error('date_naissance')
                                        <span class="invalid-feedback" role="alert" style="color:#F44336;">
                                        <i class="fa fa-warning"></i> <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="lieu_naissance" class="form-label">Lieu de naissance *</label>
                                        <input type="text" id="lieu_naissance" name="lieu_naissance" class="form-control @error('lieu_naissance') is-invalid @enderror"  value="{{ old('lieu_naissance') }}">
                                        @error('lieu_naissance')
                                        <span class="invalid-feedback" role="alert" style="color:#F44336;">
                                        <i class="fa fa-warning"></i> <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="adresse" class="form-label">Adresse complète *</label>
                                    <textarea id="adresse" name="adresse" class="form-textarea @error('adresse') is-invalid @enderror"  placeholder="Numéro, rue, ville, code postal...">{{ old('adresse') }}</textarea>
                                    @error('adresse')
                                    <span class="invalid-feedback" role="alert" style="color:#F44336;">
                                    <i class="fa fa-warning"></i> <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </fieldset>

                            <!-- Informations Baccalauréat  -->
                            <fieldset style="border: none; margin-bottom: 32px;">
                                <legend style="font-size: 20px; font-weight: 700; color: var(--neutral-800); margin-bottom: 24px; padding: 0;">
                                    🎓 Informations Baccalauréat 
                                </legend>
                                
                                <div class="grid grid-2">
                                    <div class="form-group">
                                        <label for="cin" class="form-label">CNE *</label>
                                        <input type="cne" id="cne" name="cne" class="form-control @error('cne') is-invalid @enderror"  value="{{ old('cne') }}">
                                        @error('cne')
                                        <span class="invalid-feedback" role="alert" style="color:#F44336;">
                                        <i class="fa fa-warning"></i> <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="annee_bac" class="form-label">Année d’obtention du baccalauréat *</label>
                                        <input type="number" id="annee_bac" name="annee_bac" class="form-control @error('annee_bac') is-invalid @enderror"  value="{{ old('annee_bac') }}">
                                        @error('annee_bac')
                                        <span class="invalid-feedback" role="alert" style="color:#F44336;">
                                        <i class="fa fa-warning"></i> <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="mention_bac" class="form-label">Mention du Bac</label>
                                        <select id="mention_bac" name="mention_bac" class="form-control @error('mention_bac') is-invalid @enderror" value="{{ old('mention_bac') }}">
                                            <option value="">Sélectionnez une mention</option>
                                            <option value="passable">Passable</option>
                                            <option value="assez_bien">Assez Bien</option>
                                            <option value="bien">Bien</option>
                                            <option value="tres_bien">Très Bien</option>
                                            <option value="excellent">Excellent</option>
                                        </select>
                                        @error('mention_bac')
                                        <span class="invalid-feedback" role="alert" style="color:#F44336;">
                                        <i class="fa fa-warning"></i> <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="serie_bac" class="form-label">Série du bac *</label>
                                        <input type="text" id="serie_bac" name="serie_bac" class="form-control @error('serie_bac') is-invalid @enderror"  value="{{ old('serie_bac') }}" />
                                        @error('serie_bac')
                                        <span class="invalid-feedback" role="alert" style="color:#F44336;">
                                        <i class="fa fa-warning"></i> <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="academie" class="form-label">Académie *</label>
                                        <input type="text" id="academie" name="academie" class="form-control @error('academie') is-invalid @enderror" value="{{ old('academie') }}" />
                                        @error('academie')
                                        <span class="invalid-feedback" role="alert" style="color:#F44336;">
                                        <i class="fa fa-warning"></i> <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </fieldset>

                            <!-- Informations Post-Baccalauréat   -->
                            <fieldset style="border: none; margin-bottom: 32px;">
                                <legend style="font-size: 20px; font-weight: 700; color: var(--neutral-800); margin-bottom: 24px; padding: 0;">
                                    🎓 Informations Post-Baccalauréat  
                                </legend>
                                
                                <div class="grid grid-2">
                                    <div class="form-group">
                                        <label for="niveau_etude" class="form-label">Niveau d’études (année 2024-2025)  *</label>
                                        <input type="text" id="niveau_etude" name="niveau_etude" class="form-control @error('niveau_etude') is-invalid @enderror"  value="{{ old('niveau_etude') }}">
                                        @error('niveau_etude')
                                        <span class="invalid-feedback" role="alert" style="color:#F44336;">
                                        <i class="fa fa-warning"></i> <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="filiere" class="form-label">Filière  *</label>
                                        <input type="text" id="filiere" name="filiere" class="form-control @error('filiere') is-invalid @enderror"  value="{{ old('filiere') }}">
                                        @error('filiere')
                                        <span class="invalid-feedback" role="alert" style="color:#F44336;">
                                        <i class="fa fa-warning"></i> <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="nom_etablissement_origine" class="form-label">Nom de l’établissement d’origine </label>
                                        <input type="text" id="nom_etablissement_origine" name="nom_etablissement_origine" class="form-control @error('nom_etablissement_origine') is-invalid @enderror" value="{{ old('nom_etablissement_origine') }}">
                                        @error('nom_etablissement_origine')
                                        <span class="invalid-feedback" role="alert" style="color:#F44336;">
                                        <i class="fa fa-warning"></i> <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="annee_premier_inscription_premiere_annee" class="form-label">Année de 1ère inscription en 1ère année  *</label>
                                        <input type="number" id="annee_premier_inscription_premiere_annee" name="annee_premier_inscription_premiere_annee" class="form-control @error('annee_premier_inscription_premiere_annee') is-invalid @enderror"  value="{{ old('annee_premier_inscription_premiere_annee') }}" />
                                        @error('annee_premier_inscription_premiere_annee')
                                        <span class="invalid-feedback" role="alert" style="color:#F44336;">
                                        <i class="fa fa-warning"></i> <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="date_reussite_deug" class="form-label">Date de réussite en D.E.U.G, D.E.U.S.T ou C.E.U.S  *</label>
                                        <input type="date" id="date_reussite_deug" name="date_reussite_deug" class="form-control @error('date_reussite_deug') is-invalid @enderror" value="{{ old('date_reussite_deug') }}" />
                                        @error('date_reussite_deug')
                                        <span class="invalid-feedback" role="alert" style="color:#F44336;">
                                        <i class="fa fa-warning"></i> <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Moyenne générale des 4 semestres (S1, S2, S3, S4) 
                                            <a style="float: right;border-radius: 50%;padding: 2px;width: 25px;height: 25px;line-height: 16px;" class="btn btn-rounded btn-outline-primary" 
                                                tabindex="0"
                                                role="button"
                                                data-bs-toggle="popover" 
                                                data-bs-trigger="focus" 
                                                data-bs-html="true"
                                                title="Méthode de calcule"
                                                data-bs-content="<span id='moyennes'><span id='division'><span id='nominateur'>[m1+m2+m3+m4]</span><hr><span id='denominateur'>20</span></span><span id='resultat'>= ………../20</span></span>">
                                                <span class="fa fa-info"></span>
                                            </a>
                                        </label>
                                        <input type="text" id="moyenne_generale" name="moyenne_generale" class="form-control @error('moyenne_generale') is-invalid @enderror" value="{{ old('moyenne_generale') }}" />
                                        @error('moyenne_generale')
                                        <span class="invalid-feedback" role="alert" style="color:#F44336;">
                                        <i class="fa fa-warning"></i> <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </fieldset>

                            <!-- Documents -->
                            <fieldset style="border: none; margin-bottom: 32px;">
                                <legend style="font-size: 20px; font-weight: 700; color: var(--neutral-800); margin-bottom: 24px; padding: 0;">
                                    📎 Documents Requis
                                </legend>

                                <div class="form-group">
                                    <label for="cin_file" class="form-label">Copie de la CIN légalisée *</label>
                                    <div class="file-upload @error('fichier_cin') is-invalid @enderror" onclick="document.getElementById('cin_file').click()">
                                        <div class="file-upload-icon">📄</div>
                                        <div class="file-upload-text">Cliquez pour télécharger votre CIN</div>
                                        <div class="file-upload-subtext">PDF, JPG ou PNG - Max 2MB</div>
                                    </div>
                                    <input type="file" id="cin_file" name="fichier_cin" accept=".pdf,.jpg,.jpeg,.png" style="display: none;">
                                    <div id="cin_file-preview"></div>
                                    @if(session('temp_fichier_cin'))
                                        <span class="invalid-file" role="alert" style="color:#F44336;">
                                            <i class="fa fa-warning"></i> <strong>Veuillez sélectionner à nouveau votre fichier.</strong>
                                        </span>
                                    @endif
                                    @error('fichier_cin')
                                        <span class="invalid-feedback" role="alert" style="color:#F44336;">
                                            <i class="fa fa-warning"></i> <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="baccalaureat" class="form-label">Copie du Baccalauréat légalisée*</label>
                                    <div class="file-upload @error('fichier_bac') is-invalid @enderror" onclick="document.getElementById('baccalaureat').click()">
                                        <div class="file-upload-icon">📜</div>
                                        <div class="file-upload-text">Cliquez pour télécharger votre Baccalauréat</div>
                                        <div class="file-upload-subtext">PDF, JPG ou PNG - Max 2MB</div>
                                    </div>
                                    <input type="file" id="baccalaureat" name="fichier_bac" accept=".pdf,.jpg,.jpeg,.png" style="display: none;">
                                    {{-- Afficher le nom du fichier existant s'il y en a un --}}
                                    <div id="baccalaureat-preview"></div>
                                    @if(session('temp_filename_bac'))
                                        <span class="invalid-file" role="alert" style="color:#F44336;">
                                            <i class="fa fa-warning"></i> <strong>Veuillez sélectionner à nouveau votre fichier.</strong>
                                        </span>
                                    @endif
                                    @error('fichier_bac')
                                        <span class="invalid-feedback" role="alert" style="color:#F44336;">
                                            <i class="fa fa-warning"></i> <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="deug" class="form-label">Copie du DEUG légalisée (si applicable)</label>
                                    <div class="file-upload @error('fichier_deug') is-invalid @enderror" onclick="document.getElementById('deug').click()">
                                        <div class="file-upload-icon">🎓</div>
                                        <div class="file-upload-text">Cliquez pour télécharger votre DEUG</div>
                                        <div class="file-upload-subtext">PDF, JPG ou PNG - Max 2MB</div>
                                    </div>
                                    <input type="file" id="deug" name="fichier_deug" accept=".pdf,.jpg,.jpeg,.png" style="display: none;">
                                    <div id="deug-preview"></div>
                                    @if(session('temp_fichier_deug'))
                                        <span class="invalid-file" role="alert" style="color:#F44336;">
                                            <i class="fa fa-warning"></i> <strong>Veuillez sélectionner à nouveau votre fichier.</strong>
                                        </span>
                                    @endif
                                    @error('fichier_deug')
                                    <span class="invalid-feedback" role="alert" style="color:#F44336;">
                                    <i class="fa fa-warning"></i> <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="releve_notes" class="form-label">Relevé de notes  *</label>
                                    <div class="file-upload @error('fichier_relever_notes') is-invalid @enderror" onclick="document.getElementById('releve_notes').click()">
                                        <div class="file-upload-icon">📊</div>
                                        <div class="file-upload-text">Cliquez pour télécharger votre relevé de notes</div>
                                        <div class="file-upload-subtext">PDF, JPG ou PNG - Max 2MB</div>
                                    </div>
                                    <input type="file" id="releve_notes" name="fichier_relever_notes" accept=".pdf,.jpg,.jpeg,.png" style="display: none;">
                                    <div id="releve_notes-preview"></div>
                                    @if(session('temp_fichier_relever_notes'))
                                        <span class="invalid-file" role="alert" style="color:#F44336;">
                                            <i class="fa fa-warning"></i> <strong>Veuillez sélectionner à nouveau votre fichier.</strong>
                                        </span>
                                    @endif
                                    @error('fichier_relever_notes')
                                    <span class="invalid-feedback" role="alert" style="color:#F44336;">
                                    <i class="fa fa-warning"></i> <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="fiche_candidature" class="form-label">Fiche de candidature *</label>
                                    <div class="file-upload @error('fichier_fiche_candidature') is-invalid @enderror" onclick="document.getElementById('fiche_candidature').click()">
                                        <div class="file-upload-icon">📊</div>
                                        <div class="file-upload-text">Cliquez pour télécharger votre fiche de candidature</div>
                                        <div class="file-upload-subtext">PDF, JPG ou PNG - Max 2MB</div>
                                    </div>
                                    <input type="file" id="fiche_candidature" name="fichier_fiche_candidature" accept=".pdf,.jpg,.jpeg,.png" style="display: none;">
                                    <div id="fiche_candidature-preview"></div>
                                    @if(session('temp_fichier_fiche_candidature'))
                                        <span class="invalid-file" role="alert" style="color:#F44336;">
                                            <i class="fa fa-warning"></i> <strong>Veuillez sélectionner à nouveau votre fichier.</strong>
                                        </span>
                                    @endif
                                    @error('fichier_fiche_candidature')
                                    <span class="invalid-feedback" role="alert" style="color:#F44336;">
                                    <i class="fa fa-warning"></i> <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </fieldset>

                            <!-- Motivation -->
                            <fieldset style="border: none; margin-bottom: 32px;">
                                <legend style="font-size: 20px; font-weight: 700; color: var(--neutral-800); margin-bottom: 24px; padding: 0;">
                                        Motivation
                                </legend>
                                
                                <div class="form-group">
                                    <label for="motivation" class="form-label">Lettre de motivation *</label>
                                    <textarea id="motivation" name="motivation" class="form-textarea @error('motivation') is-invalid @enderror"  
                                            placeholder="Expliquez vos motivations pour intégrer cette formation..." 
                                            style="min-height: 150px;">{{ old('motivation') }}</textarea>
                                    @error('motivation')
                                    <span class="invalid-feedback" role="alert" style="color:#F44336;">
                                    <i class="fa fa-warning"></i> <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </fieldset>
                            
                            <div class="form-check mt-4">
                                <input class="form-check-input" type="checkbox" id="acceptation" name="acceptation" >
                                <label class="form-check-label" for="acceptation">
                                    Je confirme que les informations fournies sont exactes et je m'engage à joindre les pièces justificatives nécessaires.
                                </label>
                            </div>
                            <br>
                            <!-- Submit -->
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary" style="font-size: 18px; padding: 16px 48px;">
                                        Soumettre ma pré-inscription
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('scripts')

    <script>
        // Gestion des uploads de fichiers avec preview
        function setupFileUpload(inputId) {
            const input = document.getElementById(inputId);
            console.log(inputId)
            const preview = document.getElementById(inputId + '-preview');
            const uploadArea = input.parentElement.querySelector('.file-upload');

            input.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const fileSize = (file.size / 1024 / 1024).toFixed(2);
                    preview.innerHTML = `
                        <div class="document-preview">
                            <div class="document-icon">📄</div>
                            <div class="document-info">
                                <h4>${file.name}</h4>
                                <p>${fileSize} MB</p>
                            </div>
                        </div>
                    `;
                    uploadArea.style.borderColor = 'var(--success)';
                    uploadArea.style.background = 'rgba(16, 185, 129, 0.05)';
                }
            });

            // Drag and drop
            uploadArea.addEventListener('dragover', function(e) {
                e.preventDefault();
                uploadArea.classList.add('dragover');
            });

            uploadArea.addEventListener('dragleave', function(e) {
                e.preventDefault();
                uploadArea.classList.remove('dragover');
            });

            uploadArea.addEventListener('drop', function(e) {
                e.preventDefault();
                uploadArea.classList.remove('dragover');
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    input.files = files;
                    input.dispatchEvent(new Event('change'));
                }
            });
        }

        // Initialiser les uploads
        setupFileUpload('baccalaureat');
        setupFileUpload('deug');
        setupFileUpload('releve_notes');
        setupFileUpload('fiche_candidature');
        setupFileUpload('cin_file');

        // Validation en temps réel
        const form = document.getElementById('preregistrationForm');
        const inputs = form.querySelectorAll('input[], select[], textarea[]');

        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                if (this.value.trim() === '') {
                    this.classList.add('error');
                } else {
                    this.classList.remove('error');
                }
            });

            input.addEventListener('input', function() {
                if (this.value.trim() !== '') {
                    this.classList.remove('error');
                }
            });
        });

        // Animation du formulaire
        const fieldsets = document.querySelectorAll('fieldset');
        fieldsets.forEach((fieldset, index) => {
            fieldset.style.opacity = '0';
            fieldset.style.transform = 'translateY(30px)';
            fieldset.style.transition = 'all 0.6s ease';
            
            setTimeout(() => {
                fieldset.style.opacity = '1';
                fieldset.style.transform = 'translateY(0)';
            }, index * 200);
        });
    </script>
@endsection