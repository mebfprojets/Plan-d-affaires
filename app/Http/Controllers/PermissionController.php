<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;
use \Exception;
use Carbon\Carbon;

class PermissionController extends Controller
{
    public function index()
    {
        if(Auth::user()->can('permissions.index')){
            $permissions = Permission::whereNull('deleted_at')->get();
            return view('backend.permissions.index', compact('permissions'));
        }
        return redirect()->route('admin.dashboard');
    }

    public function create()
    {
        if(Auth::user()->can('permissions.add')){
            return view('backend.permissions.create');
        }
        return redirect()->route('admin.dashboard');
    }

    public function store(Request $request)
    {
        if(Auth::user()->can('permissions.add')){
            $request->validate(['nom_permission' => 'required|unique:permissions,name']);
            try {
                Permission::create([
                    'name' => $request->nom_permission,
                    'libelle' => $request->description,
                    'slug' => Str::slug($request->description, '_'),
                    'guard_name' => auth()->getDefaultDriver(),
                ]);

            } catch (Exception $ex) {
                dd($ex);
            }


            return redirect()->route('permissions.index')->with('success', 'Permission ajoutée avec succès.');
        }
        return redirect()->route('admin.dashboard');
    }

    public function edit(Permission $permission)
    {
        if(Auth::user()->can('permissions.edit')){
            return view('permissions.edit', compact('permission'));
        }
        return redirect()->route('admin.dashboard');
    }

    public function update(Request $request, Permission $permission)
    {
        if(Auth::user()->can('permissions.edit')){
            $request->validate(['name' => 'required|unique:permissions,name,' . $permission->id]);
            $permission->update(['name' => $request->name]);

            return redirect()->route('permissions.index')->with('success', 'Permission mise à jour avec succès.');
        }
        return redirect()->route('admin.dashboard');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->route('permissions.index')->with('success', 'Permission supprimée.');
    }
}
