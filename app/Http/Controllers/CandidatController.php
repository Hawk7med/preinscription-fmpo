<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class CandidatController extends Controller
{

    public function add(Request $request){
        // Ajout de la gestion du fichier CIN en session
        if($request->hasFile('fichier_cin')){
            session()->flash('temp_filename_cin', $request->file('fichier_cin')->getClientOriginalName());
        }
        if($request->hasFile('fichier_bac')){
            session()->flash('temp_filename_bac', $request->file('fichier_bac')->getClientOriginalName());
        }
        if($request->hasFile('fichier_deug')){
            session()->flash('temp_fichier_deug', $request->file('fichier_deug')->getClientOriginalName());
        }
        if($request->hasFile('fichier_relever_notes')){
            session()->flash('temp_fichier_relever_notes', $request->file('fichier_relever_notes')->getClientOriginalName());
        }
        if($request->hasFile('fichier_fiche_candidature')){
            session()->flash('temp_fichier_fiche_candidature', $request->file('fichier_fiche_candidature')->getClientOriginalName());
        }
        $request->validate([
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'cin' => 'required|string|max:20|unique:candidats,cin',
            'sexe' => 'required|in:Homme,Femme',
            'email' => 'required|email|max:150|unique:candidats,email',
            'telephone' => 'required|string|regex:/^[0-9]{10,15}$/|unique:candidats,telephone',
            'date_naissance' => 'required|date|before:today',
            'lieu_naissance' => 'required|string|max:150',
            'adresse' => 'required|string|max:255',
            'cne' => 'required|string|max:20|unique:candidats,cne',
            'annee_bac' => 'required|integer|min:1900|max:' . date('Y'),
            'mention_bac' => 'required|string|max:50',
            'serie_bac' => 'required|string|max:100',
            'academie' => 'required|string|max:150',
            'niveau_etude' => 'required|string|max:100',
            'filiere' => 'required|string|max:150',
            'nom_etablissement_origine' => 'required|string|max:150',
            'annee_premier_inscription_premiere_annee' => 'required|integer|min:1900|max:' . date('Y'),
            'date_reussite_deug' => 'nullable|date|before_or_equal:today',
            'moyenne_generale' => 'nullable|numeric|min:0|max:20',
            'motivation' => 'required|string|min:10|max:1000',
            // Ajout de la validation pour le fichier CIN
            'fichier_cin' => 'required|file|mimes:pdf,jpeg,jpg,png|max:2048',
            'fichier_bac' => 'required|file|mimes:pdf,jpeg,jpg,png|max:2048',
            'fichier_deug' => 'required|file|mimes:pdf,jpeg,jpg,png|max:2048',
            'fichier_relever_notes' => 'required|file|mimes:pdf,jpeg,jpg,png|max:2048',
            'fichier_fiche_candidature' => 'required|file|mimes:pdf,jpeg,jpg,png|max:2048',
        ]);
        
        // Ajout de l'enregistrement du fichier CIN
        $fichier_cin = null;
        if($request->hasFile('fichier_cin')){
            $file = $request->file('fichier_cin');
            $fichier_cin = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/fichiers', $fichier_cin);
        }
        $fichier_bac = null;
        if($request->hasFile('fichier_bac')){
            $file = $request->file('fichier_bac');
            $fichier_bac = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/fichiers', $fichier_bac);
        }
        $fichier_deug = null;
        if($request->hasFile('fichier_deug')){
            $file = $request->file('fichier_deug');
            $fichier_deug = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/fichiers', $fichier_deug);
        }
        $fichier_relever_notes = null;
        if($request->hasFile('fichier_relever_notes')){
            $file = $request->file('fichier_relever_notes');
            $fichier_relever_notes = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/fichiers', $fichier_relever_notes);
        }
        $fichier_fiche_candidature = null;
        if($request->hasFile('fichier_fiche_candidature')){
            $file = $request->file('fichier_fiche_candidature');
            $fichier_fiche_candidature = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/fichiers', $fichier_fiche_candidature);
        }

        $candidat = Candidat::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'cin' => $request->cin,
            'sexe' => $request->sexe,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'date_naissance' => $request->date_naissance,
            'lieu_naissance' => $request->lieu_naissance,
            'adresse' => $request->adresse,
            'cne' => $request->cne,
            'annee_bac' => $request->annee_bac,
            'mention_bac' => $request->mention_bac,
            'serie_bac' => $request->serie_bac,
            'academie' => $request->academie,
            'niveau_etude' => $request->niveau_etude,
            'filiere' => $request->filiere,
            'nom_etablissement_origine' => $request->nom_etablissement_origine,
            'annee_premier_inscription_premiere_annee' => $request->annee_premier_inscription_premiere_annee,
            'date_reussite_deug' => $request->date_reussite_deug,
            'moyenne_generale' => $request->moyenne_generale,
            'motivation' => $request->motivation,
            'fichier_cin' => $fichier_cin, // Ajout du champ fichier_cin dans la création
            'fichier_bac' => $fichier_bac,
            'fichier_deug' => $fichier_deug,
            'fichier_relever_notes' => $fichier_relever_notes,
            'fichier_fiche_candidature' => $fichier_fiche_candidature,
            'date_inscription' => date('Y-m-d'),
            'status' => 'En Attente',
        ]);
        $token = uniqid() . '_' . time();

        return redirect()->route('candidats.recu', $candidat->id)->with('success', 'Inscription éffectué avec succés');
    }

    public function recu($id){
        $referer = request()->headers->get('referer');
        $expectedRoute = url('preregistration');
        
        if (!$referer || !str_contains($referer, $expectedRoute)) {
            abort(403, 'Accès non autorisé');
        }
        $candidat = Candidat::findOrFail($id);
        $active = 'home';
        return view('success', compact('candidat', 'active'));
    }

    public function show(){
        $candidats = Candidat::all();
        $en_attente = Candidat::where('status', 'En attente')->get();
        $approuvees = Candidat::where('status', 'Approuvée')->get();
        $rejetees = Candidat::where('status', 'Rejetée')->get();
        return view('admin.dashboard', compact('candidats', 'en_attente', 'approuvees', 'rejetees'));
    }

    public function single($id){
        $candidat = Candidat::findOrFail($id);
        return view('admin.detail_condidat', compact('candidat'));
    }

    public function edit(Request $request, $candidat_id){
        $candidat = Candidat::findOrFail($candidat_id);
        $candidat->update([
            'status' => $request->status
        ]);
        return redirect()->route('candidats.single', $candidat->id)->with('success', 'Candidat modifié avec succés');
    }
    
    public function exportExcel(Request $request){
        $request->validate([
            'status' => 'nullable|in:En Attente,Approuvée,Rejetée,tous'
        ]);

        $status = $request->input('status');
        $fileName = 'candidats_' . date('Y-m-d_H-i-s') . '.xlsx';

        $candidatsQuery = Candidat::query();

        if ($status && $status !== 'tous') {
            $candidatsQuery->where('status', $status);
            $fileName = 'candidats_' . strtolower(str_replace(' ', '_', $status)) . '_' . date('Y-m-d_H-i-s') . '.xlsx';
        }

        $candidats = $candidatsQuery->orderBy('date_inscription', 'desc')->get();

        if ($candidats->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Aucun candidat trouvé avec ce statut.'
            ], 404);
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $titleText = $status && $status !== 'tous' 
            ? "Liste des Candidats - Statut: {$status}" 
            : "Liste de Tous les Candidats";

        $sheet->setCellValue('A1', $titleText);
        // Mise à jour de la cellule fusionnée pour inclure la nouvelle colonne
        $sheet->mergeCells('A1:T1');

        $titleStyle = [
            'font' => [
                'bold' => true,
                'size' => 16,
                'color' => ['rgb' => 'FFFFFF']
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4472C4']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ]
        ];
        $sheet->getStyle('A1')->applyFromArray($titleStyle);
        $sheet->getRowDimension(1)->setRowHeight(30);

        $sheet->setCellValue('A2', 'Date d\'exportation: ' . date('d/m/Y H:i:s'));
        $sheet->setCellValue('A3', 'Nombre total de candidats: ' . $candidats->count());
        // Mise à jour de la cellule fusionnée pour inclure la nouvelle colonne
        $sheet->mergeCells('A2:T2');
        // Mise à jour de la cellule fusionnée pour inclure la nouvelle colonne
        $sheet->mergeCells('A3:T3');

        $headers = [
            'A5' => 'ID',
            'B5' => 'Nom',
            'C5' => 'Prénom',
            'D5' => 'CIN',
            'E5' => 'Sexe',
            'F5' => 'Email',
            'G5' => 'Téléphone',
            'H5' => 'Date Naissance',
            'I5' => 'Lieu Naissance',
            'J5' => 'Adresse',
            'K5' => 'CNE',
            'L5' => 'Année BAC',
            'M5' => 'Mention BAC',
            'N5' => 'Date Inscription',
            'O5' => 'Statut',
            'P5' => 'Motivation',
            // Ajout du nouvel en-tête pour le fichier CIN
            'Q5' => 'Fichier CIN',
            'R5' => 'Fichier BAC',
            'S5' => 'Fichier DEUG',
            'T5' => 'Fichier Relevé'
        ];

        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }

        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF']
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '70AD47']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN
                ]
            ]
        ];
        // Mise à jour de la plage de style pour inclure la nouvelle colonne
        $sheet->getStyle('A5:T5')->applyFromArray($headerStyle);

        $row = 6;
        foreach ($candidats as $candidat) {
            $sheet->setCellValue("A{$row}", $candidat->id);
            $sheet->setCellValue("B{$row}", $candidat->nom);
            $sheet->setCellValue("C{$row}", $candidat->prenom);
            $sheet->setCellValue("D{$row}", $candidat->cin);
            $sheet->setCellValue("E{$row}", $candidat->sexe);
            $sheet->setCellValue("F{$row}", $candidat->email);
            $sheet->setCellValue("G{$row}", $candidat->telephone);
            $sheet->setCellValue("H{$row}", $candidat->date_naissance ? date('d/m/Y', strtotime($candidat->date_naissance)) : '');
            $sheet->setCellValue("I{$row}", $candidat->lieu_naissance);
            $sheet->setCellValue("J{$row}", $candidat->adresse);
            $sheet->setCellValue("K{$row}", $candidat->cne);
            $sheet->setCellValue("L{$row}", $candidat->annee_bac);
            $sheet->setCellValue("M{$row}", $candidat->mention_bac);
            $sheet->setCellValue("N{$row}", $candidat->date_inscription ? date('d/m/Y', strtotime($candidat->date_inscription)) : '');
            $sheet->setCellValue("O{$row}", $candidat->status);
            $sheet->setCellValue("P{$row}", $candidat->motivation);
            // Ajout de la valeur du fichier CIN dans le tableau
            $sheet->setCellValue("Q{$row}", $candidat->fichier_cin ? 'Oui' : 'Non');
            $sheet->setCellValue("R{$row}", $candidat->fichier_bac ? 'Oui' : 'Non');
            $sheet->setCellValue("S{$row}", $candidat->fichier_deug ? 'Oui' : 'Non');
            $sheet->setCellValue("T{$row}", $candidat->fichier_relever_notes ? 'Oui' : 'Non');

            $statusColor = $this->getStatusColor($candidat->status);
            $sheet->getStyle("O{$row}")->applyFromArray([
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => $statusColor]
                ],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
            ]);

            $row++;
        }

        // Mise à jour de la plage de style pour inclure la nouvelle colonne
        $dataRange = "A5:T" . ($row - 1);
        $sheet->getStyle($dataRange)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ]);

        // Mise à jour de la boucle de dimension pour inclure la nouvelle colonne
        foreach (range('A', 'T') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $statsRow = $row + 2;
        $sheet->setCellValue("A{$statsRow}", 'STATISTIQUES:');
        $sheet->getStyle("A{$statsRow}")->applyFromArray(['font' => ['bold' => true, 'size' => 12]]);

        $statsRow++;
        $enAttente = $candidats->where('status', 'En Attente')->count();
        $approuvees = $candidats->where('status', 'Approuvée')->count();
        $rejetees = $candidats->where('status', 'Rejetée')->count();

        $sheet->setCellValue("A{$statsRow}", "En Attente: {$enAttente}");
        $sheet->setCellValue("B{$statsRow}", "Approuvées: {$approuvees}");
        $sheet->setCellValue("C{$statsRow}", "Rejetées: {$rejetees}");

        $writer = new Xlsx($spreadsheet);
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    private function getStatusColor($status){
        switch ($status) {
            case 'En Attente':
                return 'FFC000';
            case 'Approuvée':
                return '70AD47';
            case 'Rejetée':
                return 'E74C3C';
            default:
                return '808080';
        }
    }

    public function getExportStats(){
        $stats = [
            'total' => Candidat::count(),
            'en_attente' => Candidat::where('status', 'En Attente')->count(),
            'approuvees' => Candidat::where('status', 'Approuvée')->count(),
            'rejetees' => Candidat::where('status', 'Rejetée')->count(),
        ];

        return response()->json($stats);
    }

    public function preregistration(){
        return view('preregistration');
    }

    public function confirmed_preregistration(Request $request){
        $confirmed = $request->confirmed ? true : false;
        if($confirmed)
            return redirect()->route('preregistration');
        return view('confirmation', compact('confirmed'));
    }

    public function confirme_preregistration(){
        return view('confirmation');
    }
}