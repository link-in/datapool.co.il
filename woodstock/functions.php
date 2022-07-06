<?php 



/**
 * Woodstock functions and definitions.
 *
 * Sets up the theme and provides some helper functions, which are used
 * in the theme. Others are attached to action and filter hooks in WordPress 
 * to change core functionality.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package WordPress
 * @subpackage Woodstock 
 * @since 1.0
 */
 

define('WOODSTOCK_OPTIONS_NAME', 'woodstock_options_theme_customizer');
define('WOODSTOCK_THEME_PATH', get_template_directory());
define('WOODSTOCK_INCLUDES', get_template_directory() . '/includes');
define('WOODSTOCK_FUNCTIONS', get_template_directory() . '/functions');
define('WOODSTOCK_FRAMEWORK', get_template_directory() . '/framework');
define('WOODSTOCK_THEME_URI', get_template_directory_uri());
define('WOODSTOCK_THEME_ENABLED', true);


include_once( WOODSTOCK_INCLUDES . '/custom_styles.php'); // Custom Styles
include_once( WOODSTOCK_FUNCTIONS . '/theme_options.php' ); // Theme Options
include_once( WOODSTOCK_FUNCTIONS . '/product-meta-box-data.php' ); // Product Meta Box
include_once( WOODSTOCK_FUNCTIONS . '/woo_options.php' ); // Woocommerce Options


/******************************************************************************/
/****** Plugin recommendations ************************************************/
/******************************************************************************/
if ( ! class_exists( 'TGM_Plugin_Activation' ) ) {
	require_once( get_template_directory() . '/includes/tgm/class-tgm-plugin-activation.php' );
	require_once( get_template_directory() . '/includes/tgm/plugins.php' );
}

require get_parent_theme_file_path( '/includes/merlin/vendor/autoload.php' );
if ( is_admin() ) {
	require get_parent_theme_file_path( '/includes/merlin/class-merlin.php' );
	require get_parent_theme_file_path( '/includes/merlin/includes/wizard-config.php' );
}

/******************************************************************************/
/****** Add Font Awesome to Redux *********************************************/
/******************************************************************************/

function woodstock_newIconFont() {

    wp_register_style(
        'redux-font-awesome',
        get_template_directory_uri() . '/fonts/fontawesome/font-awesome.min.css',
        array(),
        time(),
        'all'
    );  
    wp_enqueue_style( 'redux-font-awesome' );
}
add_action( 'redux/page/tdl_options/enqueue', 'woodstock_newIconFont' );

function woodstock_global_var(){
   global $tdl_options;
   return $tdl_options;
}


#-----------------------------------------------------------------#
# Redux Framework
#-----------------------------------------------------------------#

if ( !isset( $redux_demo ) && file_exists( WOODSTOCK_FUNCTIONS . '/framework/settings.php' ) ) {
    require_once( WOODSTOCK_FUNCTIONS . '/framework/settings.php' );
}

/*-----------------------------------------------------------------------------------*/
/* Revolution Slider set as Theme
/*-----------------------------------------------------------------------------------*/

add_action('acf/init', 'woodstock_cp_setup_acf_updates');
function woodstock_cp_setup_acf_updates() {
	acf_update_setting('show_updates', false);
}

add_action('vc_before_init', 'woodstock_vc_set_as_theme');
function woodstock_vc_set_as_theme() {
	if (function_exists( 'vc_manager' )){
		vc_manager()->disableUpdater(true);
		vc_manager()->setIsAsTheme(true);
	}

	vc_set_as_theme();
}

add_action( 'init', 'woodstock_set_revslider_as_theme' );
function woodstock_set_revslider_as_theme() {
	if ( ! function_exists( 'set_revslider_as_theme' )){ return; }
	set_revslider_as_theme();
}


/* ---------------------------------------------------------------- */
/* ACF theme fields
/* ---------------------------------------------------------------- */
require_once WOODSTOCK_THEME_PATH . '/autoimport/custom_metaboxes.php';

/* ---------------------------------------------------------------- */
/* Add ACF fallback
/* ---------------------------------------------------------------- */
if (! is_admin() && ! function_exists('get_field')) {
	function get_field($name) {
		return false;
	}
}


