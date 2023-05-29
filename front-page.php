<?php
/**
 * The template for displaying the custom front page
 */

get_header();
?>

	<main id="content" class="site-main front-page">
		<div class="site-container">

		
		<div class="wrapper row cols-3">

			<?php
			$posts = get_posts([
				'post_type' => 'recipes',
				'post_status' => 'publish',
				'numberposts' => -1
				// 'order'    => 'ASC'
			]);

			

			foreach ($posts as $recipe){
				?>

					<a class="recipe-card" href="<?php echo get_permalink( $recipe->ID ) ?>">
						<h3><?php echo $recipe->post_title; ?></h3>
						<div class="wrapper">
							<div class="image-wrapper">
								<?php echo get_the_post_thumbnail($recipe->ID); ?>
								<div class="meta">
									<div class="calories">
										<span><?php echo get_field('calories', $recipe->ID); ?></span>
									</div>
								</div>
							</div>
							
						</div>
					</a>
				<?php
			}?>
		</div>

		</div><!-- .site-container -->
	</main><!-- #content -->

<?php
get_footer();
