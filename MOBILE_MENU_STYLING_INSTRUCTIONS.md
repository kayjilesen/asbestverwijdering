# Mobiele Menu Styling - Implementatie Instructies

## Overzicht
Deze instructies beschrijven hoe je de mobiele menu styling implementeert met de volgende features:
- Menu items gebruiken Title font (TGS)
- Scheidslijntjes tussen parent menu items
- Chevron correct gepositioneerd rechts naast menu tekst
- Submenu items gebruiken normaal font (Karla)
- Minder witruimte tussen submenu items
- Geen desktop menu border/hover effecten op mobiel

## Stap 1: PHP Aanpassing - Chevron Positionering

**Bestand:** `inc/custom-header.php` (of waar je menu functies staan)

**Wijziging:** Pas de chevron functie aan zodat de chevron voor het mobiele menu **binnen** de `<a>` tag komt, en voor desktop **na** de `</a>` tag.

```php
function kj_add_chevron_to_menu_item($item_output, $item, $depth, $args) {
    $chevron_icon = '<div class="chevron-wrapper"><svg class="w-6 h-6 lg:w-4 lg:h-4 lg:ml-1 duration-300 ease-in-out" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M7.41 7.84L12 12.42l4.59-4.58L18 9.25l-6 6-6-6z"/></svg></div>';

    if (in_array('menu-item-has-children', $item->classes)) {
        // For mobile menu, place chevron inside the <a> tag
        if ($args->theme_location == 'mobile-menu') {
            $item_output = str_replace('</a>', $chevron_icon . '</a>', $item_output);
        } else {
            // For desktop menu, keep chevron after </a>
            $item_output = str_replace('</a>','</a>' . $chevron_icon, $item_output);
        }
    }

    return $item_output;
}
```

**Belangrijk:** Vervang `'mobile-menu'` met de naam van jouw mobiele menu theme location.

## Stap 2: CSS Aanpassingen

**Bestand:** `assets/css/header.css` (of waar je header styles staan)

### 2.1 Desktop Menu Styles Specifieker Maken

Zorg ervoor dat desktop menu styles alleen van toepassing zijn op het desktop menu, niet op mobiel:

```css
/* Basic UL / LI - Desktop menu only */
header .primary-menu {
    @apply flex flex-col lg:flex-row items-center py-1 h-full gap-0;
}
header .primary-menu li.menu-item {
    @apply font-semibold font-serif font-sans text-sm duration-300 transition relative;
}
header.color .primary-menu li.menu-item {
    @apply text-grey-dark;
}
header .primary-menu li.menu-item a {
    @apply py-2.5 px-3 flex flex-row items-center duration-300 rounded transition-colors border border-beige;
}
header .primary-menu li.menu-item a:hover {
    @apply bg-beige-darker border-grey-dark/10;
}
header.color .primary-menu li.menu-item a {
    @apply text-grey-dark;
}
header .primary-menu li.menu-item-has-children {
    @apply flex flex-row items-center;
}
```

**Belangrijk:** Vervang `.primary-menu` met de class van jouw desktop menu.

### 2.2 Mobiele Menu Styles

Voeg deze CSS toe voor het mobiele menu (pas selectors aan naar jouw structuur):

```css
/* Override desktop menu styles for mobile menu */
#mobile-menu .menu {
    @apply w-full gap-0 !important;
}
#mobile-menu * {
    pointer-events: auto;
}
#mobile-menu .menu-item-has-children:hover {
    pointer-events: auto;
}
#mobile-menu ul.menu {
    @apply flex flex-col gap-0 items-stretch py-0 h-auto;
}
#mobile-menu ul {
    @apply flex flex-col w-full gap-0;
}

/* Parent menu items only - with divider between them */
#mobile-menu ul.menu > li.menu-item {
    @apply py-2 w-full border-b border-grey-dark/10 last:border-b-0 gap-0;
}

/* All menu items - title font */
#mobile-menu ul li.menu-item {
    @apply py-2 w-full gap-0;
}

/* Menu items without children - full width */
#mobile-menu ul li.menu-item:not(.menu-item-has-children) a {
    @apply text-grey-dark font-title uppercase font-bold text-2xl py-2.5 px-0 flex items-center w-full;
    gap: 0 !important;
    border: none !important;
}

/* Menu items with children - flex layout */
#mobile-menu ul li.menu-item a {
    @apply text-grey-dark font-title uppercase font-bold text-2xl py-2.5 px-0 flex items-center;
    gap: 0 !important;
    border: none !important;
    flex: 1;
    min-width: 0;
}

#mobile-menu ul li.menu-item a:hover {
    @apply bg-transparent;
    border: none !important;
}

#mobile-menu ul li.menu-item .chevron-wrapper {
    @apply w-8 h-8 bg-primary flex items-center justify-center flex-shrink-0 cursor-pointer;
    flex-shrink: 0 !important;
}

#mobile-menu ul li.menu-item svg {
    @apply inline-block fill-grey-dark transition-transform duration-300;
}

/* Menu items with children - layout */
#mobile-menu ul li.menu-item-has-children {
    @apply flex flex-col w-full !relative;
}

#mobile-menu ul li.menu-item-has-children > a {
    @apply flex items-center justify-between w-full;
    gap: 0 !important;
    order: 1;
}

#mobile-menu ul li.menu-item-has-children > a .chevron-wrapper {
    @apply ml-2 flex-shrink-0;
}

#mobile-menu ul li.menu-item-has-children > a .chevron-wrapper svg {
    @apply rotate-0;
}

/* Submenu styling */
#mobile-menu ul li.menu-item :is(ul.sub-menu, ul.children) {
    @apply relative w-full flex flex-col h-0 overflow-hidden transition-all duration-300 ease-in-out pl-2 mt-2 gap-0;
    position: relative !important;
    top: auto !important;
    left: auto !important;
    right: auto !important;
    transform: none !important;
    clear: both !important;
    width: 100% !important;
    margin-top: 0.5rem !important;
    order: 999;
}

/* Submenu items - normal font, less spacing */
#mobile-menu ul li.menu-item :is(ul.sub-menu, ul.children) li.menu-item a {
    @apply text-grey-dark font-sans font-semibold text-base py-1;
    border: none !important;
    text-transform: none;
}

#mobile-menu ul li.menu-item :is(ul.sub-menu, ul.children) li.menu-item a:hover {
    @apply bg-transparent;
    border: none !important;
}

/* Open state */
#mobile-menu ul li.menu-item-has-children.open :is(ul.sub-menu, ul.children) {
    @apply h-auto opacity-100;
}

#mobile-menu ul li.menu-item-has-children.open > a .chevron-wrapper svg {
    @apply rotate-180;
}
```

