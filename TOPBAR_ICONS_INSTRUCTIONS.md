# Topbar Iconen en Dividers - Implementatie Instructies

## Overzicht
Deze instructies beschrijven hoe je telefoon- en email-iconen met dividers toevoegt aan een topbar in een WordPress theme.

## Iconen

### Telefoon Icoon
```svg
<svg width="12" height="12" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg" class="fill-current">
    <path d="M1.56617 3.3703C2.18918 4.59468 3.19291 5.59842 4.4173 6.22142L5.36911 5.26961C5.49026 5.14847 5.65899 5.11386 5.81041 5.16145C6.29497 5.32152 6.81415 5.40805 7.35495 5.40805C7.4697 5.40805 7.57974 5.45364 7.66088 5.53477C7.74201 5.61591 7.7876 5.72595 7.7876 5.8407V7.35495C7.7876 7.4697 7.74201 7.57974 7.66088 7.66088C7.57974 7.74201 7.4697 7.7876 7.35495 7.7876C5.4043 7.7876 3.53354 7.0127 2.15422 5.63338C0.774894 4.25406 0 2.3833 0 0.432644C0 0.3179 0.045582 0.207855 0.126719 0.126719C0.207855 0.045582 0.3179 0 0.432644 0H1.9469C2.06164 0 2.17169 0.045582 2.25282 0.126719C2.33396 0.207855 2.37954 0.3179 2.37954 0.432644C2.37954 0.97345 2.46607 1.49262 2.62615 1.97718C2.67374 2.12861 2.63913 2.29734 2.51799 2.41848L1.56617 3.3703Z"/>
</svg>
```

### Email Icoon
```svg
<svg width="12" height="12" viewBox="0 0 10 8" fill="none" xmlns="http://www.w3.org/2000/svg" class="fill-current">
    <path d="M8.24552 1.83234L4.58084 4.12276L0.916169 1.83234V0.916169L4.58084 3.20659L8.24552 0.916169V1.83234ZM8.24552 0H0.916169C0.407695 0 0 0.407695 0 0.916169V6.41318C0 6.65616 0.0965246 6.8892 0.26834 7.06101C0.440155 7.23283 0.673186 7.32935 0.916169 7.32935H8.24552C8.4885 7.32935 8.72153 7.23283 8.89335 7.06101C9.06516 6.8892 9.16169 6.65616 9.16169 6.41318V0.916169C9.16169 0.407695 8.74941 0 8.24552 0Z"/>
</svg>
```

## Divider (Streepje)
```html
<span class="h-4 w-px bg-white/30"></span>
```

## Complete PHP/HTML Structuur

### Belangrijke punten:
1. **Iconen gebruiken `fill-current`** - Dit zorgt ervoor dat het icoon de tekstkleur overneemt en bij hover geel wordt
2. **Links hebben `flex items-center gap-2`** - Voor correcte uitlijning tussen icoon en tekst
3. **Dividers zijn 1px breed (`w-px`) en 16px hoog (`h-4`)**
4. **Dividers hebben semi-transparante witte kleur (`bg-white/30`)**
5. **Dividers worden alleen getoond tussen items die daadwerkelijk bestaan**

### PHP Code Structuur:

