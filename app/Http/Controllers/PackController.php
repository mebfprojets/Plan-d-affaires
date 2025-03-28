<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pack;
use App\Models\PackObjectif;
use Illuminate\Support\Str;
use \Exception;

class PackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::user()->can('packs.index')){
            $packs = Pack::whereNull('deleted_at')->get();
            return view('backend.packs.index', compact('packs'));
        }
        return redirect()->route('admin.dashboard');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(Auth::user()->can('packs.add')){
            return view('backend.packs.create');
        }
        return redirect()->route('admin.dashboard');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(Auth::user()->can('packs.add')){
            $request->validate([
                'libelle' => 'required|unique:packs,libelle',
                'cout_pack' => 'required',
            ]);
            try {
                $pack = Pack::create([
                    'id' => Str::uuid(),
                    'libelle' => $request->libelle,
                    'slug' => Str::slug($request->libelle, '_'),
                    'description' => $request->description,
                    'cout_pack' => $request->cout_pack,
                    'id_user_created'=>Auth::user()->id,
                ]);

                // OBJECTIFS DU PACK
                $objectifs_pack = $request->input('objectifs_pack');
                foreach ($objectifs_pack as $index => $obj) {

                    // Enregistrer chaque activité dans la base de données
                    if($obj){
                        PackObjectif::create([
                            'id_pack' => $pack->id,
                            'libelle' => $obj,
                        ]);
                    }

                }

            } catch (Exception $ex) {
                dd($ex);
            }


            return redirect()->route('packs.index')->with('success', 'Pack ajoutée avec succès.');
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
        if(Auth::user()->can('packs.edit')){
            $pack = Pack::find($id);
            return view('backend.packs.edit', compact('pack'));
        }
        return redirect()->route('admin.dashboard');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if(Auth::user()->can('packs.edit')){
            $request->validate([
                'libelle' => 'required|unique:packs,libelle,' . $id,
                'cout_pack' => 'required',
            ]);
            $pack_existe = Pack::where('slug', Str::slug($request->libelle, '_'))->where('id', '!=', $id)->first();
            if($pack_existe){
                return redirect()->back()->with('error', 'Un pack avec le même libellé existe déjà.');
            }

            $pack = Pack::find($id);
            $pack->update([
                'libelle' => $request->libelle,
                'slug' => Str::slug($request->libelle, '_'),
                'description' => $request->description,
                'cout_pack' => $request->cout_pack,
                'id_user_updated'=>Auth::user()->id,
            ]);


            // OBJECTIFS DU PACK
            $removePackObj = PackObjectif::where('id_pack', $pack->id)->delete();
            $objectifs_pack = $request->input('objectifs_pack');
            foreach ($objectifs_pack as $index => $obj) {

                // Enregistrer chaque activité dans la base de données
                if($obj){
                    PackObjectif::create([
                        'id_pack' => $pack->id,
                        'libelle' => $obj,
                    ]);
                }

            }
            return redirect()->route('packs.index')->with('success', 'Pack mise à jour avec succès.');
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
