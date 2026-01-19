<div
    id="sidebar-overlay"
    class="sidebar-overlay"
    aria-hidden="true"
>
    <aside id="sidebar" class="blog-sidebar" aria-label="Blog navigation">
        <div class="sidebar-header">
            <h2>Blog Posts</h2>
            <button
                class="close-btn"
                id="sidebar-close-btn"
                aria-label="Close sidebar"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>

        <div class="sidebar-content">
            @if($posts->isEmpty())
                <div class="no-posts">No blog posts yet</div>
            @else
                <ul class="posts-list">
                    @foreach($posts as $post)
                        @php
                            $pubDate = $post->pubDate;
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
                        <li>
                            <a 
                                href="{{ $post->getUrl() }}"
                                class="post-link"
                                aria-label="{{ $post->title }} - Published on {{ $formattedDate }}"
                            >
                                <div class="post-title">{{ $post->title }}</div>
                                <div class="post-date">{{ $formattedDate }}</div>
                                @if($post->description)
                                    <div class="post-description">{{ $post->description }}</div>
                                @endif
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </aside>
</div>