```php
<div class="container w-full flex justify-end items-center text-white text-xs px-4 lg:px-0">
    <div class="flex items-center gap-4 lg:gap-6">
    <?php 
    // Haal telefoon en email op (pas aan naar jouw ACF field names)
    $phone = get_field( 'phone', 'option' ) ?: get_field( 'telefoon', 'option' );
    $email = get_field( 'email', 'option' );
    
    // Telefoon link met icoon
    if ( $phone ) : 
    ?>
        <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>" class="text-white hover:text-yellow transition-colors flex items-center gap-2">
            <svg width="12" height="12" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg" class="fill-current">
                <path d="M1.56617 3.3703C2.18918 4.59468 3.19291 5.59842 4.4173 6.22142L5.36911 5.26961C5.49026 5.14847 5.65899 5.11386 5.81041 5.16145C6.29497 5.32152 6.81415 5.40805 7.35495 5.40805C7.4697 5.40805 7.57974 5.45364 7.66088 5.53477C7.74201 5.61591 7.7876 5.72595 7.7876 5.8407V7.35495C7.7876 7.4697 7.74201 7.57974 7.66088 7.66088C7.57974 7.74201 7.4697 7.7876 7.35495 7.7876C5.4043 7.7876 3.53354 7.0127 2.15422 5.63338C0.774894 4.25406 0 2.3833 0 0.432644C0 0.3179 0.045582 0.207855 0.126719 0.126719C0.207855 0.045582 0.3179 0 0.432644 0H1.9469C2.06164 0 2.17169 0.045582 2.25282 0.126719C2.33396 0.207855 2.37954 0.3179 2.37954 0.432644C2.37954 0.97345 2.46607 1.49262 2.62615 1.97718C2.67374 2.12861 2.63913 2.29734 2.51799 2.41848L1.56617 3.3703Z"/>
            </svg>
            <?php echo esc_html( $phone ); ?>
        </a>
        <?php if ( $email ) : ?>
            <span class="h-4 w-px bg-white/30"></span>
        <?php endif; ?>
    <?php endif; ?>
    
    <?php 
    // Email link met icoon
    if ( $email ) : 
    ?>
        <a href="mailto:<?php echo esc_attr( $email ); ?>" class="text-white hover:text-yellow transition-colors flex items-center gap-2">
            <svg width="12" height="12" viewBox="0 0 10 8" fill="none" xmlns="http://www.w3.org/2000/svg" class="fill-current">
                <path d="M8.24552 1.83234L4.58084 4.12276L0.916169 1.83234V0.916169L4.58084 3.20659L8.24552 0.916169V1.83234ZM8.24552 0H0.916169C0.407695 0 0 0.407695 0 0.916169V6.41318C0 6.65616 0.0965246 6.8892 0.26834 7.06101C0.440155 7.23283 0.673186 7.32935 0.916169 7.32935H8.24552C8.4885 7.32935 8.72153 7.23283 8.89335 7.06101C9.06516 6.8892 9.16169 6.65616 9.16169 6.41318V0.916169C9.16169 0.407695 8.74941 0 8.24552 0Z"/>
            </svg>
            <?php echo esc_html( $email ); ?>
        </a>
        <span class="h-4 w-px bg-white/30"></span>
    <?php endif; ?>
    
    <?php
    // Vacatures link met badge
    // Pas 'vacature' aan naar jouw post type naam indien anders
    $vacatures_count = wp_count_posts( 'vacature' )->publish;
    $vacatures_url = get_post_type_archive_link( 'vacature' );
    if ( $vacatures_url && $vacatures_count > 0 ) :
    ?>
        <a href="<?php echo esc_url( $vacatures_url ); ?>" class="text-white hover:text-yellow transition-colors relative inline-block">
            <?php _e( 'Bekijk onze vacatures', 'kj' ); ?>
            <span class="absolute -top-1.5 -right-2 bg-yellow text-grey-dark text-xs font-bold rounded-full min-w-[20px] h-5 flex items-center justify-center leading-none px-1"><?php echo esc_html( $vacatures_count ); ?></span>
        </a>
        <span class="h-4 w-px bg-white/30"></span>
    <?php endif; ?>
    
    <!-- Particulier / Zakelijk Switch met label -->
    <span class="text-white text-xs"><?php _e( 'Wissel naar:', 'kj' ); ?></span>
    <div class="topbar-switch flex items-center border border-white/30 px-1 py-1 rounded-[0px]">
        <?php
        $zakelijk_link = get_field( 'topbar_zakelijk_link', 'option' );
        ?>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>"
           class="topbar-switch-item topbar-switch-particulier px-3 py-1 bg-white text-grey text-xs transition-colors">
            <?php _e( 'Particulier', 'kj' ); ?>
        </a>
        <a href="<?php echo esc_url( $zakelijk_link ?: '#' ); ?>"
           class="topbar-switch-item topbar-switch-zakelijk px-3 py-1 text-white text-xs transition-colors <?php echo !$zakelijk_link ? 'pointer-events-none opacity-50' : ''; ?>"
           <?php echo $zakelijk_link ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>>
            <?php _e( 'Zakelijk', 'kj' ); ?>
        </a>
    </div>
    </div>
</div>
```

## Tailwind CSS Classes Gebruikt

### Voor Container:
- `text-xs` - Extra kleine tekstgrootte (12px / 0.75rem) - **BELANGRIJK: Alle tekst in de topbar gebruikt deze grootte**

### Voor Links:
- `flex items-center gap-2` - Flexbox layout met items gecentreerd en 8px gap tussen icoon en tekst
- `text-white hover:text-yellow` - Witte tekst die geel wordt bij hover
- `transition-colors` - Smooth kleur transitie bij hover
- Links nemen automatisch `text-xs` over van de container

### Voor Iconen:
- `fill-current` - Neemt de huidige tekstkleur over (wit, wordt geel bij hover)
- `width="12" height="12"` - Icoon grootte (12x12 pixels)

### Voor Dividers:
- `h-4` - Hoogte van 16px (1rem)
- `w-px` - Breedte van 1px
- `bg-white/30` - Semi-transparante witte achtergrond (30% opacity)

