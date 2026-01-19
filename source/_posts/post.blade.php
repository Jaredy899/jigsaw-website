@extends('_layouts.main', ['posts' => $posts])

@section('content')
<main class="container mx-auto px-4 py-8">
    <div class="logo-container">
        <a href="/" class="logo-link" aria-label="Return to home page">
            @include('_components.jc-logo')
        </a>
    </div>
    <article class="prose dark:prose-invert mx-auto fade-in blog-post">
        <time class="text-sm text-gray-500 dark:text-gray-400 blog-date">
            {{ $page->formatDate($page->pubDate) }}
        </time>
        <div class="mt-8 blog-content">
            @yield('postContent')
        </div>
    </article>
</main>
@endsection
