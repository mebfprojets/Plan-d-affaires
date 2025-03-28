<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\RegisteredUserController;
use App\Http\Controllers\BackendController;
use App\Http\Controllers\PackController;
use App\Http\Controllers\BusinessPlanController;
use App\Http\Controllers\ParametreController;
use App\Http\Controllers\ValeurController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware('guest:admin')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('admin.register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('auth', [LoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('auth', [LoginController::class, 'store']);

});

Route::prefix('admin')->middleware('auth:admin')->group(function () {
    Route::get('/dashboard', [BackendController::class, 'dashboard'])->name('admin.dashboard');
    Route::resource('packs', PackController::class);
    Route::get('businessplans',[ BusinessPlanController::class, 'index'])->name('businessplans.index');
    Route::resource('parametres', ParametreController::class);
    Route::resource('valeurs', ValeurController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('admins', AdminController::class);
    Route::post('delete/ligne', [BackendController::class, 'deleteLigne'])->name('delete.ligne');
    Route::resource('sessionformations', SessionPlanController::class);
    Route::get('souscription', [SessionPlanController::class, 'souscription'])->name('sessionformation.souscription');
    Route::get('souscription/{id_session_client}', [SessionPlanController::class, 'showSouscription'])->name('souscription.show');
    Route::post('souscription/valider', [SessionPlanController::class, 'validerSouscription'])->name('souscription.valider');
    Route::get('/business_plan/modele/{id_plan_affaire}', [BusinessPlanController::class, 'downloadBusinessPlan'])->name('businessplans.download');
    // Route::get('sessionformations/souscription', [SessionPlanController::class, 'souscription'])->name('sessionformation.souscription');
    Route::post('logout', [LoginController::class, 'destroy'])->name('admin.logout');
});
