<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\BusinessPlanController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Livewire\Chat\Index;
use App\Livewire\Chat\Chat;
use App\Livewire\Users;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\UserSessionMiddleware;

Route::post('/business_plan/{id_plan_affaire}/callback', [BusinessPlanController::class, 'callbackPaye'])->name('callback.payer');
Route::get('/selection', [FrontendController::class, 'selection'])->name('root.selection');
Route::get('/banque', [FrontendController::class, 'banque'])->name('root.banque');
Route::get('/', [FrontendController::class, 'home'])->name('frontend.home');
Route::get('account', [FrontendController::class, 'account'])->name('frontend.account');
Route::post('account', [FrontendController::class, 'storeAccount'])->name('frontend.account.store');
Route::get('pa/{slug_menu}', [FrontendController::class, 'menu'])->name('frontend.menu');
Route::post('contact', [ContactController::class, 'store'])->name('contacts.store');
Route::post('/business_plan/update/{id_plan_affaire}', [BusinessPlanController::class, 'updateBusinessPlan'])->name('businessplans.update');
// VIEW IMPORT
Route::get('/import', [ImportController::class, 'viewCsv'])->name('view.data');
Route::post('/import-data', [ImportController::class, 'importCsv'])->name('import.data');

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('connexion', [FrontendController::class, 'login'])->name('login');

    Route::post('connexion', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');

    Route::get('/change-forget', [FrontendController::class, 'forgetPassword'])->name('password.forget');


});

Route::middleware([UserSessionMiddleware::class,
    'auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/service/{slug_pack}', [FrontendController::class, 'servicePack'])->name('packs.service');
    Route::post('/business_plan/store', [BusinessPlanController::class, 'storeBusinessPlan'])->name('businessplans.store');
    Route::get('/business_plan/edit/{id_plan_affaire}', [BusinessPlanController::class, 'editBusinessPlan'])->name('businessplans.edit');
    Route::get('/business_plan/payer/{id_plan_affaire}', [BusinessPlanController::class, 'payerBusinessPlan'])->name('businessplans.payer');
    Route::post('/business_plan/payer/{id_plan_affaire}', [BusinessPlanController::class, 'validerPayBusinessPlan']);
    Route::get('/pa/edit/{id_plan_affaire}', [BusinessPlanController::class, 'editBusinessPlan'])->name('businessplans.edit');
    Route::get('/business_plan/{id_plan_affaire}/success', [BusinessPlanController::class, 'successPaye'])->name('success.payer');
    Route::get('/business_plan/{id_plan_affaire}/cancel', [BusinessPlanController::class, 'cancelPaye'])->name('cancel.payer');

    Route::get('/business_plan/details/{id_plan_affaire}', [BusinessPlanController::class, 'detailsBusinessPlan'])->name('businessplans.details');
    Route::get('/business_plan/recu/{id_plan_affaire}', [BusinessPlanController::class, 'recuBusinessPlan'])->name('businessplans.recu');
    Route::get('/add/promoteur', [BusinessPlanController::class, 'addLignePromoteur'])->name('promoteur.add-ligne');
    Route::get('/change-password', [FrontendController::class, 'changePassword'])->name('password.changes');
    Route::put('password', [PasswordController::class, 'update'])->name('password.updates');
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
    Route::get('/chat', Index::class)->name('chat.index');
    Route::get('/chat/{query}', Chat::class)->name('chat');
    Route::get('/users',Users::class)->name('users');

});



// require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
