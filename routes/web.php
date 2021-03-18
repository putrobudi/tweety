<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TweetController;
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
    Route::get('/tweets', [TweetController::class, 'index'])->name('home');
    Route::post('/tweets', [TweetController::class, 'store']);
});

Auth::routes();

