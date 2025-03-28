<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Parametre;
use Illuminate\Support\Str;
use \Exception;


class ParametreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::user()->can('parametres.index')){
            $parametres = Parametre::whereNull('deleted_at')->get();
            return view('backend.parametres.index', compact('parametres'));
        }
        return redirect()->route('admin.dashboard');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(Auth::user()->can('parametres.add')){
            return view('backend.parametres.create');
        }
        return redirect()->route('admin.dashboard');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(Auth::user()->can('parametres.add')){
            $request->validate(['nom_parametre' => 'required|unique:parametres,libelle']);
            try {
                Parametre::create([
                    'libelle' => $request->nom_parametre,
                    'slug' => Str::slug($request->nom_parametre, '_'),
                    'description' => $request->description,
                ]);

            } catch (Exception $ex) {
                dd($ex);
            }
            flash()->addSuccess('Paramètre ajouté avec succès.');
            return redirect()->route('parametres.index');
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
        if(Auth::user()->can('parametres.edit')){
            $parametre = Parametre::find($id);
            return view('backend.parametres.edit', compact('parametre'));
        }
        return redirect()->route('admin.dashboard');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if(Auth::user()->can('parametres.edit')){
            $request->validate(['nom_parametre' => 'required']);
            $parametre_exist = Parametre::where('slug', Str::slug($request->nom_parametre, '_'))->where('id', '!=', $id)->first();
            if($parametre_exist){
                flash()->addError('Un parmètre le même nom exite déjà.');
                return redirect()->back();
            }
            try {
                $parametre = Parametre::find($id);
                $parametre->update([
                    'libelle' => $request->nom_parametre,
                    'slug' => Str::slug($request->nom_parametre, '_'),
                    'description' => $request->description,
                ]);

            } catch (Exception $ex) {
                dd($ex);
            }
            flash()->addSuccess('Paramètre modifié avec succès.');
            return redirect()->route('parametres.index');
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
