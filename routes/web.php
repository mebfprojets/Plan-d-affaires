<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\BusinessPlanController;
use App\Livewire\Chat\Index;
use App\Livewire\Chat\Chat;
use App\Livewire\Users;
use Illuminate\Support\Facades\Route;


Route::get('/selection', [FrontendController::class, 'selection'])->name('root.selection');
Route::get('/', [FrontendController::class, 'home'])->name('frontend.home');
Route::get('account', [FrontendController::class, 'account'])->name('frontend.account');
Route::post('account', [FrontendController::class, 'storeAccount'])->name('frontend.account.store');
Route::get('pa/{slug_menu}', [FrontendController::class, 'menu'])->name('frontend.menu');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/service/{slug_pack}', [FrontendController::class, 'servicePack'])->name('packs.service');
    Route::post('/business_plan/store', [BusinessPlanController::class, 'storeBusinessPlan'])->name('businessplans.store');
    Route::get('/business_plan/edit/{id_plan_affaire}', [BusinessPlanController::class, 'editBusinessPlan'])->name('businessplans.edit');
    Route::post('/business_plan/update/{id_plan_affaire}', [BusinessPlanController::class, 'updateBusinessPlan'])->name('businessplans.update');
    Route::get('/business_plan/payer/{id_plan_affaire}', [BusinessPlanController::class, 'payerBusinessPlan'])->name('businessplans.payer');
    Route::post('/business_plan/payer/{id_plan_affaire}', [BusinessPlanController::class, 'validerPayBusinessPlan']);
    Route::get('/pa/edit/{id_plan_affaire}', [BusinessPlanController::class, 'editBusinessPlan'])->name('businessplans.edit');
    Route::get('/business_plan/details/{id_plan_affaire}', [BusinessPlanController::class, 'detailsBusinessPlan'])->name('businessplans.details');
    Route::get('/add/promoteur', [BusinessPlanController::class, 'addLignePromoteur'])->name('promoteur.add-ligne');
    Route::get('/chat', Index::class)->name('chat.index');
    Route::get('/chat/{query}', Chat::class)->name('chat');
    Route::get('/users',Users::class)->name('users');

});

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
