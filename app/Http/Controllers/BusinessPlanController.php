<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlanAffaire;
use App\Models\Planning;
use App\Models\Valeur;
use App\Models\Entreprise;
use App\Models\Promoteur;
use App\Models\Pack;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class BusinessPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::user()->can('businessplans.index')){
            $businessplans = PlanAffaire::whereNull('deleted_at')->get();
            return view('backend.businessplans.index', compact('businessplans'));
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
        $charges = Valeur::whereIn('id_parametre', [3, 4, 5, 6, 7, 8, 9, 10])->whereNull('deleted_at')->get();
        return view('frontend.edit-business-plan', compact('business_plan', 'sexes', 'situation_familles', 'charges'));
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
            Promoteur::updateOrCreate(
                [
                    'id_entreprise' => $entreprise->id,
                    'id_plan_affaire' => $business_plan->id, // Critères de recherche
                ],
                [
                    'age' => $request->age,
                    'id_sexe' => $request->sexe,
                    'id_situation_famille' => $request->situation_famille,
                    'domicile' => $request->domicile,
                    'adresse' => $request->adresse,
                    'niveau_formation' => $request->niveau_formation,
                    'experience_secteur_activite' => $request->experience_secteur_activite,
                    'activite_actuelle' => $request->activite_actuelle,
                    'motivation_creation' => $request->motivation_creation,
                    'garantie_aval' => $request->garantie_aval,
                    'id_user' => Auth::id(),
                ]
            );
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
     * Payer Business Plan
     */
    public function payerBusinessPlan($id_plan_affaire)
    {
        $business_plan = PlanAffaire::find($id_plan_affaire);
        $pack = Pack::find($business_plan->id_pack);
        return view('frontend.payer-business-plan', compact('business_plan'));
    }

    /**
     * Valider Pay Business Plan
     */
    public function validerPayBusinessPlan($id_plan_affaire)
    {
        //
    }

}
