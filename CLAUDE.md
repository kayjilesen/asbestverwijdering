# Perfect Finish Theme - Claude Code Rules

## Project Context
- **Theme:** Perfect Finish WordPress Theme
- **Stack:** WordPress + ACF Pro + Tailwind CSS + Swiper.js
- **Author:** Kay Jilesen
- **Version:** 1.0.0

## Naming Conventions

### PHP Functions
- **CRITICAL: All custom functions MUST start with `kj_` prefix**
- Examples: `kj_render_button()`, `kj_acf()`, `kj_image()`
- Never create functions without the `kj_` prefix

### File Naming
- **Directories:** lowercase with hyphens (`text-image`, `call-to-action`)
- **PHP files:** lowercase with hyphens (`hero.php`, `text-image.php`)
- **CSS files:** lowercase with hyphens (`hero.css`, `text-image.css`)
- **JavaScript files:** lowercase with hyphens (`hero.js`, `text-image.js`)

### CSS Classes
- **Block classes:** BEM methodology (`hero-block`, `hero-block__title`, `hero-block__content`)
- **Utility classes:** Tailwind CSS utilities (`flex`, `items-center`, `gap-4`)
- **Component classes:** `kj-` prefix (`kj-button`, `kj-button-inner`)

### ACF Field Names
- **Field names:** lowercase with underscores (`button_label`, `background_image`)
- **Group names:** `group_layout_<slug>` for layout field groups
- **Layout names:** lowercase with hyphens in flexible content (`text-image`, `call-to-action`)

## ACF (Advanced Custom Fields) Workflow

### JSON Sync
- **CRITICAL: Always use JSON sync** - All fields stored in `/acf-json/` for version control
- **CRITICAL: When creating NEW ACF field groups, ALWAYS include `"acfe_autosync": ["json"]` in the JSON file** - This enables automatic JSON sync
- **CRITICAL: After ANY ACF JSON edit, ALWAYS update the `"modified"` field to current Unix timestamp** (use `date +%s` command)
- Never edit fields directly in database
- Always commit JSON files to Git

### Field Group Structure
1. **Main Pagebuilder:** `acf-json/group_pagebuilder.json` - Contains flexible content field
2. **Layout Field Groups:** `acf-json/group_layout_<slug>.json` - Per-block field groups
   - Set `"active": false` (cloned in pagebuilder)
   - Naming: `group_layout_<block-slug>` (e.g., `group_layout_hero`)
3. **Reusable Groups:** `acf-json/group_button_fields.json` - For components

### ACF Rules
- **Buttons are ALWAYS repeaters** - Even for 1 button, use repeater (flexibility for future)
- **Image fields:** Always use "Image Array" return format (not Image ID or URL)
- **Image fields preview:** **CRITICAL: Always set `"preview_size": "thumbnail"` for image fields in ACF JSON** - This ensures images are displayed as thumbnail size in the WordPress admin area
- **Tabs:** **CRITICAL: If tabs are used in a layout, ALL content fields MUST be placed under a tab** - Never place content fields directly in the fields array when tabs are present. Always start with a "Content" tab (or similar) that contains all main content fields, then add additional tabs (e.g., "Witruimte") as needed.
- **Layout field groups:** Set `"active": false` to prevent direct admin appearance

## Pagebuilder Block System

### Block Structure
Each pagebuilder block MUST have these files:
```
templates/pagebuilder/<block-slug>/
├── <block-slug>.php      # Template markup
├── <block-slug>.css      # Block-specific styles
├── <block-slug>.js       # Block-specific JavaScript (can be empty)
└── thumbnail.jpg         # ACF preview thumbnail (optional)
```

### Creating New Block - Complete Workflow
1. **Create block folder:** `templates/pagebuilder/<block-slug>/`
2. **Create files:** `<block-slug>.php`, `<block-slug>.css`, `<block-slug>.js`
3. **Create ACF field group:** `acf-json/group_layout_<block-slug>.json`
   - Set `"active": false`
   - **ALWAYS include `"acfe_autosync": ["json"]` to enable JSON sync**
   - Update `"modified"` timestamp (`date +%s`)
4. **Add layout to pagebuilder:** Edit `acf-json/group_pagebuilder.json`
   - Add layout entry with `type: clone` pointing to `group_layout_<block-slug>`
   - Update `"modified"` timestamp
5. **Import CSS:** Add `@import '../../templates/pagebuilder/<block-slug>/<block-slug>.css';` to `assets/css/input.css`
6. **Register JavaScript:** Add block name to `pagebuilderBlocks` array in `scripts/build-pagebuilder-js.js`
7. **Build:** Run `npm run build:js` for JavaScript

### Block Template (PHP) Rules
- Always use `get_sub_field()` for ACF fields (NOT `get_field()`)
- Always escape output: `wp_kses_post()`, `esc_html()`, `esc_url()`
- Use BEM class naming combined with Tailwind utilities
- Use semantic HTML (`<section>`, `<article>`, etc.)
- Template automatically loaded via `templates/pagebuilder/loop.php` based on `get_row_layout()`

