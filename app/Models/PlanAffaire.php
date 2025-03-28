<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\Pack;
use App\Models\Planning;
use App\Models\Promoteur;
use App\Models\Entreprise;

class PlanAffaire extends Model
{
    use HasUuids;
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

    // Récupérer le promoteur
    public function promoteurs()
    {
        return $this->hasMany(Promoteur::class, 'id_plan_affaire');
    }

    // Récupérer l'entreprise
    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class, 'id_entreprise');
    }
}
