<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\Pack;
use App\Models\Planning;
use App\Models\Promoteur;
use App\Models\Entreprise;
use App\Models\Employe;
use App\Models\ChiffreAffaire;
use App\Models\ChiffreAffaireFirstYear;
use App\Models\ChareExploitation;
use App\Models\Payement;
use App\Models\Imput;
use App\Models\Partenaire;
use App\Models\EquipementProduction;
use App\Models\StructureFinanciere;
use App\Models\ServiceExterieur;
use App\Models\CompteExploitationYear;
use App\Models\CritereProduit;
use App\Models\StrategieMarketing;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PlanAffaire extends Model
{
    use HasUuids;
    use HasFactory;
    protected $guarded = [];

    // Récupérer le pack associé
    public function pack()
    {
        return $this->belongsTo(Pack::class, 'id_pack');
    }

    // Récupérer les activités associées
    public function activities()
    {
        return $this->hasMany(Planning::class, 'id_plan_affaire');
    }

    // Récupérer les promoteurs
    public function promoteurs()
    {
        return $this->hasMany(Promoteur::class, 'id_plan_affaire');
    }

    // Récupérer l'entreprise
    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class, 'id_entreprise');
    }

    // Récupérer les employe
    public function employes()
    {
        return $this->hasMany(Employe::class, 'id_plan_affaire');
    }

    // Récupérer les chiffres d'affaire
    public function chiffre_affaires()
    {
        return $this->hasMany(ChiffreAffaire::class, 'id_plan_affaire');
    }
    // Récupérer les chiffres d'affaire
    public function chiffre_affaire_first_years()
    {
        return $this->hasMany(ChiffreAffaireFirstYear::class, 'id_plan_affaire');
    }

    // Récupérer les charge exploitations
    public function charge_exploitations()
    {
        return $this->hasMany(ChareExploitation::class, 'id_plan_affaire');
    }

    // Récupérer le paiement associé
    public function paiement()
    {
        return $this->belongsTo(Payement::class, 'id_plan_affaire');
    }

    // Récupérer les imputs
    public function imputations()
    {
        return $this->hasMany(Imput::class, 'id_plan_affaire');
    }

    // Récupérer les partenaires
    public function partenaire()
    {
        return $this->hasMany(Partenaire::class, 'id_plan_affaire');
    }

    // Récupérer les equipements
    public function equipement()
    {
        return $this->hasMany(EquipementProduction::class, 'id_plan_affaire');
    }


    // Récupérer les structures financieres
    public function structureFinanciere()
    {
        return $this->hasMany(StructureFinanciere::class, 'id_plan_affaire');
    }

    // Récupérer les services exterieurs
    public function serviceExterieur()
    {
        return $this->hasMany(ServiceExterieur::class, 'id_plan_affaire');
    }

    // Récupérer les services exterieurs
    public function compte_exploitation_year()
    {
        return $this->hasMany(CompteExploitationYear::class, 'id_plan_affaire');
    }

    // Récupérer les criteres produits
    public function critere_produits()
    {
        return $this->hasMany(CritereProduit::class, 'id_plan_affaire');
    }

    // Récupérer les strategies marketing
    public function strategie_marketings()
    {
        return $this->hasMany(StrategieMarketing::class, 'id_plan_affaire');
    }
}
