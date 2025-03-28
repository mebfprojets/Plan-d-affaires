<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\PackObjectif;

class Pack extends Model
{
    use HasUuids;
    protected $guarded = [];

    // Récupérer les objectifs associées
    public function objectifs()
    {
        return $this->hasMany(PackObjectif::class, 'id_pack');
    }
}
