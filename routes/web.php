<?php

use App\Http\Controllers\Profile\AvatarController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::patch('/profile/avatar', [AvatarController::class, 'update'])->name('profile.avatar');
});

require __DIR__.'/auth.php';



Route::post('/auth/redirect', function () {
    return Socialite::driver('github')->redirect();})->name('login.github');

Route::get('/auth/callback', function () {
    $user = Socialite::driver('github')->user();
    $user = User::firstOrCreate(['email' => $user->email], [
        'name'     => $user->name,
        'password' => 'password',
    ]);

    Auth::login($user);
    return redirect('/dashboard');
});




Route::middleware('auth')->group(function () {

 Route::resource('/ticket', TicketController::class);
// Route::get('/ticket/create', TicketController::class,'create' )->name('ticket.create');

// Route::post('/ticket/create', TicketController::class,'store' )->name('ticket.store');
});
