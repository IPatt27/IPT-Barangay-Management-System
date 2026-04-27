<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangayController;

Route::get('/', fn() => redirect()->route('residents.index'));

//RESIDENTS ROUTES
Route::get('/residents',            [BarangayController::class, 'residents'])->name('residents.index');

//YAJRA TABLE
Route::get('/residents/data', [BarangayController::class, 'getResidents'])->name('residents.data');

Route::get('/residents/add',        [BarangayController::class, 'residentsAdd'])->name('residents.add');
Route::post('/residents',           [BarangayController::class, 'residentsStore'])->name('residents.store');

Route::get('/residents/{id}/view',  [BarangayController::class, 'residentsView'])->name('residents.view');
Route::get('/residents/{id}/edit',  [BarangayController::class, 'residentsEdit'])->name('residents.edit');
Route::put('/residents/{id}/update',[BarangayController::class, 'residentsUpdate'])->name('residents.update');
Route::delete('/residents/{id}',    [BarangayController::class, 'residentsDelete'])->name('residents.delete');

//RESIDENTS ROUTES END




Route::get('/documents',  [BarangayController::class, 'documents'])->name('documents.index');
Route::get('/blotter',    [BarangayController::class, 'blotter'])->name('blotter.index');




//PUROK - HOUSEHOLD ROUTES

// Purok index and Yajra
Route::get('/purok',                        [BarangayController::class, 'purok'])->name('household.purok-index');
Route::get('/purok/data',                   [BarangayController::class, 'getPuroks'])->name('purok.data');
Route::delete('/purok/{id}',                [BarangayController::class, 'purokDelete'])->name('purok.delete');
Route::post('/purok',                       [BarangayController::class, 'purokStore'])->name('purok.store');

// Purok routes
Route::get('/purok/add',                    [BarangayController::class, 'purokAdd'])->name('purok.add');
Route::get('/purok/{id}/view',              [BarangayController::class, 'purokView'])->name('purok.view');
Route::get('/purok/{id}/edit',              [BarangayController::class, 'purokEdit'])->name('purok.edit');
Route::put('/purok/{id}/update',            [BarangayController::class, 'purokUpdate'])->name('purok.update');

// Household index and Yajra
Route::get('/household',                    [BarangayController::class, 'householdIndex'])->name('household.household-index');
Route::get('/household/data',               [BarangayController::class, 'getHouseholds'])->name('household.data');
Route::delete('/household/{id}',            [BarangayController::class, 'householdDelete'])->name('household.delete');

// Household routes
Route::get('/household/add',                [BarangayController::class, 'householdAdd'])->name('household.add');
Route::get('/household/{id}/view',          [BarangayController::class, 'householdView'])->name('household.view');
Route::get('/household/{id}/edit',          [BarangayController::class, 'householdEdit'])->name('household.edit');

//PUROK - HOUSEHOLD ROUTES END



Route::get('/business',   [BarangayController::class, 'business'])->name('business.index');
Route::get('/officials',  [BarangayController::class, 'officials'])->name('officials.index');
Route::get('/committee',  [BarangayController::class, 'committee'])->name('committee.index');
Route::get('/reports',    [BarangayController::class, 'reports'])->name('reports.index');
Route::get('/users',      [BarangayController::class, 'users'])->name('users.index');
Route::get('/technical',  [BarangayController::class, 'technical'])->name('technical.index');
Route::get('/dashboard', [BarangayController::class, 'dashboard'])->name('dashboard');