### Block CSS Rules
- **CRITICAL: ALWAYS prefer Tailwind CSS classes directly in PHP templates over custom CSS**
- **NO media queries** - Use Tailwind responsive classes in PHP templates
- **STRICT RULE: Use Tailwind utilities directly in HTML/PHP templates instead of custom CSS whenever possible**
- Only use custom CSS (`@apply` or raw CSS) when Tailwind utilities are absolutely not available or insufficient
- Examples:
  - Bad: `.element { position: relative; display: inline-block; }` in CSS
  - Good: `<div class="relative inline-block">` in PHP template
  - Bad: `.element { top: 50%; left: 50%; transform: translate(-50%, -50%); }` in CSS
  - Good: `<div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">` in PHP template
  - Bad: `.element { width: 1.5em; height: 1.5em; }` in CSS
  - Good: `<div class="w-[1.5em] h-[1.5em]">` in PHP template
- Import in `assets/css/input.css` required (even if CSS file is empty)

### Block JavaScript Rules
- Wrap in IIFE: `(function() { ... })();`
- Use `'use strict';`
- Always check if element exists before using
- Add to `scripts/build-pagebuilder-js.js` array for bundling

## CSS and Responsive Design

### Media Queries
- **CRITICAL: NEVER use CSS media queries (@media) in CSS files. Always use Tailwind CSS responsive classes (sm:, md:, lg:, xl:, 2xl:) instead.**
- **STRICT RULE: Media queries are FORBIDDEN. Use Tailwind responsive utilities or CSS functions like clamp() for responsive behavior.**
- When making responsive changes, apply Tailwind responsive classes directly in PHP templates or HTML, not in CSS files.
- Use mobile-first approach: set default styles for mobile, then use md:, lg: etc. for larger screens.
- **For pseudo-elements (::before, ::after):** Tailwind responsive classes don't work well with @apply in pseudo-elements. Use CSS functions like `clamp()` for responsive values instead of media queries, or use a wrapper div element in the PHP template with Tailwind responsive classes.
- Examples:
  - Bad: `@media (min-width: 768px) { .element { height: 1rem; } }`
  - Good: `height: clamp(0.75rem, 1vw, 1rem);` (responsive without media query)
  - Bad: `@media (max-width: 1024px) { .element { padding: 1rem; } }`
  - Good: `<div class="p-4 lg:p-6">` in PHP template

