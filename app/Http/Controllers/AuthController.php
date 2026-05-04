<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller{

     public function store(Request $request){
        $request->validate([
            // 'name'=>'required|string|max:255',
            // 'email'=>'required|email',
            // 'tel'=>'required',
            // 'password'=>'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email'=> $request->email,
            'tel'=> $request->tel,
            'password'=> bcrypt($request->password),
        ]);

        return redirect('/login');
    }

    public function login(Request $request){
        $request->validate([
            'email'=>'required|email',
            'password'=>'required',
        ]);

        if (Auth::attempt(['email'=>$request->email,'password'=>$request->password])) {
            return redirect('/home');
        }

        return back()->withErrors([
            'email' => 'These credentials do not match our records .'
        ]);
        
    }
}