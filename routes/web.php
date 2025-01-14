<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\User\UserController;
use App\Http\Controllers\Admin\UserGroup\UserGroupsController;
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
Route::get('/phpinfo', function(){
    return phpinfo();
});

Route::group(['middleware' => 'auth','prefix' => '/admin' ], function(){
    // logout
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::view('/dashboard', 'dashboard')->name('dashboard')->middleware('module.check');
    Route::get('/welcome', [AuthController::class, 'afterLogin'])->name('afterLogin');
    //change password
    Route::get('/change-password', [AuthController::class, 'changePasswordPage'])->name('change-password')->middleware('module.check');
    Route::post('/check-password', [AuthController::class, 'checkPassword']);
    Route::post('/update-password', [AuthController::class, 'updatePassword']);

    //Users
    Route::resource('users', UserController::class)->except(['index']);
    Route::get('users', [UserController::class, 'index'])->middleware('module.check');
    Route::get('/users/get/data', [UserController::class, 'getUsers']);
    Route::get('/get/user-groups', [UserController::class, 'getUserGroups']);

     //user profile
    Route::get('/user-profile', [AuthController::class, 'userProfilePage'])->name('user-profile');
    Route::post('/user-profile/update', [AuthController::class, 'userProfileUpdate']);

    //User Groups
    Route::resource('user-groups', UserGroupsController::class)->except(['index']);
    Route::get('user-groups', [UserGroupsController::class, 'index'])->middleware('module.check');
    Route::get('/user-groups/get/server/data', [UserGroupsController::class, 'getServerData']);
    Route::get('/user-group/get/form/data', [UserGroupsController::class, 'getFormData']);
    Route::post('/user-groups/update/is-active/{id}', [UserGroupsController::class, 'updateIsActive']);
    Route::post('/user-groups/permissions/{groupId}', [UserGroupsController::class, 'updateUserPermissions']);
    Route::post('/user-groups/permissions', [UserGroupsController::class, 'saveUserPermissions']);


});
