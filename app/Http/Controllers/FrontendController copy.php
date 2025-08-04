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
use App\Models\Region;
use App\Models\Province;
use App\Models\Commune;
use App\Models\Arrondissement;

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
                return view('frontend.menu.a-propos');
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
            return view('frontend.home');
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
            $provinces = Province::where(['is_delete'=>FALSE, 'id_region'=>$idparent_val])->get();
                foreach ($provinces as $province)
                {
                    $array[] = array("id" => $province->id, "name" => $province->libelle);
                }
            break;

            case 'commune':
                $communes = Commune::where(['is_delete'=>FALSE, 'id_province'=>$idparent_val])->get();
                foreach ($communes as $commune)
                {
                    $array[] = array("id" => $commune->id, "name" => $commune->libelle);
                }
                break;

            case 'arrondissement':
                $arrondissements = Arrondissement::where(['is_delete'=>FALSE, 'id_commune'=>$idparent_val])->get();
                foreach ($arrondissements as $arrondissement)
                {
                    $array[] = array("id" => $arrondissement->id, "name" => $arrondissement->libelle);
                }
                break;
        }

        $response['data'] = $array;
        return response()->json($response);
    }

    /**************** SELECT CHARGEMENT DES SOUS TABLES *************************/

    /**
     * Ajouter participant
     */

    public function addLigne(Request $request)
    {
        $professions = Valeur::where('id_parametre', env('profession'))->get();
        return view("frontend.add-participant", compact('professions'));
    }

    /**
     * Store inscription formation
     */
    public function storeInscriptionFormation(Request $request)
    {
        try {
            $uuid = (string) Str::uuid();
            $session_client = SessionClient::create([
                'id'=>$uuid,
                'session_id'=>$request->session_formation_id,
                'client_id'=>$request->client_id,
                'date_inscription'=>(Carbon::now())->format('Y-m-d H:i:s'),
                'statut'=>'a_valider',
            ]);

            $sessionformation = SessionFormation::find($request->session_formation_id);
            $cout_total_client = 0;
            $nombre_participant = 0;

            $nom_participant = $request->nom_participant;
            $prenom_participant = $request->prenom_participant;
            $date_naissance = $request->date_naissance;
            $profession_participant = $request->profession_participant;
            $numero_participant = $request->numero_participant;
            $email_participant = $request->email_participant;
            $structure_participant = $request->structure_participant;
            for($i=0;$i<count($nom_participant); $i++){
                if($nom_participant[$i] !='' && $prenom_participant[$i] !=''){
                    $client_participant = ClientParticipant::create([
                        'id_session_client'=>$uuid,
                        'nom_participant'=>$nom_participant[$i],
                        'prenom_participant'=>$prenom_participant[$i],
                        'date_naissance'=>$date_naissance[$i],
                        'id_profession'=>$profession_participant[$i],
                        'numero_telephone'=>$numero_participant[$i],
                        'email_participant'=>$email_participant[$i],
                        'structure_participant'=>$structure_participant[$i],
                    ]);

                    $cout_total_client = $cout_total_client+$sessionformation->prix_formation;
                    $nombre_participant = $nombre_participant+1;
                }
            }
            if($request->participant_client == 'yes'){
                $user_client = Client::find($request->client_id);
                $client_participant = ClientParticipant::create([
                    'id_session_client'=>$uuid,
                    'nom_participant'=>$user_client->nom,
                    'prenom_participant'=>$user_client->prenom,
                    'date_naissance'=>$user_client->date_naissance_client,
                    'numero_telephone'=>$user_client->numero_telephone,
                    'email_participant'=>$user_client->email,
                ]);

                $cout_total_client = $cout_total_client+$sessionformation->prix_formation;
                $nombre_participant = $nombre_participant+1;
            }
            $session_client = SessionClient::find($uuid);
            $session_client->update([
                'cout_total_client'=>$cout_total_client,
                'nombre_participant'=>$nombre_participant,
            ]);
            return redirect()->route('frontend.formation.paye', $uuid);
        } catch (Exception $ex) {
            dd($ex);
        }

    }

    /**
     * Payer formation
     */
    public function payeFormation($id_session_client)
    {
        $session_client = SessionClient::where('id', $id_session_client)->first();
        $client_participants = DB::table('client_participants')
                    ->join('session_clients', 'session_clients.id', '=', 'client_participants.id_session_client')
                    ->join('valeurs', 'valeurs.id', '=', 'client_participants.id_profession')
                    ->select('client_participants.*', 'valeurs.libelle as profession_participant')
                    ->where('session_clients.id', $id_session_client)
                    ->get();
        $formation = DB::table('formations')
                    ->join('session_formations', 'session_formations.formation_id', '=', 'formations.id')
                    ->select('session_formations.*', 'formations.shortname', 'formations.fullname')
                    ->where('session_formations.id', $session_client->session_id)
                    ->first();

        $session_formation_client = DB::table('session_formations')
                    ->join('formations', 'session_formations.formation_id', 'formations.id')
                    ->join('valeurs', 'session_formations.lieu_formation', 'valeurs.id')
                    ->join('session_clients', 'session_formations.id', 'session_clients.session_id')
                    ->join('clients', 'clients.id', 'session_clients.client_id')
                    ->select('session_formations.*', 'session_clients.id as session_client_id', 'session_clients.nombre_participant', 'session_clients.cout_total_client', 'formations.shortname', 'formations.fullname', 'valeurs.libelle as localite_formation', 'clients.nom_client', 'clients.numero_telephone')
                    ->where('session_clients.id', $id_session_client)
                    ->first();
        $participants = DB::table('client_participants')
                    ->join('session_clients', 'session_clients.id', '=', 'client_participants.id_session_client')
                    ->select('client_participants.*')
                    ->where('session_clients.id', $id_session_client)
                    ->get();
        return view('frontend.payeFormation', compact('session_formation_client', 'participants'));
    }

    /**
     * Payer une formation
     */
    public function  payerFormation(Request $request, $session_client_id)
    {
        $session_client = SessionClient::where('id', $session_client_id)->first();
        try {
            $session_client->update([
                'cout_total_client'=>$request->cout_total_client,
                'date_payment'=>date('Y-m-d H:i:s'),
                'numero_payment'=>$request->numero_telephone_paye,
                'code_opt'=>$request->code_opt,
            ]);

            return redirect()->route('profile.formations')->with('success', 'Paiement effectuer avec succès');
        } catch (\Exception $ex) {
            //throw $th;
        }
    }

    /**
     * Details d'une formation
     */
    public function showFormation($id_session_formation, $slug)
    {
        $sessionformation = DB::table('session_formations')
                            ->join('formations', 'session_formations.formation_id', 'formations.id')
                            ->join('valeurs', 'session_formations.lieu_formation', 'valeurs.id')
                            ->select('session_formations.*', 'formations.shortname', 'formations.fullname', 'valeurs.libelle as localite_formation')
                            ->where('session_formations.id', $id_session_formation)
                            ->first();
        $nombreclient = SessionClient::where('session_id', $sessionformation->id)->first()->count();
        $other_sessions = DB::table('session_formations')
                            ->join('formations', 'session_formations.formation_id', 'formations.id')
                            ->select('session_formations.*', 'formations.shortname', 'formations.fullname')
                            ->where('session_formations.id', '!=', $id_session_formation)
                            ->get();

        return view('frontend.details-formation', compact('sessionformation', 'nombreclient', 'other_sessions'));
    }
}
