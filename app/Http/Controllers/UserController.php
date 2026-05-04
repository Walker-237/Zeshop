<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = [
            ["id"=>1 ,"name"=>"Siapi","email"=>"siapi@gmail.com", "role"=>"Mature" ],
            ["id"=>2 ,"name"=>"Jordan","email"=>"Jordan@gmail.com", "role"=>"Serious" ],
            ["id"=>3 ,"name"=>"Ghorane","email"=>"Ghorane@gmail.com", "role"=> "Responsible" ],
            ["id"=>4 ,"name"=>"Bachirou","email"=>"Bachirou@gmail.com", "role"=>"Kind" ],
            ["id"=>5 ,"name"=>"Metomo","email"=>"Metomo@gmail.com","role"=>"Hardware Maintainer" ]
        ];

        return view("user",compact("users"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $user = USER::create([
        //     'name' => $request->name,
        //     'email'=> $request->email,
        //     'tel'=> $request->tel,
        //     'password'=> $request->password,
        // ]);
        // return view("login");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
