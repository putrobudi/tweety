<?php

// quickly listen to any database queries, bindings, and dumps them.
// DB::listen(function ($query) { var_dump($query->sql, $query->bindings); });

use App\Http\Controllers\ProfilesController;
use App\Http\Controllers\TweetsController;
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
// auth()->loginUsingId(1);
Route::get('/', function () {
    return view('welcome');
});

// Go to LoginController to update $redirectTo after login
// Group the route with middleware auth. Of course you can also do that in controller in the constructor.
Route::middleware('auth')->group(function () {
    Route::get('/tweets', [TweetsController::class, 'index'])->name('home');
    Route::post('/tweets', [TweetsController::class, 'store']);
});

Route::get('/profiles/{user}', [ProfilesController::class, 'show'])->name('profile');

Auth::routes();

