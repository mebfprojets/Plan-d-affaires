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
use App\Models\Arrondissement;
use App\Models\Structure;
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

        $plan_affaires = PlanAffaire::whereNull('deleted_at')->orderBy('created_at', 'DESC')->limit(5)->get();

        return view('backend.back', compact('plan_affaires'));
    }

    public function getStat()
    {
        if(!Auth::user()->can('statistique.view')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Initialisation des variables pour les différents types de statistiques
        $statistiques = [
            //Stats gratuité femmes et enfants de moins de 5 ans
            'total_prom' => 0,
            'total_en' => 0,
            'total_pa' => 0,
            'total_pay' => 0,
            'nombre_np' => 0,
            'nombre_val' => 0,
        ];

        // Récupération des statistiques globales
        $results = DB::table('plan_affaires as pa')
                                ->leftJoin('promoteurs as p', 'p.id_plan_affaire', '=', 'pa.id')
                                ->join('packs as ps', 'ps.id', 'pa.id_pack')
                                ->selectRaw('count(p.id) as total_prom, SUM(ps.cout_pack) as total_pay')
                                ->groupBy('pa.id')
                                ->get();

        $statistiques['total_prom'] = floatval(round($results->sum('total_prom') ?? 0));
        $statistiques['total_en'] = floatval(round($results->count() ?? 0));
        $statistiques['total_pa'] = floatval(round($results->count() ?? 0));
        $statistiques['total_pay'] = floatval(round($results->sum('total_pay') ?? 0));

         // Récupération des statistiques status
        $result_s = DB::table('plan_affaires as pa')
                                ->join('payements as p', 'p.id_plan_affaire', '=', 'pa.id')
                                ->selectRaw('count(p.id) as nombre_np')
                                ->whereNull('pa.deleted_at')
                                ->first();
        $result_v = PlanAffaire::selectRaw('count(*) as nombre_val')->where('is_valide', true)->whereNull('deleted_at')->first();
        $statistiques['nombre_np'] = floatval(round($result_s->nombre_np ?? 0));
        $statistiques['nombre_val'] = floatval(round($result_v->nombre_val ?? 0));

        return response()->json(['data' => $statistiques]);
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
