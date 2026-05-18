<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthController extends Controller{

     public function store(Request $request){
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'tel' => 'nullable|string|max:255|unique:users,tel',
            'password' => 'required|min:6',
        ]);

        User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'tel' => $validated['tel'] ?? null,
            'gender' => 'male',
            'password' => Hash::make($validated['password']),
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
