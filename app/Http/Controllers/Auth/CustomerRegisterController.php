<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerRegisterController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name'   => ['required', 'string', 'max:255'],
            'last_name'    => ['required', 'string', 'max:255'],
            'email'        => ['required', 'email', 'unique:users,email'],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'birth_date'   => ['nullable', 'date'],
            'gender'       => ['nullable', 'in:male,female,other'],
            'password'     => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'first_name'   => $data['first_name'],
            'last_name'    => $data['last_name'],
            'email'        => $data['email'],
            'phone_number' => $data['phone_number'] ?? null,
            'birth_date'   => $data['birth_date'] ?? null,
            'gender'       => $data['gender'] ?? null,
            'password'     => Hash::make($data['password']),
        ]);

        $user->assignRole('customer');

        Auth::login($user);

        return redirect()->route('home');
    }
}