## Stap 3: Aanpassen aan Jouw Project

### 3.1 Selectors Aanpassen

Vervang de volgende selectors met die van jouw project:
- `#mobile-menu` → Jouw mobiele menu container ID/class
- `.primary-menu` → Jouw desktop menu class
- `font-title` → Jouw Title font class (TGS in dit project)
- `font-sans` → Jouw normale font class (Karla in dit project)
- `border-grey-dark/10` → Jouw border color
- `bg-primary` → Jouw chevron achtergrond kleur

### 3.2 Kleuren Aanpassen

Pas de kleuren aan naar jouw design system:
- `text-grey-dark` → Jouw tekst kleur
- `bg-primary` → Jouw chevron achtergrond
- `border-grey-dark/10` → Jouw border kleur

### 3.3 Font Sizes Aanpassen

Pas font sizes aan indien nodig:
- Parent items: `text-2xl` (1.5rem)
- Submenu items: `text-base` (1rem)

### 3.4 Spacing Aanpassen

Pas spacing aan indien nodig:
- Parent items padding: `py-2.5` (0.625rem)
- Submenu items padding: `py-1` (0.25rem)
- Border tussen items: `border-b border-grey-dark/10`

## Stap 4: Testen

Test de volgende scenario's:
1. ✅ Menu items gebruiken Title font
2. ✅ Scheidslijntjes tussen parent items
3. ✅ Chevron staat rechts naast menu tekst
4. ✅ Chevron draait bij openen/sluiten submenu
5. ✅ Submenu items gebruiken normaal font
6. ✅ Submenu komt onder parent item (niet erdoorheen)
7. ✅ Geen desktop border/hover op mobiel
8. ✅ Minder witruimte tussen submenu items

## Belangrijke Punten

1. **Chevron Positionering**: Voor mobiel moet de chevron **binnen** de `<a>` tag staan, voor desktop **na** de `</a>` tag.

2. **Desktop vs Mobile**: Zorg dat desktop menu styles specifiek genoeg zijn (gebruik `.primary-menu` of vergelijkbaar) zodat ze niet op mobiel worden toegepast.

3. **Flex Layout**: Items met children gebruiken `flex-col` op de parent `li`, en `justify-between` op de `<a>` tag om chevron rechts te positioneren.

4. **Submenu Order**: Gebruik `order: 999` op submenu en `order: 1` op de `<a>` tag om ervoor te zorgen dat submenu onder komt.

5. **Font Classes**: Zorg dat `font-title` en `font-sans` classes bestaan in jouw Tailwind config of pas aan naar jouw font classes.

## Troubleshooting

**Chevron staat verkeerd:**
- Controleer of chevron binnen `<a>` tag staat voor mobiel menu
- Controleer `justify-between` op de `<a>` tag
- Controleer `flex-shrink-0` op chevron-wrapper

**Submenu komt erdoorheen:**
- Controleer `flex-col` op parent `li`
- Controleer `order` properties
- Controleer `position: relative` op submenu

**Desktop styles op mobiel:**
- Maak desktop selectors specifieker (gebruik `.primary-menu` of vergelijkbaar)
- Voeg `!important` toe aan mobiele menu overrides waar nodig

**Fonts werken niet:**
- Controleer of `font-title` en `font-sans` bestaan in Tailwind config
- Controleer of fonts correct zijn geladen
