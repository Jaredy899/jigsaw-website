<?php

return [
    'production' => false,
    'baseUrl' => '',
    'siteName' => 'Jared Cervantes',
    'siteDescription' => 'Personal website of Jared Cervantes',
    'siteAuthor' => 'Jared Cervantes',

    // Collections configuration
    'collections' => [
        'posts' => [
            'path' => function ($page) {
                // Remove date prefix from filename for clean URLs
                $filename = $page->getFilename();
                $cleanSlug = preg_replace('/^\d{4}-\d{2}-\d{2}-/', '', $filename);
                return 'blog/' . $cleanSlug;
            },
            'sort' => '-pubDate',
            'extends' => '_layouts.post',
            'section' => 'postContent',
            'filter' => function ($item) {
                return !($item->draft ?? false);
            },
        ],
    ],

    // Helper function to format dates
    'formatDate' => function ($page, $date) {
        if ($date === null || $date === '') {
            return 'Unknown date';
        }
        try {
            if (is_int($date)) {
                $dateObj = new DateTime('@' . $date);
            } elseif (is_string($date)) {
                $dateObj = new DateTime($date);
            } elseif ($date instanceof DateTime) {
                $dateObj = $date;
            } else {
                return 'Unknown date';
            }
            return $dateObj->format('F j, Y');
        } catch (Exception $e) {
            return 'Unknown date';
        }
    },

    // Helper to clean slugs (port from Astro)
    'cleanSlug' => function ($page, $slug) {
        // Get the last segment
        $parts = explode('/', $slug);
        $lastSegment = end($parts) ?: $slug;

        // Remove leading date (YYYY-MM-DD-) or numeric prefixes (e.g., 12-)
        $withoutPrefixes = preg_replace('/^\d{4}-\d{2}-\d{2}-/', '', $lastSegment);
        $withoutPrefixes = preg_replace('/^\d+-/', '', $withoutPrefixes);

        // Basic slugify: lowercase, replace non-alphanumerics with '-', collapse, and trim '-'
        $simplified = strtolower($withoutPrefixes);
        $simplified = preg_replace('/[^a-z0-9-]+/', '-', $simplified);
        $simplified = preg_replace('/--+/', '-', $simplified);
        $simplified = trim($simplified, '-');

        return $simplified;
    },
];
