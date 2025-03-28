<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Valeur;
use App\Models\Parametre;
use \Exception;

class ValeurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::user()->can('valeurs.index')){
            $valeurs = DB::table('parametres as p')
                        ->join('valeurs as v', 'v.id_parametre', '=', 'p.id')
                        ->select('v.*', 'p.libelle as libelle_parametre')
                        ->whereNull('v.deleted_at')
                        ->get();

            return view('backend.valeurs.index', compact('valeurs'));
        }
        return redirect()->route('admin.dashboard');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(Auth::user()->can('valeurs.add')){
            $parametres = Parametre::whereNull('deleted_at')->get();
            return view('backend.valeurs.create', compact('parametres'));
        }
        return redirect()->route('admin.dashboard');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(Auth::user()->can('valeurs.add')){
            $request->validate([
                'id_parametre'=>'required',
                'nom_valeur' => 'required|unique:valeurs,libelle',
            ]);
            try {
                Valeur::create([
                    'id_parametre' => $request->id_parametre,
                    'libelle' => $request->nom_valeur,
                    'slug' => Str::slug($request->nom_valeur, '_'),
                    'description' => $request->description,
                ]);

            } catch (Exception $ex) {
                dd($ex);
            }
            flash()->addSuccess('Valeur ajoutée avec succès');
            return redirect()->route('valeurs.index');
        }
        return redirect()->route('admin.dashboard');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if(Auth::user()->can('valeurs.edit')){
            $valeur = Valeur::find($id);
            $parametres = Parametre::whereNull('deleted_at')->get();
            return view('backend.valeurs.edit', compact('valeur', 'parametres'));
        }
        return redirect()->route('admin.dashboard');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if(Auth::user()->can('valeurs.edit')){
            $request->validate([
                'id_parametre'=>'required',
                'nom_valeur' => 'required',
            ]);

            $valeur = Valeur::find($id);

            $valeur_exist = Valeur::where('slug', Str::slug($request->nom_valeur, '_'))
                                ->where('id_parametre', $valeur->id_parametre)
                                ->where('id', '!=', $id)
                                ->first();
            if($valeur_exist){
                flash()->addError('Une valeur le même nom du même paramètre exite déjà.');
                return redirect()->back();
            }
            try {
                $valeur = Valeur::find($id);
                $valeur->update([
                    'id_parametre' => $request->id_parametre,
                    'libelle' => $request->nom_valeur,
                    'slug' => Str::slug($request->nom_valeur, '_'),
                    'description' => $request->description,
                ]);

            } catch (Exception $ex) {
                dd($ex);
            }
            flash()->addSuccess('Valeur modifiée avec succès');
            return redirect()->route('valeurs.index');
        }
        return redirect()->route('admin.dashboard');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
