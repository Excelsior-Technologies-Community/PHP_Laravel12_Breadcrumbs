<!DOCTYPE html>
<html>
<head>
    <title>Posts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .suggestion-item { padding: 8px; cursor: pointer; background: #f8f9fa; border: 1px solid #ddd; }
        .suggestion-item:hover { background: #e9ecef; }
        #suggestions-box { z-index: 1000; }
    </style>
</head>
<body>

<div class="container py-5">
    <h1 class="mb-4">All Posts</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="mb-4">
        <a href="{{ route('posts.index') }}" class="btn btn-secondary btn-sm">All</a>
        @foreach($categories as $cat)
            <a href="?category_id={{ $cat->id }}" class="btn btn-primary btn-sm">{{ $cat->name }}</a>
        @endforeach
    </div>

    <form method="GET" class="mb-4 position-relative">
        <input type="text" id="search-input" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}" autocomplete="off">
        <div id="suggestions-box" class="position-absolute w-100 d-none"></div>
    </form>

    <a href="{{ route('posts.trash') }}" class="btn btn-warning mb-3">View Trash</a>

    <div class="row">
        @forelse($posts as $post)
        <div class="col-md-4 mb-3">
            <div class="card p-3">
                <h5>
                    <a href="{{ route('posts.show', $post->slug) }}">{{ $post->title }}</a>
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

    {{ $posts->links() }}
</div>

<script>
    $('#search-input').on('keyup', function() {
        let term = $(this).val();
        if(term.length >= 2) {
            $.get("{{ route('posts.suggestions') }}", { term: term }, function(data) {
                let html = '';
                data.forEach(item => { html += `<div class="suggestion-item">${item}</div>`; });
                $('#suggestions-box').html(html).removeClass('d-none');
            });
        } else { $('#suggestions-box').addClass('d-none'); }
    });

    $('#search-input').on('blur', function() {
        let val = $(this).val();
        if(val) {
            let history = JSON.parse(localStorage.getItem('searchHistory') || '[]');
            if(!history.includes(val)) {
                history.unshift(val);
                localStorage.setItem('searchHistory', JSON.stringify(history.slice(0, 5)));
            }
        }
    });

    $(document).on('click', '.suggestion-item', function() {
        $('#search-input').val($(this).text());
        $('#suggestions-box').addClass('d-none');
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>