<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package PerleMedia
 */

?>

	<footer id="footer" class="site-footer">
		<section id="footer-main">
			<div class="site-container">
				
			</div><!-- .site-container -->
		</section><!-- #footer-main -->

		<section id="footer-socket">
			<div class="site-container">
				<div class="site-info">
					<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'perlemedia' ) ); ?>">
						<?php
						/* translators: %s: CMS name, i.e. WordPress. */
						printf( esc_html__( 'Proudly powered by %s', 'perlemedia' ), 'WordPress' );
						?>
					</a>
					<span class="sep"> | </span>
						<?php
						/* translators: 1: Theme name, 2: Theme author. */
						printf( esc_html__( 'Theme: %1$s by %2$s.', 'perlemedia' ), 'perlemedia', '<a href="http://underscores.me/">Underscores.me</a>' );
						?>
				</div><!-- .site-info -->
				
			</div><!-- .site-container -->
		</section><!-- #footer-main -->
	</footer><!-- #footer -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
