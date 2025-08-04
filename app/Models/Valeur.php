<?php

namespace App\Models;

use App\Models\User;
use App\Models\Parametre;
use App\Models\ChareExploitation;
// use App\Traits\TracksUserActions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Valeur extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];


    /**
     * Parent linked to the valeur.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Valeur::class, 'id_parent', 'id');
    }

    /**
     * Children linked to the valeur.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(Valeur::class, 'id_parent', 'id');
    }

    /**
     * All the parents of the valeur.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function allParents()
    {
        $valeurs = new Collection();
        $valeur = $this;
        while ($valeur->parent) {
            $valeur = $valeur->parent;
            $valeurs->push($valeur);
        }

        return $valeurs;
    }

    /**
     * All the children of the valeur.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function allChildrens()
    {
        $valeurs = new Collection();
        $valeur = $this;
        while ($valeur->children) {
            $valeur = $valeur->children;
            $valeurs->push($valeur);
        }

        return $valeurs;
    }

    /**
     * Parametre linked to the valeur.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parametre()
    {
        return $this->belongsTo(Parametre::class, 'id_parametre');
    }

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
     * User who updated the valeur.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user_updated()
    {
        return $this->belongsTo(User::class, 'id_user_updated');
    }

    /**
     * User who deleted the valeur.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user_deleted()
    {
        return $this->belongsTo(User::class, 'id_user_deleted');
    }

    /**
     * User who deleted the valeur.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function charge_exploitations()
    {
        return $this->hasMany(ChareExploitation::class, 'id_valeur');
    }
}
