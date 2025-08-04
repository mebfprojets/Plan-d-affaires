<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pack;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use \Exception;
use Carbon\Carbon;
use App\Models\Structure;

class FrontendController extends Controller
{
    public function home()
    {
        $pack_first = Pack::whereNull('deleted_at')->limit(1)->first();
        $packs = Pack::whereNull('deleted_at')->where('id', '!=', $pack_first->id)->get();
        return view('frontend.front', compact('pack_first', 'packs'));
    }

    /**
     * Inscription page
     */
    public function account()
    {
        if(Auth::user()){
            return back();
        }
        return view('frontend.account');
    }

    /**
     * service Pacj page
     */
    public function servicePack($slug_pack)
    {
        $pack = Pack::where('slug', $slug_pack)->first();
        $packs = Pack::where('slug', '!=', $slug_pack)->get();
        return view('frontend.inscription', compact('pack', 'packs'));
    }

    /**
     * Inscription de client
     * @param Client
     */
    public function storeAccount(Request $request)
    {
        $client_exist = Client::where('email', $request->email)->first();
        if($client_exist){
            flash()->addError('Erreur lors de l\'enregistrement du client: Un client avec cette email existe déjà.');
            return redirect()->back();
        }
        try {
            $nom_client = $request->nom_client? $request->nom_client:$request->nom.' '.$request->prenom;
            $client = Client::create([
                'id'=>$client_id,
                'nom'=>$request->nom,
                'prenom'=>$request->prenom,
                'nom_client'=>$nom_client,
                'date_naissance_client'=>$request->date_naissance_client,
                'id_sexe'=>$request->id_sexe,
                'numero_telephone'=>$request->numero_telephone,
                'email'=>$request->email,
            ]);
            return redirect()->route('frontend.inscription.account', $client_id);
        } catch (Exception $ex) {
            dd($ex);
        }
    }

    /**
     * Connexion page
     */
    public function login()
    {
        return view('frontend.auth.login');
    }

    /**
     * Menu page
     */
    public function menu($slug_menu)
    {
        switch ($slug_menu) {
            case 'a-propos':
                $pack_first = Pack::whereNull('deleted_at')->limit(1)->first();
                $packs = Pack::whereNull('deleted_at')->where('id', '!=', $pack_first->id)->get();
                return view('frontend.menu.a-propos', compact('pack_first', 'packs'));
                break;
            case 'comment-postuler':
                return view('frontend.menu.postuler');
                break;
            case 'elaborer-pa':
                return view('frontend.menu.elaborer-pa');
                break;
            case 'nous-contacter':
                return view('frontend.menu.nous-contacter');
                break;
            case 'nos-packs':
                $packs = Pack::whereNull('deleted_at')->get();
                return view('frontend.menu.nos-packs', compact('packs'));
                break;

            default:
            return redirect()->route('frontend.home');
                break;
        }

    }

     /**************** SELECT CHARGEMENT DES SOUS TABLES *************************/
    public function selection(Request $request)
    {
        $idparent_val = $request->idparent_val;
        $table = $request->table;

        $array[] = array("id" => '', "name" => '');

        switch ($table) {
            case 'province':
            $provinces = Structure::where('id_parent', $idparent_val)->get();
                foreach ($provinces as $province)
                {
                    $array[] = array("id" => $province->id, "name" => $province->nom_structure);
                }
            break;

            case 'commune':
                $communes = Structure::where('id_parent', $idparent_val)->get();
                foreach ($communes as $commune)
                {
                    $array[] = array("id" => $commune->id, "name" => $commune->nom_structure);
                }
                break;

            case 'arrondissement':
                $arrondissements = Structure::where('id_parent', $idparent_val)->get();
                foreach ($arrondissements as $arrondissement)
                {
                    $array[] = array("id" => $arrondissement->id, "name" => $arrondissement->nom_structure);
                }
                break;
        }

        $response['data'] = $array;
        return response()->json($response);
    }

    /**************** SELECT CHARGEMENT DES SOUS TABLES *************************/

    public function changePassword()
    {
        return view('frontend.auth.change-password');
    }

    public function forgetPassword()
    {
        if(Auth::user()){
            return back();
        }
        return view('frontend.auth.forget-password');
    }
}
