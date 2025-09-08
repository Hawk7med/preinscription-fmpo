@extends('layout')
@section('content')
    @include('partials.navbar')

    <!-- Success Section -->
    <main style="flex: 1; display: flex; align-items: flex-start; justify-content: center; padding: 40px 20px; gap: 40px;">
        
        <!-- Section de confirmation existante -->
        <div style="max-width: 600px; flex: 1;">
            <div class="card animate-fade-in-up">
                <div class="card-body" style="padding: 60px 40px;">
                    <div style="width: 120px; height: 120px; background: linear-gradient(135deg, var(--success) 0%, #10B981 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 32px; color: white; font-size: 48px; animation: pulse 2s infinite;">
                        ✅
                    </div>
                    
                    <h1 style="font-size: 32px; font-weight: 800; color: var(--neutral-800); margin-bottom: 16px; text-align: center;">
                        Pré-inscription Réussie !
                    </h1>
                    
                    <p style="font-size: 18px; color: var(--neutral-600); margin-bottom: 32px; line-height: 1.6; text-align: center;">
                        Votre candidature a été soumise avec succès. Notre équipe pédagogique va examiner votre dossier et vous contactera 
                    </p>
                    
                    <div style="background: var(--neutral-50); border-radius: var(--radius-lg); padding: 24px; margin-bottom: 32px; border: 1px solid var(--neutral-200);">
                        <h3 style="font-size: 16px; font-weight: 600; color: var(--neutral-800); margin-bottom: 16px;">
                            📧 Prochaines étapes
                        </h3>
                        <ul style="text-align: left; color: var(--neutral-600); line-height: 1.8;">
                            <li style="margin-bottom: 8px;">📋 Votre dossier sera examiné par notre équipe</li>
                            <li style="margin-bottom: 8px;">📞 Nous vous contacterons pour la suite du processus</li>
                            <li>🎓 En cas d'acceptation, vous recevrez les informations d'inscription</li>
                        </ul>
                    </div>
                    
                    <div class="flex gap-4 justify-center">
                        <a href="{{ route('candidats.inscription') }}" class="btn btn-primary">
                            🏠 Retour à l'accueil
                        </a>
                        <a href="{{ route('confirme_preregistration') }}" class="btn btn-secondary">
                            📝 Nouvelle pré-inscription
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section Reçu de pré-inscription -->
        <div style="max-width: 500px; flex: 1;">
            <div class="card animate-fade-in-up" style="animation-delay: 0.3s;">
                <div class="card-body" style="padding: 40px 30px;">
                    <div style="text-align: center; margin-bottom: 30px;">
                        <h2 style="font-size: 24px; font-weight: 700; color: var(--neutral-800); margin-bottom: 8px;">
                            📄 Reçu de Pré-inscription
                        </h2>
                        <p style="color: var(--neutral-500); font-size: 14px;">
                            N° Référence: #{{ uniqid() }}
                        </p>
                    </div>

                    <!-- Zone d'impression -->
                    <div id="receipt-content" style="background: white; padding: 30px; border: 2px dashed var(--neutral-300); border-radius: var(--radius-lg); margin-bottom: 24px;">
                        <div id="header" style="display: none;">
                            <div style="display: flex; justify-content: space-between; padding: 20px;">
                                <img src="{{ asset('images/fmpo.png') }}" style="width: 150px; height: 150px;" alt="">
                                <div style="text-align: center">
                                    <h3>Faculté de Médecine et de Pharmacie d'Oujda</h3>
                                    <h3>Université Mohammed Premier</h3>
                                    <h3>Oujda</h3>
                                </div>
                            </div>
                        </div>
                        <div style="text-align: center; margin-bottom: 25px; border-bottom: 1px solid var(--neutral-200); padding-bottom: 20px;">
                            <h3 style="font-size: 20px; font-weight: 700; color: var(--primary); margin-bottom: 5px;">
                                REÇU DE PRÉ-INSCRIPTION
                            </h3>
                            <p style="font-size: 14px; color: var(--neutral-600); margin: 0;">
                                {{ date('d/m/Y à H:i') }}
                            </p>
                        </div>

                        <div style="margin-bottom: 20px;">
                            <h4 style="font-size: 16px; font-weight: 600; color: var(--neutral-800); margin-bottom: 12px; border-bottom: 1px solid var(--neutral-200); padding-bottom: 5px;">
                                👤 Informations Personnelles
                            </h4>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; font-size: 14px;">
                                <div><strong>Nom :</strong> {{ $candidat->nom ?? 'N/A' }}</div>
                                <div><strong>Prénom :</strong> {{ $candidat->prenom ?? 'N/A' }}</div>
                                <div><strong>CIN :</strong> {{ $candidat->cin ?? 'N/A' }}</div>
                                <div><strong>CNE :</strong> {{ $candidat->cne ?? 'N/A' }}</div>
                                <div style="grid-column: span 2;"><strong>Email :</strong> {{ $candidat->email ?? 'N/A' }}</div>
                                <div style="grid-column: span 2;"><strong>Téléphone :</strong> {{ $candidat->telephone ?? 'N/A' }}</div>
                            </div>
                        </div>

                        <div style="margin-bottom: 20px;">
                            <h4 style="font-size: 16px; font-weight: 600; color: var(--neutral-800); margin-bottom: 12px; border-bottom: 1px solid var(--neutral-200); padding-bottom: 5px;">
                                🎓 Formation Étudiée
                            </h4>
                            <div style="font-size: 14px; line-height: 1.6;">
                                <div><strong>Filière :</strong> {{ $candidat->filiere ?? 'N/A' }}</div>
                                <div><strong>Niveau d'étude :</strong> {{ $candidat->niveau_etude ?? 'N/A' }}</div>
                            </div>
                        </div>

                        <div style="margin-bottom: 20px;">
                            <h4 style="font-size: 16px; font-weight: 600; color: var(--neutral-800); margin-bottom: 12px; border-bottom: 1px solid var(--neutral-200); padding-bottom: 5px;">
                                📚 Parcours Académique
                            </h4>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; font-size: 14px;">
                                <div><strong>Série Bac :</strong> {{ $candidat->serie_bac ?? 'N/A' }}</div>
                                <div><strong>Année Bac :</strong> {{ $candidat->annee_bac ?? 'N/A' }}</div>
                                <div><strong>Mention :</strong> {{ $candidat->mention_bac ?? 'N/A' }}</div>
                                <div><strong>Académie :</strong> {{ $candidat->academie ?? 'N/A' }}</div>
                            </div>
                        </div>

                        <div style="background: var(--neutral-50); padding: 15px; border-radius: var(--radius); border: 1px solid var(--neutral-200); text-align: center;">
                            <p style="font-size: 12px; color: var(--neutral-600); margin: 0; line-height: 1.5;">
                                Ce reçu confirme la soumission de votre dossier de pré-inscription.<br>
                                Conservez-le précieusement pour vos démarches.
                            </p>
                        </div>

                        <div id="footer" style="display: none; text-align: center; margin-top: 200px; font-size: 12px;">
                            <p>Faculté de Médecine et de Pharmacie d’Oujda, Hay al Hikma, BP, 4867, Oujda, 60049, Maroc. </p>
                            <p>Tel : 0536531414 ; Fax : 0536531919,Site Web :http://fmpo.ump.ma; E-mail : fmpoujda@ump.ac.ma</p>
                        </div>
                    </div>

                    <!-- Bouton d'impression -->
                    <div style="text-align: center;">
                        <button onclick="printReceipt()" class="btn btn-primary" style="padding: 12px 24px; font-size: 16px;">
                            🖨️ Imprimer le Reçu
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
<script>
// Fonction d'impression simplifiée
function printReceipt() {
    try {
        // Récupérer le contenu du reçu
        var receiptContent = document.getElementById('receipt-content');
        
        if (!receiptContent) {
            alert('Erreur: Contenu du reçu introuvable');
            return;
        }
        
        // Créer le HTML d'impression
        var printHTML = '<!DOCTYPE html><html><head><title>Reçu de Pré-inscription</title><style>';
        printHTML += 'body { font-family: Arial, sans-serif; padding: 20px; color: #333; }';
        printHTML += '.receipt-container { max-width: 800px; margin: 0 auto; padding: 30px; border: 2px solid #000; }';
        printHTML += 'h3 { color: #000; font-size: 18px; margin-bottom: 10px; }';
        printHTML += 'h4 { color: #000; font-size: 14px; margin: 15px 0 8px; border-bottom: 1px solid #000; padding-bottom: 3px; }';
        printHTML += '.info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-bottom: 15px; }';
        printHTML += '.info-grid-full { grid-column: span 2; }';
        printHTML += 'strong { font-weight: bold; }';
        printHTML += '#header { display: block!important; }';
        printHTML += '#footer { display: block!important; }';
        printHTML += '.header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 15px; }';
        printHTML += '.logo { width: 60px; height: 60px; background: #000; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; color: white; font-size: 14px; margin-right: 15px; }';
        printHTML += '</style></head><body><div class="receipt-container">';
        printHTML += receiptContent.innerHTML;
        printHTML += '</div></body></html>';
        
        // Créer nouvelle fenêtre
        var printWindow = window.open('', '_blank');
        if (!printWindow) {
            alert('Veuillez autoriser les pop-ups pour imprimer');
            return;
        }
        
        // Écrire et imprimer
        printWindow.document.write(printHTML);
        printWindow.document.close();
        
        printWindow.onload = function() {
            printWindow.print();
            printWindow.close();
        };
        
    } catch (error) {
        alert('Erreur d\'impression. Veuillez réessayer.');
    }
}

