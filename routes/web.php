<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::redirect('/', '/login');
// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';

Route::middleware('auth')->group(function () {
    Route::view('about', 'about')->name('about');
    Route::post('/token/{token}', [\App\Http\Controllers\UserController::class, 'updateToken'])->name('user.update');

    Route::get('dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::get('dashboard/{id}', [\App\Http\Controllers\DashboardController::class, 'show'])->name('dashboard.show');

    Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    Route::get('users/listusers', [\App\Http\Controllers\UserController::class, 'listusers'])->name('users.listusers');

    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

    Route::get('rooms', [\App\Http\Controllers\RoomController::class, 'index'])->name('rooms.index');

    Route::post('/devicetoken', function (Request $request) {
        try {
            $request->validate([
                'token' => 'required|string',
                'userId' => 'required|string'
            ]);
            //Saves Device Token to DB
            $user = User::where('id', $request->userId)->first();
            if ($user->device_tokens == null) {
                $user->device_tokens = $request->device_token;
                $user->save();
            } else if ($user->device_tokens !== $request->device_token) {
                $user->device_tokens = $request->device_token;
                $user->update();
            }
            return response($user);
        } catch (Exception $e) {
            return response($e);
        }
    })->name('store.token');
});