### Tailwind Colors
- **CRITICAL: Always use Tailwind color classes, NEVER hex/rgb codes**
- Available colors: `primary`/`yellow` (#FFD500), `secondary`/`grey-dark` (#1A1603), `grey-surface`, `grey-decor`, `grey`, `grey-light`, `grey-text`, `yellow-light`
- Bad: `<div style="background-color: #FFD500;">` or `<div class="bg-[#FFD500]">`
- Good: `<div class="bg-primary">` or `<div class="bg-yellow">`

### CSS File Structure
- **Main entry:** `assets/css/input.css`
- **Import order:**
  1. Component CSS (`header.css`, `footer.css`, etc.)
  2. Pagebuilder block CSS (all `@import` statements)
  3. Tailwind directives (`@tailwind base/components/utilities`)

### @apply Directive
- Use `@apply` for Tailwind utilities in CSS files
- Only use raw CSS for: custom transforms, complex transitions, pseudo-elements with specific CSS features

## Build Workflow

### NPM Scripts
- `npm run build` - Build all assets (CSS + JS)
- `npm run build:css` - Build CSS only (Tailwind compile)
- `npm run build:js` - Build JS only (pagebuilder blocks bundling)
- `npm run dev` - Development mode (CSS watch)

### Build Process
- **CSS:** Tailwind compiles `assets/css/input.css` → `assets/css/style.css` (minified)
- **JavaScript:** `scripts/build-pagebuilder-js.js` combines all block JS files → `assets/js/pagebuilder.js`
- **Cache busting:** Automatic via `filemtime()` in WordPress enqueuing

### Development Workflow
1. Start: `npm run dev` (CSS watch mode)
2. Make changes: PHP/CSS auto-compiles, JS requires `npm run build:js`
3. Production: `npm run build` before commit/deploy

## Helper Functions

### ACF Helpers
- `kj_acf($field_name, $post_id)` - Echo escaped ACF field value
- `kj_image($field_name, $size, $post_id)` - Output WordPress image
- `kj_sub_image($field_name, $size, $post_id)` - Output sub field image

### Components
- `kj_render_button($data)` - Render single button
- `kj_render_buttons()` - Render button repeater (from sub fields)
- `kj_component($component, $field_name, $is_subfield, $is_option)` - Render component

### Utilities
- `kj_is_live_domain()` - Check if on live domain
- `kj_escape_html($text)` - Escape HTML with allowed tags

## Security & Best Practices

### Security
- **Always escape output:** `esc_html()`, `esc_url()`, `wp_kses_post()`
- **ACF output:** Always use `wp_kses_post(get_sub_field('title'))` not raw `get_sub_field()`
- Use nonce verification for form submissions
- Sanitize input for database queries

### Performance
- Conditional script loading (archives, specific pages)
- Use appropriate image sizes (see `inc/helpers.php` for available sizes)
- Cache busting via `filemtime()` in script/style enqueuing

### Code Quality
- Use strict typing where possible: `declare(strict_types=1);`
- Add function documentation with `@param` and `@return`
- Follow WordPress coding standards
- Use WordPress hooks instead of modifying core

## Component System

### Button Component
- **Location:** `templates/components/button.php`
- **Function:** `kj_render_button($button_data)` or `kj_render_buttons()` for repeater
- **Styles:** `primary yellow`, `primary grey-dark`, `primary white`, `secondary yellow`, `secondary grey-dark`, `secondary white`, `text`
- **Link types:** `internal`, `external`, `section`, `contact`

## Project Structure
```
perfectfinish/
├── acf-json/                    # ACF field definitions (JSON sync)
│   ├── group_pagebuilder.json   # Main flexible content
│   ├── group_layout_*.json      # Per-block field groups
│   └── group_button_fields.json # Reusable button fields
├── assets/
│   ├── css/
│   │   ├── input.css            # Main entry (imports all)
│   │   └── style.css             # Compiled output (generated)
│   └── js/
│       ├── script.js            # Main JavaScript
│       └── pagebuilder.js       # Combined blocks (generated)
├── templates/
│   ├── components/              # Reusable components
│   └── pagebuilder/             # Pagebuilder blocks
│       └── <block-name>/
│           ├── <block-name>.php
│           ├── <block-name>.css
│           └── <block-name>.js
├── inc/                         # PHP includes
├── scripts/
│   └── build-pagebuilder-js.js  # JS bundler
├── tailwind.config.js
└── package.json
```

## WordPress & WooCommerce Best Practices

### Key Principles
- Write concise, technical code with accurate PHP examples
- Follow WordPress and WooCommerce coding standards
- Use object-oriented programming when appropriate, focusing on modularity
- Prefer iteration and modularization over duplication
- Use descriptive function, variable, and file names
- Favor hooks (actions and filters) for extending functionality

### PHP/WordPress
- Use PHP 7.4+ features when appropriate (e.g., typed properties, arrow functions)
- Follow WordPress PHP Coding Standards
- Use strict typing when possible: `declare(strict_types=1);`
- Utilize WordPress core functions and APIs when available
- Implement proper error handling and logging
- Use WordPress's built-in functions for data validation and sanitization
- Implement proper nonce verification for form submissions
- Use `prepare()` statements for secure database queries

## Design Implementation

### Design Fidelity (Non-negotiables)
- Be **extremely critical** on design details: **border-radius, shadow, borders, gradients, icon sizes, line-heights** must be **exact** according to Figma
- Work **responsive-first**: implement for minimum **mobile + desktop** (and tablet where relevant)
- Never "close enough": if values are unclear, ask for confirmation instead of guessing

### Mobile Navigation (Standard Behavior)
- Mobile menu is by default an **off-canvas panel that slides in from the right** (with overlay)
- Submenus must **always** be expandable via a **chevron toggle** (not only via link click)
- Accessibility (a11y) is mandatory:
  - Chevron is a `button` with `aria-expanded` + `aria-controls`
  - Keyboard support: Tab/Enter/Space works logically; focus styles visible
  - ESC closes the menu; overlay click closes the menu; no "scroll bleed" on body when open

## Git Workflow

### When User Says "git push"
Execute these steps automatically in sequence:

1. **Check status**: Run `git status` to see all modified files
2. **Review changes**: Run `git diff` to understand what changed
3. **Build assets**: Run `npm run build` to compile Tailwind CSS and other assets
4. **Stage changes**: Run `git add .` to stage all files including dist/
5. **Create descriptive commit**: Write a clear commit message that:
   - Starts with a verb: Add, Update, Fix, Refactor, Improve
   - Describes WHAT changed (not HOW)
   - Is concise but informative (1-2 lines max)
   - Uses present tense
6. **Commit with co-author**: Format with heredoc for proper multiline
7. **Push to remote**: Run `git push origin main`
8. **Confirm**: Report completion with commit message and push status

## Important Reminders
- When creating NEW ACF field groups, ALWAYS include `"acfe_autosync": ["json"]` to enable automatic JSON sync
- When editing ACF JSON files, ALWAYS update `"modified"` timestamp using `date +%s`
- Buttons in layouts: Always use repeater field, even if only 1 button needed
- Image fields: Always use "Image Array" return format
- **Image fields preview: ALWAYS set `"preview_size": "thumbnail"` for image fields in ACF JSON** - This ensures images are displayed as thumbnail size in the WordPress admin area
- **Tabs: If tabs are used, ALL content fields MUST be placed under a tab** - Start with a "Content" tab containing all main content fields
- Never create PHP functions without `kj_` prefix
- Never use media queries in CSS files - use Tailwind responsive classes
- Never use hex/rgb color codes - use Tailwind color classes
- Always escape ACF field output before displaying
