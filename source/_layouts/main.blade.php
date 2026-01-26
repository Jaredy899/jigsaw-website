<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Jared Cervantes - Personal Website">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@400;500;600;700&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet">
    <title>{{ $page->title ?? $page->siteName }}</title>
    <meta name="title" content="{{ $page->title ?? $page->siteName }}">
    <meta name="description" content="{{ $page->description ?? $page->siteDescription }}">
    <link rel="stylesheet" href="/_assets/css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github-dark.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
    <meta name="view-transition" content="same-origin">
    <style>
        /* View Transitions */
        @view-transition {
            navigation: auto;
        }
        
        /* Logo transition */
        .home-logo-container,
        .header-logo {
            view-transition-name: jc-logo;
        }
        
        ::view-transition-old(jc-logo),
        ::view-transition-new(jc-logo) {
            animation-duration: 0.5s;
        }
        
        /* Page content fade */
        ::view-transition-old(root) {
            animation: fade-out 0.2s ease-out;
        }
        
        ::view-transition-new(root) {
            animation: fade-in 0.3s ease-in;
        }
        
        @keyframes fade-out {
            from { opacity: 1; }
            to { opacity: 0; }
        }
        
        @keyframes fade-in {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>
<body>
    <button id="sidebar-toggle" aria-label="Toggle sidebar">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
            <line x1="8" y1="6" x2="8" y2="18"></line>
        </svg>
    </button>
    
    @include('_components.sidebar', ['posts' => $posts ?? collect()])
    @include('_components.theme-toggle')
    
    <main id="main-content">
        @yield('content')
    </main>
    
    <script src="/_assets/js/main.js"></script>
</body>
</html>
