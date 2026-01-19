# Layout Migratie: Text Block

## Overzicht
Deze instructies beschrijven hoe je de **Text layout** volledig kopieert naar een andere WordPress theme. De Text layout is een flexibele content block met titel, WYSIWYG tekst, en uitgebreide styling opties.

## Benodigde Bestanden

### 1. Template Bestanden
- `templates/pagebuilder/text/text.php` - PHP template
- `templates/pagebuilder/text/text.css` - CSS styling
- `templates/pagebuilder/text/text.js` - JavaScript (optioneel, leeg in dit geval)

### 2. ACF Field Group
- `acf-json/group_layout_text.json` - ACF field definitie

### 3. Configuratie Bestanden
- `acf-json/group_pagebuilder.json` - Layout registratie in pagebuilder
- `assets/css/input.css` - CSS import
- `scripts/build-pagebuilder-js.js` - JavaScript bundling

## Implementatie Stappen

### Stap 1: Maak Block Folder Structuur
```bash
mkdir -p templates/pagebuilder/text
```

### Stap 2: Kopieer Template Bestanden

**`templates/pagebuilder/text/text.php`:**
```php
<?php
/**
 * Text Block
 *
 * @package [theme-name]
 * @version 1.0.0
 * @author [author-name]
 */

defined( 'ABSPATH' ) || exit;

$title = get_sub_field( 'title' );
$text = get_sub_field( 'text' );

// Styling options
$background_color = get_sub_field( 'background_color' ) ?: 'white';
$padding_top = get_sub_field( 'padding_top' );
$padding_bottom = get_sub_field( 'padding_bottom' );
$text_alignment = get_sub_field( 'text_alignment' ) ?: 'center';
$container_width = get_sub_field( 'container_width' ) ?: '4xl';

// Build classes
$bg_class = 'bg-' . $background_color;
$padding_classes = '';
if ( $padding_top ) {
    $padding_classes .= ' pt-12 md:pt-16 lg:pt-20';
}
if ( $padding_bottom ) {
    $padding_classes .= ' pb-12 md:pb-16 lg:pb-20';
}

// Alignment classes
$alignment_class = $text_alignment === 'left' ? 'text-left' : 'text-center';

// Container width mapping (maps friendly values to Tailwind classes)
$container_width_map = array(
    'full'      => '',
    '2xl'       => 'max-w-2xl',
    '4xl'       => 'max-w-4xl',
    '5xl'       => 'max-w-5xl',
    'screen-lg' => 'max-w-screen-lg',
    'screen-xl' => 'max-w-screen-xl',
);

// Container width classes
$container_class = '';
if ( isset( $container_width_map[ $container_width ] ) && $container_width_map[ $container_width ] !== '' ) {
    $container_class = $container_width_map[ $container_width ] . ' mx-auto';
}
?>

<section class="text-block <?php echo esc_attr( $bg_class . $padding_classes ); ?>">
    <div class="text-block__container container">

        <?php if ( $title || $text ) : ?>
            <div class="text-block__content <?php echo esc_attr( $alignment_class . ' ' . $container_class ); ?>">
                <?php if ( $title ) : ?>
                    <h2 class="text-block__title font-title text-3xl md:text-4xl lg:text-5xl uppercase font-bold mb-4 <?php echo esc_attr( $alignment_class ); ?>"><?php echo esc_html( $title ); ?></h2>
                <?php endif; ?>

                <?php if ( $text ) : ?>
                    <div class="text-block__text text-sm md:text-base text-grey <?php echo esc_attr( $alignment_class ); ?>"><?php echo wp_kses_post( $text ); ?></div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

    </div>
</section>
```

