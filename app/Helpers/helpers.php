<?php

use Carbon\Carbon;
use App\Models\Contact;
use App\Models\CompteExploitationYear;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

// Get "nom_localite"
if(!function_exists('get_contacts')){
	function get_contacts(){
		$contacts = Contact::where('is_read', false)->limit(5)->get();
		return $contacts;
	}
}

if(!function_exists('get_years')){
	function get_years($id_plan_affaire){
		$compteExploitation = CompteExploitationYear::where('id_plan_affaire', $id_plan_affaire)
                                ->orderBy('year_compte', 'DESC')
                                ->pluck('year_compte')
                                ->unique()
                                ->values()
                                ->toArray();
        
        if($compteExploitation){
            $year = max($compteExploitation);
        }else{
            $year = date('Y');
        }

		return $year;
	}
}

if(!function_exists('compte_exploitation')){
	function compte_exploitation($id_plan_affaire){
		$year = get_years($id_plan_affaire);

        $year1 = $year - 2;
        $year2 = $year - 1;
        $year3 = $year;

		$compteExploitations = DB::table('valeurs as v')
                ->select(
                    'v.id',
                    'v.libelle',
                    DB::raw("COALESCE(SUM(CASE WHEN ce.year = $year1 THEN ce.montant END), 0) AS first_year"),
                    DB::raw("COALESCE(SUM(CASE WHEN ce.year = $year2 THEN ce.montant END), 0) AS second_year"),
                    DB::raw("COALESCE(SUM(CASE WHEN ce.year = $year3 THEN ce.montant END), 0) AS third_year")
                )
                ->leftJoin('compte_exploitations as ce', 'ce.id_valeur', '=', 'v.id')
                ->where('id_parametre', env('cexploitation'))
                ->whereNull('deleted_at')
                ->groupBy('v.id', 'v.libelle')
                ->orderBy('v.libelle')
                ->get();

		return $compteExploitations;
	}
}

if(!function_exists('bilanMasseActif')){
	function bilanMasseActif($id_plan_affaire){
		$year = get_years($id_plan_affaire);

        $year1 = $year - 2;
        $year2 = $year - 1;
        $year3 = $year;
		$bilanMasseActifs = DB::table('valeurs as v')
                ->select(
                    'v.id',
                    'v.libelle',
                    DB::raw("COALESCE(SUM(CASE WHEN ce.year = $year1 THEN ce.montant END), 0) AS first_year"),
                    DB::raw("COALESCE(SUM(CASE WHEN ce.year = $year2 THEN ce.montant END), 0) AS second_year"),
                    DB::raw("COALESCE(SUM(CASE WHEN ce.year = $year3 THEN ce.montant END), 0) AS third_year")
                )
                ->leftJoin('bilan_masses as ce', 'ce.id_valeur', '=', 'v.id')
                ->where('id_parametre', env('bactif'))
                ->whereNull('deleted_at')
                ->groupBy('v.id', 'v.libelle')
                ->orderBy('v.libelle')
                ->get();

		return $bilanMasseActifs;
	}
}

if(!function_exists('bilanMassePacifs')){
	function bilanMassePacifs($id_plan_affaire){
		$year = get_years($id_plan_affaire);

        $year1 = $year - 2;
        $year2 = $year - 1;
        $year3 = $year;
		$bilanMassePacifs = DB::table('valeurs as v')
                ->select(
                    'v.id',
                    'v.libelle',
                    DB::raw("COALESCE(SUM(CASE WHEN ce.year = $year1 THEN ce.montant END), 0) AS first_year"),
                    DB::raw("COALESCE(SUM(CASE WHEN ce.year = $year2 THEN ce.montant END), 0) AS second_year"),
                    DB::raw("COALESCE(SUM(CASE WHEN ce.year = $year3 THEN ce.montant END), 0) AS third_year")
                )
                ->leftJoin('bilan_masses as ce', 'ce.id_valeur', '=', 'v.id')
                ->where('id_parametre', env('bpassif'))
                ->whereNull('deleted_at')
                ->groupBy('v.id', 'v.libelle')
                ->orderBy('v.libelle')
                ->get();

		return $bilanMassePacifs;
	}
}




        
        
