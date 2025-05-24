<?php

namespace App\Models;

use App\Models\User;
use App\Models\Entreprise;
use App\Models\Valeur;
use Illuminate\Database\Eloquent\Model;

class Promoteur extends Model
{
    protected $guarded = [];

    /**
     * User who created the valeur.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user_created()
    {
        return $this->belongsTo(User::class, 'id_user_created');
    }

    /**
     * Entreprise of promoteur.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class, 'id_entreprise');
    }

    /**
     * Sexe of promoteur.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sexe()
    {
        return $this->belongsTo(Valeur::class, 'id_sexe');
    }

    /**
     * Situation_famille of promoteur.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function situation_famille()
    {
        return $this->belongsTo(Valeur::class, 'id_situation_famille');
    }


}
