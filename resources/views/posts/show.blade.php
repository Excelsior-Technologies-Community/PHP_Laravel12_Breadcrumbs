<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->title }} - Laravel Breadcrumbs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f3f4f6;
        }

        .breadcrumb-item+.breadcrumb-item::before {
            content: "›";
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

        {{-- Breadcrumbs --}}
        <nav aria-label="breadcrumb">
            {{ Breadcrumbs::render('posts.show', $post) }}
        </nav>

        {{-- Post Card --}}
        <div class="card p-4 mx-auto" style="max-width: 700px;">
            <h1 class="card-title mb-3">{{ $post->title }}</h1>
            <p class="card-text mb-3">{{ $post->content }}</p>
            <a href="{{ route('categories.show', $post->category->id) }}" class="btn btn-outline-primary">Back to Category</a>
        </div>

    </div>
</body>

</html>