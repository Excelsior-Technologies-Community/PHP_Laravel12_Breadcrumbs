<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories - Laravel Breadcrumbs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f9fafd;
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
            {{ Breadcrumbs::render('categories.index') }}
        </nav>

        {{-- Header --}}
        <h1 class="mb-4 text-center">Categories</h1>

        {{-- Categories List --}}
        <div class="row g-4">
            @foreach($categories as $category)
            <div class="col-md-6 col-lg-4">
                <div class="card p-3">
                    <h5 class="card-title">
                        <a href="{{ route('categories.show', $category->id) }}">{{ $category->name }}</a>
                    </h5>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</body>

</html>