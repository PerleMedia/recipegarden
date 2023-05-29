<?php
/**
 * The template for displaying all pages
 */

get_header();
?>

	<main id="content" class="site-main page">
		<div class="site-container">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/includes/content', 'page' );

		endwhile; 
		?>

		</div><!-- .site-container -->
	</main><!-- #content -->

<?php
get_footer();
