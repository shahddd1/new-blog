@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $post->title }}</h1>
        <p>By {{ $post->user->name }} | {{ $post->created_at->diffForHumans() }}</p>
        <p>{{ $post->content }}</p>

        <!-- Edit and Delete buttons, only visible if the user is the post owner -->
        @if ($post->user_id == auth()->user()->id)
            <div class="mt-3">
                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning">Edit Post</a>

                <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this post?')">Delete Post</button>
                </form>
            </div>
        @endif

        <a href="{{ route('posts.index') }}" class="btn btn-secondary mt-3">Back to Posts</a>
    </div>
@endsection