/* ---------------------------------------------------------------- */
/* Register Navigation
/* ---------------------------------------------------------------- */

register_nav_menu('main_navigation', 'Main Navigation');
register_nav_menu('top-bar-navigation', 'Top Bar Navigation');
register_nav_menu('myaccount-navigation', 'My Account Navigation');
register_nav_menu('footer-navigation', 'Footer Navigation');

add_filter('wp_nav_menu_args', 'woodstock_main_menu_args');

function woodstock_main_menu_args($args) {
	global $post;

	$c_pageID = '';

	if((get_option('show_on_front') && get_option('page_for_posts') && is_home()) ||
		(get_option('page_for_posts') && is_archive() && !is_post_type_archive())) {
		$c_pageID = get_option('page_for_posts');
	} else {
		if(isset($post)) {
			$c_pageID = $post->ID;
		}

		if(class_exists('Woocommerce')) {
			if(is_shop() || is_tax('product_cat') || is_tax('product_tag')) {
				$c_pageID = get_option('woocommerce_shop_page_id');
			}
		}
	}

	return $args;
}

/* ---------------------------------------------------------------- */
/* Initialize the mega menu framework
/* ---------------------------------------------------------------- */


	// Initialize the mega menu framework
	include_once( WOODSTOCK_FUNCTIONS . '/wstock-mega-menu-framework.php' ); // Woocommerce Options

	function woodstock_create_menu() {
		global $main_menu;

		$main_menu = wp_nav_menu(array(
				'theme_location'	=> 'main_navigation',
				'depth'				=> 5,
				'container' 		=> false,
				'menu_id' 			=> 'nav',
				'items_wrap' 		=> '%3$s',
				'menu_class'        => 'nav tdl-navbar-nav 222',
				'fallback_cb'       => 'tldCoreFrontendWalker::fallback',
				'walker'            => new tdlCoreFrontendWalker(),
				'echo' 				=> false
		));
	}


add_action( 'template_redirect', 'woodstock_create_menu' );

function woodstock_mega_menu() {
	global $main_menu;
	printf( '%s', $main_menu );
}


// **********************************************************************//
// Woodstock get theme info
// **********************************************************************//
if( ! function_exists( 'woodstock_get_theme_info' ) ) {
	function woodstock_get_theme_info( $parameter ) {
		$theme_info = wp_get_theme();
		if ( is_child_theme() ){
			$theme_info = wp_get_theme( $theme_info->parent()->template );
		}
		return $theme_info->get( $parameter );
	}
}

/*-----------------------------------------------------------------------------------*/
/*	Registers and loads styles
/*-----------------------------------------------------------------------------------*/


if ( ! function_exists('woodstock_theme_styles') ) :

	function woodstock_theme_styles () {

			global $tdl_options, $wp_styles;

			$theme_info = wp_get_theme();

			// Edit CSS within their files
			wp_register_style( 'stylesheet', get_stylesheet_uri(), array(), '1.0', 'all' );
			wp_register_style( 'wstock-app', get_template_directory_uri() .  "/css/app.css", array(), '1.0', 'all');

			wp_enqueue_style('tooltipster', get_template_directory_uri() . '/css/tooltipster.css', array(), '3.3.0', 'all' );
			wp_enqueue_style('easyzoom', get_template_directory_uri() . '/css/easyzoom.css', array(), '1.0', 'all' );
			wp_enqueue_style('swiper', get_template_directory_uri() . '/css/idangerous.swiper.css', array(), '2.5.1', 'all' );
			wp_enqueue_style('nanoscroller', get_template_directory_uri() . '/css/nanoscroller.css', array(), '0.7.6', 'all' );
			wp_enqueue_style('select2', get_template_directory_uri() . '/css/select2.css', array(), '3.5.1', 'all' );


			wp_enqueue_style('wstock-app');
			wp_enqueue_style('stylesheet' );

		wp_enqueue_style( 'wstock-IE', get_template_directory_uri() . '/css/ie.css', array(), $theme_info->get( 'Version' ) );
		$wp_styles->add_data( 'wstock-IE', 'conditional', 'IE' );

	}
	add_action('wp_enqueue_scripts', 'woodstock_theme_styles', 99 );
