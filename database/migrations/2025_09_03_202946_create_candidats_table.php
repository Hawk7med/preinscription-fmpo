<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('candidats', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('cin');
            $table->string('sexe');
            $table->string('email');
            $table->string('telephone');
            $table->date('date_naissance');
            $table->string('lieu_naissance');
            $table->text('adresse');
            $table->string('cne');
            $table->integer('annee_bac');
            $table->string('mention_bac');
            $table->string('serie_bac');
            $table->string('academie');
            $table->string('niveau_etude');
            $table->string('filiere');
            $table->string('nom_etablissement_origine');
            $table->integer('annee_premier_inscription_premiere_annee');
            $table->date('date_reussite_deug');
            $table->double('moyenne_generale');
            $table->string('motivation');
            $table->string('fichier_bac');
            $table->string('fichier_deug');
            $table->string('fichier_relever_notes');
            $table->string('fichier_fiche_candidature');
            $table->date('date_inscription');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidats');
    }
};
