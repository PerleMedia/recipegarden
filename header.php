<?php
/**
 * Template for the site header
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * @package PerleMedia
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'perlemedia' ); ?></a>

	<header id="header" class="site-header">
		<div class="site-container">
			
			<div id="site-branding">
				<?php if(the_custom_logo()) : the_custom_logo(); else : ?>
				<h1 class="site-title sub-heading"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php endif; ?>
				</div><!-- #site-branding -->

			<nav id="site-navigation" class="main-navigation">
			<button id="menu-toggle" aria-controls="primary-menu" aria-expanded="false" onclick="menuToggle()"><span class="hamburger"></span></button>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'main-menu',
						'menu_id'        => 'primary-menu',
					)
				);
				?>
			</nav><!-- #site-navigation -->

		</div><!-- .site-container -->
	</header><!-- #header -->
