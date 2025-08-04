<?php

namespace App\Http\Controllers;

use App\Models\Acte;
use App\Models\User;
use App\Models\Examen;
use App\Models\Region;
use App\Models\Commune;
use App\Models\Product;
use App\Models\Nproduct;
use App\Models\Org_unit;
use App\Models\Province;
use App\Models\Structure;
use App\Models\Equipement;
use Illuminate\Http\Request;
use App\Models\Arrondissement;
use App\Models\Infrastructure;
use App\Models\Indicateurvaleur;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Indicateur_typelocalite;

class ImportController extends Controller
{
	// CONVERT DATA TO ARRAY
	function csvToArray($filename = '', $delimiter = ';')
	{
	    if (!file_exists($filename) || !is_readable($filename))
	        return false;

	    $header = null;
	    $data = array();
	    if (($handle = fopen($filename, 'r')) !== false)
	    {
	        while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
	        {
	            if (!$header)
	                $header = $row;
	            else
	                $data[] = array_merge( $row);
	        }
	        fclose($handle);
	    }

	    return $data;
	}

	/**
	* This method display import indicateur view
	*/
    public function viewCsv()
    {
        return view('importCsv');
    }

    /**
	* This method save indicateur data
	*/
	public function importCsv(Request $request)
	{
		$request->validate([
			'file_import' => 'required',
		]);

	    	$file = $request->file('file_import');

	    	// File Details
	       	$filename = $file->getClientOriginalName();
	       	$extension = $file->getClientOriginalExtension();
	       	$tempPath = $file->getRealPath();
	       	$fileSize = $file->getSize();
	       	$mimeType = $file->getMimeType();


	    	// Valid File Extensions
	        $valid_extension = array("csv");

	      	// 2MB in Bytes
	        $maxFileSize = 12097152;

		// Check file extension
        if(in_array(strtolower($extension),$valid_extension))
	    {

	        // Check file size
	        if($fileSize <= $maxFileSize){

	          // File upload location
	          // $location = 'uploads';

	          // Upload file
	          // $file->move($location, $filename);

	          // Import CSV to Database
	          // $file = public_path($location."/".$filename);

	          // Reading file
	         // $file = fopen($filepath,"r");
	              // Reading file
	              //$file = public_path('uploads/bn.csv');


	        $customerArr = $this->csvToArray($file);
	       for ($i = 0; $i < count($customerArr); $i ++)
	       {
	       		if ($customerArr[$i][1] != '') {


                // ACTE
	       		/*$acte = Acte::create([
	       						'id' => $customerArr[$i][0],
	       						'code_acte' => Time(),
	       						'description' => $customerArr[$i][1],
                                'price_pvp' => $customerArr[$i][2],
                                'niveau' => $customerArr[$i][3],
               	]);

                echo $i.' - '.$acte->id.' - '.utf8_encode($customerArr[$i][0]).' - '.utf8_encode($customerArr[$i][1]).'<br/>';*/

               	// EQUIPEMENT
	       		/*$equipement = Equipement::create([
	       						'id' => $customerArr[$i][0],
	       						'code_equipement' => Time(),
	       						'description' => $customerArr[$i][1],
                                'unit_cost_drd' => $customerArr[$i][2],
                                'unit_cost_pvp' => $customerArr[$i][3],
               	]);

                echo $i.' - '.$equipement->id.' - '.$customerArr[$i][0].' - '.$customerArr[$i][1].'<br/>';*/

                // EXAMEN
	       		/*$examen = Examen::create([
                                    'id' => $customerArr[$i][0],
                                    'code_examen' => Time(),
                                    'nom_examen' => $customerArr[$i][1],
                                    'prix_pvp' => $customerArr[$i][2],
                                    'niveau' => $customerArr[$i][3],
                    ]);

                echo $i.' - '.$examen->id.' - '.$customerArr[$i][0].' - '.$customerArr[$i][1].'<br/>';*/

                // PRODUCT
	       		/*$product = Product::create([
                    'id' => $customerArr[$i][0],
                    'code_product' => Time(),
                    'name' => $customerArr[$i][1],
                    'prix_pvp' => $customerArr[$i][3],
                    'class' => $customerArr[$i][4],
                    'prix_drd' => $customerArr[$i][2],
                ]);

                echo $i.' - '.$product->id.' - '.$customerArr[$i][0].' - '.$customerArr[$i][1].'<br/>';*/

                // STRUCTURE
                $structure = Structure::where('code_structure', $customerArr[$i][2])->first();

                if($structure){
                    Structure::create([
                    'id_parent' => $structure->id,
                    'code_structure' => $customerArr[$i][0],
                    'nom_structure' => $customerArr[$i][1],
                    'level_structure' => 'village',
                ]);

                }


	       		/*$structure = Structure::create([
                    'id_parent' => 1,
                    'code_structure' => $customerArr[$i][0],
                    'nom_structure' => $customerArr[$i][1],
                ]);*/

                echo $i.' - '.$structure->id.' - '.$customerArr[$i][0].' - '.$customerArr[$i][1].'<br/>';
                // USER
                /*$structure = Structure::where('nom_structure', $customerArr[$i][2])->first();
                $user = User::create([
                    'id' => $customerArr[$i][0],
                    'name' => html_entity_decode($customerArr[$i][2]),
                    'email' => $customerArr[$i][1],
                    'statut' => 1,
                    'password' => bcrypt($customerArr[$i][3]),
                    'structure_id' => $structure->id,
                ]);

                $user->roles()->sync([4]);

                echo $i.' - '.$user->id.' - '.$customerArr[$i][0].' - '.$customerArr[$i][1].'<br/>';*/
                // PRODUCT
	       		/*$nproduct = Nproduct::create([
                    'code_product' => html_entity_decode($customerArr[$i][0]),
                    'name' => html_entity_decode($customerArr[$i][1]),
                    'short_name' => html_entity_decode($customerArr[$i][2]),
                    'cameg_price' => html_entity_decode($customerArr[$i][3]),
                    'drd_price' => html_entity_decode($customerArr[$i][4]),
                    'etab_price' => html_entity_decode($customerArr[$i][5]),
                    'uid' => html_entity_decode($customerArr[$i][6]),
                ]);

                echo $i.' - '.$nproduct->id.' - '.$customerArr[$i][0].' - '.$customerArr[$i][1].'<br/>';*/

                // ORG UNIT
	       		/*$org_unit = Org_unit::create([
                    'code'=>$customerArr[$i][0],
                    'nom'=>$customerArr[$i][1],
                    'type'=>$customerArr[$i][2],
                    'latitude'=>$customerArr[$i][3],
                    'longitude'=>$customerArr[$i][4],
                    'ref_externe'=>$customerArr[$i][7],
                    'parent_one'=>$customerArr[$i][8],
                    'parent_two'=>$customerArr[$i][9],
                    'parent_three'=>$customerArr[$i][10],
                    'parent_four'=>$customerArr[$i][11],
                    'ref_parent_one'=>$customerArr[$i][12],
                    'ref_parent_two'=>$customerArr[$i][13],
                    'ref_parent_three'=>$customerArr[$i][14],
                    'ref_parent_four'=>$customerArr[$i][15],
                    'created_at'=>$customerArr[$i][5],
                    'updated_at'=>$customerArr[$i][6],
                ]);

                echo $i.' - '.$org_unit->id.' - '.$customerArr[$i][0].' - '.$customerArr[$i][1].'<br/>';*/

               }

				// DB::insert("insert into arrondissements (geom,  nom,id_pays, code) values (?,?,?,?)", [$customerArr[$i][0], $customerArr[$i][2],$customerArr[$i][3],$customerArr[$i][4]]);

			}

			}

			// return redirect()->route('indicateurs.index');
		}

	}


}
