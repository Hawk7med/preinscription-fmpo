<?php

use App\Http\Controllers\CandidatController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes publiques (sans authentification)
|--------------------------------------------------------------------------
*/

// Page d'accueil - inscription des candidats
Route::get('/', function () {
    $active = 'home';
    return view('home', compact('active'));
})->name('candidats.inscription');

// Routes publiques des candidats
Route::get('/candidats/recu/{id}', [CandidatController::class, 'recu'])->name('candidats.recu');
Route::get('/candidats/single/{id}', [CandidatController::class, 'single'])->name('candidats.single');
Route::post('/candidats/add', [CandidatController::class, 'add'])->name('candidats.add');

// Page de pré-inscription
Route::get('/preregistration', [CandidatController::class, 'preregistration'])->name('preregistration');
Route::get('/confirme_preregistration', [CandidatController::class, 'confirme_preregistration'])->name('confirme_preregistration');
Route::post('/confirmed_preregistration', [CandidatController::class, 'confirmed_preregistration'])->name('confirmed_preregistration');

// Page de succès
Route::get('/candidats/success/{id}', function () {
    return view('success');
})->name('candidats.success');

/*
|--------------------------------------------------------------------------
| Routes d'authentification
|--------------------------------------------------------------------------
*/

// Routes pour les invités (non connectés)
Route::middleware('guest')->group(function () {
    // Page de connexion admin (votre ancienne route /admin)
    Route::get('/admin', [AuthController::class, 'showLoginForm'])->name('login');
    Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.process');
    
    // Routes d'inscription (si vous voulez permettre l'inscription)
    Route::get('/admin/register', [AuthController::class, 'showRegisterForm'])->name('admin.register');
    Route::post('/admin/register', [AuthController::class, 'register'])->name('admin.register.process');
});

// Route de déconnexion
Route::post('/admin/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('admin.logout');

/*
|--------------------------------------------------------------------------
| Routes protégées par authentification
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    
    // Routes pour les administrateurs uniquement
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [CandidatController::class, 'show'])->name('dashboard');
        
        // Gestion des candidats (accessible uniquement aux admins)
        Route::get('/candidats', [CandidatController::class, 'show'])->name('candidats.list');
        Route::get('/candidats/{id}', [CandidatController::class, 'single'])->name('candidats.show');
        
        // Routes additionnelles pour la gestion des candidats
        Route::post('/candidats/edit/{id}', [CandidatController::class, 'edit'])->name('candidats.edit');
        Route::put('/candidats/{id}', [CandidatController::class, 'update'])->name('candidats.update');
        Route::delete('/candidats/{id}', [CandidatController::class, 'destroy'])->name('candidats.delete');
        Route::post('/candidats/export', [CandidatController::class, 'exportExcel'])->name('candidats.export');
        Route::get('/candidats/export/stats', [CandidatController::class, 'getExportStats'])->name('candidats.export.stats');
        
        // Routes pour tous les utilisateurs connectés
        Route::prefix('user')->name('user.')->group(function () {
            Route::get('/dashboard', [AuthController::class, 'userDashboard'])->name('dashboard');
            Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
            Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
        });
        
        // Gestion des utilisateurs
        Route::get('/users', [AuthController::class, 'manageUsers'])->name('users.list');
        Route::get('/users/{id}/edit', [AuthController::class, 'editUser'])->name('users.edit');
        Route::put('/users/{id}', [AuthController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{id}', [AuthController::class, 'deleteUser'])->name('users.delete');
        
        // Statistiques
        Route::get('/stats', [CandidatController::class, 'stats'])->name('stats');
    });
});

/*
|--------------------------------------------------------------------------
| Routes de compatibilité (pour votre HTML existant)
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Routes API (optionnel)
|--------------------------------------------------------------------------
*/

// Si vous avez besoin d'API pour l'administration
Route::prefix('api')->middleware('auth:sanctum')->group(function () {
    Route::get('/candidats/count', [CandidatController::class, 'getCount']);
    Route::get('/candidats/stats', [CandidatController::class, 'getStats']);
    Route::get('/users/online', [AuthController::class, 'getOnlineUsers']);
});