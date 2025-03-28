<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\BusinessPlan;
use App\Models\Client;
use App\Models\Admin;
use App\Models\FormationClient;
use App\Models\FormationParticipant;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Services\MoodleService;
use Illuminate\Support\Str;
use \Exception;
use Laracasts\Flash\Flash;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $plans = BusinessPlan::all();
        return view('backend.plans.index', compact('plans'));

    }

    public function synch()
    {
        if(Auth::user()->can('formations.store')){
            try {
                // dd((new MoodleService)->get_categories());
                $formations = (new MoodleService)->get_formations();
                foreach ($formations as $formation) {
                    $formation = (object) $formation;
                    Formation::create([
                        "shortname" => $formation->shortname,
                        "categoryid" => $formation->categoryid,
                        "categorysortorder" => $formation->categorysortorder,
                        "fullname" => $formation->fullname,
                        "displayname" => $formation->displayname,
                        "summaryformat" => $formation->summaryformat,
                        "format" => $formation->format,
                        "showgrades" => $formation->showgrades,
                        "newsitems" => $formation->newsitems,
                        "startdate" => $formation->startdate,
                        "enddate" => $formation->enddate,
                        "numsections" => $formation->numsections,
                        "maxbytes" => $formation->maxbytes,
                        "showreports" => $formation->showreports,
                        "visible" => $formation->visible,
                        "groupmode" => $formation->groupmode,
                        "groupmodeforce" => $formation->groupmodeforce,
                        "defaultgroupingid" => $formation->defaultgroupingid,
                        "timecreated" => $formation->timecreated,
                        "timemodified" => $formation->timemodified,
                        "enablecompletion" => $formation->enablecompletion,
                        "completionnotify" => $formation->completionnotify,
                        "showactivitydates" => $formation->showactivitydates,
                        'slug'=>Str::slug($formation->fullname, '_'),
                    ]);
                }
                return redirect()->back();
            } catch (Exception $ex) {
                dd($ex);
            }
        }else{
            return redidect()->route('admin.dashboard');
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.plans.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(Auth::user()->can('formations.store')){
            try {
                $request->validate([
                    'shortname'=>'required',
                    'fullname'=>'required',
                    'displayname'=>'required',
                    'summary'=>'required',
                ]);

                Formation::create([
                    "shortname" => $request->shortname,
                    "fullname" => $request->fullname,
                    "displayname" => $request->displayname,
                    "summary" => $request->summary,
                    'slug'=>Str::slug($request->fullname, '_'),
                ]);
                // Flash::success('Formation créée avec succès!');
                return redirect()->route('formations.index')->with('success', 'Formation créée avec succès!');
            } catch (Exception $ex) {
                return redirect()->back()->with('error', 'Erreur lors de l\'enregistrement de la formation'.$ex->getMessage());
            }
        }else{
            return redirect()->route('admin.dashboard');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if(Auth::user()->can('formations.index')){
        $formation = Formation::find($id);
        $sessionformations = DB::table('session_formations')
                            ->join('formations', 'session_formations.formation_id', 'formations.id')
                            ->join('valeurs', 'session_formations.lieu_formation', 'valeurs.id')
                            ->select('session_formations.*', 'formations.fullname', 'valeurs.libelle as localite_formation')
                            ->where('formations.id', $id)
                            ->get();
        // $formation_clients = FormationClient::where('formation_id', $formation->id)->get();
        $formation_clients = DB::table('clients')
                            ->join('formation_clients', 'formation_clients.client_id', '=', 'clients.id')
                            ->join('session_formations', 'formation_clients.formation_id', '=', 'session_formations.formation_id')
                            ->join('formation_participants', 'formation_participants.id_formation_client', '=', 'formation_clients.id')
                            ->select('clients.id', 'clients.nom_client')
                            // ->select(DB::raw('count(formation_clients.id) as nombre_client'))
                            ->select(DB::raw('count(formation_participants.id) as nombre_participant'))
                            ->select(DB::raw('sum(session_formations.prix_formation) as cout_total'))
                            ->where('formation_clients.formation_id', $id)
                            ->groupBy('clients.id', 'clients.nom_client')
                            ->get();
        $formation_participants = DB::table('clients')
                        ->join('formation_clients', 'formation_clients.client_id', '=', 'clients.id')
                        ->join('formation_participants', 'formation_participants.id_formation_client', '=', 'formation_clients.id')
                        ->select('formation_participants.id', 'formation_participants.nom_participant', 'formation_participants.prenom_participant')
                        ->where('formation_clients.formation_id', $formation->id)
                        ->groupBy('formation_participants.id', 'formation_participants.nom_participant', 'formation_participants.prenom_participant')
                        ->get();
        return view('admin.formations.show', compact('formation', 'sessionformations', 'formation_clients', 'formation_participants'));
        }else{
            return redirect()->route('admin.dashboard');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