### Voor Vacatures Badge:
- `relative inline-block` - Relatieve positioning voor de link container
- `absolute -top-1.5 -right-2` - Absolute positioning rechtsboven van de link
- `bg-yellow` - Gele achtergrondkleur
- `text-grey-dark` - Donkergrijze tekstkleur
- `text-xs` - Extra kleine tekstgrootte (12px)
- `font-bold` - Vetgedrukte tekst
- `rounded-full` - Volledig ronde badge
- `min-w-[20px]` - Minimale breedte van 20px
- `h-5` - Hoogte van 20px (1.25rem)
- `flex items-center justify-center` - Flexbox voor centrering van tekst
- `leading-none` - Geen line-height voor compacte weergave
- `px-1` - Horizontale padding van 4px

### Voor Switch Label:
- `text-white` - Witte tekstkleur
- `text-xs` - Extra kleine tekstgrootte (12px / 0.75rem)

## Aanpassingen voor Andere Sites

### Als je andere ACF field names gebruikt:
Pas deze regels aan:
```php
$phone = get_field( 'jouw_telefoon_field', 'option' );
$email = get_field( 'jouw_email_field', 'option' );
```

### Als je andere kleuren gebruikt:
Pas de classes aan:
- `text-white` → jouw tekstkleur class
- `hover:text-yellow` → jouw hover kleur class
- `bg-white/30` → jouw divider kleur met opacity

### Als je geen Tailwind gebruikt:
Gebruik deze CSS in plaats van Tailwind classes:
```css
.topbar-link {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: white;
    transition: color 0.3s ease;
}

.topbar-link:hover {
    color: #FFD500; /* of jouw hover kleur */
}

.topbar-icon {
    width: 12px;
    height: 12px;
    fill: currentColor;
}

.topbar-divider {
    height: 16px;
    width: 1px;
    background-color: rgba(255, 255, 255, 0.3);
}
```

## Belangrijke Details

1. **Icoon grootte**: 12x12 pixels (width="12" height="12")
2. **ViewBox behouden**: De viewBox moet exact blijven zoals hierboven voor correcte weergave
3. **fill-current**: Dit is cruciaal - zorgt ervoor dat iconen de tekstkleur volgen
4. **Divider logica**: Dividers worden alleen getoond tussen items die bestaan
5. **Gap tussen items**: `gap-4 lg:gap-6` zorgt voor 16px op mobile en 24px op desktop tussen items

## Vacatures Badge

Voor de vacatures link wordt een geel badge met het aantal vacatures rechtsboven getoond:

```php
<?php
// Get vacatures count
$vacatures_count = wp_count_posts( 'vacature' )->publish;
$vacatures_url = get_post_type_archive_link( 'vacature' );
if ( $vacatures_url && $vacatures_count > 0 ) :
?>
    <a href="<?php echo esc_url( $vacatures_url ); ?>" class="text-white hover:text-yellow transition-colors relative inline-block">
        <?php _e( 'Bekijk onze vacatures', 'kj' ); ?>
        <span class="absolute -top-1.5 -right-2 bg-yellow text-grey-dark text-xs font-bold rounded-full min-w-[20px] h-5 flex items-center justify-center leading-none px-1"><?php echo esc_html( $vacatures_count ); ?></span>
    </a>
    <span class="h-4 w-px bg-white/30"></span>
<?php endif; ?>
```

**Belangrijke punten:**
- `wp_count_posts( 'vacature' )->publish` - Haalt het aantal gepubliceerde vacatures op
- `get_post_type_archive_link( 'vacature' )` - Haalt de archive URL op voor het post type
- Badge gebruikt `absolute` positioning met `-top-1.5 -right-2` voor rechtsboven plaatsing
- Badge heeft gele achtergrond (`bg-yellow`) en donkergrijze tekst (`text-grey-dark`)
- `min-w-[20px]` zorgt ervoor dat de badge minimaal 20px breed is voor kleine getallen
- `rounded-full` maakt de badge rond
- Badge wordt alleen getoond als er vacatures zijn (`$vacatures_count > 0`)

**Voor andere post types:**
Pas `'vacature'` aan naar jouw post type naam:
```php
$vacatures_count = wp_count_posts( 'jouw_post_type' )->publish;
$vacatures_url = get_post_type_archive_link( 'jouw_post_type' );
```

## Switch Label

Voor de particulier/zakelijk switch moet een label "Wissel naar:" worden toegevoegd:

```php
<span class="text-white text-xs"><?php _e( 'Wissel naar:', 'kj' ); ?></span>
```

Dit label staat vlak voor de switch en gebruikt:
- `text-white` - Witte tekstkleur
- `text-xs` - Extra kleine tekstgrootte (12px / 0.75rem)

**Belangrijk**: Het label moet vlak voor de switch div komen, binnen dezelfde flex container.

## Voorbeeld Output

De topbar ziet er zo uit:
```
[📞 Telefoon] | [✉️ Email] | [Bekijk onze vacatures 🔵] | Wissel naar: [Particulier] [Zakelijk]
```

Waar:
- `|` de dividers zijn (1px verticale streepjes)
- `🔵` het gele badge met aantal vacatures is (rechtsboven van de tekst)
