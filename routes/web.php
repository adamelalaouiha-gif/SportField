<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SuperAdminController;

// ─── Routes publiques ──────────────────────────────────────────────────────────
Route::get('/', [PublicController::class, 'accueil'])->name('accueil');
Route::get('/clubs', [PublicController::class, 'clubs'])->name('clubs.index');
Route::get('/clubs/{id}', [PublicController::class, 'clubShow'])->name('clubs.show');
Route::get('/apropos', [PublicController::class, 'apropos'])->name('apropos');
Route::get('/contact', [PublicController::class, 'contact'])->name('contact');
Route::get('/demande-club', [PublicController::class, 'demandeForm'])->name('visiteur.demande');
Route::post('/demande-club', [PublicController::class, 'demandePost'])->name('visiteur.demande.post');

// ─── Authentification ──────────────────────────────────────────────────────────
Route::get('/connexion', [AuthController::class, 'loginForm'])->name('login');
Route::post('/connexion', [AuthController::class, 'login'])->name('login.post');
Route::get('/inscription', [AuthController::class, 'registerForm'])->name('register');
Route::post('/inscription', [AuthController::class, 'register'])->name('register.post');
Route::post('/deconnexion', [AuthController::class, 'logout'])->name('logout');

// ─── Vérification Email ────────────────────────────────────────────────────────
Route::get('/verification', [AuthController::class, 'verificationNotice'])->name('verification.notice');
Route::post('/verification', [AuthController::class, 'verifyEmail'])->name('verification.verify');
Route::post('/verification/renvoyer', [AuthController::class, 'resendVerificationCode'])->name('verification.resend');

// ─── Mot de passe oublié ───────────────────────────────────────────────────────
Route::get('/mot-de-passe-oublie', [AuthController::class, 'forgotPasswordForm'])->name('password.forgot');
Route::post('/mot-de-passe-oublie', [AuthController::class, 'forgotPasswordSend'])->name('password.forgot.send');
Route::get('/reinitialiser-mot-de-passe', [AuthController::class, 'resetPasswordForm'])->name('password.reset.form');
Route::post('/reinitialiser-mot-de-passe', [AuthController::class, 'resetPassword'])->name('password.reset');

// ─── Espace Client ─────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:client'])->prefix('client')->name('client.')->group(function () {
    Route::get('/', [ClientController::class, 'accueil'])->name('accueil');
    Route::get('/reservations', [ClientController::class, 'reservations'])->name('reservations');
    Route::get('/reserver/{id}', [ClientController::class, 'reserverForm'])->name('reserver');
    Route::post('/reserver/{id}', [ClientController::class, 'reserverPost'])->name('reserver.post');
    Route::patch('/reservation/{id}/annuler', [ClientController::class, 'annulerReservation'])->name('reservation.annuler');
    Route::get('/profil', [ClientController::class, 'profil'])->name('profil');
    Route::put('/profil', [ClientController::class, 'profilUpdate'])->name('profil.update');
});

// ─── Espace Admin Club ─────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'accueil'])->name('accueil');
    Route::get('/terrains', [AdminController::class, 'terrains'])->name('terrains');
    Route::get('/terrains/create', [AdminController::class, 'terrainCreate'])->name('terrains.create');
    Route::post('/terrains', [AdminController::class, 'terrainStore'])->name('terrains.store');
    Route::get('/terrains/{id}/edit', [AdminController::class, 'terrainEdit'])->name('terrains.edit');
    Route::put('/terrains/{id}', [AdminController::class, 'terrainUpdate'])->name('terrains.update');
    Route::delete('/terrains/{id}', [AdminController::class, 'terrainDelete'])->name('terrains.delete');
    Route::get('/reservations', [AdminController::class, 'reservations'])->name('reservations');
    Route::patch('/reservations/{id}/statut', [AdminController::class, 'updateStatutReservation'])->name('reservation.statut');
    Route::get('/profil', [AdminController::class, 'profil'])->name('profil');
    Route::put('/profil', [AdminController::class, 'profilUpdate'])->name('profil.update');
});

// ─── Espace Super Admin ────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:super_admin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/', [SuperAdminController::class, 'accueil'])->name('accueil');
    Route::get('/demandes', [SuperAdminController::class, 'demandes'])->name('demandes');
    Route::get('/demandes/{id}', [SuperAdminController::class, 'demandeShow'])->name('demande.show');
    Route::patch('/demandes/{id}/approuver', [SuperAdminController::class, 'approuverDemande'])->name('demande.approuver');
    Route::patch('/demandes/{id}/rejeter', [SuperAdminController::class, 'rejeterDemande'])->name('demande.rejeter');
    Route::get('/clubs', [SuperAdminController::class, 'clubs'])->name('clubs');
    Route::delete('/clubs/{id}', [SuperAdminController::class, 'deleteClub'])->name('club.delete');
    Route::get('/utilisateurs', [SuperAdminController::class, 'utilisateurs'])->name('utilisateurs');
    Route::delete('/utilisateurs/{id}', [SuperAdminController::class, 'deleteUtilisateur'])->name('utilisateur.delete');
    Route::get('/reservations', [SuperAdminController::class, 'reservations'])->name('reservations');
});
