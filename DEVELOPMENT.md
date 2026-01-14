# Perfect Finish Theme - Development Guide

## Project Overzicht

**Theme:** Perfect Finish  
**Versie:** 1.0.0  
**Auteur:** Kay Jilesen

### Technologie Stack

- **WordPress** - Latest stable
- **ACF Pro** - Flexibele content management
- **Tailwind CSS** - Utility-first styling
- **Swiper.js** - Sliders/carousels
- **jQuery** - DOM manipulatie (legacy)

---

## Project Structuur

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

---

## Build Workflow

### NPM Scripts

```bash
npm run build        # Build alle assets (CSS + JS)
npm run build:css    # Build alleen CSS (Tailwind)
npm run build:js     # Build alleen JS (pagebuilder blocks)
npm run dev          # Development mode (CSS watch)
```

### Development Workflow

1. **Start development:**
   ```bash
   npm run dev
   ```

2. **Maak wijzigingen:**
   - PHP/CSS wijzigingen → CSS wordt automatisch gerecompileerd
   - JavaScript wijzigingen → Run `npm run build:js`

3. **Production build:**
   ```bash
   npm run build
   ```

### Build Process

**CSS:**
- Tailwind compileert `assets/css/input.css` → `assets/css/style.css`
- Alle `@import` statements worden verwerkt
- Output is geminified

**JavaScript:**
- `scripts/build-pagebuilder-js.js` combineert alle block JS files
- Output: `assets/js/pagebuilder.js`
- Automatische cache busting via `filemtime()`

---

## Belangrijke Conventies

### Naming

- **PHP functies:** Altijd `kj_` prefix (`kj_render_button()`)
- **Bestanden:** lowercase met hyphens (`text-image.php`)
- **CSS classes:** BEM + Tailwind (`hero-block`, `hero-block__title`)
- **ACF fields:** lowercase met underscores (`button_label`)

### ACF Workflow

1. **JSON sync:** Alle fields in `/acf-json/` (versiecontrole)
2. **Na wijziging:** Update `"modified"` timestamp (`date +%s`)
3. **Layouts:** `group_layout_<slug>.json` met `"active": false`
4. **Buttons:** Altijd repeater (zelfs voor 1 button)

### CSS & Tailwind

- **GEEN media queries** - Gebruik Tailwind responsive classes in PHP
- **Kleuren:** Altijd Tailwind classes (`bg-primary`, `text-secondary`)
- **@apply:** Gebruik voor Tailwind utilities in CSS
- **Mobile-first:** Base = mobile, dan `md:`, `lg:`, etc.

### Pagebuilder Blocks

**Structuur:**
```
templates/pagebuilder/<block-slug>/
├── <block-slug>.php
├── <block-slug>.css
└── <block-slug>.js
```

**Toevoegen:**
1. Maak block folder + bestanden
2. Maak `acf-json/group_layout_<slug>.json`
3. Voeg layout toe aan `group_pagebuilder.json`
4. Import CSS in `assets/css/input.css`
5. Voeg block toe aan `scripts/build-pagebuilder-js.js` array
6. Run `npm run build:js`

---

## Helper Functies

```php
// ACF helpers
kj_acf('field_name')                    // Echo escaped ACF field
kj_image('field_name', 'size')          // Output image
kj_sub_image('field_name', 'size')      // Output sub field image

// Components
kj_render_button($data)                 // Render button
kj_render_buttons()                     // Render button repeater
kj_component('button', 'field')         // Render component

// Utilities
kj_is_live_domain()                     // Check live domain
kj_escape_html($text)                   // Escape HTML
```

---

## Best Practices

### Security
- Altijd escaping: `esc_html()`, `esc_url()`, `wp_kses_post()`
- ACF output: `wp_kses_post(get_sub_field('title'))`

### Performance
- Conditional script loading (archives, etc.)
- Gebruik juiste image sizes
- Cache busting via `filemtime()`

### Code Quality
- Strict typing waar mogelijk
- Function documentation
- WordPress coding standards

---

## Troubleshooting

**ACF fields verschijnen niet:**
- Check JSON bestand + `"modified"` timestamp
- Refresh WordPress admin

**CSS werkt niet:**
- Run `npm run build:css`
- Check import in `input.css`

**JavaScript werkt niet:**
- Check block in `build-pagebuilder-js.js` array
- Run `npm run build:js`

**Tailwind classes werken niet:**
- Run `npm run build:css`
- Check `tailwind.config.js` content paths
