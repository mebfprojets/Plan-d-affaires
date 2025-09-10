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
use App\Http\Controllers\PromoteurController;
use App\Http\Controllers\EntrepriseController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\Auth\PasswordController;
use App\Livewire\Chat\Index;
use App\Livewire\Chat\Chat;
use App\Livewire\Users;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminSessionMiddleware;

Route::prefix('admin')->middleware('guest:admin')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('admin.register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('auth', [LoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('auth', [LoginController::class, 'store']);

});


Route::prefix('admin')->middleware([
    AdminSessionMiddleware::class,
    'auth:admin'
])->group(function () {
    Route::get('/dashboard', [BackendController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/get-stat', [BackendController::class, 'getStat'])->name('data.stat');
    Route::resource('packs', PackController::class);
    Route::get('businessplans',[ BusinessPlanController::class, 'index'])->name('businessplans.index');
    Route::resource('parametres', ParametreController::class);
    Route::resource('valeurs', ValeurController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('admins', AdminController::class);
    Route::resource('promoteurs', PromoteurController::class);
    Route::resource('entreprises', EntrepriseController::class);
    Route::post('delete/ligne', [BackendController::class, 'deleteLigne'])->name('delete.ligne');
    // Route::resource('sessionformations', SessionPlanController::class);
    // Route::get('souscription', [SessionPlanController::class, 'souscription'])->name('sessionformation.souscription');
    // Route::get('souscription/{id_session_client}', [SessionPlanController::class, 'showSouscription'])->name('souscription.show');
    // Route::post('souscription/valider', [SessionPlanController::class, 'validerSouscription'])->name('souscription.valider');
    Route::get('/business_plan/modele/{id_plan_affaire}', [BusinessPlanController::class, 'downloadBusinessPlan'])->name('businessplans.download');
    Route::get('/business_plan/show/{id_plan_affaire}', [BusinessPlanController::class, 'showBusinessPlan'])->name('businessplans.show');
    Route::get('/business_plan/edit/{id_plan_affaire}', [BusinessPlanController::class, 'editBusinessPlan'])->name('business_plans.edit');
    Route::post('/business_plan/update/{id_plan_affaire}', [BusinessPlanController::class, 'updateBusinessPlan'])->name('business_plans.update');
    Route::get('/business_plan/valider/{id_plan_affaire}', [BusinessPlanController::class, 'validerBusinessPlan'])->name('businessplans.valider');
    Route::get('/business_plan/print/{id_plan_affaire}', [BusinessPlanController::class, 'printBusinessPlan'])->name('businessplans.print');
    Route::post('/business_plan/cloturer', [BusinessPlanController::class, 'cloturerBusinessPlan'])->name('businessplans.cloturer');
    Route::get('/change-password', [PasswordController::class, 'changePassword'])->name('password.change');
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');
    Route::get('/get/pa', [BusinessPlanController::class, 'getPa'])->name('pa.get');
    Route::post('/save/imput', [BusinessPlanController::class, 'saveImputation'])->name('imput.save');
    Route::get('/chat', Index::class)->name('chat.index');
    Route::get('/chat/{query}', Chat::class)->name('chat');
    Route::get('/users',Users::class)->name('users');
    Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
    Route::get('/contacts/{id}', [ContactController::class, 'show'])->name('contacts.show');
    // Route::get('sessionformations/souscription', [SessionPlanController::class, 'souscription'])->name('sessionformation.souscription');
    Route::post('logout', [LoginController::class, 'destroy'])->name('admin.logout');
});
