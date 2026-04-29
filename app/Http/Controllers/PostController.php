<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // LIST + SEARCH + PAGINATION
    public function index(Request $request)
    {
        $query = Post::with('category');

        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $posts = $query->latest()->paginate(4);

        return view('posts.index', compact('posts'));
    }

    // SHOW BY SLUG
    public function show($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        return view('posts.show', compact('post'));
    }


    // TRASH LIST
    public function trash()
    {
        $posts = Post::onlyTrashed()->get();
        return view('posts.trash', compact('posts'));
    }

    public function destroy($id)
    {
        Post::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Post moved to trash successfully!');
    }

    public function restore($id)
    {
        Post::onlyTrashed()->findOrFail($id)->restore();
        return redirect()->back()->with('success', 'Post restored successfully!');
    }

    public function forceDelete($id)
    {
        Post::onlyTrashed()->findOrFail($id)->forceDelete();
        return redirect()->back()->with('success', 'Post deleted permanently!');
    }
}