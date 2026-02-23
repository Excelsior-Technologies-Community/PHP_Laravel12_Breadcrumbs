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