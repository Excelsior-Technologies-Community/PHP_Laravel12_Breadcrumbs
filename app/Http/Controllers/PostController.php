<?php

namespace App\Http\Controllers;

use App\Models\Post;

class PostController extends Controller
{
    // Show all posts
    public function index()
    {
        $posts = Post::with('category')->get(); // eager load category
        return view('posts.index', compact('posts'));
    }

    // Show single post
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }
}