@extends('_layouts.main', ['posts' => $posts])

@section('content')
<style>
    /* Hide global controls on blog pages - we have our own in header */
    body > #sidebar-toggle,
    body > #theme-toggle {
        display: none !important;
    }
    
    /* Blog page header */
    .page-header {
        position: fixed !important;
        top: 1rem !important;
        left: 1rem !important;
        right: 1rem !important;
        z-index: 10 !important;
        display: flex !important;
        flex-direction: row !important;
        justify-content: space-between !important;
        align-items: center !important;
        transition: transform 0.3s ease !important;
    }
    
    .page-header.header-hidden {
        transform: translateY(-100%) !important;
    }
    
    .page-header .header-logo {
        position: absolute !important;
        left: 50% !important;
        transform: translateX(-50%) !important;
        width: 60px !important;
        height: 60px !important;
    }
    
    .page-header .header-logo svg,
    .page-header .header-logo .jc-logo {
        width: 100% !important;
        height: 100% !important;
    }
    
    /* Force logo to use text color */
    .page-header .header-logo,
    .page-header .header-logo a,
    .page-header .header-logo svg,
    .page-header .header-logo .jc-logo,
    .page-header .header-logo .jc-logo path,
    .page-header .header-logo svg path,
    .page-header .header-logo .letter {
        fill: var(--text) !important;
        color: var(--text) !important;
    }
    
    .page-header .header-btn {
        padding: 0.25rem !important;
        border-radius: 50% !important;
        border: none !important;
        background: transparent !important;
        color: var(--text) !important;
        cursor: pointer !important;
    }
    
    /* Theme toggle icons - show/hide based on theme */
    html .header-sun-icon {
        display: none !important;
    }
    html .header-moon-icon {
        display: block !important;
    }
    html.dark .header-sun-icon {
        display: block !important;
    }
    html.dark .header-moon-icon {
        display: none !important;
    }
</style>
@php
    $pubDate = $page->pubDate;
    if (is_int($pubDate)) {
        $formattedDate = date('F j, Y', $pubDate);
    } elseif (is_string($pubDate)) {
        $formattedDate = date('F j, Y', strtotime($pubDate));
    } elseif ($pubDate instanceof DateTime) {
        $formattedDate = $pubDate->format('F j, Y');
    } else {
        $formattedDate = 'Unknown date';
    }
@endphp

<div class="blog-post-page">
    <header class="page-header" id="page-header">
        <button class="header-btn" aria-label="Toggle sidebar" onclick="window.toggleSidebar && window.toggleSidebar()">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="8" y1="6" x2="8" y2="18"></line>
            </svg>
        </button>
        <div class="header-logo" style="view-transition-name: jc-logo;">
            <a href="/" class="logo-link" aria-label="Return to home page">
                @include('_components.jc-logo')
            </a>
        </div>
        <button class="header-btn" aria-label="Toggle dark mode" onclick="document.documentElement.classList.toggle('dark'); localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');">
            <svg class="header-sun-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="5"></circle>
                <line x1="12" y1="1" x2="12" y2="3"></line>
                <line x1="12" y1="21" x2="12" y2="23"></line>
                <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                <line x1="1" y1="12" x2="3" y2="12"></line>
                <line x1="21" y1="12" x2="23" y2="12"></line>
                <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
            </svg>
            <svg class="header-moon-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
            </svg>
        </button>
    </header>

    <main class="blog-content">
        <article class="post">
            <header class="post-header">
                <time class="blog-date" datetime="{{ is_int($pubDate) ? date('Y-m-d', $pubDate) : (is_string($pubDate) ? date('Y-m-d', strtotime($pubDate)) : $pubDate->format('Y-m-d')) }}">
                    {{ $formattedDate }}
                </time>
            </header>
            <div class="prose dark:prose-invert blog-content-inner">
                @yield('postContent')
            </div>
            <footer class="post-footer">
                <a href="/" class="back-link">← Back to Home</a>
            </footer>
        </article>
    </main>
</div>

<script>
function setupBlogPage() {
    const header = document.getElementById('page-header');
    let lastScrollY = window.scrollY;
    
    if (!header) return;
    
    // Remove any existing scroll listener first
    window.removeEventListener('scroll', window.blogScrollHandler);
    
    window.blogScrollHandler = function() {
        const currentScrollY = window.scrollY;
        
        if (currentScrollY < 100) {
            header.classList.remove('header-hidden');
        } else if (currentScrollY > lastScrollY) {
            header.classList.add('header-hidden');
        } else {
            header.classList.remove('header-hidden');
        }
        
        lastScrollY = currentScrollY;
    };
    
    window.addEventListener('scroll', window.blogScrollHandler, { passive: true });
}

// Run on DOM ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', setupBlogPage);
} else {
    setupBlogPage();
}
</script>
@endsection
