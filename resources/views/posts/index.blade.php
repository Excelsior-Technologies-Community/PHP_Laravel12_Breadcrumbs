<!DOCTYPE html>
<html>
<head>
    <title>Posts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container py-5">

    <h1 class="mb-4">All Posts</h1>

    <!-- FLASH MESSAGE -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- SEARCH -->
    <form method="GET" class="mb-4 d-flex">
        <input type="text" name="search" class="form-control me-2" placeholder="Search..." value="{{ request('search') }}">
        <button class="btn btn-primary">Search</button>
    </form>

    <a href="{{ route('posts.trash') }}" class="btn btn-warning mb-3">View Trash</a>

    <div class="row">
        @forelse($posts as $post)
        <div class="col-md-4 mb-3">
            <div class="card p-3">
                <h5>
                    <a href="{{ route('posts.show', $post->slug) }}">
                        {{ $post->title }}
                    </a>
                </h5>

                <p>{{ Str::limit($post->content, 80) }}</p>

                <small>Category: {{ $post->category->name ?? 'N/A' }}</small>

                <form action="{{ route('posts.delete', $post->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm mt-2">Delete</button>
                </form>
            </div>
        </div>
        @empty
            <p class="text-center">No posts found.</p>
        @endforelse
    </div>

    <!-- PAGINATION -->
    {{ $posts->links() }}

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>