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

    //this routes can access bu assistant
    Route::middleware(['auth', 'role:assistant'])->group(function () {
        Route::post('/create-case', [CasesController::class, 'store'])->name('store.case');

        Route::post('/folders', [FolderController::class, 'storeFolder'])->name('folder.store');

        Route::get('/folders', [FilecasesController::class, 'viewFolders'])->name('folders');

        Route::get('/case', [CasesController::class, 'createCase'])->name('case');

        Route::get('/cases/{caseId}/folders/{folderId}/pdf', [FilecasesController::class, 'viewPDF'])->name('folder.viewPDF');

        Route::get('case/folders/{id}', [CasesController::class, 'showFolders'])->name('case.folders');

        Route::get('/cases/{case}/folders/{folder}', [FolderController::class, 'viewFolderFileCases'])->name('case.folderFiles');
       
        Route::get('/all-folders', [FolderController::class, 'index'])->name('folders.index');

        Route::get('/filter-folders', [FolderController::class, 'filter'])->name('folders.filter');
    });



    // Routes restricted to admin only
    Route::middleware(['auth', 'role:admin'])->group(function () {
       

        Route::post('/file/store', [FilecasesController::class, 'store'])->name('file.store');

        Route::delete('/file/{id}', [FilecasesController::class, 'destroy'])->name('file.destroy');

        Route::get('/users', [  UserController::class, 'manageUsers'])->name('manage.users');

        Route::get('/case/{id}/edit', [CasesController::class, 'edit'])->name('case.edit');

        Route::post('/case/{id}/update', [CasesController::class, 'update'])->name('case.update');

        

        Route::delete('/cases/{case}/folders/{folder}', [FolderController::class, 'destroy'])->name('folder.destroy');

        Route::put('/folders/{folder}', [FolderController::class, 'update'])->name('folder.update');

        Route::post('/users', [UserController::class, 'store'])->name('user.store');

        Route::delete('/users/{userId}/delete-roles', [UserController::class, 'deleteRoles'])->name('user.deleteRoles');

        Route::post('/users/{id}/reset-password', [UserController::class, 'resetPassword'])->name('user.resetPassword');

    });



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
