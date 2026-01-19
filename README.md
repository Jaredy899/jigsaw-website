# Jared Cervantes - Personal Website

A personal website built with [Jigsaw](https://jigsaw.tighten.com/), a static site generator for PHP.

## Prerequisites

- PHP 8.1+
- Composer
- Bun (or npm/yarn)

## Quick Start

```bash
# Install PHP dependencies
composer install

# Install frontend dependencies
bun install

# Start development server
bun run dev
```

The site will be available at `http://localhost:8000`.

## Available Commands

| Command | Description |
|---------|-------------|
| `bun run dev` | Start development server at localhost:8000 |
| `bun run build` | Build for production (outputs to `build_production/`) |
| `bun run build:dev` | Build for development (outputs to `build_local/`) |
| `bun run assets` | Compile assets with Laravel Mix |
| `bun run assets:watch` | Watch and compile assets |
| `bun run preview` | Build and preview locally |

## Project Structure

```
├── config.php              # Site configuration
├── bootstrap.php           # Event listeners and helpers
├── source/
│   ├── _assets/
│   │   ├── css/main.css   # All styles
│   │   └── js/main.js     # Client-side JavaScript
│   ├── _components/        # Blade partials
│   ├── _layouts/           # Layout templates
│   ├── _posts/             # Blog posts (Markdown)
│   ├── index.blade.php     # Homepage
│   └── favicon.svg         # Site icon
├── build_local/            # Development build output
└── build_production/       # Production build output
```

## Features

- Dark/light theme toggle with system preference detection
- Sidebar navigation with blog post listing
- Syntax highlighting with highlight.js (github-dark theme)
- Copy code button for code blocks
- Responsive design

## Writing Posts

Create a new Markdown file in `source/_posts/` with the following frontmatter:

```yaml
---
title: "My Post Title"
description: "A brief description"
pubDate: 2025-01-19
draft: false
---

# Your content here
```

## Deployment

Build for production:

```bash
bun run build
```

The static site will be generated in `build_production/` - deploy this folder to any static hosting service (Vercel, Netlify, GitHub Pages, etc.).
