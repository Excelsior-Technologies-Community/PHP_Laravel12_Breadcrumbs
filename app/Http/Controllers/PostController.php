<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with('category');

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $posts = $query->latest()->paginate(4);
        $categories = Category::all();

        return view('posts.index', compact('posts', 'categories'));
    }

    public function getSuggestions(Request $request)
    {
        $term = $request->get('term');
        return Post::where('title', 'like', '%' . $term . '%')
                   ->limit(5)
                   ->pluck('title');
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        return view('posts.show', compact('post'));
    }

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