**`templates/pagebuilder/text/text.css`:**
```css
/**
 * Text Block Styles
 *
 * @package [theme-name]
 * @version 1.0.0
 * @author [author-name]
 */

/* Typography styling for text block content */
.text-block__text {
    @apply text-grey;
}

/* Paragraphs */
.text-block__text p {
    @apply mb-4 text-base leading-relaxed;
    font-size: 16px;
}

.text-block__text p:first-child {
    @apply mt-0;
}

.text-block__text p:last-child {
    @apply mb-0;
}

/* Headings */
.text-block__text h1,
.text-block__text h3,
.text-block__text h4,
.text-block__text h5,
.text-block__text h6 {
    @apply font-serif font-bold text-grey-dark;
}

.text-block__text h1 {
    @apply text-3xl md:text-4xl lg:text-5xl mt-8 mb-4 leading-tight;
}

.text-block__text h2 {
    @apply font-title font-bold text-grey-dark text-2xl md:text-3xl lg:text-4xl mt-8 mb-4 leading-tight uppercase;
}

.text-block__text h3 {
    @apply text-lg md:text-xl lg:text-2xl mt-6 mb-3 leading-tight;
}

.text-block__text h4 {
    @apply text-lg md:text-xl lg:text-2xl mt-6 mb-3 leading-tight;
}

.text-block__text h5 {
    @apply text-base md:text-lg lg:text-xl mt-4 mb-2 leading-tight;
}

.text-block__text h6 {
    @apply text-sm md:text-base lg:text-lg mt-4 mb-2 leading-tight;
}

.text-block__text h1:first-child,
.text-block__text h2:first-child,
.text-block__text h3:first-child,
.text-block__text h4:first-child,
.text-block__text h5:first-child,
.text-block__text h6:first-child {
    @apply mt-0;
}

/* Unordered and Ordered Lists */
.text-block__text ul,
.text-block__text ol {
    @apply mb-4 pl-6 text-grey;
}

.text-block__text ul {
    @apply list-disc;
}

.text-block__text ol {
    @apply list-decimal;
}

.text-block__text ul:last-child,
.text-block__text ol:last-child {
    @apply mb-0;
}

/* List Items */
.text-block__text li {
    @apply mb-2 text-base leading-relaxed;
}

.text-block__text li:last-child {
    @apply mb-0;
}

/* Nested Lists */
.text-block__text ul ul,
.text-block__text ol ol,
.text-block__text ul ol,
.text-block__text ol ul {
    @apply mt-2 mb-0;
}

/* Links */
.text-block__text a {
    @apply text-primary underline transition-colors hover:text-secondary;
}

/* Strong/Bold */
.text-block__text strong,
.text-block__text b {
    @apply font-semibold text-grey-dark;
}

/* Emphasis/Italic */
.text-block__text em,
.text-block__text i {
    @apply italic;
}

/* Code */
.text-block__text code {
    @apply bg-grey-light px-1 py-0.5 rounded text-sm font-mono;
}

.text-block__text pre {
    @apply bg-grey-light p-4 rounded mb-4 overflow-x-auto;
}

.text-block__text pre code {
    @apply bg-transparent p-0;
}

/* Blockquotes */
.text-block__text blockquote {
    @apply border-l-4 border-primary pl-4 my-4 italic text-grey-text;
}

.text-block__text blockquote p {
    @apply mb-0;
}

/* Images */
.text-block__text img {
    @apply max-w-full h-auto my-4 rounded;
}

.text-block__text img:first-child {
    @apply mt-0;
}

.text-block__text img:last-child {
    @apply mb-0;
}

/* Horizontal Rules */
.text-block__text hr {
    @apply border-t border-grey-decor my-6;
}

/* Tables */
.text-block__text table {
    @apply w-full mb-4 border-collapse;
}

.text-block__text th,
.text-block__text td {
    @apply border border-grey-decor px-4 py-2 text-left;
}

.text-block__text th {
    @apply bg-grey-light font-semibold text-grey-dark;
}

/* Alignment adjustments for centered text */
.text-block__content.text-center .text-block__text ul,
.text-block__content.text-center .text-block__text ol {
    @apply list-inside;
}

.text-block__content.text-center .text-block__text blockquote {
    @apply border-l-0 border-t-4 pl-0 pt-4;
    text-align: center;
}
```

**`templates/pagebuilder/text/text.js`:**
```javascript
/**
 * Text Block JavaScript
 *
 * @package [theme-name]
 * @version 1.0.0
 * @author [author-name]
 */

(function() {
    'use strict';

    // No JavaScript required for this block

})();
```

