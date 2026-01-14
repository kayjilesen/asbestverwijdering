<?php 

    /*
        Template name: Text
    */

    get_header(); 

?>

<main class="bg-white">

    <!-- Hero Section -->
    <section class="text-hero relative overflow-hidden bg-secondary">
        <div class="text-hero__container container relative z-10">
            <div class="text-hero__content text-white py-20 lg:py-32">
                <h1 class="text-hero__title text-2xl md:text-3xl lg:text-5xl font-serif font-medium mb-6 !leading-[1.25] text-center"><?php echo wp_kses_post( get_the_title() ); ?></h1>
            </div>
        </div>
    </section>

    <!-- Content Section -->
    <section class="text-content w-full bg-white py-16 lg:py-24">
        <div class="container relative z-[1]">
            <div class="text-content__wrapper mx-auto w-full max-w-screen-lg prose prose-lg max-w-none">
                <?php 
                while ( have_posts() ) :
                    the_post();
                    // Render Gutenberg blocks and process shortcodes
                    $content = get_the_content();
                    $content = apply_filters( 'the_content', $content );
                    $content = str_replace( ']]>', ']]&gt;', $content );
                    echo $content;
                endwhile;
                ?>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>