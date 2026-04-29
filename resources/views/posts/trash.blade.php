<!DOCTYPE html>
<html>

<head>
    <title>Trash</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Style -->
    <style>
        body {
            background: #f8f9fa;
        }

        .trash-card {
            border-radius: 12px;
            transition: 0.3s;
        }

        .trash-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        }

        .title {
            font-weight: 600;
        }

        .actions button,
        .actions a {
            min-width: 110px;
        }
    </style>
</head>

<body>

    <div class="container py-5">

        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-danger">🗑 Trash Posts</h2>

            <a href="{{ route('posts.index') }}" class="btn btn-outline-primary">
                ← Back to Posts
            </a>
        </div>

        <!-- FLASH MESSAGE -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- POSTS -->
        <div class="row">
            @forelse($posts as $post)
                <div class="col-md-6 mb-3">

                    <div class="card trash-card p-3">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>
                                <h5 class="title mb-1">{{ $post->title }}</h5>
                                <small class="text-muted">Deleted item</small>
                            </div>

                            <div class="actions d-flex gap-2">

                                <!-- RESTORE -->
                                <a href="{{ route('posts.restore', $post->id) }}" class="btn btn-success btn-sm">
                                    ♻ Restore
                                </a>

                                <!-- DELETE -->
                                <a href="{{ route('posts.forceDelete', $post->id) }}" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to delete permanently?')">
                                    ❌ Delete
                                </a>

                            </div>

                        </div>

                    </div>

                </div>
            @empty
                <div class="text-center mt-5">
                    <h5 class="text-muted">No trashed posts found 🧹</h5>
                </div>
            @endforelse
        </div>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>