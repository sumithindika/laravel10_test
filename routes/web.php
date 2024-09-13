<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Profile\AvatarController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use OpenAI\Laravel\Facades\OpenAI;
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
    //fatch all user
    //$users=User::all();

    //$users =DB::table('users')->first();
   // $users =DB::table('users')->where('id',1)->get();
  // $users = User::where('id',8)->first();
   // $users = User::where('id',1)->first();

//     $users =User::create([
// "name" =>"sumithssx",
// "email"=>"sumithxss@gmail.com",
// "password"=>'xpassword',


//     ]);

//  $users->update([
//  'email'=>'sumithh@gmail.com',


//  ]);
   // $users =DB::select("select * from users");
  // $users =DB::table('users')->where('id',1)->get();
   // $users =DB::select("select * from users where email=?",['sumith@gmail.com']);
  // $users =DB::insert("insert into users (name,email,password)values(?,?,?)",[
   // "sumitht",
    //"sum@gmail.com",
   // "12345678",


   //]);
//$users=User::where('id',9)->delete();
   //$users =DB::update("update users set email=? where id=?",[
 // "sumithsddd@gmail.com",
 // 2,




 //  ]);
 //$users=DB::delete("delete from users where id=2");

//  $users=DB::table('users')->insert([

// "name" =>"sumithsdf",
// "email" =>"sumjfj@gmail.com",
// "password" =>"x12345678",

//  ]);
//$users =DB::table('users')->where('id',5)->update(['email'=>"sumithddgs@gmail.com"]);
// $users=DB::table('users')->update([
//"name" =>"sumithh",
//"email"=>"summm@gmail.com",
//"password"=>"password",
//$users=DB::table('users')->where('id',5)->delete();
// $users= User::find(10);
// $users ->delete();
// ]);


// $users =DB::insert('insert into users (name ,email,password) values(?,?,?)',[
// "sumith5",
// "sum5@gmail.com",
// "password",

// ]);

// $users=DB::table('users')->insert([
//    "name"=>"sumith2",
// "email"=>"sum2@gmail.com",
// "password"=>"password",

// ]);
//  $users =User::create([
//          "name"=>"sumith6",
//         "email"=>"sum6@gmail.com",
//          "password"=>"password",

//     ]);

//    dd($users);




});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/avatar', [AvatarController::class, 'update'])->name('profile.avatar');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::post('/auth/redirect', function () {
    return Socialite::driver('github')->redirect();})->name('login.github');

Route::get('/auth/callback', function () {
    $user = Socialite::driver('github')->user();
 $user = User::firstOrCreate(['email'=>$user->email],[
'name'=>$user->name,
'password'=> 'password',

    ]);

 Auth::login($user);
 return redirect('/dashboard');
    // $user->token
});