### Stap 3: Maak ACF Field Group

Kopieer `acf-json/group_layout_text.json` en pas aan:
- Update `"modified"` timestamp naar huidige Unix timestamp (`date +%s`)
- Controleer dat `"active": false` staat
- Controleer dat `"acfe_autosync": ["json"]` aanwezig is

**Belangrijk:** Pas de achtergrondkleur opties aan naar de kleuren die beschikbaar zijn in jouw theme's Tailwind configuratie. Standaard opties zijn: `white`, `beige`, `beige-darker`.

### Stap 4: Registreer Layout in Pagebuilder

Voeg de layout toe aan `acf-json/group_pagebuilder.json` in de `layouts` array:

```json
{
    "key": "layout_text",
    "name": "text",
    "label": "Text",
    "display": "block",
    "sub_fields": [
        {
            "key": "field_text_clone",
            "label": "Text",
            "name": "text",
            "type": "clone",
            "clone": [
                "group_layout_text"
            ],
            "display": "seamless",
            "layout": "block",
            "prefix_label": 0
        }
    ],
    "min": "",
    "max": ""
}
```

**Belangrijk:** Update `"modified"` timestamp in `group_pagebuilder.json` na toevoeging.

### Stap 5: Import CSS

Voeg toe aan `assets/css/input.css` (voor de `@tailwind` directives):

```css
@import '../../templates/pagebuilder/text/text.css';
```

### Stap 6: Registreer JavaScript

Voeg `'text'` toe aan de `pagebuilderBlocks` array in `scripts/build-pagebuilder-js.js`:

```javascript
const pagebuilderBlocks = [
    // ... andere blocks ...
    'text'
];
```

### Stap 7: Build Assets

```bash
npm run build
```

Of apart:
```bash
npm run build:css  # Voor CSS
npm run build:js    # Voor JavaScript
```

## Aanpassingen voor Andere Themes

### Kleuren
Pas de achtergrondkleur opties aan in `group_layout_text.json`:
- Vervang `white`, `beige`, `beige-darker` met jouw theme kleuren
- Zorg dat deze kleuren bestaan in `tailwind.config.js`

### Typography
Controleer of deze Tailwind classes bestaan in jouw theme:
- `font-title` - Voor titel font
- `font-serif` - Voor headings in tekst
- `text-grey`, `text-grey-dark`, `text-grey-text` - Voor tekst kleuren

### Container Classes
Zorg dat `.container` class bestaat in jouw theme CSS, of pas aan naar jouw container implementatie.

## Vereisten

- **WordPress** met ACF Pro
- **Tailwind CSS** geconfigureerd
- **Pagebuilder systeem** met flexible content
- **Helper functies:** Geen specifieke helper functies nodig (gebruikt alleen `get_sub_field()`)

## Test Checklist

- [ ] Block verschijnt in pagebuilder dropdown
- [ ] Alle velden zijn zichtbaar en werkend
- [ ] Styling wordt correct toegepast
- [ ] Responsive gedrag werkt (mobile/tablet/desktop)
- [ ] Tekst alignment werkt (links/gecentreerd)
- [ ] Container breedtes werken correct
- [ ] Padding opties werken
- [ ] Achtergrondkleuren worden toegepast
- [ ] WYSIWYG content wordt correct gerenderd
- [ ] Alle HTML elementen in tekst hebben correcte styling (headings, lists, links, etc.)

## Troubleshooting

**Block verschijnt niet in pagebuilder:**
- Check of layout is toegevoegd aan `group_pagebuilder.json`
- Check `"modified"` timestamp
- Refresh WordPress admin pagina

**Styling werkt niet:**
- Run `npm run build:css`
- Check of CSS import correct is in `input.css`
- Controleer of Tailwind classes bestaan in config

**ACF velden verschijnen niet:**
- Check `group_layout_text.json` bestand
- Controleer `"active": false` en `"acfe_autosync": ["json"]`
- Update `"modified"` timestamp
- Refresh WordPress admin
