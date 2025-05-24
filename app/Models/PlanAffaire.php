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

    // Récupérer le paiement associé
    public function paiement()
    {
        return $this->belongsTo(Payement::class, 'id_plan_affaire');
    }
}
