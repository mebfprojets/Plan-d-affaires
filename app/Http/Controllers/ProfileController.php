<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\PlanAffaire;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $plan_affaires = PlanAffaire::where('id_user', Auth::user()->id)->get();
        return view('frontend.profile.show', [
            'user' => $request->user(),
            'plan_affaires'=>$plan_affaires,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Formations
     */
    public function formation()
    {
        $formations = DB::table('session_formations')
                    ->join('formations', 'session_formations.formation_id', 'formations.id')
                    ->join('valeurs', 'session_formations.lieu_formation', 'valeurs.id')
                    ->join('session_clients', 'session_formations.id', 'session_clients.session_id')
                    ->join('clients', 'clients.id', 'session_clients.client_id')
                    ->join('users', 'users.client_id', 'clients.id')
                    ->select('session_formations.*', 'session_clients.id as session_client_id', 'session_clients.nombre_participant', 'session_clients.cout_total_client', 'session_formations.startdate', 'session_formations.enddate', 'formations.fullname', 'valeurs.libelle as localite_formation', 'clients.nom_client', 'clients.numero_telephone')
                    ->where('users.id', Auth::user()->id)
                    ->get();
        return view('profile.formations', compact('formations'));
    }
}
