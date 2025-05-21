<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Admin;
use App\Models\Parametre;
use App\Models\Valeur;
use App\Models\Pack;
use App\Models\PlanAffaire;
use \Exception;
use Carbon\Carbon;

class BackendController extends Controller
{
    /**
     * Dashboard
     */
    public function dashboard()
    {
        /*$manageUsers = Permission::create([
            'name' => 'admin.add',
            'slug' => 'admin_add',
            'libelle' => 'Ajouter un utilisateur',
        ]);
        $viewDashboard = Permission::create([
            'name' => 'admin.edit',
            'slug' => 'admin_edit',
            'libelle' => 'Modifier un utilisateur',
        ]);*/

        // Création des rôles
        // $superadmin = Role::create(['name' => 'Super admin']);
        // $superadmin = Role::find(1);
        // $permissions = Permission::all();
        // $superadmin->givePermissionTo($permissions);
        // $admin = Admin::find(Auth::user()->id);
        // $admin->assignRole($superadmin);

        return view('backend.back');
    }

    /**
     * Delete ligne
     */
    public function deleteLigne(Request $request)
    {
            $id_ligne = $request->id_ligne;
            $table_name = $request->table_name;

            try {
                switch ($table_name) {
                    case 'permission':
                        if(Auth::user()->can('permissions.delete')){
                            $permission = Permission::find($id_ligne);
                            $permission->deleted_at = Carbon::now();
                            $permission->id_user_deleted = Auth::user()->id;
                            $permission->save();
                        }else{
                            return redirect()->route('admin.dashboard')->with('error', 'Vous n\'aviez pas le droit de supprimer cette ligne');
                        }
                        break;
                    case 'role':
                        if(Auth::user()->can('roles.delete')){
                            $role = Role::find($id_ligne);
                            $role->deleted_at = Carbon::now();
                            $role->id_user_deleted = Auth::user()->id;
                            $role->save();
                        }else{
                            return redirect()->route('admin.dashboard')->with('error', 'Vous n\'aviez pas le droit de supprimer cette ligne');
                        }
                        break;
                    case 'admin':
                        if(Auth::user()->can('admins.delete')){
                            $admin = Admin::find($id_ligne);
                            $admin->deleted_at = Carbon::now();
                            $admin->id_user_deleted = Auth::user()->id;
                            $admin->save();
                        }else{
                            return redirect()->route('admin.dashboard')->with('error', 'Vous n\'aviez pas le droit de supprimer cette ligne');
                        }
                        break;
                    case 'parametre':
                        if(Auth::user()->can('parametres.delete')){
                            $parametre = Parametre::find($id_ligne);
                            $parametre->deleted_at = Carbon::now();
                            $parametre->id_user_deleted = Auth::user()->id;
                            $parametre->save();
                        }else{
                            return redirect()->route('admin.dashboard')->with('error', 'Vous n\'aviez pas le droit de supprimer cette ligne');
                        }
                        break;
                    case 'valeur':
                        if(Auth::user()->can('valeurs.delete')){
                            $valeur = Valeur::find($id_ligne);
                            $valeur->deleted_at = Carbon::now();
                            $valeur->id_user_deleted = Auth::user()->id;
                            $valeur->save();
                        }else{
                            return redirect()->route('admin.dashboard')->with('error', 'Vous n\'aviez pas le droit de supprimer cette ligne');
                        }
                        break;
                    case 'pack':
                        if(Auth::user()->can('packs.delete')){
                            $pack = Pack::find($id_ligne);
                            $pack->deleted_at = Carbon::now();
                            $pack->id_user_deleted = Auth::user()->id;
                            $pack->save();
                        }else{
                            return redirect()->route('admin.dashboard')->with('error', 'Vous n\'aviez pas le droit de supprimer cette ligne');
                        }
                        break;
                    case 'plan_affaire':
                        if(Auth::user()->can('businessplans.delete')){
                            $business_plan = PlanAffaire::find($id_ligne);
                            $business_plan->deleted_at = Carbon::now();
                            $business_plan->id_user_deleted = Auth::user()->id;
                            $business_plan->save();
                        }else{
                            return redirect()->route('admin.dashboard')->with('error', 'Vous n\'aviez pas le droit de supprimer cette ligne');
                        }
                        break;

                    default:
                        return redirect()->back()->with('error', 'Erreur lors de la suppresion');
                        break;
                }

                return redirect()->back()->with('success', 'Suppression réalisée avec succès');
            } catch (Exception $ex) {
                dd($ex);
            }

    }
}
