// ========================================
// Theme Toggle Functionality
// ========================================

const handleThemeToggleClick = () => {
    const element = document.documentElement;
    const isDark = element.classList.toggle("dark");
    const theme = isDark ? "dark" : "light";

    // Update localStorage if available
    if (typeof localStorage !== 'undefined') {
        localStorage.setItem("theme", theme);
    }

    // Update icons efficiently
    const sunIcon = document.getElementById('sun-icon');
    const moonIcon = document.getElementById('moon-icon');
    if (isDark) {
        sunIcon?.classList.remove('hidden');
        moonIcon?.classList.add('hidden');
    } else {
        sunIcon?.classList.add('hidden');
        moonIcon?.classList.remove('hidden');
    }
};

const setupTheme = () => {
    const savedTheme = typeof localStorage !== 'undefined' ? localStorage.getItem('theme') : null;
    const prefersDark = typeof window !== 'undefined' && window.matchMedia ?
        window.matchMedia('(prefers-color-scheme: dark)').matches : false;

    // Determine theme: saved > system preference > default to light
    const theme = savedTheme || (prefersDark ? 'dark' : 'light');

    // Apply theme
    const element = document.documentElement;
    const isDark = theme === 'dark';
    element.classList.toggle('dark', isDark);

    // Update icons
    const sunIcon = document.getElementById('sun-icon');
    const moonIcon = document.getElementById('moon-icon');
    if (isDark) {
        sunIcon?.classList.remove('hidden');
        moonIcon?.classList.add('hidden');
    } else {
        sunIcon?.classList.add('hidden');
        moonIcon?.classList.remove('hidden');
    }

    // Save theme if not already saved
    if (typeof localStorage !== 'undefined' && !savedTheme) {
        localStorage.setItem('theme', theme);
    }

    // Setup click handler (only once)
    const themeToggleButton = document.getElementById("theme-toggle");
    if (themeToggleButton && !themeToggleButton.hasAttribute('data-theme-handler')) {
        themeToggleButton.setAttribute('data-theme-handler', 'true');
        themeToggleButton.addEventListener("click", handleThemeToggleClick);
    }
};

// ========================================
// Sidebar Functionality
// ========================================

const toggleSidebar = (open = null) => {
    const sidebar = document.getElementById("sidebar");
    const overlay = document.getElementById("sidebar-overlay");

    if (!sidebar || !overlay) return;

    const isCurrentlyOpen = sidebar.classList.contains('open');

    // If open is specified, use it; otherwise toggle
    const shouldOpen = open !== null ? open : !isCurrentlyOpen;

    if (shouldOpen) {
        sidebar.classList.add('open');
        overlay.classList.add('active');
    } else {
        sidebar.classList.remove('open');
        overlay.classList.remove('active');
    }
};

const setupSidebar = () => {
    const sidebarToggleButton = document.getElementById("sidebar-toggle");
    const overlay = document.getElementById("sidebar-overlay");

    // Setup toggle button (only once)
    if (sidebarToggleButton && !sidebarToggleButton.hasAttribute('data-sidebar-handler')) {
        sidebarToggleButton.setAttribute('data-sidebar-handler', 'true');
        sidebarToggleButton.addEventListener("click", () => toggleSidebar());
    }

    // Setup overlay click (only once)
    if (overlay && !overlay.hasAttribute('data-overlay-handler')) {
        overlay.setAttribute('data-overlay-handler', 'true');
        overlay.addEventListener("click", () => toggleSidebar(false));
    }
};

const setupSidebarClose = () => {
    const closeBtn = document.getElementById('sidebar-close-btn');
    const sidebar = document.getElementById('sidebar');

    // Close button click
    if (closeBtn && !closeBtn.hasAttribute('data-close-handler')) {
        closeBtn.setAttribute('data-close-handler', 'true');
        closeBtn.addEventListener('click', () => {
            toggleSidebar(false);
        });
    }

    // Close sidebar when clicking on post links (event delegation)
    if (sidebar && !sidebar.hasAttribute('data-link-handler')) {
        sidebar.setAttribute('data-link-handler', 'true');
        sidebar.addEventListener('click', (e) => {
            if (e.target && e.target.closest('.post-link')) {
                toggleSidebar(false);
            }
        });
    }
};

