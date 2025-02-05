<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    // Constructor to ensure the user is authenticated
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Display all posts
    public function index()
    {
        $posts = Post::with('user')->get();
        return view('posts.index', compact('posts'));
    }

    // Show the create post form
    public function create()
    {
        return view('posts.create');
    }

    // Store a new post
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:3|max:255',  // Minimum 3 characters for title
            'content' => 'required|min:10',        // Minimum 10 characters for content
        ]);

        // Create a new post
        $post = new Post();
        $post->title = $request->title;
        $post->content = $request->content;
        $post->user_id = auth()->user()->id; // Associate post with logged-in user
        $post->save();

        return redirect()->route('posts.index');
    }

    // Show a single post
    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.show', compact('post'));
    }

    // Show the edit post form
    public function edit($id)
    {
        $post = Post::findOrFail($id);

        // Check if the logged-in user is the owner of the post
        if ($post->user_id != Auth::id()) {
            return redirect()->route('posts.index')->with('error', 'You do not have permission to edit this post.');
        }

        return view('posts.edit', compact('post'));
    }

    // Update a post
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        $post = Post::findOrFail($id);

        // Check if the logged-in user is the owner of the post
        if ($post->user_id != Auth::id()) {
            return redirect()->route('posts.index')->with('error', 'You do not have permission to update this post.');
        }

        $post->update([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
        ]);

        return redirect()->route('posts.index')->with('success', 'Post updated successfully!');
    }

    // Delete a post
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        // Check if the logged-in user is the owner of the post
        if ($post->user_id != Auth::id()) {
            return redirect()->route('posts.index')->with('error', 'You do not have permission to delete this post.');
        }

        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully!');
    }
}
