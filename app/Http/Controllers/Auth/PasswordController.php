<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required', 'current_password'], // détecte le bon guard
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $guard = Auth::guard('admin')->check() ? 'admin' : 'web'; // ou 'users'

        $user = Auth::guard($guard)->user();
        $user->password = Hash::make($request->password);
        $user->save();

        Auth::guard($guard)->logout(); // ⛔ Déconnecte l'utilisateur

        $request->session()->invalidate();     // Nettoie la session
        $request->session()->regenerateToken();

        // Redirection vers la page de connexion appropriée
        return redirect()->route('login')->with('success', 'Mot de passe modifié. Veuillez vous reconnecter.');
    }
}
