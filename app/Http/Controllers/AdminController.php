<?php

namespace App\Http\Controllers;

use App\Models\FormationClient;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Admin;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::user()->can('admins.index')){
            $admins = Admin::whereNull('deleted_at')->get();
            return view('backend.admins.index', compact('admins'));
        }
        return redirect()->route('admin.dashboard');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(Auth::user()->can('admins.add')){
            $roles = Role::whereNull('deleted_at')->get();
            return view('backend.admins.create', compact('roles'));
        }
        return redirect()->route('admin.dashboard');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(Auth::user()->can('admins.add')){
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:admins,email',
                'password' => 'required|min:6|confirmed',
                'roles' => 'array'
            ]);

            try{
                $statut = false;
                if($request->statut == 1){
                    $statut = true;
                }
                $admin = Admin::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'statut' => $statut,
                    'password' => bcrypt($request->password)
                ]);

                // $admin->syncRoles($request->roles);
                $roles = Role::whereIn('name', $request->roles)->get();
                $admin->syncRoles($roles);

            }
            catch(Exception $e){
                Log::error('Erreur lors de la création d\'un utilisateur : '.$e->getMessage());
                flash()->addError('Impossible de créer cet utilisateur !');
                return redirect()->route('admins.index');
            }
            flash()->addSuccess('Utilisateur ajouté avec succès.');
            return redirect()->route('admins.index');
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
        if(Auth::user()->can('admins.edit')){
            $admin = Admin::find($id);
            $roles = Role::whereNull('deleted_at')->get();
            return view('backend.admins.edit', compact('admin', 'roles'));
        }
        return redirect()->route('admin.dashboard');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if(Auth::user()->can('admins.edit')){
            $request->validate([
                'name' => 'required',
                'email' => 'required',
                'roles' => 'array'
            ]);

            $admin_exist = Admin::where('email', $request->email)->where('id', '!=', $id)->first();
            if($admin_exist){
                flash()->addError('Un utilisateur la même email exite déjà.');
                return redirect()->back();
            }


            try{
                $statut = false;
                if($request->statut == 1){
                    $statut = true;
                }

                $admin = Admin::find($id);
                $admin->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'statut' => $statut,
                ]);

                // $admin->syncRoles($request->roles);
                // $admin->assignRole($request->roles);
                $roles = Role::whereIn('name', $request->roles)->get();
                $admin->syncRoles($roles);


            }
            catch(Exception $e){
                Log::error('Erreur lors de la création d\'un utilisateur : '.$e->getMessage());
                flash()->addError('Impossible de créer cet utilisateur !');
                return redirect()->route('admins.index');
            }
            flash()->addSuccess('Utilisateur modifié avec succès.');
            return redirect()->route('admins.index');
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