// Make toggleSidebar available globally
if (typeof window !== 'undefined') {
    window.toggleSidebar = toggleSidebar;
}

// ========================================
// Copy Button Functionality
// ========================================

function setupCopyButtons() {
    const codeBlocks = document.querySelectorAll("pre code");
    if (codeBlocks.length === 0) return; // Exit early if no code blocks

    codeBlocks.forEach((codeBlock) => {
        const wrapper = codeBlock.parentElement;
        if (!wrapper) return;

        // Skip if already has wrapper or button
        if (wrapper.classList.contains("code-block-wrapper") ||
            wrapper.querySelector(".copy-code-button")) return;

        // Create wrapper and move code block
        const newWrapper = document.createElement("div");
        newWrapper.className = "code-block-wrapper";
        wrapper.insertBefore(newWrapper, codeBlock);
        newWrapper.appendChild(codeBlock);

        // Create and add copy button
        const btn = document.createElement("button");
        btn.className = "copy-code-button";
        btn.setAttribute("aria-label", "Copy code");
        btn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="9" y="9" width="13" height="13" rx="2" ry="2"/>
            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
        </svg>`;

        // Use event delegation and optimize clipboard operation
        btn.addEventListener("click", async (e) => {
            e.preventDefault();
            try {
                const text = codeBlock.textContent || "";
                await navigator.clipboard.writeText(text);

                const originalHTML = btn.innerHTML;
                btn.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"/>
                </svg><span class="btn-text">Copied!</span>`;
                btn.classList.add("copied");

                setTimeout(() => {
                    btn.innerHTML = originalHTML;
                    btn.classList.remove("copied");
                }, 2000);
            } catch (err) {
                console.error("Failed to copy code:", err);
            }
        });

        newWrapper.appendChild(btn);
    });
}

// ========================================
// Syntax Highlighting with highlight.js
// ========================================

function setupHighlighting() {
    if (typeof hljs !== 'undefined') {
        hljs.highlightAll();
    }
}

// ========================================
// View Transitions (for browsers that support it)
// ========================================

function setupViewTransitions() {
    // Only setup if the browser supports view transitions
    if (!document.startViewTransition) return;
    
    // Intercept link clicks for same-origin navigation
    document.addEventListener('click', (e) => {
        const link = e.target.closest('a');
        if (!link) return;
        
        const href = link.getAttribute('href');
        if (!href) return;
        
        // Skip external links, anchors, and special links
        if (link.target === '_blank' || 
            link.origin !== window.location.origin ||
            href.startsWith('#') ||
            href.startsWith('mailto:') ||
            href.startsWith('tel:')) {
            return;
        }
        
        e.preventDefault();
        
        // Start the view transition
        document.startViewTransition(async () => {
            // Fetch the new page
            const response = await fetch(href);
            const html = await response.text();
            
            // Parse the new HTML
            const parser = new DOMParser();
            const newDoc = parser.parseFromString(html, 'text/html');
            
            // Update the document
            document.title = newDoc.title;
            document.body.innerHTML = newDoc.body.innerHTML;
            
            // Update URL
            history.pushState({}, '', href);
            
            // Scroll to top
            window.scrollTo(0, 0);
            
            // Re-initialize all functionality
            initAll();
        });
    });
    
    // Handle browser back/forward
    window.addEventListener('popstate', () => {
        document.startViewTransition(async () => {
            const response = await fetch(window.location.href);
            const html = await response.text();
            const parser = new DOMParser();
            const newDoc = parser.parseFromString(html, 'text/html');
            document.title = newDoc.title;
            document.body.innerHTML = newDoc.body.innerHTML;
            window.scrollTo(0, 0);
            initAll();
        });
    });
}

// ========================================
// Initialize All Functionality
// ========================================

function initAll() {
    setupTheme();
    setupSidebar();
    setupSidebarClose();
    setupCopyButtons();
    setupHighlighting();
}

// Run on initial load
if (typeof document !== 'undefined') {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => {
            initAll();
            setupViewTransitions();
        });
    } else {
        initAll();
        setupViewTransitions();
    }
}