endif;



/*-----------------------------------------------------------------------------------*/
/*	Registers and loads front-end javascript
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists('woodstock_register_js') ) :

	function woodstock_register_js() {
		if (!is_admin()) {


			
			// Get theme version info
			$version = woodstock_get_theme_info( 'Version' );
			global $woodstock_theme_info, $tdl_options;

			wp_enqueue_script('wstock-plugins', get_template_directory_uri() . '/js/wstock-plugins.js', array('jquery'), '1.3', TRUE);
			wp_enqueue_script('wstock-autocomplete', get_template_directory_uri() . '/js/jquery.autocomplete.min.js', array('jquery'), $version, TRUE);
			wp_enqueue_script('wstock-custom-scripts', get_template_directory_uri() . '/js/wstock-custom.scripts.js', array('jquery'), '1.4', TRUE);
		

			// Send variables to js
			$woodstock_scripts_vars_array = array(
				'ajaxurl'				=> admin_url( 'admin-ajax.php' ),
				'add_to_cart_nonce'	 => wp_create_nonce( 'woodstock-add-to-cart' ),
				'live_search_empty_msg'	=> esc_html__( 'Unable to find any products that match the currenty query', 'woodstock' ),
				'all_results' => esc_html__('View all results', 'woodstock'),
				'rtl'	=> is_rtl() ? 'true' : 'false',
				'minicart' 			=> (!empty($tdl_options['tdl_offcanvas_minicart'])) ? $tdl_options['tdl_offcanvas_minicart'] : 0,
				'product_add_to_cart_ajax'  => (isset($tdl_options['tdl_product_addtocart_ajax']) && $tdl_options['tdl_product_addtocart_ajax'] == 1) ? '1' : '0',
				'mapApiKey' => (!empty($tdl_options['tdl_google_map_api_key'])) ? $tdl_options['tdl_google_map_api_key'] : ''

			);
			
			wp_localize_script( 'wstock-plugins', 'woodstock_scripts_vars', $woodstock_scripts_vars_array );				
			
		}
	}
	add_action('wp_enqueue_scripts', 'woodstock_register_js');


endif;


// Megamenu registration

function woodstock_admin_scripts( $hook ) {

	if ( is_admin() ) {

    	wp_enqueue_style("wstock-admin-styles", get_template_directory_uri() . "/css/wp-admin-custom.css", false, "1.0", "all");

			if (class_exists('WPBakeryVisualComposerAbstract')) { 
				wp_enqueue_style('wstock-visual-composer', get_template_directory_uri() .'/css/visual-composer.css', false, "1.0", 'all');
			}
    	}
}
add_action('admin_enqueue_scripts', 'woodstock_admin_scripts');


/*-----------------------------------------------------------------------------------*/
/*	Sidebars
/*-----------------------------------------------------------------------------------*/

