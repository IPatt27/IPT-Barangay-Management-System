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
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\BlotterController;
use App\Http\Controllers\OfficialController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;

Route::get('/', fn() => redirect()->route('login'));

Route::middleware(['auth'])->group(function () {

    // PROFILE ROUTES
    Route::get('/profile',                      [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',                    [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile',                   [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard',                    [DashboardController::class, 'dashboard'])->name('dashboard');

    // ── ALL ROLES CAN VIEW ──
    Route::get('/residents',                    [ResidentController::class, 'residents'])->name('residents.index');
    Route::get('/residents/data',               [ResidentController::class, 'getResidents'])->name('residents.data');
    Route::get('/residents/{id}/view',          [ResidentController::class, 'residentsView'])->name('residents.view');

    Route::get('/purok',                        [PurokController::class, 'purok'])->name('household.purok-index');
    Route::get('/purok/data',                   [PurokController::class, 'getPuroks'])->name('purok.data');
    Route::get('/purok/{id}/view',              [PurokController::class, 'purokView'])->name('purok.view');

    Route::get('/household',                    [HouseholdController::class, 'householdIndex'])->name('household.household-index');
    Route::get('/household/data',               [HouseholdController::class, 'getHouseholds'])->name('household.data');
    Route::get('/household/{id}/view',          [HouseholdController::class, 'householdView'])->name('household.view');

    Route::get('/business',                     [BusinessController::class, 'business'])->name('business.index');
    Route::get('/business/data',                [BusinessController::class, 'getBusinesses'])->name('business.data');
    Route::get('/business/{id}/view',           [BusinessController::class, 'businessView'])->name('business.view');

    Route::get('/committee',                    [CommitteeController::class, 'index'])->name('committee.index');
    Route::get('/committee/{slug}',             [CommitteeController::class, 'show'])->name('committee.view');

    Route::get('/documents',                    [DocumentController::class, 'index'])->name('documents.index');
    Route::get('/documents/data',               [DocumentController::class, 'getData'])->name('documents.data');
    Route::get('/documents/{id}/print',         [DocumentController::class, 'print'])->name('documents.print');

    Route::get('/blotter',                      [BlotterController::class, 'index'])->name('blotter.index');
    Route::get('/blotter/data',                 [BlotterController::class, 'getData'])->name('blotter.data');
    Route::get('/blotter/{id}/view',            [BlotterController::class, 'view'])->name('blotter.view');
    Route::get('/blotter/{id}/print',           [BlotterController::class, 'print'])->name('blotter.print');

    Route::get('/officials',                    [OfficialController::class, 'index'])->name('officials.index');
    Route::get('/officials/data',               [OfficialController::class, 'getData'])->name('officials.data');
    Route::get('/officials/{id}/view',          [OfficialController::class, 'view'])->name('officials.view');
    Route::get('/officials/{id}/id-card',       [OfficialController::class, 'idCard'])->name('officials.id');

    Route::get('/payments',                     [PaymentController::class, 'paymentDashboard'])->name('payments.index');
    Route::get('/payments/data',                [PaymentController::class, 'getData'])->name('payments.data');
    Route::get('/payments/{id}/receipt',        [PaymentController::class, 'receipt'])->name('payments.receipt');

    Route::get('/reports',                      [ReportController::class, 'reports'])->name('reports.index');
    Route::get('/reports/data',                 [ReportController::class, 'getReportsData'])->name('reports.data');
    Route::get('/reports/export/pdf',           [ReportController::class, 'exportPdf'])->name('reports.export.pdf');
    Route::get('/reports/export/excel',         [ReportController::class, 'exportExcel'])->name('reports.export.excel');

    // ── ADMIN AND SECRETARY (create and edit) ──
    Route::middleware(['role:admin|secretary'])->group(function () {

        Route::get('/residents/add',            [ResidentController::class, 'residentsAdd'])->name('residents.add');
        Route::post('/residents',               [ResidentController::class, 'residentsStore'])->name('residents.store');
        Route::get('/residents/{id}/edit',      [ResidentController::class, 'residentsEdit'])->name('residents.edit');
        Route::put('/residents/{id}/update',    [ResidentController::class, 'residentsUpdate'])->name('residents.update');

        Route::get('/purok/add',                [PurokController::class, 'purokAdd'])->name('purok.add');
        Route::post('/purok',                   [PurokController::class, 'purokStore'])->name('purok.store');
        Route::get('/purok/{id}/edit',          [PurokController::class, 'purokEdit'])->name('purok.edit');
        Route::put('/purok/{id}/update',        [PurokController::class, 'purokUpdate'])->name('purok.update');

        Route::get('/household/add',            [HouseholdController::class, 'householdAdd'])->name('household.add');
        Route::post('/household',               [HouseholdController::class, 'householdStore'])->name('household.store');
        Route::get('/household/{id}/edit',      [HouseholdController::class, 'householdEdit'])->name('household.edit');
        Route::put('/household/{id}/update',    [HouseholdController::class, 'householdUpdate'])->name('household.update');

        Route::post('/committee/{slug}/upload',             [CommitteeController::class, 'upload'])->name('committee.upload');
        Route::delete('/committee/{slug}/records/{id}',     [CommitteeController::class, 'deleteRecord'])->name('committee.record.delete');
        Route::put('/committee/{slug}/records/{id}',        [CommitteeController::class, 'updateRecord'])->name('committee.record.update');

        Route::get('/business/add',             [BusinessController::class, 'businessAdd'])->name('business.add');
        Route::post('/business',                [BusinessController::class, 'businessStore'])->name('business.store');
        Route::get('/business/{id}/edit',       [BusinessController::class, 'businessEdit'])->name('business.edit');
        Route::put('/business/{id}/update',     [BusinessController::class, 'businessUpdate'])->name('business.update');

        Route::get('/documents/create',         [DocumentController::class, 'create'])->name('documents.create');
        Route::post('/documents',               [DocumentController::class, 'store'])->name('documents.store');

        Route::get('/blotter/create',           [BlotterController::class, 'create'])->name('blotter.create');
        Route::post('/blotter',                 [BlotterController::class, 'store'])->name('blotter.store');
        Route::get('/blotter/{id}/edit',        [BlotterController::class, 'edit'])->name('blotter.edit');
        Route::put('/blotter/{id}',             [BlotterController::class, 'update'])->name('blotter.update');

        Route::get('/officials/create',         [OfficialController::class, 'create'])->name('officials.create');
        Route::post('/officials',               [OfficialController::class, 'store'])->name('officials.store');
        Route::get('/officials/{id}/edit',      [OfficialController::class, 'edit'])->name('officials.edit');
        Route::put('/officials/{id}',           [OfficialController::class, 'update'])->name('officials.update');

        Route::post('/payments',                [PaymentController::class, 'store'])->name('payments.store');
    });

    // ── ADMIN ONLY (delete and user management) ──
    Route::middleware(['role:admin'])->group(function () {
        Route::delete('/residents/{id}',                    [ResidentController::class, 'residentsDelete'])->name('residents.delete');
        Route::post('/residents/{id}/restore',              [ResidentController::class, 'restore'])->name('residents.restore');           // ← new
        Route::delete('/residents/{id}/force-delete',       [ResidentController::class, 'forceDelete'])->name('residents.forceDelete');   // ← new

        Route::delete('/purok/{id}',                        [PurokController::class, 'purokDelete'])->name('purok.delete');
        Route::delete('/household/{id}',                    [HouseholdController::class, 'householdDelete'])->name('household.delete');
        Route::delete('/business/{id}',                     [BusinessController::class, 'businessDelete'])->name('business.delete');

        Route::delete('/documents/{id}',                    [DocumentController::class, 'delete'])->name('documents.delete');
        Route::post('/documents/{id}/restore',              [DocumentController::class, 'restore'])->name('documents.restore');
        Route::delete('/documents/{id}/force-delete',       [DocumentController::class, 'forceDelete'])->name('documents.forceDelete');

        Route::delete('/blotter/{id}',                      [BlotterController::class, 'delete'])->name('blotter.delete');
        Route::delete('/blotter/attachment/{id}',           [BlotterController::class, 'deleteAttachment'])->name('blotter.attachment.delete');
        Route::post('/blotter/{id}/restore',                [BlotterController::class, 'restore'])->name('blotter.restore');
        Route::delete('/blotter/{id}/force-delete',         [BlotterController::class, 'forceDelete'])->name('blotter.force-delete');

        Route::delete('/officials/{id}',                    [OfficialController::class, 'delete'])->name('officials.delete');
        Route::post('/officials/{id}/restore',              [OfficialController::class, 'restore'])->name('officials.restore');
        Route::delete('/officials/{id}/force-delete',       [OfficialController::class, 'forceDelete'])->name('officials.force-delete');

        Route::get('/users',                                [UserController::class, 'users'])->name('users.index');
        Route::get('/users/data',                           [UserController::class, 'getUsers'])->name('users.data');
        Route::get('/users/{id}/edit',                      [UserController::class, 'usersEdit'])->name('users.edit');
        Route::put('/users/{id}/update',                    [UserController::class, 'usersUpdate'])->name('users.update');

        Route::delete('/payments/{id}',                     [PaymentController::class, 'delete'])->name('payments.delete');
    });

});

require __DIR__.'/auth.php';