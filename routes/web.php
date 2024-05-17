<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

use App\Http\Controllers\CasesController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FilecasesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', [FilecasesController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
Route::post('/create-case', [CasesController::class, 'store'])->name('store.case');
Route::get('/case', [CasesController::class, 'createCase'])->name('case');
Route::get('/folders', [FilecasesController::class, 'viewFolders'])->name('folders');
Route::post('/file/store', [FilecasesController::class, 'store'])->name('file.store');
Route::delete('/file/{id}', [FilecasesController::class, 'destroy'])->name('file.destroy');
Route::get('/users', [FilecasesController::class, 'manageUsers'])->name('manage.users');
Route::get('/cases/{caseId}/folders/{folderId}/pdf', [FilecasesController::class, 'viewPDF'])->name('folder.viewPDF');
Route::get('/case/{id}/edit', [CasesController::class, 'edit'])->name('case.edit');
Route::post('/case/{id}/update', [CasesController::class, 'update'])->name('case.update');
Route::get('/case/{id}/folders', [CasesController::class, 'showFolders'])->name('case.folders');
Route::get('/cases/{case}/folders/{folder}', [FolderController::class, 'viewFolderFileCases'])->name('case.folderFiles');
Route::post('/folders', [FolderController::class, 'storeFolder'])->name('folder.store');
Route::delete('/cases/{case}/folders/{folder}', [FolderController::class, 'destroy'])->name('folder.destroy');
Route::put('/folders/{folder}', [FolderController::class, 'update'])->name('folder.update');
Route::post('/items', [UserController::class, 'store'])->name('user.store');












// Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {

// });

// Route::middleware(['auth', 'role:assistant'])->name('assistant.')->prefix('assistant')->group(function () {

// });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
