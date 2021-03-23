<?php

// quickly listen to any database queries, bindings, and dumps them.
// DB::listen(function ($query) { var_dump($query->sql, $query->bindings); });

use App\Http\Controllers\ExploreController;
use App\Http\Controllers\FollowsController;
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
    Route::post('/profiles/{user:username}/follow', [FollowsController::class, 'store'])->name('follow');
    Route::get('/profiles/{user:username}/edit', [ProfilesController::class, 'edit'])->middleware('can:edit,user');

    // You can wrap this middleware within a group with the one edit above.
    Route::patch('/profiles/{user:username}', [ProfilesController::class, 'update'])->middleware('can:edit,user');
    
    Route::get('/explore', [ExploreController::class, 'index']);
});



// Because we are explicitly telling Laravel to use name as route key, in your blade you'll need to 
// be specific. For instance in _tweet.blade.php -> $tweet->user->name. You can't just write $tweet->user.
// You need to define getRouteKeyName for that. Well I think this is not the case anymore with Laravel 8.
// So, $tweet->user is okay. Or in old way, you'd declare $tweet->user->name in User method like path().
// So return route('profile', $this->name);
Route::get('/profiles/{user:username}', [ProfilesController::class, 'show'])->name('profile');

Auth::routes();

