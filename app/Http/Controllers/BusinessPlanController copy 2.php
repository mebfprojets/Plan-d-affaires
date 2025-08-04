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
            $businessplans = PlanAffaire::whereNull('deleted_at')->get();
            $admins = Admin::whereNull('deleted_at')->get();
            $admin = Admin::find(Auth::user()->id);
            $flag = false;
            foreach($admin->roles as $role_admin){
                if($role_admin->slug == env('super_admin')){
                    $flag = true;
                }
            }
            if(!$flag){
                $businessplans = PlanAffaire::where('id_admin_imput', Auth::user()->id)->whereNull('deleted_at')->get();
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
        if($business_plan->is_valide && $business_plan->is_paye){
            return back()->with('error', 'Ce plan d\'affaire est déjà validé et ne peut plus être modifié!');
        }
        $sexes = Valeur::where('id_parametre', env('sexe'))->whereNull('deleted_at')->get();
        $forme_juridiques = Valeur::where('id_parametre', env('forme_juridique'))->whereNull('deleted_at')->get();
        // $banques = Valeur::where('id_parametre', env('banque'))->whereNull('deleted_at')->get();
        $situation_familles = Valeur::where('id_parametre', env('situation_famille'))->whereNull('deleted_at')->get();
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

        $charges = Valeur::where('id_parametre', env('ID_CHARGE'))->whereNull('deleted_at')->get();
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
            return view('backend.businessplans.edit', compact('business_plan', 'sexes', 'situation_familles', 'charges', 'groupedCharges', 'forme_juridiques', 'regions', 'provinces', 'communes', 'arrondissements'));
        }
            return view('frontend.edit-business-plan', compact('business_plan', 'sexes', 'situation_familles', 'charges', 'groupedCharges', 'forme_juridiques',  'regions', 'provinces', 'communes', 'arrondissements'));
    }

    /**
     * Add Promoteur Ligne
     */
    public function addLignePromoteur()
    {
        $sexes = Valeur::where('id_parametre', env('sexe'))->whereNull('deleted_at')->get();
        $situation_familles = Valeur::where('id_parametre', env('situation_famille'))->whereNull('deleted_at')->get();
        return view('frontend.add-promoteur', compact('sexes', 'situation_familles'));
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
                        'id_forme_juridique' => $request->forme_juridique,
                        'date_creation_prevue' => $request->date_creation,
                        'engagement_institution' => $request->engagement,
                        'denomination' => $request->denomination,
                        'id_region' => $request->id_region,
                        'id_province' => $request->id_province,
                        'id_commune' => $request->id_commune,
                        'id_arrondissement' => $request->id_arrondissement,
                    ]
                );
            }else{
                $entreprise = Entreprise::create(
                    [
                        'id_forme_juridique' => $request->forme_juridique,
                        'date_creation_prevue' => $request->date_creation,
                        'engagement_institution' => $request->engagement,
                        'denomination' => $request->denomination,
                        'id_region' => $request->id_region,
                        'id_province' => $request->id_province,
                        'id_commune' => $request->id_commune,
                        'id_arrondissement' => $request->id_arrondissement,
                        'id_user' => $id_user, // Critère de recherche
                    ]
                );
            }



            // ENGAGEMENT
            $banques = $request->input('nom_banque');
            $montant_emps = $request->input('montant_emp');
            $durees = $request->input('duree');
            $type_durees = $request->input('type_duree');
            $montant_restants = $request->input('montant_restant');
            $removeEngagement = Engagement::where(['id_plan_affaire'=>$business_plan->id, 'id_entreprise'=>$entreprise->id])->delete();
            if($banques){
                foreach ($banques as $index => $banque) {
                    $montant_emp = $montant_emps[$index];
                    $duree = $durees[$index];
                    $type_duree = $type_durees[$index];
                    $montant_restant = $montant_restants[$index];
                    if($banque){
                        Engagement::updateOrCreate([
                        'id_plan_affaire' => $business_plan->id,
                        'id_entreprise' => $entreprise->id,
                        'nom_banque' => $banque,
                        'montant_emprunt' => $montant_emp,
                        'duree' => $duree,
                        'type_duree' => $type_duree,
                        'montant_restant' => $montant_restant,

                    ]);
                    }

                }
            }

            // PROMOTEUR
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
            if($ages){
                foreach ($ages as $index => $age) {
                    $sexe = $sexes[$index];
                    $situation_famille = $situation_familles[$index];
                    $domicile = $domiciles[$index];
                    $adresse = $adresses[$index];
                    $niveau_formation = $niveau_formations[$index];
                    $experience_secteur_activite = $experience_secteur_activites[$index];
                    $activite_actuelle = $activite_actuelles[$index];
                    $motivation_creation = $motivation_creations[$index];
                    $garantie_aval = $garantie_avals[$index];

                    // Enregistrer chaque activité dans la base de données
                    if($age && $sexe){
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

                // DOSSIER COMMERCIAL
                'produit_service' => $request->produits_services,
                'situation_secteur_activite' => $request->situation_secteur,
                'evaluation_marche_potentiel' => $request->evaluation_marche,
                'profil_marche_cible' => $request->profil_marche,
                'marche_vise' => $request->marche_vise,
                'situation_concurrentielle' => $request->situation_concurrentielle,
                'analyse_concurrentielle' => $request->analyse_concurrentielle,
                'politique_produit' => $request->politique_produit,
                'politique_prix' => $request->politique_prix,
                'politique_promotion' => $request->politique_promotion,
                'politique_distribution' => $request->politique_distribution,

                // DOSSIER TECHNIQUE
                'description_infrastructure' => $request->infrastructures,
                'description_equipement' => $request->equipements,
                'description_process' => $request->approvisionnement,
                'processus_production' => $request->production,
                'reglementation' => $request->reglementation,

                // DOSSIER FINANCIER
                'estimation_chiffre_affaire' => $request->estimation_chiffre_affaire,
                'montant_emprunt' => $request->montant_emprunt,
                'nombre_year_remb' => $request->nombre_year_remb,
                'cible_partenaire' => $request->cible_partenaire,
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
                        'salaire_mensuel' => $salaires[$index],
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
                        'salaire_mensuel' => $salaire_recs[$index],
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
                        'an_1' => $an_1s[$index],
                        'an_2' => $an_2s[$index],
                        'an_3' => $an_3s[$index],
                        'an_4' => $an_4s[$index],
                        'an_5' => $an_4s[$index],
                    ]);
                }
            }

            // Partenaires ciblés
            $removePartenaire = Partenaire::where('id_plan_affaire', $business_plan->id)->delete();
            $partenaires = $request->input('nom_partenaire');
            $montant_empruntes = $request->input('montant_emprunte');
            $nombre_year_rems = $request->input('nombre_year_rem');
            foreach ($partenaires as $index => $partenaire) {

                // Enregistrer chaque activité dans la base de données
                if($partenaire){
                    Partenaire::create([
                        'id_plan_affaire' => $business_plan->id,
                        'nom_partenaire' => $partenaire,
                        'montant_emprunt' => $montant_empruntes[$index],
                        'nombre_year_remb' => $nombre_year_rems[$index],
                    ]);
                }
            }

            // Chiffre d’affaires de la première année
            $removeChiffreAffaireFirstYear = ChiffreAffaireFirstYear::where('id_plan_affaire', $business_plan->id)->delete();
            $produits = $request->input('produit');
            $unite_firsts = $request->input('unite_first');
            $quantite_firsts = $request->input('quantite_first');
            $prix_unitaire_firsts = $request->input('prix_unitaire_first');
            $chiffre_affaire_firsts = $request->input('chiffre_affaire_first');
            foreach ($produits as $index => $produit) {

                if($produit){
                    ChiffreAffaireFirstYear::create([
                        'id_plan_affaire' => $business_plan->id,
                        'produit' => $produit,
                        'unite_first' => $unite_firsts[$index],
                        'quantite' => $quantite_firsts[$index],
                        'prix_unitaire' => $prix_unitaire_firsts[$index],
                        'chiffre_affaire_first' => $chiffre_affaire_firsts[$index],
                    ]);
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
                        'quantite' => $quantite_equipement_exists[$index],
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
                        'quantite' => $quantite_equipement_aqs[$index],
                        'etat_fonctionnement' => $source_approvisionnements[$index],
                        'type_equipement' => 'acquerir',
                    ]);
                }
            }

            // Charge d'exploitation
            $removeChareExploitation = ChareExploitation::where('id_plan_affaire', $business_plan->id)->delete();
            $charges = $request->input('charge'); // Ex: [1, 2, 3]
            if($charges){
                foreach ($charges as $index => $chargeId) {
                    // Récupère les tableaux pour cette charge
                    $designations = $request->input("designation_charge_$chargeId", []);
                    $unites = $request->input("unite_charge_$chargeId", []);
                    $quantites = $request->input("quantite_charge_$chargeId", []);
                    $couts = $request->input("cout_unitaire_charge_$chargeId", []);

                    foreach ($designations as $index => $designation) {

                        $unite = $unites[$index] ?? null;
                        $quantite = $quantites[$index] ?? 0;
                        $cout_unitaire = $couts[$index] ?? 0;
                        $cout_total = $quantite * $cout_unitaire;

                        if($designation){
                            ChareExploitation::create([
                                'id_plan_affaire' => $business_plan->id,
                                'designation' => $designation,
                                'id_valeur' => $chargeId,
                                'unite' => $unite,
                                'quantite' => $quantite,
                                'cout_unitaire' => $cout_unitaire,
                                'cout_total' => $cout_total,
                            ]);
                        }
                    }
                }
            }

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
        $entreprise = $business_plan->entrepris;
        $templateProcessor->setValue('nom', $business_plan->entreprise?$business_plan->entreprise->denomination:"");
        $templateProcessor->setValue('adresse', $business_plan->entreprise?$business_plan->entreprise->denomination:"");
        $region = "...";
        $province = "...";
        $commune = "...";
        $arrondissement = "...";
        if($entreprise){
            $region = $entreprise->region?$entreprise->region->libelle:"...";
            $province = $entreprise->province?$entreprise->province->libelle:"...";
            $commune = $entreprise->commune?$entreprise->commune->libelle:"...";
            $arrondissement = $entreprise->arrondissement?$entreprise->arrondissement->libelle:"...";
        }
        $templateProcessor->setValue('region', $region);
        $templateProcessor->setValue('province', $province);
        $templateProcessor->setValue('commune', $commune);
        $templateProcessor->setValue('arrondissement', $arrondissement);
        // $templateProcessor->setValue('email', 'jean.dupont@example.com');
        // $templateProcessor->setValue('date', now()->format('d/m/Y'));
        $file_name = $business_plan->entreprise?Str::slug($business_plan->entreprise->denomination, '_'):$id_plan_affaire;

        // CHIFFRE D'AFFAIRE DE LA PREMIERE ANNEE
        // Récupération des données
        $charge_firsts = $business_plan->chiffre_affaire_first_years;

        // S'assurer que c'est une collection ou tableau
        $charge_firstsArray = $charge_firsts->toArray();

        // Cloner les lignes dans le template Word selon le nombre d'enregistrements
        $templateProcessor->cloneRow('produit', count($charge_firstsArray));

        // Injection des données dans le tableau Word
        foreach ($charge_firstsArray as $index => $charge_first) {
            $i = $index + 1;

            $templateProcessor->setValue("produit#{$i}", $charge_first['produit'] ?? '');
            $templateProcessor->setValue("unite_first#{$i}", $charge_first['unite_first']?? '');
            $templateProcessor->setValue("quantite_first#{$i}", number_format($charge_first['quantite'], 0, ',', ' ')?? '');
            $templateProcessor->setValue("prix_unitaire_first#{$i}", number_format($charge_first['prix_unitaire'], 0, ',', ' ')?? '');
            $templateProcessor->setValue("chiffre_affaire_first#{$i}", number_format($charge_first['chiffre_affaire_first'], 0, ',', ' ')?? '');
        }

        // ESTIMATION CHIFFRE D'AFFAIRES
        // Récupération des données
        $charges = $business_plan->chiffre_affaires;

        // S'assurer que c'est une collection ou tableau
        $chargesArray = $charges->toArray();

        // Cloner les lignes dans le template Word selon le nombre d'enregistrements
        $templateProcessor->cloneRow('designation', count($chargesArray));

        // Injection des données dans le tableau Word
        foreach ($chargesArray as $index => $charge) {
            $i = $index + 1;

            $templateProcessor->setValue("designation#{$i}", $charge['produit'] ?? '');
            $templateProcessor->setValue("annee1#{$i}", number_format($charge['an_1'], 0, ',', ' ')?? '');
            $templateProcessor->setValue("annee2#{$i}", number_format($charge['an_2'], 0, ',', ' ')?? '');
            $templateProcessor->setValue("annee3#{$i}", number_format($charge['an_3'], 0, ',', ' ')?? '');
            $templateProcessor->setValue("annee4#{$i}", number_format($charge['an_4'], 0, ',', ' ')?? '');
            $templateProcessor->setValue("annee5#{$i}", number_format($charge['an_5'], 0, ',', ' ')?? '');
        }

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
        $materiels = $charge_exploitations->where('id_valeur', env('materiel_mobilier'));
        // S'assurer que c'est une collection ou tableau
        $materielsArray = $materiels->toArray();
        // Cloner les lignes dans le template Word selon le nombre d'enregistrements
        $templateProcessor->cloneRow('designation_ma', count($materielsArray));
        // Injection des données dans le tableau Word
        $ma = 1;
        foreach ($materielsArray as $index => $chargeMateriel) {
            $templateProcessor->setValue("designation_ma#{$ma}", $chargeMateriel['designation'] ?? '');
            $templateProcessor->setValue("unite_ma#{$ma}", $chargeMateriel['unite']?? '');
            $templateProcessor->setValue("quantite_ma#{$ma}", number_format($chargeMateriel['quantite'], 0, ',', ' ')?? '');
            $templateProcessor->setValue("cout_unitaire_ma#{$ma}", number_format($chargeMateriel['cout_unitaire'], 0, ',', ' ')?? '');
            $templateProcessor->setValue("cout_total_ma#{$ma}", number_format($chargeMateriel['cout_total'], 0, ',', ' ')?? '');
            $ma = $ma + 1;
        }

        // MATERIELS INFORMATIQUES
        $materiel_is = $charge_exploitations->where('id_valeur', env('materiel_informatique'));
        // S'assurer que c'est une collection ou tableau
        $materiel_isArray = $materiel_is->toArray();
        // Cloner les lignes dans le template Word selon le nombre d'enregistrements
        $templateProcessor->cloneRow('designation_mi', count($materiel_isArray));
        // Injection des données dans le tableau Word
        $mi = 1;
        foreach ($materiel_isArray as $index => $chargeMateriel_i) {

            $templateProcessor->setValue("designation_mi#{$mi}", $chargeMateriel_i['designation'] ?? '');
            $templateProcessor->setValue("unite_mi#{$mi}", $chargeMateriel_i['unite']?? '');
            $templateProcessor->setValue("quantite_mi#{$mi}", number_format($chargeMateriel_i['quantite'], 0, ',', ' ')?? '');
            $templateProcessor->setValue("cout_unitaire_mi#{$mi}", number_format($chargeMateriel_i['cout_unitaire'], 0, ',', ' ')?? '');
            $templateProcessor->setValue("cout_total_mi#{$mi}", number_format($chargeMateriel_i['cout_total'], 0, ',', ' ')?? '');
            $mi = $mi + 1;
        }

        // MATERIELS ROULANTS
        $materiel_rs = $charge_exploitations->where('id_valeur', env('materiel_'));

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

        // Injection des données dans le tableau Word
        foreach ($engagementsArray as $index => $engagement) {
            $i = $index + 1;

            $templateProcessor->setValue("engagement#{$i}", $engagement['nom_banque'] ?? '');
            $templateProcessor->setValue("montant_emprunt#{$i}", $engagement['montant_emprunt']?? '');
            $templateProcessor->setValue("duree#{$i}", $engagement['duree']?? '');
            $templateProcessor->setValue("montant_restant#{$i}", number_format($engagement['montant_restant'], 0, ',', ' ')?? '');
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
        $callback_url = route('callback.payer', $id_plan_affaire);

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
        return header("Location: $payment_url");
        /*$business_plan = PlanAffaire::find($id_plan_affaire);
        return view('frontend.payer-business-plan', compact('business_plan'));*/
    }

    /**
     * Succes de paiement
     */
    public function successPaye(Request $request, $id_plan_affaire)
    {
        $business_plan = PlanAffaire::find($id_plan_affaire);
        $response = Http::withHeaders([
            'Apikey' => env('ligdicash_api_key'),
            'Authorization' => 'Bearer ' . env('ligdicash_auth_token'),
                ])->get(env('ligdicash_redirect'), [
                    'invoiceToken' => $business_plan->token_paye,
                ]);
        $data = $response->json();
        if($data['response_code'] == '00'){


            try {
            $customer = $data['customer_details'];
            $entreprise = Transaction::updateOrCreate(
                [
                    'id_plan_affaire' => $id_plan_affaire, // Critère de recherche
                ],
                [
                    'client_phone'=>$customer['phone'],
                    'client_firstname'=>$customer['firstname'],
                    'client_lastname'=>$customer['lastname'],
                    'email'=>$customer['email'],
                    'montant'=>$data['montant'],
                    'json'=>json_encode($data),
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
    public function callbackPaye(Request $request)
    {
        try {
            $payload = $request->getContent();
            $event = json_decode($payload);
            Log::channel('callback')->info($event);

            $token = $event->token;
            $transaction_id = $event->transaction_id;
            $status = $event->status;

            $transaction = Transaction::where('id_plan_affaire', $id_plan_affaire)->first(); // Ou avec le transaction
            if($transaction){
                $transaction->update([
                    'status'=>$status,
                    'callback'=>$event,
                ]);
            }
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
        return view('frontend.recu-business-plan', compact('business_plan'));
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
        // 2. Récupérer le fichier
        $pdf = $request->file('file_pa');
        if(!$pdf){
            flash()->addError('Vous v\'aviez pas joint de fichier');
            return back();
        }

        // 3. Définir le nom du fichier (optionnel)
        $filename = time() . '_' . $pdf->getClientOriginalName();

        // 4. Stocker dans storage/app/businessplans/
        // $path = $pdf->storeAs('businessplans', $filename);
        $path = '';

            if ($request->hasFile('file_pa')) {
                $path = $request->file_pa->store('public/businessplans');
            }



        $business_plan = PlanAffaire::find($request->id_plan_affaire_clos);
        $business_plan->date_cloture = date('Y-m-d');
        $business_plan->url_file = $path;
        $business_plan->file_name = $filename;
        $business_plan->id_admin_cloture =  Auth::guard('admin')->user()->id;
        $business_plan->statut = env('cloture');
        $business_plan->save();

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
