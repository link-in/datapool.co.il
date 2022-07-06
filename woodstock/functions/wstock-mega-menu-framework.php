<?php
/**
 * Woodstock MegaMenu Functions
 *
 * WARNING: This file is part of the Mega Menu Framework.
 * Do not edit the core files.
 * Add any modifications necessary under a child theme.
 *
 * @package  Woodstock/MegaMenu
 * @author   TemashDesign
 * @link     http://temashdesign.com
 */

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) {
	die;
}

// Don't duplicate me!
if( ! class_exists( 'tdlMegaMenuFramework' ) ) {

    /**
     * Main tdlMegaMenuFramework Class
     *
     * @since       4.0.0
     */
    class tdlMegaMenuFramework {

        public static $_version = '4.0.0';
        public static $_name;

        public static $_url;
        public static $_urls;
        public static $_dir;
        public static $_dirs;

        public static $_classes;

        function __construct() {

        	$this->init();

        	add_action( 'woodstock_init', 				array( $this, 'include_functions' ) );

        	add_action( 'admin_enqueue_scripts', 	array( $this, 'register_scripts' ) );
        	add_action( 'admin_enqueue_scripts',	array( $this, 'register_stylesheets' ) );

        	do_action( 'woodstock_init' );

        } // end __construct()

		static function init() {

			// Windows-proof constants: replace backward by forward slashes. Thanks to: @peterbouwmeester
			self::$_dir     = trailingslashit( str_replace( '\\', '/', get_template_directory() ) );
			$wp_content_dir = trailingslashit( str_replace( '\\', '/', WP_CONTENT_DIR ) );
			$relative_url   = str_replace( $wp_content_dir, '', self::$_dir );
			$wp_content_url = ( is_ssl() ? str_replace( 'http://', 'https://', WP_CONTENT_URL ) : WP_CONTENT_URL );
			self::$_url     = trailingslashit( $wp_content_url ) . $relative_url;

			self::$_urls = array(
				'parent'	=> get_template_directory_uri() . '/',
				'child' 	=> get_stylesheet_directory() . '/',
				'framework'	=> self::$_url . 'framework',
			);

			self::$_urls['admin-js'] = get_template_directory() . '/js';
			self::$_urls['admin-css'] = get_template_directory() . '/css';

			self::$_dirs = array(
				'parent' 	=> get_template_directory() . '/',
				'child' 	=> get_stylesheet_directory() . '/',
				'framework' => self::$_dir . 'framework',
			);

        } // end init()


        public function include_functions() {


			// Load functions

			// require_once( 'wstockmegamenus.php' );
			get_template_part( '/functions/wstock-mega-menus' );

			self::$_classes['menus'] = new tdlMegaMenu();


        } // end include_functions()

		/**
		 * Register megamenu javascript assets
		 *
		 * @return void
		 *
		 * @since  3.4
		 */
		function register_scripts() {

			// scripts
			wp_enqueue_media();
			wp_register_script( 'wstock-megamenu', get_template_directory_uri() . '/js/wstock-mega-menu.js', array( 'jquery' ), '1.0.0', true );
			wp_enqueue_script( 'wstock-megamenu' );
		}

		/**
		 * Enqueue megamenu stylesheets
		 *
		 * @return void
		 *
		 * @since  3.4
		 */
		function register_stylesheets() {

			wp_enqueue_style( 'wstock-megamenu', get_template_directory_uri() . '/css/wstock-mega-menu.css', false, '1.0' );

		}



	}

	$tdlcore = new tdlMegaMenuFramework();

}