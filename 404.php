<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Perlemedia
 */

get_header();
?>
        <main id="content" class="site-main error-404">
            <div class="site-container">

            <?php
            while ( have_posts() ) :
                the_post();

                get_template_part( 'template-parts/includes/content', 'page' );

                // If comments are open or we have at least one comment, load up the comment template.
                if ( comments_open() || get_comments_number() ) :
                    comments_template();
                endif;

            endwhile; // End of the loop.
            ?>

            </div><!-- .site-container -->
        </main><!-- #content -->


<?php
get_footer();
