<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Categories - Laravel Breadcrumbs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f9fafd; }
        .card { border-radius: 12px; transition: 0.3s; }
        .card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
    </style>
</head>
<body>
    <div class="container py-5">
        <nav aria-label="breadcrumb" class="mb-4">
            {{ Breadcrumbs::render('categories.index') }}
        </nav>

        <h1 class="mb-4 text-center">Categories</h1>

        <div class="row g-4">
            @foreach($categories as $category)
            <div class="col-md-6 col-lg-4">
                <div class="card p-4 border-0 shadow-sm">
                    <h5 class="card-title">
                        <a href="{{ route('categories.show', $category->id) }}" class="text-dark">
                            {{ $category->name }}
                        </a>
                    </h5>
                    <p class="text-muted small">{{ $category->posts_count }} Posts</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</body>
</html>