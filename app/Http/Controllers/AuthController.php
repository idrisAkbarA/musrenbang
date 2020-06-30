<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Kelurahan;
use App\User;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    public function login(Request $request){
        $credentials = $request->only('name', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            $user = $request->name;
            if($user == 'admin'){
                session(['user' => "Administrator"]);
                return redirect()->intended('musrenbang-admin');
            }else{
                $_user = Auth::user()->id_kel;
                $kelurahan = Kelurahan::find($_user);
                session(['user' => $kelurahan->nama]);
                // session(['test' => $_user]);
                return redirect()->intended('/');
            }
        }
        return redirect()->intended('/login');
    }
    public function logout(){
        Auth::logout();
        return redirect('login');
    }
    public function changePass(Request $request){
        $user = User::find(Auth::id());
        if(!Hash::check($request->input("old"), $user->password)){
            return response()->json(["status"=>"invalid old password","detail"=>$request['old']]);
        }
        $newPass = Hash::make($request->input("new"));
        $user->password = $newPass;
        $user->save();
        return response()->json(["status"=>"ok"]);
    }
}
