<?php
/**
 * PerleMedia functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package PerleMedia
 */


/*******************************
** Underscore Theme Functions **
*******************************/

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

// Sets up theme defaults and registers support for various WordPress features.
function perlemedia_setup() {

	// Make theme available for translation.
	load_theme_textdomain( 'perlemedia', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Let WordPress manage the document title.
	add_theme_support( 'title-tag' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'main-menu' => esc_html__( 'Primary', 'perlemedia' ),
		)
	);
	
	// Switch default core markup to output valid HTML5.
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Enable support for Post Thumbnails on posts and pages.
	// @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	add_theme_support( 'post-thumbnails' );

	// Add support for core custom logo.
	// @link https://codex.wordpress.org/Theme_Logo
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'perlemedia_setup' );

// Custom template tags for this theme.
require get_template_directory() . '/inc/template-tags.php';

// Load Jetpack compatibility file.
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

// Set the content width in pixels, based on the theme's design and stylesheet.
// @global int $content_width
function perlemedia_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'perlemedia_content_width', 640 );
}
add_action( 'after_setup_theme', 'perlemedia_content_width', 0 );

/*******************************
**** Begin Custom Functions ****
*******************************/

/** 
 * Enqueue scripts and styles.
 */
function perlemedia_scripts() {
	// CSS
	wp_enqueue_style( 'perlemedia-style', get_stylesheet_uri(), array(), _S_VERSION );
	
	// JS
	wp_enqueue_script( 'perlemedia-js', get_template_directory_uri() . '/js/script.js', array(), _S_VERSION, true );

	// GSAP
	wp_enqueue_script('gsap-js', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.6.1/gsap.min.js', array(), false, true);
    wp_enqueue_script('scrollTrigger-js', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.6.1/ScrollTrigger.min.js', array(), false, true);
    wp_enqueue_script('splitText-js', get_template_directory_uri() . '/js/splittext.js', array(), false, true );
    wp_enqueue_script('gsapCustom-js', get_template_directory_uri() . '/js/gsap-js.js', array('gsap-js', 'scrollTrigger-js', 'jquery'), false, true );
	
	// Comments
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'perlemedia_scripts' );


/**
 * Add scripts to header
 */
function perlemedia_add_header() { ?>
    
<?php }
//add_action('wp_head', 'perlemedia_add_header');

/**
 * Add scripts after opening body tag
 */
function perlemedia_add_body() { ?>

<?php }
//add_action('wp_body_open', 'perlemedia_add_body');

/**
 * Add scripts to footer
 */
function perlemedia_add_footer() { ?>

<?php }
//add_action('wp_footer', 'perlemedia_add_footer');


/**
 * Declare WooCommerce support
 */
function perlemedia_add_woocommerce_support() {
    add_theme_support( 'woocommerce' );
}
//add_action( 'after_setup_theme', 'perlemedia_add_woocommerce_support' );

/** 
 * Register widget area.
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function perlemedia_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'perlemedia' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'perlemedia' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'perlemedia_widgets_init' );


/**
 * Enable SVG Upload
 */
function codeless_file_types_to_uploads($file_types){
	$new_filetypes = array();
	$new_filetypes['svg'] = 'image/svg+xml';
	$file_types = array_merge($file_types, $new_filetypes );
	return $file_types;
	}
add_filter('upload_mimes', 'codeless_file_types_to_uploads');


/**
 * Custom Post Types
 */
add_action('init', 'new_post_types');

function new_post_types(){

	// Recipes
	register_post_type('recipes',
		array(
			'labels' => array(
				'name' => __('Recipes', 'perlemedia-theme'),
				'singular_name' => __('Recipe', 'perlemedia-theme'),
				'add_new_item' => 'Add New',
				'menu_name' => 'Recipes'
			),
			'public' => true,
			'public_queryable' => true,
			'has_archive' => false,
			'supports' => array('thumbnail','title','editor'),
			'rewrite' => array('slug' => 'recipes'),
			'menu_icon' => 'dashicons-food',
			'description' => 'Recipe cards',
            'menu_position' => 4
		)
	);
}

/**
 * Custom Taxonomies
 */
function add_custom_taxonomies() {
	
	register_taxonomy('recipe-ingredients', 'recipes', array(
		'hierarchical' => true,
		'labels' => array(
			'name' => _x( 'Ingredients', 'taxonomy general name' ),
			'singular_name' => _x( 'Ingredients', 'taxonomy singular name' ),
			'search_items' =>  __( 'Search Ingredients' ),
			'all_items' => __( 'All Ingredients' ),
			'parent_item' => __( 'Ingredient Type' ),
			'parent_item_colon' => __( 'Ingredient Type:' ),
			'edit_item' => __( 'Edit Ingredient' ),
			'update_item' => __( 'Update Ingredient' ),
			'add_new_item' => __( 'Add New Ingredient' ),
			'new_item_name' => __( 'New Ingredient Name' ),
			'menu_name' => __( 'Ingredients' ),
		),
		'rewrite' => array(
			'slug' => 'recipe-ingredients', 
			'with_front' => false, 
			'hierarchical' => true 
		),
	));

	register_taxonomy('recipe-cuisines', 'recipes', array(
		'hierarchical' => true,
		'labels' => array(
			'name' => _x( 'Cuisines', 'taxonomy general name' ),
			'singular_name' => _x( 'Cuisine', 'taxonomy singular name' ),
			'search_items' =>  __( 'Search Cuisines' ),
			'all_items' => __( 'All Cuisines' ),
			'parent_item' => __( 'Cuisine Category' ),
			'parent_item_colon' => __( 'Cuisine Category:' ),
			'edit_item' => __( 'Edit Cuisine' ),
			'update_item' => __( 'Update Cuisine' ),
			'add_new_item' => __( 'Add New Cuisine' ),
			'new_item_name' => __( 'New Cuisine Name' ),
			'menu_name' => __( 'Cuisines' ),
		),
		'rewrite' => array(
			'slug' => 'recipe-cuisines', 
			'with_front' => false, 
			'hierarchical' => true 
		),
	));

	register_taxonomy('recipe-courses', 'recipes', array(
	  'hierarchical' => false,
	  'labels' => array(
		'name' => _x( 'Courses', 'taxonomy general name' ),
		'singular_name' => _x( 'Course', 'taxonomy singular name' ),
		'search_items' =>  __( 'Search Courses' ),
		'all_items' => __( 'All Courses' ),
		'edit_item' => __( 'Edit Course' ),
		'update_item' => __( 'Update Course' ),
		'add_new_item' => __( 'Add New Course' ),
		'new_item_name' => __( 'New Course Name' ),
		'menu_name' => __( 'Courses' ),
	  ),
	  'rewrite' => array(
		'slug' => 'recipe-courses', 
		'with_front' => false, 
		'hierarchical' => true 
	  ),
	));

	register_taxonomy('recipe-diets', 'recipes', array(
	  'hierarchical' => false,
	  'labels' => array(
		'name' => _x( 'Diets', 'taxonomy general name' ),
		'singular_name' => _x( 'Diet', 'taxonomy singular name' ),
		'search_items' =>  __( 'Search Diets' ),
		'all_items' => __( 'All Diets' ),
		'edit_item' => __( 'Edit Diet' ),
		'update_item' => __( 'Update Diet' ),
		'add_new_item' => __( 'Add New Diet' ),
		'new_item_name' => __( 'New Diet Name' ),
		'menu_name' => __( 'Diets' ),
	  ),
	  'rewrite' => array(
		'slug' => 'recipe-diets', 
		'with_front' => false, 
		'hierarchical' => true 
	  ),
	));

	register_taxonomy('recipe-tags', 'recipes', array(
	  'hierarchical' => false,
	  'labels' => array(
		'name' => _x( 'Tags', 'taxonomy general name' ),
		'singular_name' => _x( 'Tag', 'taxonomy singular name' ),
		'search_items' =>  __( 'Search Tags' ),
		'all_items' => __( 'All Tags' ),
		'edit_item' => __( 'Edit Tag' ),
		'update_item' => __( 'Update Tag' ),
		'add_new_item' => __( 'Add New Tag' ),
		'new_item_name' => __( 'New Tag Name' ),
		'menu_name' => __( 'Tags' ),
	  ),
	  'rewrite' => array(
		'slug' => 'recipe-tags', 
		'with_front' => false, 
		'hierarchical' => true 
	  ),
	));
}
add_action( 'init', 'add_custom_taxonomies', 0 );

/**
 * Custom login page logo
 */
function customLoginLogo()
{
echo '<style type="text/css"> h1 a {  background-image:url("https://perlemedia.com/wp-content/uploads/2019/01/perlemedia-logo.png") !important; height:73px!important;
		width:300px!important;
		background-size: 300px 73px!important;
		background-repeat: no-repeat!important; } </style>';
}
add_action('login_head',  'customLoginLogo');
function customLoginLogoURL() {
    return 'https://perlemedia.com';
}
add_filter( 'login_headerurl', 'customLoginLogoURL' );
function customLoginLogoTitle() {
    return 'PerleMedia Website Design & Development';
}
add_filter( 'login_headertitle', 'customLoginLogoTitle' );



/**
 * Disable ACF Pro Update Notifications
 */
add_filter('site_transient_update_plugins', 'my_remove_update_nag');
function my_remove_update_nag($value) {
	unset($value->response[ 'advanced-custom-fields-pro/acf.php' ]);
	return $value;
}


/**
 * ACF Options Pages
 */
if( function_exists('acf_add_options_page') ) {

	acf_add_options_page(array(
		'page_title' 	=> 'Homepage Fields',
		'menu_title'	=> 'Homepage',
		'menu_slug' 	=> 'home-section',
		'icon_url' 		=> 'dashicons-admin-home',
		'position' 		=> 4,
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));	

	acf_add_options_page(array(
		'page_title' 	=> 'Site Branding',
		'menu_title'	=> 'Site Branding',
		'menu_slug' 	=> 'branding-section',
		'icon_url' 		=> 'dashicons-art',
		'position' 		=> 2,
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));	
}


/**
 * Register ACF Gutengerg Blocks (Flex Content)
 */

if (function_exists('acf_register_block_type')) {
    add_action('acf/init', 'register_acf_block_types');
}

function register_acf_block_types() {
    wp_register_style('acf-block-styles', get_template_directory_uri() . '/inc/custom-gutenberg-styles.css', false);
    acf_register_block_type(
        array(
            'name' => 'premade-layouts',
            'title' => __('Premade Layouts'),
            'description' => __('ACF blocks for Gutenberg'),
            'render_template' => 'template-parts/blocks/index.php',
            'icon' => 'schedule',
            'keywords' => array( 'premade', 'layout' ),  
            'style_handle' => 'acf-block-styles'    
        )
    );
}

// Stylesheet for displaying custom Gutenberg blocks
add_action('init', function() {
	wp_register_style('acf-block-styles', get_template_directory_uri() . '/css/custom-gutenberg-styles.scss', false);
	register_block_style('core/acf-premade-layouts', [
		'name' => 'premade-layouts',
		'style_handle' => 'acf-block-styles'
	]);
});

// Get the template part for flex content
function get_the_right_row($name){
	$template_path = "template-parts/blocks/" . $name;
    get_template_part($template_path);
}

/**
 * Register SASS variables from PHP
 */
function generate_options_css() {
    $ss_dir = get_stylesheet_directory();
    ob_start(); 
    require($ss_dir . '/inc/sass_variables.php'); 
    $css = ob_get_clean(); 
    file_put_contents($ss_dir . '/sass/variables/_colors.scss', $css, LOCK_EX); 
}
add_action( 'acf/save_post', 'generate_options_css', 20 ); 

/**
 * Hide SCSS Compiler from plugins list in Dashboard
 */
function hide_SCSSCompiler() {
	global $wp_list_table;
	$hidearr = array('scss-compiler/scss-compiler.php');
	$myplugins = $wp_list_table->items;
	foreach ($myplugins as $key => $val) {
	  if (in_array($key,$hidearr)) {
		unset($wp_list_table->items[$key]);
		echo '<div>SCSS Compiler plugin hidden from list.</div>';
	  }
	}
  }
  
add_action('pre_current_active_plugins', 'hide_SCSSCompiler');


function array_count_values_of($value, $array) {
	$counts = array_count_values($array);
	return $counts[$value];
}