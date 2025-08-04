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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use \Exception;

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
        $sexes = Valeur::where('id_parametre', env('sexe'))->whereNull('deleted_at')->get();
        $situation_familles = Valeur::where('id_parametre', env('situation_famille'))->whereNull('deleted_at')->get();
        $charges = DB::table('valeurs as v')
                        ->join('parametres as p', 'p.id', 'v.id_parametre')
                        ->select('v.*')
                        ->whereIn('v.id_parametre', [3, 4, 5, 6, 7, 8, 9, 10])
                        ->whereNull('p.deleted_at')
                        ->whereNull('v.deleted_at')
                        ->get();
        // dd($charges);
        $groupedCharges = DB::table('valeurs as v')
                    ->leftJoin('chare_exploitations as ce', function ($join) use ($id_plan_affaire){
                        $join->on('ce.id_valeur', '=', 'v.id')
                             ->where('ce.id_plan_affaire', '=', $id_plan_affaire);
                    })
                    ->leftJoin('parametres as p', 'p.id', '=', 'v.id_parametre') // Jointure pour récupérer le libellé du paramètre
                    ->select(
                        'v.id as id_valeur',  // Ajout de v.id comme id_valeur
                        'v.id_parametre',
                        'p.libelle as parametre_libelle', // Alias clair
                        'v.libelle',
                        'ce.unite',
                        'ce.quantite',
                        'ce.cout_unitaire',
                        'ce.cout_total'
                    )
                    ->whereIn('v.id_parametre', [3, 4, 5, 6, 7, 8, 9, 10])
                    ->whereNull('v.deleted_at')
                    ->whereNull('p.deleted_at')
                    ->orderBy('id_parametre', 'ASC')
                    ->get()
                    ->groupBy('id_parametre');


        $route = request()->route();
        $middlewares = $route->gatherMiddleware(); // Donne tous les middleware appliqués à la route
        if (in_array('auth:admin', $middlewares)) {
            return view('backend.businessplans.edit', compact('business_plan', 'sexes', 'situation_familles', 'charges', 'groupedCharges'));
        }
        return view('frontend.edit-business-plan', compact('business_plan', 'sexes', 'situation_familles', 'charges', 'groupedCharges'));
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
        $etapes = $request->input('etapes_activites');
        $dates = $request->input('dates_indicatives');

        try {
            $business_plan = PlanAffaire::find($id_plan_affaire);

            // ENTREPRISE
            $entreprise = Entreprise::updateOrCreate(
                [
                    'id_user' => Auth::id(), // Critère de recherche
                ],
                [
                    'forme_juridique' => $request->forme_juridique,
                    'date_creation_prevue' => $request->date_creation,
                    'localisation' => $request->localisation,
                    'engagement_institution' => $request->engagement,
                    'denomination' => $request->denomination,
                ]
            );

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
                'id_user' => Auth::user()->id,
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

            // Chiffre d’affaires de la première année
            $removeChiffreAffaireFirstYear = ChiffreAffaireFirstYear::where('id_plan_affaire', $business_plan->id)->delete();
            $produits = $request->input('produit');
            $quantite_firsts = $request->input('quantite_first');
            $capacite_accueils = $request->input('capacite_accueil');
            $taux_occupations = $request->input('taux_occupation');
            $prix_unitaire_firsts = $request->input('prix_unitaire_first');
            $ca_mensuels = $request->input('ca_mensuel');
            $ca_annuels = $request->input('ca_annuel');
            foreach ($produits as $index => $produit) {

                if($produit){
                    ChiffreAffaireFirstYear::create([
                        'id_plan_affaire' => $business_plan->id,
                        'produit' => $produit,
                        'quantite' => $quantite_firsts[$index],
                        'capacite_accueil' => $capacite_accueils[$index],
                        'taux_occupation' => $taux_occupations[$index],
                        'prix_unitaire' => $prix_unitaire_firsts[$index],
                        'ca_mensuel' => $ca_mensuels[$index],
                        'ca_annuel' => $ca_annuels[$index],
                    ]);
                }
            }

            // Charge d'exploitation
            $removeChareExploitation = ChareExploitation::where('id_plan_affaire', $business_plan->id)->delete();
            $valeur_charges = $request->input('valeur_charge');
            $unite_charges = $request->input('unite_charge');
            $quantite_charges = $request->input('quantite_charge');
            $cout_unitaire_charges = $request->input('cout_unitaire_charge');
            foreach ($valeur_charges as $index => $valeur_charge) {

                if($valeur_charge){
                    ChareExploitation::create([
                        'id_plan_affaire' => $business_plan->id,
                        'id_valeur' => $valeur_charge,
                        'unite' => $unite_charges[$index],
                        'quantite' => $quantite_charges[$index],
                        'cout_unitaire' => $cout_unitaire_charges[$index],
                        'cout_total' => $quantite_charges[$index]*$cout_unitaire_charges[$index],
                    ]);
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
        $templateProcessor->setValue('nom', $business_plan->entreprise?$business_plan->entreprise->denomination:"");
        $templateProcessor->setValue('adresse', $business_plan->entreprise?$business_plan->entreprise->denomination:"");
        // $templateProcessor->setValue('email', 'jean.dupont@example.com');
        // $templateProcessor->setValue('date', now()->format('d/m/Y'));
        $file_name = $business_plan->entreprise?Str::slug($business_plan->entreprise->denomination, '_'):$id_plan_affaire;

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
                    ->leftJoin('chare_exploitations as ce', function ($join) use ($id_plan_affaire){
                        $join->on('ce.id_valeur', '=', 'v.id')
                             ->where('ce.id_plan_affaire', '=', $id_plan_affaire);
                    })
                    ->leftJoin('parametres as p', 'p.id', '=', 'v.id_parametre') // Jointure pour récupérer le libellé du paramètre
                    ->select(
                        'v.id as id_valeur',  // Ajout de v.id comme id_valeur
                        'v.id_parametre',
                        'p.libelle as parametre_libelle', // Alias clair
                        'v.libelle',
                        'ce.unite',
                        'ce.quantite',
                        'ce.cout_unitaire',
                        'ce.cout_total'
                    )
                    ->whereIn('v.id_parametre', [3, 4, 5, 6, 7, 8, 9, 10])
                    ->whereNull('v.deleted_at')
                    ->orderBy('id_parametre', 'ASC')
                    ->get()
                    ->groupBy('id_parametre');
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
        $business_plan->save();
        return redirect()->back()->with('success', 'Plan d\'affaire validé avec succès!');
    }

    /**
     * Payer Business Plan
     */
    public function payerBusinessPlan($id_plan_affaire)
    {
        $business_plan = PlanAffaire::find($id_plan_affaire);
        return view('frontend.payer-business-plan', compact('business_plan'));
    }

    /**
     * Valider Pay Business Plan
     */
    public function validerPayBusinessPlan(Request $request, $id_plan_affaire)
    {
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

            return redirect()->route('businessplans.details', $id_plan_affaire)->with('success', 'Paiement effectué avec succès!');
        } catch (\Exception $ex) {
            Log::error('Erreur lors de l\'enregistrement du gerant: '.$ex->getMessage());
            return redirect()->back()->with('error', 'Erreur lors du paiement!');
        }
    }

    /**
     * Details Business Plan
     */
    public function detailsBusinessPlan($id_plan_affaire)
    {
        $business_plan = PlanAffaire::find($id_plan_affaire);
        return view('frontend.details-business-plan', compact('business_plan'));
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
            'business_object' => $business_plan->business_object
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
            $business_plan->save();
            flash()->addSuccess('Imputation effectuée avec succès"');
        } catch (Exception $ex) {
            //throw $th;
        }

    }

}
