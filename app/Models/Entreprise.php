<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Engagement;
use App\Models\Structure;

class Entreprise extends Model
{
    protected $guarded = [];

    // Récupérer les engagements
    public function engagements()
    {
        return $this->hasMany(Engagement::class, 'id_entreprise');
    }

    public function region()
    {
        return $this->belongsTo(Structure::class, 'id_region');
    }

    public function province()
    {
        return $this->belongsTo(Structure::class, 'id_province');
    }

    public function commune()
    {
        return $this->belongsTo(Structure::class, 'id_commune');
    }

    public function arrondissement()
    {
        return $this->belongsTo(Structure::class, 'id_arrondissement');
    }
}
