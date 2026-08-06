<?php

use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\WebController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleAndPermissionController;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

// Default route ke landing page
Route::get('/', [WebController::class, 'index']);
Route::get('/get-peserta', [WebController::class, 'getPeserta'])->name('web.getPeserta');
// Route::get('/download-sertifikat', [WebController::class, 'downloadSertifikat'])->name('download.sertifikat');
Route::get('/events/{event}/peserta/{peserta}/download-sertifikat', [WebController::class, 'downloadSertifikat'])
    ->name('sertifikat.download');

Route::middleware(['auth', 'web'])->group(function () {
    Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');
    Route::get('/profile', ProfileController::class)->name('profile');
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleAndPermissionController::class);
    Route::resource('events', EventController::class);

    Route::get('/participants/search', [ParticipantController::class, 'searchCallsign'])->name('participants.search');
    Route::post('/participants', [ParticipantController::class, 'store'])->name('participants.store');
    Route::get('/events/{event}/participants', [ParticipantController::class, 'getParticipants'])->name('events.participants');
    Route::delete('/participants/{id}', [ParticipantController::class, 'destroy'])->name('participants.destroy');
});
