<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\Category\CategoryController;
use App\Http\Controllers\Admin\Role\RolesController;
use App\Http\Controllers\Admin\User\UserController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// login page
Route::get('/', [AuthController::class, 'loginPage'])->name('login-page');
// login request
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/phpinfo', function () {
    return phpinfo();
});

Route::group(['middleware' => 'auth', 'prefix' => '/admin'], function () {
    // logout
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::view('/dashboard', 'dashboard')->name('dashboard')->middleware('module.check');
    Route::get('/welcome', [AuthController::class, 'afterLogin'])->name('afterLogin');
    //change password
    Route::get('/change-password', [AuthController::class, 'changePasswordPage'])->name('change-password');
    Route::post('/check-password', [AuthController::class, 'checkPassword']);
    Route::post('/update-password', [AuthController::class, 'updatePassword']);

    //Users
    Route::resource('users', UserController::class)->except(['index']);
    Route::get('users', [UserController::class, 'index'])->middleware('module.check');
    Route::get('/users/get/data', [UserController::class, 'getUsers']);
    Route::get('/get/roles', [UserController::class, 'getRoles']);

    //user profile
    Route::get('/user-profile', [AuthController::class, 'userProfilePage'])->name('user-profile');
    Route::post('/user-profile/update', [AuthController::class, 'userProfileUpdate']);

    //User Groups
    Route::resource('roles', RolesController::class)->except(['index']);
    Route::get('roles', [RolesController::class, 'index'])->middleware('module.check');
    Route::get('/roles/get/server/data', [RolesController::class, 'getServerData']);
    Route::get('/user-group/get/form/data', [RolesController::class, 'getFormData']);
    Route::post('/roles/update/is-active/{id}', [RolesController::class, 'updateIsActive']);
    Route::post('/roles/permissions/{groupId}', [RolesController::class, 'updateUserPermissions']);
    Route::post('/roles/permissions', [RolesController::class, 'saveUserPermissions']);

   
    Route::resource('categories', CategoryController::class)->except(['index']);
    Route::get('categories', [CategoryController::class, 'index'])->middleware('module.check');
    Route::get('/categories/get/server/data', [CategoryController::class, 'getServerData']);


});
