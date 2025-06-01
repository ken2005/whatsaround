<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EvenementController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UtilisateurController;

/*Route::get('/', function () {
    return view('welcome');
})->name('accueil');*/
Route::get('/', [HomeController::class, 'index'])->name('accueil');


Route::get('/consultest', function () {
    return view('evenement.consulter');
});

Route::get('/invitest', function () {
    return view('evenement.inviter');
});

Route::get('/creer', [EvenementController::class, 'creer'])->name('creer');
Route::post('/docreer', [EvenementController::class, 'doCreer'])->name('doCreer');
Route::get('/evenement/{id}', [EvenementController::class, 'consulter'])->name('evenement');
Route::post('/evenement/{id}/sinscrire', [EvenementController::class, 'sInscrire'])->name('sInscrire');
Route::post('/evenement/{id}/enregistrer', [EvenementController::class, 'enregistrer'])->name('enregistrer');
Route::get('/evenements/enregistres', [EvenementController::class, 'enregistres'])->name('evenements.enregistres');
Route::get('/evenements/inscriptions', [EvenementController::class, 'inscriptions'])->name('evenements.inscriptions');
Route::post('/evenement/{id}/desenregistrer', [EvenementController::class, 'desenregistrer'])->name('desenregistrer');
Route::post('/evenement/{id}/sedesinscrire', [EvenementController::class, 'seDesinscrire'])->name('seDesinscrire');
Route::get('/rechercher', [EvenementController::class, 'rechercher'])->name('recherche');
Route::delete('/evenement/{id}', [EvenementController::class, 'supprimer'])->name('evenement.supprimer');
Route::get('/evenements/crees', [EvenementController::class, 'crees'])->name('evenements.crees');
Route::get('/evenement/{id}/inviter', [EvenementController::class, 'inviter'])->name('evenement.inviter');
Route::post('/evenement/{id}/inviter', [EvenementController::class, 'doInviter'])->name('evenement.doInviter');
Route::get('/evenement/{id}/participants', [EvenementController::class, 'participants'])->name('evenement.participants');


Route::get('/connexion', function () {
    return view('auth.login');
})->name('connexion');

Route::get('/inscription', function () {
    return view('auth.signup');
})->name('inscription');


Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/profil/{id}', [UtilisateurController::class, 'profil'])->name('profil');
Route::post('/suivre/{id}', [UtilisateurController::class, 'suivre'])->name('suivre');
Route::post('/sedesabonner/{id}', [UtilisateurController::class, 'seDesabonner'])->name('seDesabonner');
Route::get('/abonnements', [UtilisateurController::class, 'abonnements'])->name('abonnements');
Route::get('/demandes', [UtilisateurController::class, 'demandes'])->name('demandes');
Route::post('/demande/{id}/accepter', [UtilisateurController::class, 'accepterDemande'])->name('demandes.accepter');
Route::post('/demande/{id}/refuser', [UtilisateurController::class, 'refuserDemande'])->name('demandes.refuser');
Route::post('/profil/{id}/prive', [UtilisateurController::class, 'passerPrive'])->name('passerPrive');
Route::post('/profil/{id}/public', [UtilisateurController::class, 'passerPublic'])->name('passerPublic');
