<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidat extends Model
{
    protected $fillable = [
        'nom',
        'prenom',
        'cin',
        'sexe',
        'email',
        'telephone',
        'date_naissance',
        'lieu_naissance',
        'adresse',
        'cne',
        'annee_bac',
        'mention_bac',
        'serie_bac',
        'academie',
        'niveau_etude',
        'filiere',
        'nom_etablissement_origine',
        'annee_premier_inscription_premiere_annee',
        'date_reussite_deug',
        'moyenne_generale',
        'motivation',
        'fichier_cin',
        'fichier_bac',
        'fichier_deug',
        'fichier_relever_notes',
        'fichier_fiche_candidature',
        'date_inscription',
        'status',
    ];

    public function getNom(){
        return strtoupper($this->nom)." ".ucfirst(strtolower($this->prenom));
    }
}
