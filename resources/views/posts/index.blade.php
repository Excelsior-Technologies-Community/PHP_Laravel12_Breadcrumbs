<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Posts - Laravel Breadcrumbs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f9fafd;
        }

        .card {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        a {
            text-decoration: none;
            color: #0d6efd;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <h1 class="mb-4 text-center">All Posts</h1>

        <div class="row g-4">
            @foreach($posts as $post)
            <div class="col-md-6 col-lg-4">
                <div class="card p-3">
                    <h5 class="card-title">
                        <a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a>
                    </h5>
                    <p class="text-muted">{{ Str::limit($post->content, 80) }}</p>
                    <p class="mb-0"><small>Category: <a href="{{ route('categories.show', $post->category->id) }}">{{ $post->category->name }}</a></small></p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</body>

</html>