<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangayController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\PurokController;
use App\Http\Controllers\HouseholdController;

Route::get('/', fn() => redirect()->route('residents.index'));

//RESIDENTS ROUTES
Route::get('/residents',             [ResidentController::class, 'residents'])->name('residents.index');
Route::get('/residents/data',        [ResidentController::class, 'getResidents'])->name('residents.data');
Route::get('/residents/add',         [ResidentController::class, 'residentsAdd'])->name('residents.add');
Route::post('/residents',            [ResidentController::class, 'residentsStore'])->name('residents.store');
Route::get('/residents/{id}/view',   [ResidentController::class, 'residentsView'])->name('residents.view');
Route::get('/residents/{id}/edit',   [ResidentController::class, 'residentsEdit'])->name('residents.edit');
Route::put('/residents/{id}/update', [ResidentController::class, 'residentsUpdate'])->name('residents.update');
Route::delete('/residents/{id}',     [ResidentController::class, 'residentsDelete'])->name('residents.delete');
//RESIDENTS ROUTES END


Route::get('/documents',  [BarangayController::class, 'documents'])->name('documents.index');
Route::get('/blotter',    [BarangayController::class, 'blotter'])->name('blotter.index');


//PUROK ROUTES
Route::get('/purok',                 [PurokController::class, 'purok'])->name('household.purok-index');
Route::get('/purok/data',            [PurokController::class, 'getPuroks'])->name('purok.data');
Route::get('/purok/add',             [PurokController::class, 'purokAdd'])->name('purok.add');
Route::post('/purok',                [PurokController::class, 'purokStore'])->name('purok.store');
Route::get('/purok/{id}/view',       [PurokController::class, 'purokView'])->name('purok.view');
Route::get('/purok/{id}/edit',       [PurokController::class, 'purokEdit'])->name('purok.edit');
Route::put('/purok/{id}/update',     [PurokController::class, 'purokUpdate'])->name('purok.update');
Route::delete('/purok/{id}',         [PurokController::class, 'purokDelete'])->name('purok.delete');
//PUROK ROUTES END


//HOUSEHOLD ROUTES
Route::get('/household',             [HouseholdController::class, 'householdIndex'])->name('household.household-index');
Route::get('/household/data',        [HouseholdController::class, 'getHouseholds'])->name('household.data');
Route::get('/household/add',         [HouseholdController::class, 'householdAdd'])->name('household.add');
Route::get('/household/{id}/view',   [HouseholdController::class, 'householdView'])->name('household.view');
Route::get('/household/{id}/edit',   [HouseholdController::class, 'householdEdit'])->name('household.edit');
Route::delete('/household/{id}',     [HouseholdController::class, 'householdDelete'])->name('household.delete');
//HOUSEHOLD ROUTES END


Route::get('/business',   [BarangayController::class, 'business'])->name('business.index');
Route::get('/officials',  [BarangayController::class, 'officials'])->name('officials.index');
Route::get('/committee',  [BarangayController::class, 'committee'])->name('committee.index');
Route::get('/reports',    [BarangayController::class, 'reports'])->name('reports.index');
Route::get('/users',      [BarangayController::class, 'users'])->name('users.index');
Route::get('/technical',  [BarangayController::class, 'technical'])->name('technical.index');
Route::get('/dashboard',  [BarangayController::class, 'dashboard'])->name('dashboard');