<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $category->name }} - Laravel Breadcrumbs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f7fa;
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
            {{ Breadcrumbs::render('categories.show', $category) }}
        </nav>

        {{-- Category Header --}}
        <h1 class="mb-4 text-center">{{ $category->name }}</h1>

        {{-- Posts in Category --}}
        <div class="row g-4">
            @foreach($category->posts as $post)
            <div class="col-md-6 col-lg-4">
                <div class="card p-3">
                    <h5 class="card-title">
                        <a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a>
                    </h5>
                    <p class="text-muted">{{ Str::limit($post->content, 80) }}</p>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-4 text-center">
            <a href="{{ route('categories.index') }}" class="btn btn-outline-primary">Back to Categories</a>
        </div>
    </div>
</body>

</html>