// Animation confetti
function createConfetti() {
    var colors = ['#1E40AF', '#059669', '#EA580C', '#F59E0B'];
    var confettiCount = 30;
    
    for (var i = 0; i < confettiCount; i++) {
        var confetti = document.createElement('div');
        confetti.style.position = 'fixed';
        confetti.style.width = '8px';
        confetti.style.height = '8px';
        confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
        confetti.style.left = Math.random() * 100 + 'vw';
        confetti.style.top = '-10px';
        confetti.style.borderRadius = '50%';
        confetti.style.pointerEvents = 'none';
        confetti.style.zIndex = '9999';
        confetti.style.animation = 'fall ' + (Math.random() * 3 + 2) + 's linear forwards';
        
        document.body.appendChild(confetti);
        
        setTimeout(function(el) {
            return function() { if (el.parentNode) el.parentNode.removeChild(el); };
        }(confetti), 5000);
    }
}

// Ajouter CSS animations
var style = document.createElement('style');
style.textContent = '@keyframes fall { to { transform: translateY(100vh) rotate(360deg); } }';
style.textContent += '@keyframes pulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.05); } }';
style.textContent += '@keyframes fade-in-up { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }';
style.textContent += '.animate-fade-in-up { animation: fade-in-up 0.6s ease-out forwards; }';
style.textContent += '@media (max-width: 1024px) { main { flex-direction: column !important; } main > div { max-width: 600px !important; width: 100% !important; } }';
document.head.appendChild(style);

// Attacher événements
document.addEventListener('DOMContentLoaded', function() {
    var printBtn = document.getElementById('printReceiptBtn');
    if (printBtn) {
        printBtn.onclick = printReceipt;
    }
    
    setTimeout(createConfetti, 500);
});
</script>
@endsection