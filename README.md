# PHP_Laravel12_Breadcrumbs

## Project Introduction

PHP_Laravel12_Breadcrumbs is a Laravel 12 project demonstrating dynamic and hierarchical breadcrumbs using the diglactic/laravel-breadcrumbs package. The project showcases how to implement breadcrumbs for navigation through Home, Categories, and Posts, including dynamic breadcrumbs using route parameters and integration into Blade views.

---

## Project Overview

This project includes:

- Laravel 12 setup with MySQL/PostgreSQL database

- Models & Relationships: Category (hasMany Posts) and Post (belongsTo Category)

- Dynamic Breadcrumbs using diglactic/laravel-breadcrumbs

- Controllers for Categories and Posts

- Routes for listing and showing Categories & Posts

- Blade Views with Bootstrap for clean, modern UI

- Seeders for demo data (optional)

- Fully functional CRUD display for Categories and Posts

---

## Key Features

- Dynamic breadcrumbs updated based on the current route and parameters.

- Hierarchical structure: Home → Categories → Category → Post.

- Eager loading of relationships for optimized performance.

- Modern UI with Bootstrap 5 and card-style layouts.

- Clean and modular project structure with controllers, models, views, and routes well-organized.

--- 

## Step 1: Install Laravel 12 Project

Open your terminal and run:

```bash
composer create-project laravel/laravel PHP_Laravel12_Breadcrumbs "12.*"
cd PHP_Laravel12_Breadcrumbs
```

This will create a new Laravel 12 project in a folder called PHP_Laravel12_Breadcrumbs and start the local development server.

---

## Step 2: Install Laravel Breadcrumbs Package

We will use the diglactic/laravel-breadcrumbs package:

```bash
composer require diglactic/laravel-breadcrumbs
```

Publish the config file (optional, if you want to customize settings):

```bash
php artisan vendor:publish --provider="Diglactic\Breadcrumbs\ServiceProvider"
```

---

## Step 3: Create Database

Update your .env file to connect to your database:

```.env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel12_breadcrumbs
DB_USERNAME=root
DB_PASSWORD=
```

Create the database laravel12_breadcrumbs in your MySQL/PostgreSQL server.

or

run migration command:

```bash
php artisan migrate
```

---

## Step 4: Create Models and Migrations

We will create Category and Post models:

```bash
php artisan make:model Category -m
php artisan make:model Post -m
```

### Migration for Categories (database/migrations/xxxx_create_categories_table.php):

```php
public function up(): void
{
    Schema::create('categories', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->timestamps();
    });
}
```

### Migration for Posts (database/migrations/xxxx_create_posts_table.php):

```php
public function up(): void
{
    Schema::create('posts', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->text('content');
        $table->foreignId('category_id')->constrained()->onDelete('cascade');
        $table->timestamps();
    });
}
```

Run migrations:

```bash
php artisan migrate
```

### Category.php Model

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // Add this
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
```

### Post.php Model

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'category_id'];

    // Add this
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
```

---

## Step 5: Create Seeders (Optional Demo Data)

```bash
php artisan make:seeder CategorySeeder
php artisan make:seeder PostSeeder
```

### CategorySeeder:

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::create(['name' => 'Technology']);
        Category::create(['name' => 'Lifestyle']);
    }
}
```

### PostSeeder:

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Category;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $tech = Category::where('name', 'Technology')->first();
        $life = Category::where('name', 'Lifestyle')->first();

        Post::create(['title' => 'Laravel 12 Breadcrumbs', 'content' => 'This is a Laravel 12 tutorial for breadcrumbs.', 'category_id' => $tech->id]);
        Post::create(['title' => 'Healthy Living', 'content' => 'Tips for a healthy lifestyle.', 'category_id' => $life->id]);
    }
}
```

Run seeders:

```bash
php artisan db:seed --class=CategorySeeder
php artisan db:seed --class=PostSeeder
```

---

## Step 6: Create Controllers

```bash
php artisan make:controller CategoryController
php artisan make:controller PostController
```

### CategoryController:

```php
<?php

namespace App\Http\Controllers;


use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    public function show(Category $category)
    {
        return view('categories.show', compact('category'));
    }
}
```

### PostController:

```php
<?php

namespace App\Http\Controllers;

use App\Models\Post;

class PostController extends Controller
{
    // Show all posts
    public function index()
    {
        $posts = Post::with('category')->get(); // eager load category
        return view('posts.index', compact('posts'));
    }

    // Show single post
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }
}
```

---

## Step 7: Define Routes (routes/web.php)

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

// NEW: Route to show all posts
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
```

---


## Step 8: Define Breadcrumbs (routes/breadcrumbs.php)

Create routes/breadcrumbs.php (Laravel Breadcrumbs expects this file):

```php
<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;
use App\Models\Category;
use App\Models\Post;

// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('home'));
});

// Categories Index
Breadcrumbs::for('categories.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Categories', route('categories.index'));
});

// Category Show
Breadcrumbs::for('categories.show', function (BreadcrumbTrail $trail, Category $category) {
    $trail->parent('categories.index');
    $trail->push($category->name, route('categories.show', $category->id));
});

// Post Show
Breadcrumbs::for('posts.show', function (BreadcrumbTrail $trail, Post $post) {
    $trail->parent('categories.show', $post->category);
    $trail->push($post->title, route('posts.show', $post->id));
});
```

---

## Step 9: Create Blade Views

### 9.1 index.blade.php

resources/views/categories/index.blade.php

```html
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
```

### 9.2 show.blade.php

resources/views/categories/show.blade.php

```html
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
```

### 9.3 index.blade.php

resources/views/posts/index.blade.php


```html
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
```

### 9.4 show.blade.php

resources/views/posts/show.blade.php

```html
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
```

---

## Step 10: Test the Application

Run Laravel server:

```bash
php artisan serve
```
Open your browser: 

```bash
http://127.0.0.1:8000
```

Navigate through:

- /categories → list of categories

- /categories/{id} → category page

- /posts → post page

You will see breadcrumbs updating dynamically at the top of each page.

---

## Output

<img width="1919" height="1030" alt="Screenshot 2026-02-23 175155" src="https://github.com/user-attachments/assets/ea70084e-5ae6-425c-b7ff-1bb072b40fa7" />

<img width="1919" height="1027" alt="Screenshot 2026-02-23 175225" src="https://github.com/user-attachments/assets/6f51cebd-d453-4641-8c88-5fe69111897f" />

<img width="1919" height="1029" alt="Screenshot 2026-02-23 175242" src="https://github.com/user-attachments/assets/07b166b1-c10a-425b-9e8e-dc82243d3919" />

---

## Project Structure

```
PHP_Laravel12_Breadcrumbs/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── CategoryController.php
│   │       └── PostController.php
│   └── Models/
│       ├── Category.php
│       └── Post.php
├── database/
│   ├── migrations/
│   │   ├── 2026_02_23_000001_create_categories_table.php
│   │   └── 2026_02_23_000002_create_posts_table.php
│   └── seeders/
│       ├── CategorySeeder.php
│       └── PostSeeder.php
├── resources/
│   └── views/
│       ├── categories/
│       │   ├── index.blade.php
│       │   └── show.blade.php
│       └── posts/
│           ├── index.blade.php
│           └── show.blade.php
├── routes/
│   ├── web.php
│   └── breadcrumbs.php
├── .env
└── composer.json
```

---

Your PHP_Laravel12_Breadcrumbs Project is now ready!
<<<<<<< HEAD

=======
>>>>>>> development
