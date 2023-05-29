<?php
/**
 * The template for displaying all single posts
 */

get_header();
?>

	<main id="content" class="site-main single-post">
		<div class="site-container">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/includes/content', get_post_type() );

			the_post_navigation(
				array(
					'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'perlemedia' ) . '</span> <span class="nav-title">%title</span>',
					'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'perlemedia' ) . '</span> <span class="nav-title">%title</span>',
				)
			);

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>
		
		</div><!-- .site-container -->
	</main><!-- #main -->

<?php
get_footer();
