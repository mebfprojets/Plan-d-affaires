<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\PlanAffaire;
use App\Models\Planning;
use App\Models\Valeur;
use App\Models\Entreprise;
use App\Models\Promoteur;
use App\Models\Pack;
use App\Models\Employe;
use App\Models\ChiffreAffaire;
use App\Models\ChiffreAffaireFirstYear;
use App\Models\ChareExploitation;
use App\Models\Payement;
use App\Models\Imput;
use App\Models\Engagement;
use App\Models\Structure;
use App\Models\Partenaire;
use App\Models\EquipementProduction;
use App\Models\Transaction;
use App\Models\StructureFinanciere;
use App\Models\ServiceExterieur;
use App\Models\CompteExploitation;
use App\Models\BilanMasse;
use App\Models\CompteExploitationYear;
use App\Models\CritereProduit;
use App\Models\StrategieMarketing;
use App\Models\TransactionSuccesses;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use \Exception;
use Ligdicash\Ligdicash;
use Illuminate\Support\Facades\Http;
use Barryvdh\DomPDF\Facade\Pdf;

class BusinessPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::user()->can('businessplans.index')){
            $businessplans = PlanAffaire::whereNull('deleted_at')->orderBy('date_imput', 'DESC')->get();
            $admins = Admin::whereNull('deleted_at')->get();
            $admin = Admin::find(Auth::user()->id);
            $flag = false;
            foreach($admin->roles as $role_admin){
                if($role_admin->slug == env('super_admin')){
                    $flag = true;
                }
            }
            if(!$flag){
                $businessplans = PlanAffaire::where('id_admin_imput', Auth::user()->id)->whereNull('deleted_at')->orderBy('date_imput', 'DESC')->get();
            }
            return view('backend.businessplans.index', compact('businessplans', 'admins'));
        }
        return redirect()->route('admin.dashboard');
    }

    /**
     * Store business Plan
     */
    public function storeBusinessPlan(Request $request)
    {
        $request->validate([
            'business_idea' => 'required',
        ]);


        $etapes = $request->input('etapes_activites');
        $dates = $request->input('dates_indicatives');

        try {
            $id_plan_affaire = (string) Str::uuid();
            $plan_affaire = PlanAffaire::create([
                'id' => $id_plan_affaire,
                'business_idea' => $request->business_idea,
                'business_object' => $request->business_object,
                'id_pack' => $request->id_pack,
                'statut' => env('initie'),
                'id_user' => Auth::user()->id,
            ]);

            foreach ($etapes as $index => $etape) {
                $date = $dates[$index];

                // Enregistrer chaque activité dans la base de données
                if($date && $etape){
                    Planning::create([
                        'id_plan_affaire' => $id_plan_affaire,
                        'step_activity' => $etape,
                        'date_indicative' => $date,
                    ]);
                }

            }

            return redirect()->route('businessplans.edit', $id_plan_affaire)->with('success', 'Plan d\'affaire enregistré avec succès!');

        } catch (Exception $ex) {
            dd($ex);
        }
    }

    /**
     * Edit Business Plan
     */
    public function editBusinessPlan($id_plan_affaire)
    {
        $business_plan = PlanAffaire::find($id_plan_affaire);
        /*if($business_plan->is_valide && $business_plan->is_paye){
            return back()->with('error', 'Ce plan d\'affaire est déjà validé et ne peut plus être modifié!');
        }*/
        $sexes = Valeur::where('id_parametre', env('sexe'))->whereNull('deleted_at')->get();
        $forme_juridiques = Valeur::where('id_parametre', env('forme_juridique'))->whereNull('deleted_at')->get();
        // $banques = Valeur::where('id_parametre', env('banque'))->whereNull('deleted_at')->get();
        $situation_familles = Valeur::where('id_parametre', env('situation_famille'))->whereNull('deleted_at')->get();
        $criteres = Valeur::where('id_parametre', env('critere_produit'))->whereNull('deleted_at')->get();
        $provinces = null;
        $communes = null;
        $arrondissements = null;
        /*$charges = DB::table('valeurs as v')
                        ->join('parametres as p', 'p.id', 'v.id_parametre')
                        ->select('v.*')
                        ->where('v.id_parametre', env('matieres_premieres'))
                        ->whereNull('p.deleted_at')
                        ->whereNull('v.deleted_at')
                        ->get();*/
        // dd($charges);
        $groupedCharge_exs = DB::table('valeurs as v')
                    ->leftJoin('chare_exploitations as ce', function ($join) use ($id_plan_affaire) {
                        $join->on('ce.id_valeur', '=', 'v.id')
                            ->where('ce.id_plan_affaire', '=', $id_plan_affaire)
                            ->where('ce.type_mat', '=', 'existent');
                    })
                    ->select(
                        'ce.id',
                        'v.id as id_valeur',
                        'v.libelle as valeur_libelle',
                        'v.description',
                        'ce.designation',
                        'ce.unite',
                        'ce.quantite',
                        'ce.cout_unitaire',
                        'ce.cout_total',
                        'ce.etat_fonctionnement'
                    )
                    ->where('v.id_parametre', env('ID_CHARGE'))
                    ->whereNull('v.deleted_at')
                    ->orderBy('v.id', 'ASC')
                    ->get()
                    ->groupBy('id_valeur');

        $groupedCharge_aqs = DB::table('valeurs as v')
                    ->leftJoin('chare_exploitations as ce', function ($join) use ($id_plan_affaire) {
                        $join->on('ce.id_valeur', '=', 'v.id')
                            ->where('ce.id_plan_affaire', '=', $id_plan_affaire)
                            ->where('ce.type_mat', '=', 'acquerir');
                    })
                    ->select(
                        'ce.id',
                        'v.id as id_valeur',
                        'v.libelle as valeur_libelle',
                        'v.description',
                        'ce.designation',
                        'ce.unite',
                        'ce.quantite',
                        'ce.cout_unitaire',
                        'ce.cout_total',
                        'ce.etat_fonctionnement'
                    )
                    ->where('v.id_parametre', env('ID_CHARGE'))
                    ->whereNull('v.deleted_at')
                    ->orderBy('v.id', 'ASC')
                    ->get()
                    ->groupBy('id_valeur');

        $charges = Valeur::where('id_parametre', env('ID_CHARGE'))->whereNull('deleted_at')->get();

        $groupedStrategieMarketings = DB::table('parametres as p')
                    ->leftJoin('valeurs as v', function ($join) {
                        $join->on('v.id_parametre', '=', 'p.id');
                    })
                    ->select(
                        'p.id as id_parametre',
                        'p.libelle as libelle_parametre',
                        'v.id as id_valeur',
                        'v.id_parametre',
                        'v.libelle as libelle_valeur'
                    )
                    ->where('p.id_parent', env('strategie_marketing'))
                    ->whereNull('p.deleted_at')
                    ->orderBy('p.id', 'ASC')
                    ->get()
                    ->groupBy('id_parametre');
        // dd($groupedStrategieMarketings);
        // $compteExploitations = Valeur::where('id_parametre', env('cexploitation'))->whereNull('deleted_at')->get();
        // $bilanMasseActifs = Valeur::where('id_parametre', env('bactif'))->whereNull('deleted_at')->get();
        // $bilanMassePacifs = Valeur::where('id_parametre', env('bpassif'))->whereNull('deleted_at')->get();

        $year = get_years($id_plan_affaire);
        $compteExploitations = compte_exploitation($id_plan_affaire);
        $bilanMasseActifs = bilanMasseActif($id_plan_affaire);
        $bilanMassePacifs = bilanMassePacifs($id_plan_affaire);

        $regions = Structure::where('level_structure', 'region')->get();
        if($business_plan->entreprise){
            if($business_plan->entreprise->id_region){
                $provinces = Structure::where('id_parent', $business_plan->entreprise->id_region)->get();
            }
            if($business_plan->entreprise->id_province){
                $communes = Structure::where('id_parent', $business_plan->entreprise->id_province)->get();
            }
            if($business_plan->entreprise->id_commune){
                $arrondissements = Structure::where('id_parent', $business_plan->entreprise->id_commune)->get();
            }
        }


        $route = request()->route();
        $middlewares = $route->gatherMiddleware(); // Donne tous les middleware appliqués à la route
        if (in_array('auth:admin', $middlewares)) {
            $trash_icon = 'fa fa-trash';

            return view('backend.businessplans.edit', compact('business_plan', 'sexes', 'situation_familles', 'criteres', 'groupedStrategieMarketings', 'charges', 'groupedCharge_exs', 'groupedCharge_aqs', 'compteExploitations', 'bilanMassePacifs', 'bilanMasseActifs', 'forme_juridiques', 'regions', 'provinces', 'communes', 'arrondissements', 'trash_icon', 'year'));
        }
            $trash_icon = 'bi bi-trash';
            return view('frontend.edit-business-plan', compact('business_plan', 'sexes', 'situation_familles', 'criteres', 'groupedStrategieMarketings', 'charges', 'groupedCharge_exs', 'groupedCharge_aqs', 'compteExploitations', 'bilanMassePacifs', 'bilanMasseActifs', 'forme_juridiques',  'regions', 'provinces', 'communes', 'arrondissements', 'trash_icon', 'year'));
    }

    /**
     * Add Promoteur Ligne
     */
    public function addLignePromoteur(Request $request)
    {
        $nombre_promoteur = $request->nombre_promoteur;
        $sexes = Valeur::where('id_parametre', env('sexe'))->whereNull('deleted_at')->get();
        $situation_familles = Valeur::where('id_parametre', env('situation_famille'))->whereNull('deleted_at')->get();
        return view('frontend.add-promoteur', compact('sexes', 'situation_familles', 'nombre_promoteur'));
    }

    /**
     * Update Business Plan
     */
    public function updateBusinessPlan(Request $request, $id_plan_affaire)
    {
        $admin = Auth::guard('admin')->check();
        $web = Auth::guard('web')->check();
        if (!$admin && !$web) {
            return back()->with('success', 'Vous ne pouvez pas modifier un plan d\'affaire'); // adapte si besoin
        }

        $etapes = $request->input('etapes_activites');
        $dates = $request->input('dates_indicatives');

        try {
            $business_plan = PlanAffaire::find($id_plan_affaire);
            $id_user = $business_plan->id_user;
            $web = Auth::guard('web')->check();
            if ($web) {
                $id_user = Auth::id();
            }
            // ENTREPRISE
            if($business_plan->entreprise){
                $entreprise = Entreprise::find($business_plan->entreprise->id);
                $entreprise->update(
                    [
                        'adresse_entreprise' => $request->adresse_entreprise,
                        'email_entreprise' => $request->email_entreprise,
                        'tel_entreprise' => $request->tel_entreprise,
                        'atout_promoteur' => $request->atout_promoteur,
                        'id_forme_juridique' => $request->forme_juridique,
                        'date_creation_prevue' => $request->date_creation,
                        'engagement_institution' => $request->engagement,
                        'denomination' => $request->denomination,
                        'id_region' => $request->id_region,
                        'id_province' => $request->id_province,
                        'id_commune' => $request->id_commune,
                        'id_arrondissement' => $request->id_arrondissement,
                        'presentation_entreprise' => $request->presentation_entreprise,
                        'statut_juridique_gerance' => $request->statut_juridique_gerance,
                    ]
                );
            }else{
                $entreprise = Entreprise::create(
                    [
                        'adresse_entreprise' => $request->adresse_entreprise,
                        'email_entreprise' => $request->email_entreprise,
                        'tel_entreprise' => $request->tel_entreprise,
                        'atout_promoteur' => $request->atout_promoteur,
                        'id_forme_juridique' => $request->forme_juridique,
                        'date_creation_prevue' => $request->date_creation,
                        'engagement_institution' => $request->engagement,
                        'denomination' => $request->denomination,
                        'id_region' => $request->id_region,
                        'id_province' => $request->id_province,
                        'id_commune' => $request->id_commune,
                        'id_arrondissement' => $request->id_arrondissement,
                        'presentation_entreprise' => $request->presentation_entreprise,
                        'statut_juridique_gerance' => $request->statut_juridique_gerance,
                        'id_user' => $id_user, // Critère de recherche
                    ]
                );
            }

            // CRITERE
            $removeCritereProduit = CritereProduit::where('id_plan_affaire', $business_plan->id)->delete();
            $critere_valeurs = $request->input('critere_valeur');
            $critere_produits = $request->input('critere_produit');
            $critere_descriptions = $request->input('critere_description');

            if($critere_valeurs){
                foreach ($critere_valeurs as $index => $critere_valeur) {
                    $critere_produit = $critere_produits[$index];
                    $critere_description = $critere_descriptions[$index];
                    if($critere_description){
                        CritereProduit::updateOrCreate([
                        'id_plan_affaire' => $business_plan->id,
                        'id_produit' => $critere_produit,
                        'id_valeur' => $critere_valeur,
                        'description' => $critere_description,

                    ]);
                    }

                }
            }

            // CRITERE
            $removeStrategieMarketing = StrategieMarketing::where('id_plan_affaire', $business_plan->id)->delete();
            $valeur_sms = $request->input('valeur_sm');
            $libelle_sms = $request->input('libelle_sm');

            if($valeur_sms){
                foreach ($valeur_sms as $index => $valeur_sm) {
                    $libelle_sm = $libelle_sms[$index];

                    if($libelle_sm){
                        StrategieMarketing::updateOrCreate([
                        'id_plan_affaire' => $business_plan->id,
                        'id_valeur' => $valeur_sms[$index],
                        'libelle_sm' => $libelle_sms[$index],

                    ]);
                    }

                }
            }

            // ENGAGEMENT
            $natures = $request->input('nature_credit');
            $banques = $request->input('nom_banque');
            $datedebuts = $request->input('date_debut');
            $montant_emps = $request->input('montant_emp');
            $mensualites = $request->input('mensualite');
            $montant_restants = $request->input('montant_restant');
            $dateecheances = $request->input('date_echeance');
            $removeEngagement = Engagement::where(['id_plan_affaire'=>$business_plan->id, 'id_entreprise'=>$entreprise->id])->delete();
            if($banques){
                foreach ($banques as $index => $banque) {
                    $nature = $natures[$index];
                    $datedebut = $datedebuts[$index];
                    $montant_emp = preg_replace('/\s+/u', '', $montant_emps[$index]);
                    $mensualite = preg_replace('/\s+/u', '', $mensualites[$index]);
                    $montant_restant = preg_replace('/\s+/u', '', $montant_restants[$index]);
                    $dateecheance = $dateecheances[$index];
                    if($banque){
                        Engagement::updateOrCreate([
                        'id_plan_affaire' => $business_plan->id,
                        'id_entreprise' => $entreprise->id,
                        'nature_credit' => $nature,
                        'nom_banque' => $banque,
                        'date_debut' => $datedebut,
                        'montant_emprunt' => (double) $montant_emp,
                        'mensualite' => (double) $mensualite,
                        'montant_restant' => (double) $montant_restant,
                        'date_echeance' => $dateecheance,

                    ]);
                    }

                }
            }

            // COMPTE EXPLOITATION
            $first_year = $request->input('first_year');
            $comptex = CompteExploitationYear::where('id_plan_affaire', $id_plan_affaire)->get();
            if($comptex->count()<=0){
                CompteExploitationYear::insert([
                    [
                        'id_plan_affaire' => $business_plan->id,
                        'year_compte' => $first_year - 2,
                    ],
                    [
                        'id_plan_affaire' => $business_plan->id,
                        'year_compte' => $first_year - 1,
                    ],
                    [
                        'id_plan_affaire' => $business_plan->id,
                        'year_compte' => $first_year,
                    ],
                ]);
            }

            $valeurs = $request->input('valeur');
            $montant_firsts = $request->input('montant_first');
            $montant_seconds = $request->input('montant_second');
            $montant_thirds = $request->input('montant_third');

            $removeCompteExploitation = CompteExploitation::where(['id_plan_affaire'=>$business_plan->id, 'id_entreprise'=>$entreprise->id])->delete();
            if($valeurs){
                foreach ($valeurs as $index => $valeur) {
                    $montant_first =  preg_replace('/\s+/u', '', $montant_firsts[$index]);
                    $montant_second =  preg_replace('/\s+/u', '', $montant_seconds[$index]);
                    $montant_third =  preg_replace('/\s+/u', '', $montant_thirds[$index]);

                    // FIRST
                    if($montant_first){

                        CompteExploitation::create([
                            'id_plan_affaire' => $business_plan->id,
                            'id_entreprise' => $entreprise->id,
                            'id_valeur' => $valeur,
                            'montant' => (double) $montant_first,
                            'year' => $first_year-2,
                        ]);
                    }

                    // SECOND
                    if($montant_second){
                        CompteExploitation::create([
                            'id_plan_affaire' => $business_plan->id,
                            'id_entreprise' => $entreprise->id,
                            'id_valeur' => $valeur,
                            'montant' => (double) $montant_second,
                            'year' => $first_year-1,
                        ]);
                    }

                    // THIRD
                    if($montant_third){
                        CompteExploitation::create([
                            'id_plan_affaire' => $business_plan->id,
                            'id_entreprise' => $entreprise->id,
                            'id_valeur' => $valeur,
                            'montant' => (double) $montant_third,
                            'year' => $first_year,
                        ]);
                    }

                }
            }

            // COMPTE EXPLOITATION
            $removeBilanMasse = BilanMasse::where(['id_plan_affaire'=>$business_plan->id, 'id_entreprise'=>$entreprise->id])->delete();
            // ACTIF
            $valeur_actifs = $request->input('valeur_actif');
            $montant_first_actifs = $request->input('montant_first_actif');
            $montant_second_actifs = $request->input('montant_second_actif');
            $montant_third_actifs = $request->input('montant_third_actif');
            if($valeur_actifs){
                foreach ($valeur_actifs as $index => $valeur_actif) {
                    $montant_first_actif =  preg_replace('/\s+/u', '', $montant_first_actifs[$index]);
                    $montant_second_actif =  preg_replace('/\s+/u', '', $montant_second_actifs[$index]);
                    $montant_third_actif =  preg_replace('/\s+/u', '', $montant_third_actifs[$index]);

                    // FIRST
                    if($montant_first_actif){

                        BilanMasse::create([
                            'id_plan_affaire' => $business_plan->id,
                            'id_entreprise' => $entreprise->id,
                            'id_valeur' => $valeur_actif,
                            'montant' => (double) $montant_first_actif,
                            'year' => $first_year-2,
                        ]);
                    }

                    // SECOND
                    if($montant_second_actif){
                        CompteExploitation::create([
                            'id_plan_affaire' => $business_plan->id,
                            'id_entreprise' => $entreprise->id,
                            'id_valeur' => $valeur_actif,
                            'montant' => (double) $montant_second_actif,
                            'year' => $first_year-1,
                        ]);
                    }

                    // THIRD
                    if($montant_third_actif){
                        CompteExploitation::create([
                            'id_plan_affaire' => $business_plan->id,
                            'id_entreprise' => $entreprise->id,
                            'id_valeur' => $valeur_actif,
                            'montant' => (double) $montant_third_actif,
                            'year' => $first_year,
                        ]);
                    }

                }
            }

            // PACIF
            $valeur_pacifs = $request->input('valeur_pacif');
            $montant_first_pacifs = $request->input('montant_first_pacif');
            $montant_second_pacifs = $request->input('montant_second_pacif');
            $montant_third_pacifs = $request->input('montant_third_pacif');
            if($valeur_pacifs){
                foreach ($valeur_pacifs as $index => $valeur_pacif) {
                    $montant_first_pacif =  preg_replace('/\s+/u', '', $montant_first_pacifs[$index]);
                    $montant_second_pacif =  preg_replace('/\s+/u', '', $montant_second_pacifs[$index]);
                    $montant_third_pacif =  preg_replace('/\s+/u', '', $montant_third_pacifs[$index]);

                    // FIRST
                    if($montant_first_pacif){

                        BilanMasse::create([
                            'id_plan_affaire' => $business_plan->id,
                            'id_entreprise' => $entreprise->id,
                            'id_valeur' => $valeur_pacif,
                            'montant' => (double) $montant_first_pacif,
                            'year' => $first_year-2,
                        ]);
                    }

                    // SECOND
                    if($montant_second_pacif){
                        BilanMasse::create([
                            'id_plan_affaire' => $business_plan->id,
                            'id_entreprise' => $entreprise->id,
                            'id_valeur' => $valeur_pacif,
                            'montant' => (double) $montant_second_pacif,
                            'year' => $first_year-1,
                        ]);
                    }

                    // THIRD
                    if($montant_third_pacif){
                        BilanMasse::create([
                            'id_plan_affaire' => $business_plan->id,
                            'id_entreprise' => $entreprise->id,
                            'id_valeur' => $valeur_pacif,
                            'montant' => (double) $montant_third_pacif,
                            'year' => $first_year,
                        ]);
                    }

                }
            }

            // PROMOTEUR
            // dd(Promoteur::where('id_plan_affaire', $business_plan->id)->get());
            $porteur = $request->input('porteur');
            $nom_promoteurs = $request->input('nom_promoteur');
            $prenom_promoteurs = $request->input('prenom_promoteur');
            $tel_promoteurs = $request->input('tel_promoteur');
            $email_promoteurs = $request->input('email_promoteur');
            $ages = $request->input('age');
            $sexes = $request->input('sexe');
            $situation_familles = $request->input('situation_famille');
            $domiciles = $request->input('domicile');
            $adresses = $request->input('adresse');
            $niveau_formations = $request->input('niveau_formation');
            $experience_secteur_activites = $request->input('experience_secteur_activite');
            $activite_actuelles = $request->input('activite_actuelle');
            $motivation_creations = $request->input('motivation_creation');
            $garantie_avals = $request->input('garantie_aval');
            $removePromoteur = Promoteur::where('id_plan_affaire', $business_plan->id)->delete();

            if($nom_promoteurs){
                foreach ($nom_promoteurs as $index => $nom_promoteur) {
                    $is_porteur = false;
                    $age = $ages[$index];
                    $prenom_promoteur = $prenom_promoteurs[$index];
                    $tel_promoteur = $tel_promoteurs[$index];
                    $email_promoteur = $email_promoteurs[$index];
                    $sexe = $sexes[$index];
                    $situation_famille = $situation_familles[$index];
                    $domicile = $domiciles[$index];
                    $adresse = $adresses[$index];
                    $niveau_formation = $niveau_formations[$index];
                    $experience_secteur_activite = $experience_secteur_activites[$index];
                    $activite_actuelle = $activite_actuelles[$index];
                    $motivation_creation = $motivation_creations[$index];
                    $garantie_aval = $garantie_avals[$index];
                    if($porteur == $index){
                            $is_porteur = true;
                        }
                    // Enregistrer chaque activité dans la base de données
                    if($nom_promoteur){

                        Promoteur::updateOrCreate([
                            'id_entreprise' => $entreprise->id,
                            'id_plan_affaire' => $business_plan->id,
                            'age' => $age,
                            'id_sexe' => $sexe,
                            'id_situation_famille' => $situation_famille,
                            'domicile' => $domicile,
                            'adresse' => $adresse,
                            'niveau_formation' => $niveau_formation,
                            'experience_secteur_activite' => $experience_secteur_activite,
                            'activite_actuelle' => $activite_actuelle,
                            'motivation_creation' => $motivation_creation,
                            'garantie_aval' => $garantie_aval,
                            'is_porteur' => $is_porteur,
                            'nom_promoteur' => $nom_promoteur,
                            'prenom_promoteur' => $prenom_promoteur,
                            'tel_promoteur' => $tel_promoteur,
                            'email_promoteur' => $email_promoteur,
                            'id_user' => Auth::id(),
                        ]);
                    }
                }
            }

            // BUSINESS PLAN
            $business_plan->update([
                // ENTREPRISE
                'id_entreprise' => $entreprise->id,
                // PRESENTATION
                'business_idea' => $request->business_idea,
                'business_object' => $request->business_object,
                'business_titre' => $request->business_titre,
                'caractere_innovant_projet' => $request->caractere_innovant_projet,
                'business_activity' => $request->business_activity,

                // DOSSIER COMMERCIAL
                'produit_service' => $request->produits_services,
                'situation_secteur_activite' => $request->situation_secteur,
                'evaluation_marche_potentiel' => $request->evaluation_marche,
                'profil_marche_cible' => $request->profil_marche,
                'marche_vise' => $request->marche_vise,
                'situation_concurrentielle' => $request->situation_concurrentielle,
                'analyse_concurrentielle' => $request->analyse_concurrentielle,
                'politique_produit' => $request->politique_produit,
                // 'politique_prix' => $request->politique_prix,
                // 'politique_promotion' => $request->politique_promotion,
                // 'politique_distribution' => $request->politique_distribution,
                'etude_marche' => $request->etude_marche,
                'etude_demande' => $request->etude_demande,

                // DOSSIER TECHNIQUE
                'description_infrastructure' => $request->infrastructures,
                'description_equipement' => $request->equipements,
                'description_process' => $request->approvisionnement,
                'processus_production' => $request->production,
                'reglementation' => $request->reglementation,

                // DOSSIER FINANCIER
                'estimation_chiffre_affaire' => $request->estimation_chiffre_affaire,
                'montant_emprunt' => (double) preg_replace('/\s+/u', '', $request->montant_emprunt),
                'nombre_year_remb' => $request->nombre_year_remb,
                'cible_partenaire' => $request->cible_partenaire,
                'pourcentage_evolution' => $request->pourcentage_evolution,
                'id_user' => $id_user,
            ]);




            // ETAPES ACTIVITES
            $removePlanning = Planning::where('id_plan_affaire', $business_plan->id)->delete();
            $etapes = $request->input('etapes_activites');
            $dates = $request->input('dates_indicatives');
            if($etapes){
                foreach ($etapes as $index => $etape) {
                    $date = $dates[$index];

                    // Enregistrer chaque activité dans la base de données
                    if($date && $etape){
                        Planning::create([
                            'id_plan_affaire' => $business_plan->id,
                            'step_activity' => $etape,
                            'date_indicative' => $date,
                        ]);
                    }
                }
            }


            // EMPLOYES
            $removeEmploye = Employe::where('id_plan_affaire', $business_plan->id)->delete();
            $postes = $request->input('poste');
            $qualifications = $request->input('qualification');
            $effectifs = $request->input('effectif');
            $salaires = $request->input('salaire');
            $taches = $request->input('taches');
            foreach ($postes as $index => $poste) {

                // Enregistrer chaque activité dans la base de données
                if($poste){
                    Employe::create([
                        'id_plan_affaire' => $business_plan->id,
                        'poste' => $poste,
                        'qualification' => $qualifications[$index],
                        'effectif' => $effectifs[$index],
                        'salaire_mensuel' => (double) preg_replace('/\s+/u', '', $salaires[$index]),
                        'tache_prevu' => $taches[$index],
                        'type_employee' => 'existent',
                    ]);
                }

            }

            $poste_recs = $request->input('poste_rec');
            $qualification_recs = $request->input('qualification_rec');
            $effectif_recs = $request->input('effectif_rec');
            $salaire_recs = $request->input('salaire_rec');
            $tache_recs = $request->input('taches_rec');
            foreach ($poste_recs as $index => $poste_rec) {

                // Enregistrer chaque activité dans la base de données
                if($poste_rec){
                    Employe::create([
                        'id_plan_affaire' => $business_plan->id,
                        'poste' => $poste_rec,
                        'qualification' => $qualification_recs[$index],
                        'effectif' => $effectif_recs[$index],
                        'salaire_mensuel' => (double) preg_replace('/\s+/u', '', $salaire_recs[$index]),
                        'tache_prevu' => $tache_recs[$index],
                        'type_employee' => 'recruter',
                    ]);
                }

            }


            // Estimation du chiffre d’affaires
            $removeChiffreAffaire = ChiffreAffaire::where('id_plan_affaire', $business_plan->id)->delete();
            $produits = $request->input('produits');
            $an_1s = $request->input('an_1');
            $an_2s = $request->input('an_2');
            $an_3s = $request->input('an_3');
            $an_4s = $request->input('an_4');
            $an_5s = $request->input('an_5');
            foreach ($produits as $index => $produit) {

                // Enregistrer chaque activité dans la base de données
                if($produit){
                    ChiffreAffaire::create([
                        'id_plan_affaire' => $business_plan->id,
                        'produit' => $produit,
                        'an_1' => (double) preg_replace('/\s+/u', '', $an_1s[$index]),
                        'an_2' => (double) preg_replace('/\s+/u', '', $an_2s[$index]),
                        'an_3' => (double) preg_replace('/\s+/u', '', $an_3s[$index]),
                        'an_4' => (double) preg_replace('/\s+/u', '', $an_4s[$index]),
                        'an_5' => (double) preg_replace('/\s+/u', '', $an_4s[$index]),
                    ]);
                }
            }

            // Partenaires ciblés
            $removePartenaire = Partenaire::where('id_plan_affaire', $business_plan->id)->delete();
            $partenaires = $request->input('nom_partenaire');
            $montant_empruntes = $request->input('montant_emprunte');
            // $apport_personnel_empruntes = $request->input('apport_personnel_emprunte');
            // $subvention_empruntes = $request->input('subvention_emprunte');
            $nombre_year_rems = $request->input('nombre_year_rem');
            foreach ($partenaires as $index => $partenaire) {

                // Enregistrer chaque activité dans la base de données
                if($partenaire){
                    Partenaire::create([
                        'id_plan_affaire' => $business_plan->id,
                        'nom_partenaire' => $partenaire,
                        'montant_emprunt' => (double) preg_replace('/\s+/u', '', $montant_empruntes[$index]),
                        // 'apport_personnel_emprunte' => (double) preg_replace('/\s+/u', '', $apport_personnel_empruntes[$index]),
                        // 'subvention_emprunte' => (double) preg_replace('/\s+/u', '', $subvention_empruntes[$index]),
                        'nombre_year_remb' => $nombre_year_rems[$index],
                    ]);
                }
            }

            // Chiffre d’affaires de la première année
            // $removeChiffreAffaireFirstYear = ChiffreAffaireFirstYear::where('id_plan_affaire', $business_plan->id)->delete();
            $produit_firsts = $request->input('produit_first');
            $removeChiffreAffaireFirstYear = ChiffreAffaireFirstYear::where('id_plan_affaire', $business_plan->id)->whereNotIn('id',$produit_firsts)->delete();
            $produits = $request->input('produit');
            $unite_firsts = $request->input('unite_first');
            $quantite_firsts = $request->input('quantite_first');
            $prix_unitaire_firsts = $request->input('prix_unitaire_first');
            $chiffre_affaire_firsts = $request->input('chiffre_affaire_first');
            $pourcentage_firsts = $request->input('pourcentage_first');

            foreach ($produits as $index => $produit) {

                if($produit){
                    $pourcentage_evolution = $pourcentage_firsts[$index];

                    $chiffreAffaireFirstYear_exist = ChiffreAffaireFirstYear::find($produit_firsts[$index]);
                    if($chiffreAffaireFirstYear_exist){
                        $chiffreAffaireFirstYear_exist->update([
                            'id_plan_affaire' => $business_plan->id,
                            'produit' => $produit,
                            'unite_first' => $unite_firsts[$index],
                            'quantite' => (double) preg_replace('/\s+/u', '', $quantite_firsts[$index]),
                            'prix_unitaire' => (double) preg_replace('/\s+/u', '', $prix_unitaire_firsts[$index]),
                            'chiffre_affaire_first' => (double) preg_replace('/\s+/u', '', $chiffre_affaire_firsts[$index]),
                            'pourcentage_first' => (double) preg_replace('/\s+/u', '', $pourcentage_evolution),
                        ]);
                    }else{
                        ChiffreAffaireFirstYear::create([
                            'id_plan_affaire' => $business_plan->id,
                            'produit' => $produit,
                            'unite_first' => $unite_firsts[$index],
                            'quantite' => (double) preg_replace('/\s+/u', '', $quantite_firsts[$index]),
                            'prix_unitaire' => (double) preg_replace('/\s+/u', '', $prix_unitaire_firsts[$index]),
                            'chiffre_affaire_first' => (double) preg_replace('/\s+/u', '', $chiffre_affaire_firsts[$index]),
                            'pourcentage_first' => (double) preg_replace('/\s+/u', '', $pourcentage_evolution),
                        ]);
                    }


                    // CHIFFRE D'AFFAIRE 5 ANS
                    if(floatval($pourcentage_evolution>0)){
                        $c_an_1 = (double) preg_replace('/\s+/u', '', $chiffre_affaire_firsts[$index]);
                        $c_an_2 = $c_an_1 + (floatval($pourcentage_evolution)*$c_an_1)/100;
                        $c_an_3 = $c_an_2 + floatval($pourcentage_evolution)*$c_an_2/100;
                        $c_an_4 = $c_an_3 + floatval($pourcentage_evolution)*$c_an_3/100;
                        $c_an_5 = $c_an_4 + floatval($pourcentage_evolution)*$c_an_4/100;
                        ChiffreAffaire::create([
                            'id_plan_affaire' => $business_plan->id,
                            'produit' => $produit,
                            'an_1' => $c_an_1,
                            'an_2' => $c_an_2,
                            'an_3' => $c_an_3,
                            'an_4' => $c_an_4,
                            'an_5' => $c_an_5,
                            'is_ch_first'=>true,
                        ]);
                    }

                }
            }

            // 4.2	Equipements de production
            $removeEquipementProduction = EquipementProduction::where('id_plan_affaire', $business_plan->id)->delete();
            // EXIST
            $designation_equipement_exists = $request->input('designation_equipement_exist');
            $unite_equipement_exists = $request->input('unite_equipement_exist');
            $quantite_equipement_exists = $request->input('quantite_equipement_exist');
            $etat_fonctionnements = $request->input('etat_fonctionnement');
            foreach ($designation_equipement_exists as $index => $designation_equipement_exist) {
                if($designation_equipement_exist){
                    EquipementProduction::create([
                        'id_plan_affaire' => $business_plan->id,
                        'description' => $designation_equipement_exist,
                        'unite' => $unite_equipement_exists[$index],
                        'quantite' => (double) preg_replace('/\s+/u', '', $quantite_equipement_exists[$index]),
                        'etat_fonctionnement' => $etat_fonctionnements[$index],
                        'type_equipement' => 'existent',
                    ]);
                }
            }

            // AQ
            $designation_equipement_aqs = $request->input('designation_equipement_aq');
            $unite_equipement_aqs = $request->input('unite_equipement_aq');
            $quantite_equipement_aqs = $request->input('quantite_equipement_aq');
            $source_approvisionnements = $request->input('source_approvisionnement');
            foreach ($designation_equipement_aqs as $index => $designation_equipement_aq) {
                if($designation_equipement_aqs){
                    EquipementProduction::create([
                        'id_plan_affaire' => $business_plan->id,
                        'description' => $designation_equipement_aq,
                        'unite' => $unite_equipement_aqs[$index],
                        'quantite' => (double) preg_replace('/\s+/u', '', $quantite_equipement_aqs[$index]),
                        'etat_fonctionnement' => $source_approvisionnements[$index],
                        'type_equipement' => 'acquerir',
                    ]);
                }
            }

            // Service exterieur
            $removeServiceExterieur = ServiceExterieur::where('id_plan_affaire', $business_plan->id)->delete();
            $designation_ses = $request->input("designation_service_exterieur");
            $unite_ses = $request->input("unite_service_exterieur");
            $quantite_ses = $request->input("quantite_service_exterieur");
            $cout_ses = $request->input("cout_unitaire_service_exterieur");
            foreach ($designation_ses as $index => $designation_se) {

                $unite = $unite_ses[$index] ?? null;
                $quantite = (double) preg_replace('/\s+/u', '', $quantite_ses[$index]) ?? 0;
                $cout_unitaire = (double) preg_replace('/\s+/u', '', $cout_ses[$index]) ?? 0;
                $cout_total = $quantite * $cout_unitaire;

                if($designation_se){
                    ServiceExterieur::create([
                        'id_plan_affaire' => $business_plan->id,
                        'designation' => $designation_se,
                        'unite' => $unite,
                        'quantite' => (double) preg_replace('/\s+/u', '', $quantite),
                        'cout_unitaire' => (double) preg_replace('/\s+/u', '', $cout_unitaire),
                        'cout_total' => (double) preg_replace('/\s+/u', '', $cout_total),
                    ]);
                }
            }

            // Charge d'exploitation existentes
            $removeChareExploitation = ChareExploitation::where('id_plan_affaire', $business_plan->id)->delete();
            $charge_exs = $request->input('charge_existe'); // Ex: [1, 2, 3]
            if($charge_exs){
                foreach ($charge_exs as $index => $charge_exId) {
                    // Récupère les tableaux pour cette charge
                    $designations = $request->input("designation_charge_existe$charge_exId", []);
                    // $unites = $request->input("unite_charge_existe$charge_exId", []);
                    $quantites = $request->input("quantite_charge_existe$charge_exId", []);
                    $etat_charge_existes = $request->input("etat_charge_existe$charge_exId", []);

                    foreach ($designations as $index => $designation) {

                        // $unite = $unites[$index] ?? null;
                        $quantite = (double) preg_replace('/\s+/u', '', $quantites[$index]) ?? 0;
                        // $cout_unitaire = (double) preg_replace('/\s+/u', '', $couts[$index]) ?? 0;
                        $etat_charge_existe = $etat_charge_existes[$index];

                        if($designation){
                            ChareExploitation::create([
                                'id_plan_affaire' => $business_plan->id,
                                'designation' => $designation,
                                'id_valeur' => $charge_exId,
                                // 'unite' => $unite,
                                'quantite' => (double) preg_replace('/\s+/u', '', $quantite),
                                'etat_fonctionnement' => $etat_charge_existe,
                                // 'cout_total' => (double) preg_replace('/\s+/u', '', $cout_total),
                                'type_mat' => 'existent',
                            ]);
                        }
                    }
                }
            }


            $charge_aqs = $request->input('charge_acquerir'); // Ex: [1, 2, 3]
            if($charge_aqs){
                foreach ($charge_aqs as $index => $charge_aqId) {
                    // Récupère les tableaux pour cette charge
                    $designations = $request->input("designation_charge_acquerir$charge_aqId", []);
                    $unites = $request->input("unite_charge_acquerir$charge_aqId", []);
                    $quantites = $request->input("quantite_charge_acquerir$charge_aqId", []);
                    $source_charge_acquerirs = $request->input("source_charge_acquerir$charge_aqId", []);

                    foreach ($designations as $index => $designation) {

                        $unite = $unites[$index] ?? null;
                        $quantite = (double) preg_replace('/\s+/u', '', $quantites[$index]) ?? 0;
                        // $cout_unitaire = (double) preg_replace('/\s+/u', '', $couts[$index]) ?? 0;
                        $source_charge_acquerir = $source_charge_acquerirs[$index];

                        if($designation){
                            ChareExploitation::create([
                                'id_plan_affaire' => $business_plan->id,
                                'designation' => $designation,
                                'id_valeur' => $charge_aqId,
                                'unite' => $unite,
                                'quantite' => (double) preg_replace('/\s+/u', '', $quantite),
                                // 'cout_unitaire' => (double) preg_replace('/\s+/u', '', $cout_unitaire),
                                'etat_fonctionnement' => $source_charge_acquerir,
                                'type_mat' => 'acquerir',
                            ]);
                        }
                    }
                }
            }

            // STRUCUTURES FINANCIERES
            $removeStructureFinanciere = StructureFinanciere::where('id_plan_affaire', $business_plan->id)->delete();
            $designations = $request->input('designation_sf');
            $montants = $request->input('montant_sf');
            $apports = $request->input('apport_personnel');
            $subventions = $request->input('subvention_sf');
            $emprunts = $request->input('emprunt_sf');
            if($designations){
                foreach ($designations as $index => $designation) {
                    // Enregistrer chaque activité dans la base de données
                    if($designation){
                        StructureFinanciere::create([
                            'id_plan_affaire' => $business_plan->id,
                            'designation' => $designations[$index],
                            'montant' => (double) preg_replace('/\s+/u', '', $montants[$index]),
                            'apport_personnel' => (double) preg_replace('/\s+/u', '', $apports[$index]),
                            'subvention' => (double) preg_replace('/\s+/u', '', $subventions[$index]),
                            'emprunt' => (double) preg_replace('/\s+/u', '', $emprunts[$index]),
                        ]);
                    }
                }
            }
            $structureFinancieres = StructureFinanciere::where('id_plan_affaire', $business_plan->id)->get();
            $business_plan->update([
                'cout_total_projet' => $structureFinancieres->sum('montant'),
                'apport_personnel' => $structureFinancieres->sum('apport_personnel'),
                'cout_total_emprunt' => $structureFinancieres->sum('emprunt'),
            ]);


            return redirect()->back()->with('success', 'Plan d\'affaire mis à jour avec succès!');

        } catch (Exception $ex) {
            dd($ex);
        }
    }

    /**
     * Business Plan Modele
     */
    public function downloadBusinessPlan($id_plan_affaire)
    {
        $business_plan = PlanAffaire::find($id_plan_affaire);
        $templatePath = storage_path('app/templates/plan_affaire.docx');
        $templateProcessor = new TemplateProcessor($templatePath);
        // ENTREPRISE
        $entreprise = $business_plan->entreprise;
        $templateProcessor->setValue('nom', $business_plan->entreprise?$business_plan->entreprise->denomination:"");
        $templateProcessor->setValue('adresse', $business_plan->entreprise?$business_plan->entreprise->adresse_entreprise:"");
        $templateProcessor->setValue('telephone', $business_plan->entreprise?$business_plan->entreprise->tel_entreprise:"");
        $templateProcessor->setValue('email', $business_plan->entreprise?$business_plan->entreprise->email_entreprise:"");
        $templateProcessor->setValue('atout', $business_plan->entreprise?$business_plan->entreprise->atout_promoteur:"");
        $templateProcessor->setValue('presentation', $business_plan->entreprise?$business_plan->entreprise->presentation_entreprise:"");
        $templateProcessor->setValue('juridique', $business_plan->entreprise?$business_plan->entreprise->statut_juridique_gerance:"");
        $region = "...";
        $province = "...";
        $commune = "...";
        $arrondissement = "...";
        if($entreprise){
            $region = $entreprise->region?$entreprise->region->nom_structure:"...";
            $province = $entreprise->province?$entreprise->province->nom_structure:"...";
            $commune = $entreprise->commune?$entreprise->commune->nom_structure:"...";
            $arrondissement = $entreprise->arrondissement?$entreprise->arrondissement->nom_structure:"...";
        }
        $templateProcessor->setValue('region', $region);
        $templateProcessor->setValue('province', $province);
        $templateProcessor->setValue('commune', $commune);
        $templateProcessor->setValue('arrondissement', $arrondissement);

        $year = get_years($id_plan_affaire);
        $year1 = $year - 2;
        $year2 = $year - 1;
        $year3 = $year;
        $templateProcessor->setValue('year1', $year1);
        $templateProcessor->setValue('year2', $year2);
        $templateProcessor->setValue('year3', $year3);
        $compteExploitations = compte_exploitation($id_plan_affaire);
        $bilanMasseActifs = bilanMasseActif($id_plan_affaire);
        $bilanMassePacifs = bilanMassePacifs($id_plan_affaire);

        $compteExploitationArray = $compteExploitations->toArray();
        $bilanMasseActifArray = $bilanMasseActifs->toArray();
        $bilanMassePacifArray = $bilanMassePacifs->toArray();
        // Cloner les lignes dans le template Word selon le nombre d'enregistrements
        $templateProcessor->cloneRow('cexploitation', count($compteExploitationArray));
        $templateProcessor->cloneRow('bactif', count($bilanMasseActifArray));
        $templateProcessor->cloneRow('bpacif', count($bilanMassePacifArray));

        $ce = 1;
        // Injection des données dans le tableau Word
        foreach ($compteExploitationArray as $index => $compteExploitation) {
            $templateProcessor->setValue("cexploitation#{$ce}", $compteExploitation->libelle ?? '');
            $templateProcessor->setValue("first#{$ce}", number_format($compteExploitation->first_year, 0, ',', ' ')?? '');
            $templateProcessor->setValue("second#{$ce}", number_format($compteExploitation->second_year, 0, ',', ' ')?? '');
            $templateProcessor->setValue("third#{$ce}", number_format($compteExploitation->third_year, 0, ',', ' ')?? '');
            $ce = $ce + 1;
        }

        $ca = 1;
        // Injection des données dans le tableau Word
        foreach ($bilanMasseActifArray as $index => $bilanMasseActif) {
            $templateProcessor->setValue("bactif#{$ca}", $bilanMasseActif->libelle ?? '');
            $templateProcessor->setValue("afirst#{$ca}", number_format($bilanMasseActif->first_year, 0, ',', ' ')?? '');
            $templateProcessor->setValue("asecond#{$ca}", number_format($bilanMasseActif->second_year, 0, ',', ' ')?? '');
            $templateProcessor->setValue("athird#{$ca}", number_format($bilanMasseActif->third_year, 0, ',', ' ')?? '');
            $ca = $ca + 1;
        }

        $templateProcessor->setValue("tafirst", number_format($bilanMasseActifs->sum('first_year'), 0, ',', ' ')?? '');
        $templateProcessor->setValue("tasecond", number_format($bilanMasseActifs->sum('second_year'), 0, ',', ' ')?? '');
        $templateProcessor->setValue("tathird", number_format($bilanMasseActifs->sum('third_year'), 0, ',', ' ')?? '');

        $cp = 1;
        // Injection des données dans le tableau Word
        foreach ($bilanMassePacifArray as $index => $bilanMassePacif) {
            $templateProcessor->setValue("bpacif#{$cp}", $bilanMassePacif->libelle ?? '');
            $templateProcessor->setValue("pfirst#{$cp}", number_format($bilanMassePacif->first_year, 0, ',', ' ')?? '');
            $templateProcessor->setValue("psecond#{$cp}", number_format($bilanMassePacif->second_year, 0, ',', ' ')?? '');
            $templateProcessor->setValue("pthird#{$cp}", number_format($bilanMassePacif->third_year, 0, ',', ' ')?? '');
            $cp = $cp + 1;
        }

        $templateProcessor->setValue("tpfirst", number_format($bilanMassePacifs->sum('first_year'), 0, ',', ' ')?? '');
        $templateProcessor->setValue("tpsecond", number_format($bilanMassePacifs->sum('second_year'), 0, ',', ' ')?? '');
        $templateProcessor->setValue("tpthird", number_format($bilanMassePacifs->sum('third_year'), 0, ',', ' ')?? '');

        // PROMOTEUR
        $promoteur = Promoteur::where(['id_plan_affaire'=>$id_plan_affaire, 'is_porteur'=>true])->first();
        $templateProcessor->setValue('nom_promoteur', $promoteur?$promoteur->nom_promoteur.' '.$promoteur->prenom_promoteur:"");
        $templateProcessor->setValue('age_promoteur', $promoteur?$promoteur->age:"");

        // $templateProcessor->setValue('email', 'jean.dupont@example.com');
        // MOIS
        $mos = array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
        $templateProcessor->setValue('date', $mos[((int) date('m'))-1].' '.date('Y'));
        $templateProcessor->setValue('business_idea', $business_plan->business_idea);
        $templateProcessor->setValue('business_object', $business_plan->business_object);
        $templateProcessor->setValue('titre', $business_plan->business_titre);
        $templateProcessor->setValue('caractere', $business_plan->caractere_innovant_projet);
        $templateProcessor->setValue('total', number_format($business_plan->cout_total_projet, 0, ',', ' ')??0);
        $templateProcessor->setValue('apport', number_format($business_plan->apport_personnel, 0, ',', ' ')??0);
        $templateProcessor->setValue('credit', number_format($business_plan->cout_total_emprunt, 0, ',', ' ')??0);
        $templateProcessor->setValue('marche', $business_plan->etude_marche??'');
        $templateProcessor->setValue('demande', $business_plan->etude_demande??'');
        $templateProcessor->setValue('activite', $business_plan->business_activity??'');
        $file_name = $business_plan->entreprise?Str::slug($business_plan->entreprise->denomination, '_'):$id_plan_affaire;

        // CHIFFRE D'AFFAIRE DE LA PREMIERE ANNEE
        // Récupération des données
        $charge_firsts = $business_plan->chiffre_affaire_first_years;

        // S'assurer que c'est une collection ou tableau
        $charge_firstsArray = $charge_firsts->toArray();
        $produits = "";
        // Cloner les lignes dans le template Word selon le nombre d'enregistrements
        $templateProcessor->cloneRow('produit', count($charge_firstsArray));
        // Injection des données dans le tableau Word
        $i = 1;
        foreach ($charge_firstsArray as $index => $charge_first) {
            $produits = $produits.', '.$charge_first['produit'] ?? '';
            $templateProcessor->setValue("produit#{$i}", $charge_first['produit'] ?? '');
            $templateProcessor->setValue("unite_first#{$i}", $charge_first['unite_first']?? '');
            $templateProcessor->setValue("quantite_first#{$i}", number_format($charge_first['quantite'], 0, ',', ' ')?? '');
            $templateProcessor->setValue("prix_unitaire_first#{$i}", number_format($charge_first['prix_unitaire'], 0, ',', ' ')?? '');
            $templateProcessor->setValue("chiffre_affaire_first#{$i}", number_format($charge_first['chiffre_affaire_first'], 0, ',', ' ')?? '');
            $i = $i + 1;
        }

        $templateProcessor->setValue('produits', $produits);

        // S'assurer que c'est une collection ou tableau
        $charge_firstprodsArray = $charge_firsts->toArray();
        // Cloner les lignes dans le template Word selon le nombre d'enregistrements
        $templateProcessor->cloneRow('nom_produit', count($charge_firstprodsArray));
        $i_prod = 1;
        foreach ($charge_firstprodsArray as $charge_firstprod) {
            $templateProcessor->setValue("nom_produit#{$i_prod}", '3.1.'.$i_prod.'. '.$charge_firstprod['produit']);
            $i_prod = $i_prod + 1;
        }

        // ESTIMATION CHIFFRE D'AFFAIRES
        // Récupération des données
        $charges = $business_plan->chiffre_affaires;

        // S'assurer que c'est une collection ou tableau
        $chargesArray = $charges->toArray();

        // Cloner les lignes dans le template Word selon le nombre d'enregistrements
        $templateProcessor->cloneRow('designation', count($chargesArray));
        $i_ch = 1;
        // Injection des données dans le tableau Word
        foreach ($chargesArray as $index => $charge) {

            $templateProcessor->setValue("designation#{$i_ch}", $charge['produit'] ?? '');
            $templateProcessor->setValue("annee1#{$i_ch}", number_format($charge['an_1'], 0, ',', ' ')?? '');
            $templateProcessor->setValue("annee2#{$i_ch}", number_format($charge['an_2'], 0, ',', ' ')?? '');
            $templateProcessor->setValue("annee3#{$i_ch}", number_format($charge['an_3'], 0, ',', ' ')?? '');
            $templateProcessor->setValue("annee4#{$i_ch}", number_format($charge['an_4'], 0, ',', ' ')?? '');
            $templateProcessor->setValue("annee5#{$i_ch}", number_format($charge['an_5'], 0, ',', ' ')?? '');

            $i_ch = $i_ch + 1;
        }

        $chiffre_affaire_moyen = floatval($charges->sum('an_1'))+floatval($charges->sum('an_2'))+floatval($charges->sum('an_3'))+floatval($charges->sum('an_4'))+floatval($charges->sum('an_5'));
        $templateProcessor->setValue('moyen', $chiffre_affaire_moyen>0?number_format($chiffre_affaire_moyen/5, 0, ',', ' ') : 0);

        // CHARGES
        $charge_exploitations = $business_plan->charge_exploitations;

        // MATIERES PREMIERES
        $matieres = $charge_exploitations->where('id_valeur', env('matiere_premiere'));

        // SERVICES EXTERIEURS
        $services = $charge_exploitations->where('id_valeur', env('service_exterieur'));

        // INFRASTRUCTURES ET AMENAGEMENT
        $infrastructures = $charge_exploitations->where('id_valeur', env('infrastructure_amenagement'));

        // EQUIPEMENT DE PRODUCTION
        // $equipements = $charge_exploitations->where('id_valeur', env('equipement_production'));
        // EXIST
        $equipement_exists = $business_plan->equipement->filter(function ($equipement_ex) {
            return ($equipement_ex->type_equipement == 'existent') !== false;
        });
        // S'assurer que c'est une collection ou tableau
        $equipementExistsArray = $equipement_exists->toArray();
        // Cloner les lignes dans le template Word selon le nombre d'enregistrements
        $templateProcessor->cloneRow('designation_exist', count($equipementExistsArray));
        // Injection des données dans le tableau Word
        $ex = 1;
        foreach ($equipementExistsArray as $index => $equipementExist) {

            $templateProcessor->setValue("designation_exist#{$ex}", $equipementExist['description'] ?? '');
            $templateProcessor->setValue("unite_exist#{$ex}", $equipementExist['unite']?? '');
            $templateProcessor->setValue("quantite_exist#{$ex}", number_format($equipementExist['quantite'], 0, ',', ' ')?? '');
            $templateProcessor->setValue("etat_fonctionnement#{$ex}", $equipementExist['etat_fonctionnement']?? '');
            $ex = $ex + 1;
        }

        // AQ
        $equipement_aqs = $business_plan->equipement->filter(function ($equipement_a) {
            return ($equipement_a->type_equipement == 'acquerir') !== false;
        });
         // S'assurer que c'est une collection ou tableau
        $equipementAqsArray = $equipement_aqs->toArray();
        // Cloner les lignes dans le template Word selon le nombre d'enregistrements
        $templateProcessor->cloneRow('designation_aq', count($equipementAqsArray));
        $aq = 1;
        foreach ($equipementAqsArray as $index => $equipementAq) {

            $templateProcessor->setValue("designation_aq#{$aq}", $equipementAq['description'] ?? '');
            $templateProcessor->setValue("unite_aq#{$aq}", $equipementAq['unite']?? '');
            $templateProcessor->setValue("quantite_aq#{$aq}", number_format($equipementAq['quantite'], 0, ',', ' ')?? '');
            $templateProcessor->setValue("source_approvisionnement#{$aq}", $equipementAq['etat_fonctionnement']?? '');
            $aq = $aq + 1;
        }



        // MATERIELS ET MOBILIERS
        // $materiel_exs = $charge_exploitations->where(['id_valeur'=>env('materiel_mobilier'), 'type_mat'=>'existent']);
        // $materiel_exs = $charge_exploitations->where('id_valeur', env('materiel_mobilier'));
        // EXISTENT
        $materiel_exs = $charge_exploitations->filter(function ($materiel_ex) {
            return ($materiel_ex->id_valeur == env('materiel_mobilier')) !== false && ($materiel_ex->type_mat == 'existent') !== false;
        });
        // S'assurer que c'est une collection ou tableau
        $materiel_exsArray = $materiel_exs->toArray();
        // Cloner les lignes dans le template Word selon le nombre d'enregistrements
        $templateProcessor->cloneRow('designation_ma_ex', count($materiel_exsArray));
        // Injection des données dans le tableau Word
        $ma_ex = 1;
        foreach ($materiel_exsArray as $index => $chargeMaterielex) {
            $templateProcessor->setValue("designation_ma_ex#{$ma_ex}", $chargeMaterielex['designation'] ?? '');
            // $templateProcessor->setValue("unite_ma_ex#{$ma_ex}", $chargeMaterielex['unite']?? '');
            $templateProcessor->setValue("quantite_ma_ex#{$ma_ex}", number_format($chargeMaterielex['quantite'], 0, ',', ' ')?? '');
            // $templateProcessor->setValue("cout_unitaire_ma_ex#{$ma_ex}", number_format($chargeMaterielex['cout_unitaire'], 0, ',', ' ')?? '');
            // $templateProcessor->setValue("cout_total_ma_ex#{$ma_ex}", number_format($chargeMaterielex['cout_total'], 0, ',', ' ')?? '');
            $templateProcessor->setValue("etat_ma_ex#{$ma_ex}", $chargeMaterielex['etat_fonctionnement']?? '');
            $ma_ex = $ma_ex + 1;
        }

        // ACQUERIR
        $materiel_aqs = $charge_exploitations->filter(function ($materiel_aq) {
            return ($materiel_aq->id_valeur == env('materiel_mobilier')) !== false && ($materiel_aq->type_mat == 'acquerir') !== false;
        });
        // S'assurer que c'est une collection ou tableau
        $materiel_aqsArray = $materiel_aqs->toArray();
        // Cloner les lignes dans le template Word selon le nombre d'enregistrements
        $templateProcessor->cloneRow('designation_ma_aq', count($materiel_aqsArray));
        // Injection des données dans le tableau Word
        $ma_aq = 1;
        foreach ($materiel_aqsArray as $index => $chargeMaterielaq) {
            $templateProcessor->setValue("designation_ma_aq#{$ma_aq}", $chargeMaterielaq['designation'] ?? '');
            $templateProcessor->setValue("unite_ma_aq#{$ma_aq}", $chargeMaterielaq['unite']?? '');
            $templateProcessor->setValue("quantite_ma_aq#{$ma_aq}", number_format($chargeMaterielaq['quantite'], 0, ',', ' ')?? '');
            // $templateProcessor->setValue("cout_unitaire_ma_aq#{$ma_aq}", number_format($chargeMaterielaq['cout_unitaire'], 0, ',', ' ')?? '');
            // $templateProcessor->setValue("cout_total_ma_aq#{$ma_aq}", number_format($chargeMaterielaq['cout_total'], 0, ',', ' ')?? '');
            $templateProcessor->setValue("source_ma_aq#{$ma_aq}", $chargeMaterielaq['etat_fonctionnement']?? '');
            $ma_aq = $ma_aq + 1;
        }

        // MATERIELS INFORMATIQUES
        // $materiel_is = $charge_exploitations->where('id_valeur', env('materiel_informatique'));
        // EXISTENT
        $materiel_iexs = $charge_exploitations->filter(function ($materiel_iex) {
            return ($materiel_iex->id_valeur == env('materiel_informatique')) !== false && ($materiel_iex->type_mat == 'existent') !== false;
        });
        // S'assurer que c'est une collection ou tableau
        $materiel_iexsArray = $materiel_iexs->toArray();
        // Cloner les lignes dans le template Word selon le nombre d'enregistrements
        $templateProcessor->cloneRow('designation_mi_ex', count($materiel_iexsArray));
        // Injection des données dans le tableau Word
        $mi_ex = 1;
        foreach ($materiel_iexsArray as $index => $chargeMateriel_iex) {

            $templateProcessor->setValue("designation_mi_ex#{$mi_ex}", $chargeMateriel_iex['designation'] ?? '');
            // $templateProcessor->setValue("unite_mi_ex#{$mi_ex}", $chargeMateriel_iex['unite']?? '');
            $templateProcessor->setValue("quantite_mi_ex#{$mi_ex}", number_format($chargeMateriel_iex['quantite'], 0, ',', ' ')?? '');
            // $templateProcessor->setValue("cout_unitaire_mi_ex#{$mi_ex}", number_format($chargeMateriel_iex['cout_unitaire'], 0, ',', ' ')?? '');
            // $templateProcessor->setValue("cout_total_mi_ex#{$mi_ex}", number_format($chargeMateriel_iex['cout_total'], 0, ',', ' ')?? '');
            $templateProcessor->setValue("etat_mi_ex#{$mi_ex}", $chargeMateriel_iex['etat_fonctionnement']?? '');
            $mi_ex = $mi_ex + 1;
        }

        // ACQUERIR
        $materiel_iaqs = $charge_exploitations->filter(function ($materiel_iaq) {
            return ($materiel_iaq->id_valeur == env('materiel_informatique')) !== false && ($materiel_iaq->type_mat == 'acquerir') !== false;
        });
        // S'assurer que c'est une collection ou tableau
        $materiel_iaqsArray = $materiel_iaqs->toArray();
        // Cloner les lignes dans le template Word selon le nombre d'enregistrements
        $templateProcessor->cloneRow('designation_mi_aq', count($materiel_iaqsArray));
        // Injection des données dans le tableau Word
        $mi_aq = 1;
        foreach ($materiel_iaqsArray as $index => $chargeMateriel_iaq) {

            $templateProcessor->setValue("designation_mi_aq#{$mi_aq}", $chargeMateriel_iaq['designation'] ?? '');
            $templateProcessor->setValue("unite_mi_aq#{$mi_aq}", $chargeMateriel_iaq['unite']?? '');
            $templateProcessor->setValue("quantite_mi_aq#{$mi_aq}", number_format($chargeMateriel_iaq['quantite'], 0, ',', ' ')?? '');
            // $templateProcessor->setValue("cout_unitaire_mi_aq#{$mi_aq}", number_format($chargeMateriel_iaq['cout_unitaire'], 0, ',', ' ')?? '');
            // $templateProcessor->setValue("cout_total_mi_aq#{$mi_aq}", number_format($chargeMateriel_iaq['cout_total'], 0, ',', ' ')?? '');
            $templateProcessor->setValue("source_mi_aq#{$mi_aq}", $chargeMateriel_iaq['etat_fonctionnement']?? '');
            $mi_aq = $mi_aq + 1;
        }

        // MATERIELS ROULANTS
        // $materiel_rs = $charge_exploitations->where('id_valeur', env('materiel_'));
        // EXISTENT
        $materiel_rexs = $charge_exploitations->filter(function ($materiel_rex) {
            return ($materiel_rex->id_valeur == env('materiel_roulant')) !== false && ($materiel_rex->type_mat == 'existent') !== false;
        });
        // S'assurer que c'est une collection ou tableau
        $materiel_rexsArray = $materiel_rexs->toArray();
        // Cloner les lignes dans le template Word selon le nombre d'enregistrements
        $templateProcessor->cloneRow('designation_mr_ex', count($materiel_rexsArray));
        // Injection des données dans le tableau Word
        $mr_ex = 1;
        foreach ($materiel_rexsArray as $index => $chargeMateriel_rex) {

            $templateProcessor->setValue("designation_mr_ex#{$mr_ex}", $chargeMateriel_rex['designation'] ?? '');
            //$templateProcessor->setValue("unite_mr_ex#{$mr_ex}", $chargeMateriel_rex['unite']?? '');
            $templateProcessor->setValue("quantite_mr_ex#{$mr_ex}", number_format($chargeMateriel_rex['quantite'], 0, ',', ' ')?? '');
            // $templateProcessor->setValue("cout_unitaire_mr_ex#{$mr_ex}", number_format($chargeMateriel_rex['cout_unitaire'], 0, ',', ' ')?? '');
            // $templateProcessor->setValue("cout_total_mr_ex#{$mr_ex}", number_format($chargeMateriel_rex['cout_total'], 0, ',', ' ')?? '');
            $templateProcessor->setValue("etat_mr_ex#{$mr_ex}", $chargeMateriel_rex['etat_fonctionnement']?? '');
            $mr_ex = $mr_ex + 1;
        }

        // ACQUERIR
        $materiel_raqs = $charge_exploitations->filter(function ($materiel_raq) {
            return ($materiel_raq->id_valeur == env('materiel_roulant')) !== false && ($materiel_raq->type_mat == 'acquerir') !== false;
        });
        // S'assurer que c'est une collection ou tableau
        $materiel_raqsArray = $materiel_raqs->toArray();
        // Cloner les lignes dans le template Word selon le nombre d'enregistrements
        $templateProcessor->cloneRow('designation_mr_aq', count($materiel_raqsArray));
        // Injection des données dans le tableau Word
        $mr_aq = 1;
        foreach ($materiel_raqsArray as $index => $chargeMateriel_raq) {

            $templateProcessor->setValue("designation_mr_aq#{$mr_aq}", $chargeMateriel_raq['designation'] ?? '');
            $templateProcessor->setValue("unite_mr_aq#{$mr_aq}", $chargeMateriel_raq['unite']?? '');
            $templateProcessor->setValue("quantite_mr_aq#{$mr_aq}", number_format($chargeMateriel_raq['quantite'], 0, ',', ' ')?? '');
            // $templateProcessor->setValue("cout_unitaire_mr_aq#{$mr_aq}", number_format($chargeMateriel_raq['cout_unitaire'], 0, ',', ' ')?? '');
            // $templateProcessor->setValue("cout_total_mr_aq#{$mr_aq}", number_format($chargeMateriel_raq['cout_total'], 0, ',', ' ')?? '');
            $templateProcessor->setValue("source_mr_aq#{$mr_aq}", $chargeMateriel_raq['etat_fonctionnement']?? '');
            $mr_aq = $mr_aq + 1;
        }

        // INFRASTRUCTURES ET AMENAGEMENTS
        // $minfrastructure_amenagements = $charge_exploitations->where('id_valeur', env('infrastructure_amenagement'));
        // EXISTENT
        $infrastructure_amenagementexs = $charge_exploitations->filter(function ($infrastructure_amenagementex) {
            return ($infrastructure_amenagementex->id_valeur == env('infrastructure_amenagement')) !== false && ($infrastructure_amenagementex->type_mat == 'existent') !== false;
        });
        // S'assurer que c'est une collection ou tableau
        $infrastructure_amenagementexsArray = $infrastructure_amenagementexs->toArray();
        // Cloner les lignes dans le template Word selon le nombre d'enregistrements
        $templateProcessor->cloneRow('designation_ia_ex', count($infrastructure_amenagementexsArray));
        // Injection des données dans le tableau Word
        $ia_ex = 1;
        foreach ($infrastructure_amenagementexsArray as $index => $chargeinfrastructure_amenagementex) {

            $templateProcessor->setValue("designation_ia_ex#{$ia_ex}", $chargeinfrastructure_amenagementex['designation'] ?? '');
            // $templateProcessor->setValue("unite_ia_ex#{$ia_ex}", $chargeinfrastructure_amenagementex['unite']?? '');
            $templateProcessor->setValue("quantite_ia_ex#{$ia_ex}", number_format($chargeinfrastructure_amenagementex['quantite'], 0, ',', ' ')?? '');
            // $templateProcessor->setValue("cout_unitaire_ia_ex#{$ia_ex}", number_format($chargeinfrastructure_amenagementex['cout_unitaire'], 0, ',', ' ')?? '');
            // $templateProcessor->setValue("cout_total_ia_ex#{$ia_ex}", number_format($chargeinfrastructure_amenagementex['cout_total'], 0, ',', ' ')?? '');
            $templateProcessor->setValue("etat_ia_ex#{$ia_ex}",$chargeinfrastructure_amenagementex['etat_fonctionnement']?? '');
            $ia_ex = $ia_ex + 1;
        }

        // ACQUERIR
        $infrastructure_amenagementaqs = $charge_exploitations->filter(function ($infrastructure_amenagementaq) {
            return ($infrastructure_amenagementaq->id_valeur == env('infrastructure_amenagement')) !== false && ($infrastructure_amenagementaq->type_mat == 'acquerir') !== false;
        });
        // S'assurer que c'est une collection ou tableau
        $infrastructure_amenagementaqsArray = $infrastructure_amenagementaqs->toArray();
        // Cloner les lignes dans le template Word selon le nombre d'enregistrements
        $templateProcessor->cloneRow('designation_ia_aq', count($infrastructure_amenagementaqsArray));
        // Injection des données dans le tableau Word
        $ia_aq = 1;
        foreach ($infrastructure_amenagementaqsArray as $index => $chargeinfrastructure_amenagementaq) {

            $templateProcessor->setValue("designation_ia_aq#{$ia_aq}", $chargeinfrastructure_amenagementaq['designation'] ?? '');
            $templateProcessor->setValue("unite_ia_aq#{$ia_aq}", $chargeinfrastructure_amenagementaq['unite']?? '');
            $templateProcessor->setValue("quantite_ia_aq#{$ia_aq}", number_format($chargeinfrastructure_amenagementaq['quantite'], 0, ',', ' ')?? '');
            // $templateProcessor->setValue("cout_unitaire_ia_aq#{$ia_aq}", number_format($chargeinfrastructure_amenagementaq['cout_unitaire'], 0, ',', ' ')?? '');
            // $templateProcessor->setValue("cout_total_ia_aq#{$ia_aq}", number_format($chargeinfrastructure_amenagementaq['cout_total'], 0, ',', ' ')?? '');
            $templateProcessor->setValue("source_ia_aq#{$ia_aq}", $chargeinfrastructure_amenagementaq['etat_fonctionnement']?? '');
            $ia_aq = $ia_aq + 1;
        }

        // PERSONNEL: ORGANISATION, EFFECTIF, QUALIFICATION ET TÂCHES PRÉVUES
        // Récupération des données
        // EXIST
        $i_ex = 1;
        $employee_exists = $business_plan->employes->filter(function ($employee_ex) {
            return ($employee_ex->type_employee == 'existent') !== false;
        });

        // AQ
        $i_rec = 1;
        $employee_recs = $business_plan->employes->filter(function ($employee_rec) {
            return ($employee_rec->type_employee == 'recruter') !== false;
        });

        // S'assurer que c'est une collection ou tableau
        $personnelsArray = $employee_exists->toArray();
        $personnelsRecArray = $employee_recs->toArray();

        // Cloner les lignes dans le template Word selon le nombre d'enregistrements
        $templateProcessor->cloneRow('employe', count($personnelsArray));
        $templateProcessor->cloneRow('employe_rec', count($personnelsRecArray));

        $templateProcessor->setValue('nombre_employe_exist', $employee_exists->count()??0);
        $templateProcessor->setValue('nombre_employe_rec', $employee_recs->count()??0);

        // Injection des données dans le tableau Word
        foreach ($personnelsArray as $index => $employe) {


            $templateProcessor->setValue("employe#{$i_ex}", $employe['poste'] ?? '');
            $templateProcessor->setValue("qualification#{$i_ex}", $employe['qualification']?? '');
            $templateProcessor->setValue("effectif#{$i_ex}", $employe['effectif']?? '');
            $templateProcessor->setValue("salaire_mensuel#{$i_ex}", number_format($employe['salaire_mensuel'], 0, ',', ' ')?? '');
            $templateProcessor->setValue("tache_prevu#{$i_ex}", $employe['tache_prevu']?? '');
            $i_ex = $i_ex + 1;
        }

        // Injection des données dans le tableau Word
        foreach ($personnelsRecArray as $index_rec => $employe_rec) {

            $templateProcessor->setValue("employe_rec#{$i_rec}", $employe_rec['poste'] ?? '');
            $templateProcessor->setValue("qualification_rec#{$i_rec}", $employe_rec['qualification']?? '');
            $templateProcessor->setValue("effectif_rec#{$i_rec}", $employe_rec['effectif']?? '');
            $templateProcessor->setValue("salaire_mensuel_rec#{$i_rec}", number_format($employe_rec['salaire_mensuel'], 0, ',', ' ')?? '');
            $templateProcessor->setValue("tache_prevu_rec#{$i_rec}", $employe_rec['tache_prevu']?? '');
            $i_rec = $i_rec + 1;
        }

        // ENGAGEMENT EN COURS AVEC LES BANQUES
        // Récupération des données
        $engagements = $business_plan->entreprise->engagements;

        // S'assurer que c'est une collection ou tableau
        $engagementsArray = $engagements->toArray();
        // Cloner les lignes dans le template Word selon le nombre d'enregistrements
        $templateProcessor->cloneRow('engagement', count($engagementsArray));
        $i_en = 1;
        // Injection des données dans le tableau Word
        foreach ($engagementsArray as $index => $engagement) {
            $templateProcessor->setValue("nature#{$i_en}", $engagement['nature_credit'] ?? '');
            $templateProcessor->setValue("engagement#{$i_en}", $engagement['nom_banque'] ?? '');
            $templateProcessor->setValue("date_debut#{$i_en}", $engagement['date_debut'] ?? '');
            $templateProcessor->setValue("montant_emprunt#{$i_en}", number_format($engagement['montant_emprunt'], 0, ',', ' ')?? '');
            $templateProcessor->setValue("mensualite#{$i_en}", number_format($engagement['mensualite'], 0, ',', ' ')?? '');
            $templateProcessor->setValue("montant_restant#{$i_en}", number_format($engagement['montant_restant'], 0, ',', ' ')?? '');
            $templateProcessor->setValue("date_echeance#{$i_en}", $engagement['date_echeance'] ?? '');

            $i_en = $i_en + 1;
        }

        // ESTIMATION ACTIVITES
        // Récupération des données
        $activites = $business_plan->activities;

        // S'assurer que c'est une collection ou tableau
        $activitesArray = $activites->toArray();

        // Cloner les lignes dans le template Word selon le nombre d'enregistrements
        $templateProcessor->cloneRow('planning_act', count($activitesArray));

        $i_ac = 1;
        // Injection des données dans le tableau Word
        foreach ($activitesArray as $index => $activite) {

            $templateProcessor->setValue("planning_act#{$i_ac}", $activite['step_activity'] ?? '');
            $templateProcessor->setValue("echeance#{$i_ac}", $activite['date_indicative'] ?? '');
            $i_ac = $i_ac + 1;
        }

        // ESTIMATION PARTENAIRES
        // Récupération des données
        /*$partenaires = $business_plan->partenaire;

        // S'assurer que c'est une collection ou tableau
        $partenairesArray = $partenaires->toArray();

        // Cloner les lignes dans le template Word selon le nombre d'enregistrements
        $templateProcessor->cloneRow('partenaire', count($partenairesArray));
        $i_pa = 1;
        // Injection des données dans le tableau Word
        foreach ($partenairesArray as $index => $partenaire) {

            $templateProcessor->setValue("partenaire#{$i_pa}", $partenaire['nom_partenaire'] ?? '');
            $templateProcessor->setValue("montant#{$i_pa}", number_format($partenaire['montant_emprunt'], 0, ',', ' ') ?? '');
            $templateProcessor->setValue("apportper#{$i_pa}", number_format($partenaire['apport_personnel_emprunte'], 0, ',', ' ') ?? '');
            $templateProcessor->setValue("subvention#{$i_pa}", number_format($partenaire['subvention_emprunte'], 0, ',', ' ') ?? '');

            $i_pa = $i_pa + 1;
        }*/

        // ESTIMATION STRUCTURE FINANCIERES
        // Récupération des données
        $structure_financieres = $business_plan->structureFinanciere;

        // S'assurer que c'est une collection ou tableau
        $structure_financieresArray = $structure_financieres->toArray();

        // Cloner les lignes dans le template Word selon le nombre d'enregistrements
        $templateProcessor->cloneRow('designation_sf', count($structure_financieresArray));
        $i_sf = 1;
        // Injection des données dans le tableau Word
        foreach ($structure_financieresArray as $index => $structure_financiere) {

            $templateProcessor->setValue("designation_sf#{$i_sf}", $structure_financiere['designation'] ?? '');
            $templateProcessor->setValue("montant_sf#{$i_sf}", number_format($structure_financiere['montant'], 0, ',', ' ') ?? '');
            $templateProcessor->setValue("apport_sf#{$i_sf}", number_format($structure_financiere['apport_personnel'], 0, ',', ' ') ?? '');
            $templateProcessor->setValue("pourcentage_apport_sf#{$i_sf}", floatval($structure_financiere['montant'])>0?round((floatval($structure_financiere['apport_personnel'])/floatval($structure_financiere['montant']))*100, 2): '');
            $templateProcessor->setValue("subvention_sf#{$i_sf}", number_format($structure_financiere['subvention'], 0, ',', ' ') ?? '');
            $templateProcessor->setValue("pourcentage_subvention_sf#{$i_sf}", floatval($structure_financiere['montant'])>0?round((floatval($structure_financiere['subvention'])/floatval($structure_financiere['montant']))*100, 2): '');
            $templateProcessor->setValue("emprunt_sf#{$i_sf}", number_format($structure_financiere['emprunt'], 0, ',', ' ') ?? '');
            $templateProcessor->setValue("pourcentage_emprunt_sf#{$i_sf}", floatval($structure_financiere['montant'])>0?round((floatval($structure_financiere['emprunt'])/floatval($structure_financiere['montant']))*100, 2): '');

            $i_sf = $i_sf + 1;
        }

        $templateProcessor->setValue('total_montant_sf', number_format($structure_financieres->sum('montant'), 0, ',', ' ')??0);
        $templateProcessor->setValue('total_apport_sf', number_format($structure_financieres->sum('apport_personnel'), 0, ',', ' ')??0);
        $templateProcessor->setValue('pourcent_apport_sf', floatval($structure_financieres->sum('montant'))>0?round((floatval($structure_financieres->sum('apport_personnel'))/floatval($structure_financieres->sum('montant')))*100, 2): '');
        $templateProcessor->setValue('total_subvention_sf', number_format($structure_financieres->sum('subvention'), 0, ',', ' ')??0);
        $templateProcessor->setValue('pourcent_subvention_sf', floatval($structure_financieres->sum('montant'))>0?round((floatval($structure_financieres->sum('subvention'))/floatval($structure_financieres->sum('montant')))*100, 2): '');
        $templateProcessor->setValue('total_emprunt_sf', number_format($structure_financieres->sum('emprunt'), 0, ',', ' ')??0);
        $templateProcessor->setValue('pourcent_emprunt_sf', floatval($structure_financieres->sum('montant'))>0?round((floatval($structure_financieres->sum('emprunt'))/floatval($structure_financieres->sum('montant')))*100, 2): '');

        // STRATEGIE MARKETING
        $groupedStrategieMarketings = DB::table('valeurs as v')
                ->leftJoin('parametres as p', 'p.id', 'v.id_parametre')
                ->leftJoin('strategie_marketings as sm', function ($join) use ($id_plan_affaire) {
                    $join->on('v.id', '=', 'sm.id_valeur')
                         ->where('sm.id_plan_affaire', $id_plan_affaire);
                })
                ->select(
                    'v.id_parametre',
                    'v.libelle as libelle_valeur',
                    'v.id as id_valeur',
                    'sm.libelle_sm' // ✅ correction de la faute : "liblle_sm" → "libelle_sm"
                )

                ->whereNull('v.deleted_at') // ✅ v est bien joint
                ->where('p.id_parent', env('strategie_marketing'))
                ->get();

        // Politique prix
        // Récupération des données
        $sm_prixs = $groupedStrategieMarketings->filter(function ($sm_p) {
                                            return ($sm_p->id_parametre == env('sm_prix')) !== false ;
                                        });

        // S'assurer que c'est une collection ou tableau
        $sm_prixsArray = $sm_prixs->toArray();

        // Cloner les lignes dans le template Word selon le nombre d'enregistrements
        $templateProcessor->cloneRow('sm_prix', count($sm_prixsArray));
        $i_prix = 1;
        // Injection des données dans le tableau Word
        foreach ($sm_prixsArray as $index => $sm_prix) {
            $templateProcessor->setValue("sm_prix#{$i_prix}", $sm_prix->libelle_valeur ?? '');
            $templateProcessor->setValue("libelle_smp#{$i_prix}", $sm_prix->libelle_sm ?? '');

            $i_prix = $i_prix + 1;
        }

        // Politique communication
        // Récupération des données
        $sm_coms = $groupedStrategieMarketings->filter(function ($sm_p) {
                                            return ($sm_p->id_parametre == env('sm_communication')) !== false ;
                                        });

        // S'assurer que c'est une collection ou tableau
        $sm_comsArray = $sm_coms->toArray();

        // Cloner les lignes dans le template Word selon le nombre d'enregistrements
        $templateProcessor->cloneRow('sm_com', count($sm_comsArray));
        $i_com = 1;
        // Injection des données dans le tableau Word
        foreach ($sm_comsArray as $index => $sm_com) {
            $templateProcessor->setValue("sm_com#{$i_com}", $sm_com->libelle_valeur ?? '');
            $templateProcessor->setValue("libelle_smc#{$i_com}", $sm_com->libelle_sm ?? '');

            $i_com = $i_com + 1;
        }

        // Politique distribution
        // Récupération des données
        $sm_dists = $groupedStrategieMarketings->filter(function ($sm_p) {
                                            return ($sm_p->id_parametre == env('sm_distribution')) !== false ;
                                        });

        // S'assurer que c'est une collection ou tableau
        $sm_distsArray = $sm_dists->toArray();

        // Cloner les lignes dans le template Word selon le nombre d'enregistrements
        $templateProcessor->cloneRow('sm_dist', count($sm_distsArray));
        $i_dist = 1;
        // Injection des données dans le tableau Word
        foreach ($sm_distsArray as $index => $sm_dist) {
            $templateProcessor->setValue("sm_dist#{$i_dist}", $sm_dist->libelle_valeur ?? '');
            $templateProcessor->setValue("libelle_smd#{$i_dist}", $sm_dist->libelle_sm ?? '');

            $i_dist = $i_dist + 1;
        }

        // Sauvegarde du document généré
        $outputPath = storage_path('app/docs/'.$file_name.'.docx');
        $templateProcessor->saveAs($outputPath);

        // Retourner le fichier en téléchargement
        return response()->download($outputPath)->deleteFileAfterSend(true);
    }

    /**
     * Visualiser détails Business Plan
     */
    public function showBusinessPlan(Request $request, $id_plan_affaire)
    {
        $business_plan = PlanAffaire::find($id_plan_affaire);
        $groupedCharges = DB::table('valeurs as v')
                    ->leftJoin('chare_exploitations as ce', function ($join) use ($id_plan_affaire) {
                        $join->on('ce.id_valeur', '=', 'v.id')
                            ->where('ce.id_plan_affaire', '=', $id_plan_affaire);
                    })
                    ->select(
                        'ce.id',
                        'v.id as id_valeur',
                        'v.libelle as valeur_libelle',
                        'v.description',
                        'ce.designation',
                        'ce.unite',
                        'ce.quantite',
                        'ce.cout_unitaire',
                        'ce.cout_total'
                    )
                    ->where('v.id_parametre', env('ID_CHARGE'))
                    ->whereNull('v.deleted_at')
                    ->orderBy('v.id', 'ASC')
                    ->get()
                    ->groupBy('id_valeur');
        return view('backend.businessplans.show', compact('business_plan', 'groupedCharges'));
    }

    /**
     * Valider Business Plan
     */
    public function validerBusinessPlan(Request $request, $id_plan_affaire)
    {
        $business_plan = PlanAffaire::find($id_plan_affaire);
        $business_plan->is_valide = true;
        $business_plan->date_valide = now();
        $business_plan->statut = env('valide');
        $business_plan->save();
        return redirect()->back()->with('success', 'Plan d\'affaire validé avec succès!');
    }

    /**
     * Payer Business Plan
     */
    public function payerBusinessPlan($id_plan_affaire)
    {
        $client = new Ligdicash([
            "api_key" => env('ligdicash_api_key'),
            "auth_token" => env('ligdicash_auth_token'),
            "platform" => env('ligdicash_platform')
        ]);

        // Décrire la facture et le client
        $invoice = $client->Invoice([
            "currency" => "XOF",
            "description" => "Paiement de création de plan d'affaire",
            "customer_firstname" => Auth::user()->name,
            "customer_lastname" => Auth::user()->name,
            "customer_email" => Auth::user()->email,
            "store_name" => "Mon plan d'affaire",
            "store_website_url" => "https://monbusinessplan.me.bf"
        ]);

        # Ajouter des éléments(produit, service, etc) à la facture
        $invoice->addItem([
            "name" => "PACK",
            "description" => "__description_du_produit__",
            "quantity" => 1,
            "unit_price" => 10
        ]);

        $success_url = route('success.payer', $id_plan_affaire);
        $cancel_url = route('cancel.payer', $id_plan_affaire);
        $callback_url = "https://5531903ae3e8.ngrok-free.app/api/business_plan/b964177d-530e-4954-9c99-a7d86e2f8ae8/callback"; // route('callback.payer', $id_plan_affaire);

        $response = $invoice->payWithRedirection([
            "return_url" => $success_url,
            "cancel_url" => $cancel_url,
            "callback_url" => $callback_url,
            "custom_data" => [
                "order_id" => "ORD-1234567890",
                "customer_id" => "CUST-1234567890"
            ]
        ]);
        $business_plan = PlanAffaire::find($id_plan_affaire);
        $business_plan->update([
            'token_paye'=>$response->token,
        ]);

        $payment_url = $response->response_text;
        // dd($payment_url);
        return redirect()->to($payment_url);
        return header("Location: https://client.ligdicash.com/directpayment/invoice/eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZF9pbnZvaWNlIjoiNjk1MTQ5MTQiLCJzdGFydF9kYXRlIjoiMjAyNS0wOC0yNCAxMDowNjoyMiIsImV4cGlyeV9kYXRlIjoxNzU2MTE2MzgyfQ.mE9UQAYtTeq-MB8CewH7O4BYojtKs82GxubJHCciOPA");
        /*$business_plan = PlanAffaire::find($id_plan_affaire);
        return view('frontend.payer-business-plan', compact('business_plan'));*/
    }

    public function getResponse($id_plan_affaire)
    {
        $business_plan = PlanAffaire::find($id_plan_affaire);
        $response = Http::withHeaders([
            'Apikey' => env('ligdicash_api_key'),
            'Authorization' => 'Bearer ' . env('ligdicash_auth_token'),
                ])->get(env('ligdicash_redirect'), [
                    'invoiceToken' => $business_plan->token_paye,
                ]);

                return $response;
    }

    /**
     * Succes de paiement
     */
    public function successPaye(Request $request, $id_plan_affaire)
    {
        // Get response
        $response = $this->getResponse($id_plan_affaire);

        // Convert to json
        $data = $response->json();

        // Verify if success
        if($data['response_code'] == '00'){
            try {
            $customer = $data['customer_details'];
            $transaction = TransactionSuccesses::updateOrCreate(
                [
                    'id_plan_affaire' => $id_plan_affaire, // Critère de recherche
                ],
                [
                    'response_code'=>$data['response_code'],
                    'token'=>$data['token'],
                    'response_text'=>$data['response_text'],
                    'description'=>$data['description'],
                    'status'=>$data['status'],
                    'operator_id'=>$data['operator_id'],
                    'operator_name'=>$data['operator_name'],
                    'customer'=>$data['customer'],
                    'wiki'=>$data['wiki'],
                    'montant'=>$data['montant'],
                    'amount'=>$data['amount'],
                    'date'=>$data['date'],
                    'external_id'=>$data['external_id'],
                    'oreference'=>$data['oreference'],
                    'custom_firstname'=>$data['customer_details']['firstname'],
                    'custom_lastname'=>$data['customer_details']['lastname'],
                    'custom_email'=>$data['customer_details']['email'],
                    'custom_phone'=>$data['customer_details']['phone'],
                    'custom_details'=>$data['customer_details']['details'],
                    'request_id'=>$data['request_id'],
                ]
            );

            $business_plan->update([
                'is_paye'=>True,
                'statut' => env('paye'),
            ]);

            return redirect()->route('businessplans.recu', $id_plan_affaire)->with('success', 'Paiement effectué avec succès!');
        } catch (\Exception $ex) {
            Log::error('Erreur lors de lors du paiement: '.$ex->getMessage());

        }
        }

        return redirect()->route('profile.edit')->with('error', 'Erreur lors du paiement!');
    }

    /**
     * Annuler de paiement
     */
    public function cancelPaye(Request $request, $id_plan_affaire)
    {
        dd($request->getContent());
    }

    /**
     * Retour de paiement
     */
    public function callbackPaye(Request $request, $id_plan_affaire)
    {
        if (str_starts_with($request->header('Content-Type'), 'application/json')) {
            // Récupérer le payload brut (string JSON tel qu'envoyé)
            $event = $request->getContent();

            // Créer la transaction
            $entreprise = Transaction::create([
                'id_plan_affaire'  => $id_plan_affaire,
                'client_phone'     => null,  // tu pourras parser plus tard si besoin
                'client_firstname' => null,
                'client_lastname'  => null,
                'email'            => null,
                'montant'          => null,
                'json'             => $event,  // ici on garde le JSON en string
                'response'         => 'callback ' . $request->header('Content-Type'),
            ]);
        }

        try {
            $payload = $request->getContent();
            $event = json_decode($payload);
            // Log::channel('callback')->info($event);

            $token = $event->token;
            $transaction_id = $event->transaction_id;
            $status = $event->status;

            $transaction = Transaction::where('id_plan_affaire', $id_plan_affaire)->first(); // Ou avec le transaction
            if($transaction){
                $transaction->update([
                    'status'=>$status,
                    'callback'=>$event,
                    'response'=>'callback',
                ]);
            }else{
                $entreprise = Transaction::create([
                    'id_plan_affaire' => $id_plan_affaire, // Critère de recherche
                    'client_phone'=>'phone',
                    'client_firstname'=>'firstname',
                    'client_lastname'=>'lastname',
                    'email'=>'email',
                    'montant'=>'montant',
                    'json'=>'ljnjn',
                    'response'=>'callback',
                ]);
            }
            $entreprise = Transaction::create([
                    'id_plan_affaire' => $id_plan_affaire, // Critère de recherche
                    'client_phone'=>'phone',
                    'client_firstname'=>'firstname',
                    'client_lastname'=>'lastname',
                    'email'=>'email',
                    'montant'=>'montant',
                    'json'=>'ljnjn',
                    'response'=>'callback',
                ]);
        } catch (Exception $ex) {
            Log::channel('callback')->info($ex);
        }


    }

    /**
     * Valider Pay Business Plan
     */
    public function validerPayBusinessPlan(Request $request, $id_plan_affaire)
    {
        // Décrire la facture et le client

        $request->validate([
            'numero_paye'=>'required',
            'montant_paye'=>'required',
            'code_opt_paye'=>'required',
        ]);

        try {
            Payement::create([
                'id_plan_affaire'=>$request->id_plan_affaire,
                'numero_paye'=>$request->numero_paye,
                'montant_paye'=>$request->montant_paye,
                'code_opt_paye'=>$request->code_opt_paye,
            ]);

            $business_plan = PlanAffaire::find($id_plan_affaire);
            $business_plan->update([
                'is_paye'=>True,
                'statut' => env('paye'),
            ]);

            return redirect()->route('businessplans.recu', $id_plan_affaire)->with('success', 'Paiement effectué avec succès!');
        } catch (\Exception $ex) {
            Log::error('Erreur lors de lors du paiement: '.$ex->getMessage());
            return redirect()->back()->with('error', 'Erreur lors du paiement!');
        }
    }

    /**
     * Details Business Plan
     */
    public function detailsBusinessPlan($id_plan_affaire)
    {
        $business_plan = PlanAffaire::find($id_plan_affaire);
        $groupedCharges = DB::table('valeurs as v')
                    ->leftJoin('chare_exploitations as ce', function ($join) use ($id_plan_affaire) {
                        $join->on('ce.id_valeur', '=', 'v.id')
                            ->where('ce.id_plan_affaire', '=', $id_plan_affaire);
                    })
                    ->select(
                        'ce.id',
                        'v.id as id_valeur',
                        'v.libelle as valeur_libelle',
                        'v.description',
                        'ce.designation',
                        'ce.unite',
                        'ce.quantite',
                        'ce.cout_unitaire',
                        'ce.cout_total'
                    )
                    ->where('v.id_parametre', env('ID_CHARGE'))
                    ->whereNull('v.deleted_at')
                    ->orderBy('v.id', 'ASC')
                    ->get()
                    ->groupBy('id_valeur');
        return view('frontend.details-business-plan', compact('business_plan', 'groupedCharges'));
    }

    /**
     * Reçu Business Plan
     */
    public function recuBusinessPlan($id_plan_affaire)
    {
        $business_plan = PlanAffaire::find($id_plan_affaire);
        $promoteur = Promoteur::where(['id_plan_affaire'=>$id_plan_affaire, 'is_porteur'=>true])->first();
        return view('frontend.recu-business-plan', compact('business_plan', 'promoteur'));
    }

    /**
     * Recuperer le PA pour imputation
     */
    public function getPa(Request $request)
    {
        $business_plan = PlanAffaire::find($request->id_plan_affaire);
        $response = array(
            'id_plan_affaire'=>$business_plan->id,
            'pack'=>$business_plan->pack->libelle,
            'business_idea' => $business_plan->business_idea,
            'business_object' => $business_plan->business_object,
            'id_admin_imput' => $business_plan->id_admin_imput,
        );
        return response()->json($response, 200);
    }

    /**
     * Imputation d'un PA
     */
    public function saveImputation(Request $request)
    {
        try {
            $business_plan = PlanAffaire::find($request->id_plan_affaire);
            $business_plan->id_admin_imput = $request->id_conseiller;
            $business_plan->date_imput = $request->date_imput;
            $business_plan->statut = env('impute');
            $business_plan->save();

            Imput::create([
                'id_admin_imput'=>$request->id_conseiller,
                'id_user_imput'=>Auth::user()->id,
                'id_plan_affaire'=>$business_plan->id,
                'date_imput'=>$request->date_imput,
                'motif_imput'=>$request->motif_imput,
            ]);

            flash()->addSuccess('Imputation effectuée avec succès');
        } catch (Exception $ex) {
            //throw $th;
        }

    }

    /**
     * Clôture d'un PA
     */
    public function cloturerBusinessPlan(Request $request)
    {

        // 1. Vérifier si un fichier a été envoyé
        if (!$request->hasFile('file_path')) {
            flash()->addError('Vous n\'avez pas joint de fichier');
            return back();
        }

        // 2. Récupérer le fichier
        $pdf = $request->file('file_path');

        // 3. Définir un nom de fichier unique
        $filename = time() . '_' . $pdf->getClientOriginalName();

        // 4. Stocker le fichier dans le dossier public/storage/businessplans/
        $path = $pdf->storeAs('public/businessplans', $filename);

        // 5. Supprimer le préfixe 'public/' pour obtenir le chemin relatif utilisable
        $path = str_replace('public/', 'storage/', $path);

        // 6. Mettre à jour le plan d'affaires
        $business_plan = PlanAffaire::find($request->id_plan_affaire_clos);
        $business_plan->date_cloture = now(); // Utilise Carbon automatiquement
        $business_plan->url_file = $path;
        $business_plan->file_name = $filename;
        $business_plan->id_admin_cloture = Auth::guard('admin')->id();
        $business_plan->statut = env('cloture');
        $business_plan->save();

        // 7. Retour avec succès
        flash()->addSuccess('Plan d\'affaire clôturé avec succès');
        return back();

    }

    /**
     * Imprimer un plan d'affaire
     */
    public function printBusinessPlan($id_plan_affaire)
    {
        $business_plan = PlanAffaire::find($id_plan_affaire);
        $groupedCharges = DB::table('valeurs as v')
                    ->leftJoin('chare_exploitations as ce', function ($join) use ($id_plan_affaire) {
                        $join->on('ce.id_valeur', '=', 'v.id')
                            ->where('ce.id_plan_affaire', '=', $id_plan_affaire);
                    })
                    ->select(
                        'ce.id',
                        'v.id as id_valeur',
                        'v.libelle as valeur_libelle',
                        'v.description',
                        'ce.designation',
                        'ce.unite',
                        'ce.quantite',
                        'ce.cout_unitaire',
                        'ce.cout_total'
                    )
                    ->where('v.id_parametre', env('ID_CHARGE'))
                    ->whereNull('v.deleted_at')
                    ->orderBy('v.id', 'ASC')
                    ->get()
                    ->groupBy('id_valeur');
        $pdf = Pdf::loadView('frontend.print-business-plan', compact('business_plan', 'groupedCharges'));
        return $pdf->stream('facture.pdf');
    }

}
