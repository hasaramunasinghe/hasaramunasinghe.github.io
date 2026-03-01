# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Static portfolio website for Hasara Munasinghe, a Project Manager, deployed via GitHub Pages at `hasaramunasinghe.com`. Based on the EasyFolio Bootstrap template (BootstrapMade), customized with personal content.

No build process — the site is served directly as static HTML/CSS/JS.

## Development

**Preview locally:** Open `index.html` in a browser directly, or use any static file server:
```bash
python -m http.server 8000
# or
npx serve .
```

**SCSS:** Source files live in `assets/scss/` but the pre-compiled `assets/css/main.css` is what's served. If editing styles, modify `assets/css/main.css` directly (the SCSS is not actively compiled in this workflow).

## Architecture

### Single-page layout
All primary content is in `index.html` as distinct sections (Hero, About, Skills, Resume, Testimonials, Contact). Additional pages (`portfolio-details.html`, `service-details.html`) follow the same structure but are largely template stubs.

### Vendor libraries (all local, in `assets/vendor/`)
- **Bootstrap 5.3.3** — grid, layout, components
- **AOS** — fade-in animations on scroll
- **Swiper** — testimonials carousel
- **Glightbox** — portfolio lightbox
- **Isotope** — portfolio grid filtering
- **Waypoints** — triggers skill bar animation on scroll entry

### JavaScript (`assets/js/main.js`)
Vanilla JS. Handles: sticky header, mobile nav toggle, scroll-to-top, smooth scrolling, scrollspy active states, and initialization of all vendor plugins (AOS, Swiper, Glightbox, Isotope).

### CSS custom properties
Color scheme and fonts are defined as CSS variables at the top of `assets/css/main.css`:
- `--accent-color`: `#4a6fa5` (dusty blue)
- `--heading-color`: `#1F2A44` (navy)
- `--background-color`: `#EFF5FA` (soft misty blue)
- `--surface-color`: `#F0F7FC` (light sky blue, used in alternating sections)

### Contact form
`index.html` submits the contact form directly to Google Forms. The `forms/contact.php` file (a BootstrapMade PHP Email Form handler) exists but is not currently wired up.

### Assets
- `assets/img/profile/` — profile photos (use WebP format)
- `assets/resume/Hasara-Munasinghe-2025.pdf` — downloadable resume
- `CNAME` — sets the custom domain for GitHub Pages
