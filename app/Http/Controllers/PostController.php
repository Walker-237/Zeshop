<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with(['user','likes','comments'])
                    ->latest()
                    ->WithCount(['comments','likes'])
                    ->get();

        return view('home', compact('posts'));
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
        $request->validate([
            'image'=>'nullable|image|max:2048',
            'content'=>'required|string',
            'title'=>'required|string|max:255',
            'category'=>'required|string|max:255',
        ]);

        $imagepath = null;
        if($request->hasFile('image')){
            $imagepath = $request->file('image')->store('post', 'public');
        }

        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'image' => $imagepath,
            'category' => $request->category,
            'user_id' => auth()->id(),
            'is_published' => true,
        ]);

        return redirect('/home');
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
