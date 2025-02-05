@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>All Posts</h1>

        <!-- Button to create a new post -->
        <a href="{{ route('posts.create') }}" class="btn btn-primary mb-3">Create New Post</a>

        <!-- Displaying posts -->
        @foreach ($posts as $post)
            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">{{ $post->title }}</h5>
                    <p class="card-text">{{ Str::limit($post->content, 100) }}</p>
                    <a href="{{ route('posts.show', $post->id) }}" class="btn btn-info">Read More</a>

                    <!-- Edit and Delete buttons, only visible if the user is the post owner -->
                    @if ($post->user_id == auth()->user()->id)
                        <div class="mt-2">
                            <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning btn-sm">Edit</a>

                            <!-- Delete Form -->
                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endsection