if( ! function_exists( 'woodstock_widgets_init' ) ):
	function woodstock_widgets_init() {

		register_sidebar(array(
			'name' => esc_html__('Sidebar', 'woodstock'),
			'id' => 'sidebar',
			'before_widget' => '<aside class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		));
		
		register_sidebar(array(
			'name' => esc_html__('Shop Sidebar', 'woodstock'),
			'id' => 'widgets-product-listing',
			'before_widget' => '<aside class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		));
		
		register_sidebar(array(
			'name' => esc_html__('Product Page Sidebar', 'woodstock'),
			'id' => 'widgets-product-page-listing',
			'before_widget' => '<aside class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		));		
		
		register_sidebar(array(
			'name' => esc_html__('Footer 1', 'woodstock'),
			'id' => 'footer-sidebar-1',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		));
		
		register_sidebar(array(
			'name' => esc_html__('Footer 2', 'woodstock'),
			'id' => 'footer-sidebar-2',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		));
		
		register_sidebar(array(
			'name' => esc_html__('Footer 3', 'woodstock'),			
			'id' => 'footer-sidebar-3',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		));
		
		register_sidebar(array(
			'name' => esc_html__('Footer 4', 'woodstock'),			
			'id' => 'footer-sidebar-4',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		));

}
endif;
add_action( 'widgets_init', 'woodstock_widgets_init' );

/******************************************************************************/
/****** Set woocommerce images sizes ******************************************/
/******************************************************************************/

if ( ! function_exists('woodstock_woocommerce_image_dimensions') ) :
	function woodstock_woocommerce_image_dimensions() {
		global $pagenow;
	 
		if ( ! isset( $_GET['activated'] ) || $pagenow != 'themes.php' ) {
			return;
		}

	  	$catalog = array(
			'width' 	=> '350',	// px
			'height'	=> '380',	// px
			'crop'		=> 1 		// true
		);

		$single = array(
			'width' 	=> '570',	// px
			'height'	=> '619',	// px
			'crop'		=> 1 		// true
		);

		$thumbnail = array(
			'width' 	=> '80',	// px
			'height'	=> '80',	// px
			'crop'		=> 1 		// false
		);

		// Image sizes
		update_option( 'shop_catalog_image_size', $catalog ); 		// Product category thumbs
		update_option( 'shop_single_image_size', $single ); 		// Single product image
		update_option( 'shop_thumbnail_image_size', $thumbnail ); 	// Image gallery thumbs
	}
	add_action( 'after_switch_theme', 'woodstock_woocommerce_image_dimensions', 1 );
endif;



/******************************************************************************/
/*********************** Woodstock setup **************************************/
/******************************************************************************/


if ( ! function_exists( 'woodstock_setup' ) ) :
function woodstock_setup() {
	
	global $tdl_options;
	
	/** Theme support **/
	add_theme_support( 'title-tag' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'quote', 'status', 'video', 'audio' ) );
	add_theme_support( 'woocommerce');

	// gutenberg
	add_theme_support( 'align-wide' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'responsive-embeds' );

	add_editor_style( get_template_directory_uri() . '/css/editor-styles.css' );

	global $woodstock_woocommerce;
	$woodstock_woocommerce = new Woodstock_WooCommerce;

	if ( is_admin() ) {
		new Woodstock_Meta_Box_Product_Data;
	}
	
	/** Add Image Sizes **/
	// $shop_catalog_image_size = get_option( 'shop_catalog_image_size' );
	// $shop_single_image_size = get_option( 'shop_single_image_size' );
	// add_image_size('woodstock_product_small_thumbnail', (int)$shop_catalog_image_size['width']/3, (int)$shop_catalog_image_size['height']/3, isset($shop_catalog_image_size['crop']) ? true : false); 
	// add_image_size('woodstock_shop_single_small_thumbnail', (int)$shop_single_image_size['width']/3, (int)$shop_single_image_size['height']/3, isset($shop_catalog_image_size['crop']) ? true : false); 
	// add_image_size( 'woodstock_blog-isotope', 620, 500, true ); 
	
	
	/* THUMBNAIL SIZES
	================================================== */
	// set_post_thumbnail_size( 520, 150, true);
	add_image_size( 'woodstock-widget-image', 94, 70, true);
	add_image_size( 'woodstock-thumb-square', 120, 120, true);
	add_image_size( 'woodstock-thumb-image', 600, 450, true);
	add_image_size( 'woodstock-thumb-image-twocol', 900, 675, true);
	add_image_size( 'woodstock-thumb-image-onecol', 1800, 1200, true);
	add_image_size( 'woodstock-blog-image', 1280, '', true); 
	add_image_size( 'woodstock-gallery-image', 1000, 9999);
	add_image_size( 'woodstock-large-square', 1200, 1200, true);
	add_image_size( 'woodstock-full-width-image-gallery', 1280, 720, true);	

	/** Theme textdomain **/
	load_theme_textdomain( 'woodstock', get_template_directory() . '/languages' );


}
endif; // woodstock_setup
add_action( 'after_setup_theme', 'woodstock_setup' );

 /********************************************************************************/
if ( ! isset( $content_width ) ) $content_width = 640; /* pixels */
