<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use \Exception;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::user()->can('roles.index')){
            $roles = Role::whereNull('deleted_at')->get();
            return view('backend.roles.index', compact('roles'));
        }
        return redirect()->route('admin.dashboard');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(Auth::user()->can('roles.add')){
            $permissions = Permission::whereNull('deleted_at')->get();
            return view('backend.roles.create', compact('permissions'));
        }
        return redirect()->route('admin.dashboard');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(Auth::user()->can('roles.add')){
            $request->validate([
                'nom_role'=>'required|unique:roles,name',
                'permissions'=>'required|array',
            ]);

            try {
                $role = Role::create([
                    'name'=>$request->nom_role,
                    'slug'=>Str::slug($request->nom_role, '_'),
                    'guard_name'=>auth()->getDefaultDriver(),
                    'description'=>$request->description,
                    'id_user_created'=>Auth::user()->id,
                ]);
                $role->syncPermissions($request->permissions);
            } catch (Exception $ex) {
                dd($ex);
            }
            flash()->addSuccess('Rôle ajouté avec succès.');
            return redirect()->route('roles.index');
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
        if(Auth::user()->can('roles.edit')){
            $role = Role::find($id);
            $permissions = Permission::whereNull('deleted_at')->get();
            return view('backend.roles.edit', compact('role', 'permissions'));
        }
        return redirect()->route('admin.dashboard');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if(Auth::user()->can('roles.edit')){
            $request->validate([
                'nom_role'=>'required',
                'permissions'=>'required|array',
            ]);

            try {
                $role_exist = Role::where('id', '!=', $id)->where('slug', Str::slug($request->nom_role, '_'))->first();
                if($role_exist){
                    flash()->addError('Un rôle avec le même nom existe déjà.');
                    return redirect()->back();
                }
                $role = Role::find($id);
                $role->update([
                    'name'=>$request->nom_role,
                    'slug'=>Str::slug($request->nom_role, '_'),
                    'guard_name'=>$request->guard_name,
                    'description'=>$request->description,
                    'id_user_updated'=>Auth::user()->id,
                ]);
                $role->syncPermissions($request->permissions);
            } catch (Exception $ex) {
                dd($ex);
            }
            flash()->addSuccess('Rôle modifié avec succès.');
            return redirect()->route('roles.index');
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
