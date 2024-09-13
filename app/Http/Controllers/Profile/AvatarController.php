<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AvatarController extends Controller
{

public function update(Request $request){

// $request->validate([
// 'avatar'=>['required','image'],


// ]);

$path = Storage::disk('public')->put('avatars',$request->file('avatar'));
//$path= $request->file('avatar')->store('avatars',"public");

if($old_avatar =$request->user()->avatar){

Storage::disk('public') -> delete($old_avatar);


}

auth()->user()->update(['avatar'=>$path]);
//dd(auth->user());
//
 //dd($path);



   // dd($request->all());
//return 'hello';

//store image
    //return redirect(route('profile.edit'));
    //return back()->redirectTo(route('profile.edit'));

   // return back()->with('message', 'avatar changes!');
   return redirect(route('profile.edit'))->with('message','avatar store done');

}


}
