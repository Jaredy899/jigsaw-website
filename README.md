# Jared Cervantes - Personal Website

A personal website built with [Jigsaw](https://jigsaw.tighten.com/), a static site generator for PHP.

## Prerequisites

- PHP 8.1+
- Composer

## Quick Start

```bash
# Install PHP dependencies
composer install

# Start development server
vendor/bin/jigsaw serve
```

The site will be available at `http://localhost:8000`.

## Available Commands

| Command | Description |
|---------|-------------|
| `vendor/bin/jigsaw serve` | Start development server at localhost:8000 |
| `vendor/bin/jigsaw build production` | Build for production (outputs to `build_production/`) |
| `vendor/bin/jigsaw build` | Build for development (outputs to `build_local/`) |

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

### Traditional Static Hosting

Build for production:

```bash
vendor/bin/jigsaw build production
```

The static site will be generated in `build_production/` - deploy this folder to any static hosting service (Vercel, Netlify, GitHub Pages, etc.).

### Docker Self-Hosting

#### Quick Deploy (Recommended)

Use the provided deployment script:

```bash
./deploy.sh
```

#### Manual Docker Commands

Build and run with Docker:

```bash
# Build and start the container
docker compose up --build -d

# Or build the image manually
docker build -t jigsaw-website .

# Run the container
docker run -p 8081:80 jigsaw-website
```

The site will be available at `http://localhost:8081`.

#### Docker Commands

```bash
# Start in detached mode
docker-compose up -d

# Stop the container
docker-compose down

# Rebuild after changes
docker-compose up --build --force-recreate

# View logs
docker-compose logs -f
```

#### Custom Configuration

- **Port**: Change the port in `docker-compose.yml` (default: 8081)
- **Domain**: Update `nginx.conf` server_name for custom domains
- **SSL**: Add SSL certificates and update nginx config for HTTPS

#### Updating Content

If you make changes to the site content:

```bash
# Install dependencies (if not already done)
composer install

# Build the updated site
vendor/bin/jigsaw build production

# Restart the Docker container to pick up changes
docker compose down && docker compose up -d
```

## How Jigsaw Works

This site uses Jigsaw exclusively - no Node.js, npm, or build tools required. Here's how it works:

### Static Assets

Jigsaw automatically copies static files from the `source/` directory to the build output. CSS and JavaScript files in `source/_assets/` are served directly without compilation:

- `source/_assets/css/main.css` → `build_production/_assets/css/main.css`
- `source/_assets/js/main.js` → `build_production/_assets/js/main.js`

### Collections

Posts in `source/_posts/` are automatically processed as a collection. Jigsaw:
- Reads frontmatter from each markdown file
- Filters out drafts (`draft: false`)
- Sorts by `pubDate` (newest first)
- Generates clean URLs (removes date prefix)
- Applies the `post` layout template

### Building

Jigsaw processes:
1. **Blade templates** - PHP templating engine for layouts and components
2. **Markdown files** - Blog posts with frontmatter
3. **Static assets** - CSS, JS, images copied as-is
4. **Collections** - Organized content (posts, pages, etc.)

The build process is pure PHP - no compilation step needed for assets.
