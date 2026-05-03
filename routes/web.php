<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangayController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\PurokController;
use App\Http\Controllers\HouseholdController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\CommitteeController;

Route::get('/', fn() => redirect()->route('login'));

// BREEZE PROFILE ROUTES
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ALL PROTECTED ROUTES
Route::middleware(['auth'])->group(function () {

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
    Route::post('/household',            [HouseholdController::class, 'householdStore'])->name('household.store');
    Route::get('/household/{id}/view',   [HouseholdController::class, 'householdView'])->name('household.view');
    Route::get('/household/{id}/edit',   [HouseholdController::class, 'householdEdit'])->name('household.edit');
    Route::delete('/household/{id}',     [HouseholdController::class, 'householdDelete'])->name('household.delete');
    Route::put('/household/{id}/update', [HouseholdController::class, 'householdUpdate'])->name('household.update');
    //HOUSEHOLD ROUTES END

   // BUSINESS ROUTES
    Route::get('/business',                 [BusinessController::class, 'business'])->name('business.index');
    Route::get('/business/data',            [BusinessController::class, 'getBusinesses'])->name('business.data');
    Route::get('/business/add',             [BusinessController::class, 'businessAdd'])->name('business.add');
    Route::post('/business',                [BusinessController::class, 'businessStore'])->name('business.store');
    Route::get('/business/{id}/view',       [BusinessController::class, 'businessView'])->name('business.view');
    Route::get('/business/{id}/edit',       [BusinessController::class, 'businessEdit'])->name('business.edit');
    Route::put('/business/{id}/update',     [BusinessController::class, 'businessUpdate'])->name('business.update');
    Route::delete('/business/{id}',         [BusinessController::class, 'businessDelete'])->name('business.delete');
    // BUSINESS ROUTES END

   // COMMITTEE ROUTES
    Route::get('/committee',                [CommitteeController::class, 'committee'])->name('committee.index');
    Route::get('/committee/data',           [CommitteeController::class, 'getCommittees'])->name('committee.data');
    Route::get('/committee/add',            [CommitteeController::class, 'committeeAdd'])->name('committee.add');
    Route::post('/committee',               [CommitteeController::class, 'committeeStore'])->name('committee.store');
    Route::get('/committee/{id}/view',      [CommitteeController::class, 'committeeView'])->name('committee.view');
    Route::get('/committee/{id}/edit',      [CommitteeController::class, 'committeeEdit'])->name('committee.edit');
    Route::put('/committee/{id}/update',    [CommitteeController::class, 'committeeUpdate'])->name('committee.update');
    Route::delete('/committee/{id}',        [CommitteeController::class, 'committeeDelete'])->name('committee.delete');
    // COMMITTEE ROUTES END

    Route::get('/reports',    [BarangayController::class, 'reports'])->name('reports.index');
    Route::get('/users',      [BarangayController::class, 'users'])->name('users.index');
    Route::get('/technical',  [BarangayController::class, 'technical'])->name('technical.index');
    Route::get('/dashboard',  [BarangayController::class, 'dashboard'])->name('dashboard');

    // DOCUMENT ROUTES
    Route::get('/documents',                [BarangayController::class, 'documents'])->name('documents.index');
    Route::get('/documents/data',           [BarangayController::class, 'getDocuments'])->name('documents.data');
    Route::get('/documents/create',         [BarangayController::class, 'documentsCreate'])->name('documents.create');
    Route::post('/documents',               [BarangayController::class, 'documentsStore'])->name('documents.store');
    Route::get('/documents/{id}/print',     [BarangayController::class, 'documentsPrint'])->name('documents.print');
    Route::delete('/documents/{id}',        [BarangayController::class, 'documentsDelete'])->name('documents.delete');
    // DOCUMENT ROUTES END

    // BLOTTER ROUTES
    Route::get('/blotter',                          [BarangayController::class, 'blotter'])->name('blotter.index');
    Route::get('/blotter/data',                     [BarangayController::class, 'getBlotters'])->name('blotter.data');
    Route::get('/blotter/create',                   [BarangayController::class, 'blotterCreate'])->name('blotter.create');
    Route::post('/blotter',                         [BarangayController::class, 'blotterStore'])->name('blotter.store');
    Route::get('/blotter/{id}/view',                [BarangayController::class, 'blotterView'])->name('blotter.view');
    Route::get('/blotter/{id}/edit',                [BarangayController::class, 'blotterEdit'])->name('blotter.edit');
    Route::put('/blotter/{id}',                     [BarangayController::class, 'blotterUpdate'])->name('blotter.update');
    Route::delete('/blotter/{id}',                  [BarangayController::class, 'blotterDelete'])->name('blotter.delete');
    Route::delete('/blotter/attachment/{id}',       [BarangayController::class, 'blotterDeleteAttachment'])->name('blotter.attachment.delete');
    Route::get('/blotter/{id}/print',               [BarangayController::class, 'blotterPrint'])->name('blotter.print');
    // BLOTTER ROUTES END

    // OFFICIALS ROUTES
    Route::get('/officials',              [BarangayController::class, 'officials'])->name('officials.index');
    Route::get('/officials/data',         [BarangayController::class, 'getOfficials'])->name('officials.data');
    Route::get('/officials/create',       [BarangayController::class, 'officialsCreate'])->name('officials.create');
    Route::post('/officials',             [BarangayController::class, 'officialsStore'])->name('officials.store');
    Route::get('/officials/{id}/view',    [BarangayController::class, 'officialsView'])->name('officials.view');
    Route::get('/officials/{id}/edit',    [BarangayController::class, 'officialsEdit'])->name('officials.edit');
    Route::put('/officials/{id}',         [BarangayController::class, 'officialsUpdate'])->name('officials.update');
    Route::delete('/officials/{id}',      [BarangayController::class, 'officialsDelete'])->name('officials.delete');
    Route::get('/officials/{id}/id-card', [BarangayController::class, 'officialsId'])->name('officials.id');
    // OFFICIALS ROUTES END

    // ── TECHNICAL / BACKUP
    Route::post('/technical/backup',        [BarangayController::class, 'backupDatabase'])->name('technical.backup');
    Route::get('/technical/backup/download',[BarangayController::class, 'downloadBackup'])->name('technical.backup.download');
    Route::post('/technical/restore',       [BarangayController::class, 'restoreDatabase'])->name('technical.restore');
});

require __DIR__.'/auth.php';
