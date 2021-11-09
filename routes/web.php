<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Site\PublicController;
use App\Http\Controllers\Site\ContactController;
use App\Http\Controllers\Site\ContactjobController;
use App\Http\Controllers\Site\EducationController;

require __DIR__.'/auth.php';

Route::get('/preregistered', [PublicController::class, 'preregistered'])->name('preregistered');
Route::get('/pin', [PublicController::class, 'showPin'])->name('show_pin');

Route::group(['middleware' => 'auth'], function () {
    //this is resource controller but listing all actions for readability
    Route::get('/', [ContactController::class, 'index'])->name('contacts.index');
    Route::get('/contacts', [ContactController::class, 'contacts'])->name('contacts.contacts');
    Route::get('/contacts/create', [ContactController::class, 'create'])->name('contacts.create');
    Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store');
    Route::get('/contacts/{id}', [ContactController::class, 'show'])->name('contacts.show');
    Route::get('/contacts/{id}/edit', [ContactController::class, 'edit'])->name('contacts.edit');
    Route::put('/contacts/{id}', [ContactController::class, 'update'])->name('contacts.update');
    Route::put('/contacts/{id}/connect', [ContactController::class, 'connect'])->name('contacts.connect');
    Route::delete('/contacts/{id}', [ContactController::class, 'destroy'])->name('contacts.destroy');

    Route::get('/jobs/create/{contact_id}', [ContactjobController::class, 'create'])->name('jobs.create');
    Route::post('/jobs', [ContactjobController::class, 'store'])->name('jobs.store');
    Route::get('/jobs/{contact_id}/{id}/edit', [ContactjobController::class, 'edit'])->name('jobs.edit');
    Route::put('/jobs/{id}', [ContactjobController::class, 'update'])->name('jobs.update');
    Route::delete('/jobs/{id}', [ContactjobController::class, 'destroy'])->name('jobs.destroy');

    Route::get('/educations/create/{contact_id}', [EducationController::class, 'create'])->name('educations.create');
    Route::post('/educations', [EducationController::class, 'store'])->name('educations.store');
    Route::get('/educations/{contact_id}/{id}/edit', [EducationController::class, 'edit'])->name('educations.edit');
    Route::put('/educations/{id}', [EducationController::class, 'update'])->name('educations.update');
    Route::delete('/educations/{id}', [EducationController::class, 'destroy'])->name('educations.destroy');
});
