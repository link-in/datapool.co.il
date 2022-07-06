<?php if ( ! defined('WOODSTOCK_THEME_PATH')) exit('No direct script access allowed');

/**
 * ------------------------------------------------------------------------------------------------
 * Init Theme Settings and Options with Redux plugin
 * ------------------------------------------------------------------------------------------------
 */

    if ( ! class_exists( 'Redux' ) ) {
        return;
    }

    $opt_name = "tdl_options";


    $theme = wp_get_theme(); // For use with some settings. Not necessary.

    /**
     * Get product attributes
     *
     * @return string
     */
    function woodstock_product_attributes() {
        $output = array();
        if ( function_exists( 'wc_get_attribute_taxonomies' ) ) {
            $attributes_tax = wc_get_attribute_taxonomies();
            if ( $attributes_tax ) {
                $output['none'] = esc_html__( 'None', 'woodstock' );

                foreach ( $attributes_tax as $attribute ) {
                    $output[$attribute->attribute_name] = $attribute->attribute_label;
                }
            }
        }

        return $output;
    }

     // Background Patterns Reader
    $sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
    $sample_patterns_url  = ReduxFramework::$_url . '../sample/patterns/';
    $sample_patterns      = array();

    if ( is_dir( $sample_patterns_path ) ) {

        if ( $sample_patterns_dir = opendir( $sample_patterns_path ) ) {
            $sample_patterns = array();

            while ( ( $sample_patterns_file = readdir( $sample_patterns_dir ) ) !== false ) {

                if ( stristr( $sample_patterns_file, '.png' ) !== false || stristr( $sample_patterns_file, '.jpg' ) !== false ) {
                    $name              = explode( '.', $sample_patterns_file );
                    $name              = str_replace( '.' . end( $name ), '', $sample_patterns_file );
                    $sample_patterns[] = array(
                        'alt' => $name,
                        'img' => $sample_patterns_url . $sample_patterns_file
                    );
                }
            }
        }
    };   

    $args = array(
        'opt_name'             => $opt_name,
        'display_name'         => $theme->get( 'Name' ),
        'display_version'      => $theme->get( 'Version' ),
        'menu_type'            => 'menu',
        'allow_sub_menu'       => true,
        'menu_title'           => __( 'Theme Settings', 'woodstock' ),
        'page_title'           => __( 'Theme Settings', 'woodstock' ),
        'google_api_key'       => '',
        'google_update_weekly' => false,
        'async_typography'     => false,
        'admin_bar'            => true,
        'admin_bar_icon'       => 'dashicons-portfolio',
        'admin_bar_priority'   => 50,
        'global_variable'      => '',
        'dev_mode'             => false,
        'update_notice'        => true,
        'customizer'           => true,
        'page_priority'        => 3,
        'page_parent'          => 'themes.php',
        'page_permissions'     => 'manage_options',
        'menu_icon'            => '', 
        'last_tab'             => '',
        'page_icon'            => 'icon-themes',
        'page_slug'            => '_options',
        'save_defaults'        => true,
        'default_show'         => false,
        'default_mark'         => '',
        'show_import_export'   => true,
        'transient_time'       => 60 * MINUTE_IN_SECONDS,
        'output'               => true,
        'output_tag'           => true,
        'footer_credit'     =>  '1.0',                  
        'database'             => '',
        'system_info'          => false,
        'hints'                => array(
            'icon'          => 'el el-question-sign',
            'icon_position' => 'right',
            'icon_color'    => 'lightgray',
            'icon_size'     => 'normal',
            'tip_style'     => array(
                'color'   => 'light',
                'shadow'  => true,
                'rounded' => false,
                'style'   => '',
            ),
            'tip_position'  => array(
                'my' => 'top left',
                'at' => 'bottom right',
            ),
            'tip_effect'    => array(
                'show' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'mouseover',
                ),
                'hide' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'click mouseleave',
                ),
            ),
        )
    );

    Redux::setArgs( $opt_name, $args );


/* ---------------------------------------------------------------- */
/* General Settings
/* ---------------------------------------------------------------- */

    Redux::setSection( $opt_name, array(
                'title'     => esc_html__('General Settings', 'woodstock'),
                'icon'      => 'fa fa-cogs',
                 'fields'    => array(
 
                array(
                    'id' => 'tdl_maincontent_width',
                    'type' => 'slider',
                    'title' => esc_html__('Main Content Max Width', 'woodstock'),
                    'subtitle' => esc_html__('This example displays float values', 'woodstock'),
                    'desc' => esc_html__('Min: 1170, max: 1440, step: 1, default value: 1440', 'woodstock'),
                    "default" => 1440,
                    "min" => 940,
                    "step" => 1,
                    "max" => 1440,
                    'resolution' => 1,
                    'display_value' => 'text'
                ),                

                array(
                    'desc' => esc_html__('Select Theme Layout Type', 'woodstock'),
                    'id' => 'tdl_layout_type',
                    'type' => 'select',
                    'options' => array (
                        'fullwidth' => esc_html__('Fullwidth', 'woodstock'),
                        'boxed' => esc_html__('Boxed', 'woodstock'),
                        'float_box' => esc_html__('Floating Boxed', 'woodstock'),
                    ),
                    'title' => esc_html__('Responsive Layout', 'woodstock'),
                    'default' => 'fullwidth',
                ),

                array(
                    'desc' => esc_html__('Select Background Type', 'woodstock'),
                    'id' => 'tdl_background_type',
                    'type' => 'select',
                    'options' => array (
                        'none' => esc_html__('None', 'woodstock'),
                        'color' => esc_html__('Color', 'woodstock'),
                        'custom_back' => esc_html__('Custom Background', 'woodstock'),
                        'pattern_back' => esc_html__('Pattern Background', 'woodstock'),
                    ),
                    'title' => esc_html__('Background Type', 'woodstock'),
                    'default' => 'color',
                    'required' => array('tdl_layout_type','!=','fullwidth')
                ),

                array(
                    'id'       => 'tdl_background_color',
                    'type'     => 'color',
                    'title'    => esc_html__('Background Color', 'woodstock'), 
                    'subtitle' => esc_html__('Pick a background color', 'woodstock'),
                    'default'  => '#333333',
                    'validate' => 'color',
                    'transparent' => false, 
                    'required' => array('tdl_background_type','equals','color')
                ),

                array(
                    'desc' => esc_html__('Upload your background image here.', 'woodstock'),
                    'id' => 'tdl_background_img',
                    'type' => 'media',
                    'title' => esc_html__('Background Image', 'woodstock'),
                    'url' => true,
                    'required' => array('tdl_background_type','equals','custom_back')                 
                ),  

                array(
                    'desc' => esc_html__('Check this option if you want to use your custom background as pattern.', 'woodstock'),
                    'id' => 'tdl_background_repeat',   
                    'on' => esc_html__('Enable', 'woodstock'),
                    'off' => esc_html__('Disable', 'woodstock'),
                    'type' => 'switch',
                    'title' => esc_html__('Repeat Background', 'woodstock'),
                    'default'  => 0,
                    'required' => array('tdl_background_type','equals','custom_back')
                ),                            

                array(
                    'id'        => 'tdl_pattern_back',
                    'type'      => 'image_select',
                    'tiles'     => true,
                    'title'     => esc_html__('Background Pattern', 'woodstock'),
                    'subtitle'  => esc_html__('Choose background pattern for your site.', 'woodstock'),
                    'default'   => 0,
                    'options'   => $sample_patterns,
                    'required' => array('tdl_background_type','equals','pattern_back')
                ),  

                array(
                    'id'       => 'tdl_google_map_api_key',
                    'type'     => 'text',
                    'title'    => esc_html__('Google map API key', 'woodstock'), 
                    'subtitle' => __('Obrain API key <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">here</a> to use our Google Map VC element.', 'woodstock')
                ),                           
              
        )
    ) );

/* ---------------------------------------------------------------- */
/* General Settings
/* ---------------------------------------------------------------- */


    Redux::setSection( $opt_name, array(
            'title' => esc_html__('Logo & Favicon', 'woodstock' ),
            'icon'  => 'fa fa-rocket',
            'fields'    => array(
 
                array(
                    'subtitle' => esc_html__('Upload your logo image.', 'woodstock' ),
                    'id' => 'tdl_site_logo_noretina',
                    'type' => 'media',
                    'title' => esc_html__('Your Logo Image', 'woodstock' ),
                    'url' => false,                 
                ),

                array(
                    'subtitle' => esc_html__('Upload a higher-resolution image to be used for retina display devices.', 'woodstock' ),
                    'id' => 'tdl_site_logo_retina',
                    'type' => 'media',
                    'title' => esc_html__('Your Retina Logo Image', 'woodstock' ),
                    'url' => false,                 
                ),

                array(
                    'id' => 'tdl_site_logo_height',
                    'type' => 'slider',
                    'title' => esc_html__('Logo Height', 'redux-framework-demo'),
                    'subtitle' => esc_html__('Drag the slider to set the logo height.', 'redux-framework-demo'),
                    "default" => 75,
                    "min" => 50,
                    "step" => 1,
                    "max" => 300,
                    'display_value' => 'text',
                ), 
                

                array(
                    'id' => 'tdl_header_top_bar',
                    'type' => 'info',
                    'raw' => 'Text Logo Settings',
                ),  

                array(
                    'id'=> 'td_logo_font',
                    'type' => 'typography',
                    'title' => esc_html__('Logo Font', 'woodstock'),
                    'subtitle' => esc_html__('Specify the logo font properties.', 'woodstock'),
                    'google'=> true,
                    'font-backup'=>true,
                    'line-height'=>true,
                    'text-align'=>false,
                    'text-transform'=>true,
                    'letter-spacing'=>true,
                    'all_styles' => true, // Enable all Google Font style/weight variations to be added to the page
                    'output' => array('.header-main-section .l-logo .logo h1'), // An array of CSS selectors to apply this font style to dynamically
                    'compiler' => array('.header-main-section .l-logo .logo h1'), // An array of CSS selectors to apply this font style to dynamically
                    'units'=>'px', // Defaults to px
                    'default' => array(
                        'color'=>'#333333',
                        'font-size'=>'40px',
                        'line-height'=>'40px',
                        'font-family'=>'Lato',
                        'text-transform'=>'Uppercase',
                        'font-weight'=>'700',
                        'letter-spacing'  => 0,
                        'subsets' => 'latin'
                    ),
                ),  

                array(
                    'subtitle' => esc_html__('Check to show the description (tagline) for your site. Will be displayed next to a logo.', 'woodstock'),
                    'id' => 'tdl_logo_description',
                    'type' => 'switch',
                    'title' => esc_html__('Show Logo Tagline', 'woodstock'),
                    'default'  => 1,
                ),

                array(
                    'id'=> 'tdl_logo_tagline_font',
                    'type' => 'typography',
                    'title' => esc_html__('Logo Tagline Font', 'woodstock'),
                    'subtitle' => esc_html__('Specify the logo Tagline font properties.', 'woodstock'),
                    'google'=> true,
                    'font-backup'=>true,
                    'line-height'=>true,
                    'text-align'=>false,
                    'text-transform'=>true,
                    'letter-spacing'=>true,
                    'all_styles' => true, // Enable all Google Font style/weight variations to be added to the page
                    'output' => array('.header-main-section .l-logo small'), // An array of CSS selectors to apply this font style to dynamically
                    'compiler' => array('.header-main-section .l-logo small'), // An array of CSS selectors to apply this font style to dynamically
                    'units'=>'px', // Defaults to px
                    'default' => array(
                        'color'=>'#666666',
                        'font-size'=>'14px',
                        'line-height'=>'14px',
                        'font-family'=>'Lato',
                        'font-weight'=>'300',
                        'letter-spacing'  => 0,
                        'text-transform'=>'None',
                        'subsets' => 'latin'
                        ),
                    'required' => array( 'tdl_logo_description', 'equals', array( '1' ) ),
                ), 

                array(                   
                    'id' => 'td_logo_font_align',
                    'type' => 'select',
                    'options' => array (
                        'left' => esc_html__('Left', 'woodstock'),
                        'center' => esc_html__('Center', 'woodstock'),
                        'right' => esc_html__('Right', 'woodstock'),
                    ),
                    'title' => esc_html__('Logo/Tagline align', 'woodstock'),
                    'subtitle' => esc_html__('Specify the Logo/Tagline align', 'woodstock'),
                    'default' => 'center',
                ),    

                //  Favicon Settings

                array(
                    'id' => 'tdl_header_top_bar',
                    'type' => 'info',
                    'raw' => esc_html__('Favicon Settings', 'woodstock'),
                ),   

                array(
                    'desc' => esc_html__('As of WP 4.3, the favicon setting is now available in the default WordPress customizer (Appearance > Customize > Site Identity).', 'woodstock'),
                    'id' => 'info_success',
                    'type' => 'info',
                    'style' => 'success',
                    'title' => esc_html__('Favicon', 'woodstock'),                                        
                ),                                                                                       
              
        )
    ) );

/* ---------------------------------------------------------------- */
/* Header Settings
/* ---------------------------------------------------------------- */


    Redux::setSection( $opt_name, array(
            'title' => esc_html__('Header Settings', 'woodstock' ),
            'icon'  => 'fa fa-chevron-up',
            'fields'    => array(
 
                array(
                    'id'       => 'main_header_layout',
                    'type'     => 'image_select',
                    'compiler' => true,
                    'title'    => esc_html__( 'Header Layout', 'woodstock' ),
                    'subtitle' => esc_html__( 'Select the Layout style for the Header.', 'woodstock' ),
                    'options'  => array(
                        '1' => array(
                            'alt' => 'Layout 1',
                            'img' => get_template_directory_uri() . '/images/theme-options/header_1.png'
                        ),
                        '2' => array(
                            'alt' => 'Layout 2',
                            'img' => get_template_directory_uri() . '/images/theme-options/header_2.png'
                        ),
                    ),
                    'default'  => '1'
                ), 

                array(
                    'id' => 'search_header_info',
                    'icon' => true,
                    'type' => 'info',
                    'raw' => esc_html__( 'Sticky Header', 'woodstock' ),
                ),
                                              
                array(
                    'id' => 'tdl_sticky_menu',
                    'type' => 'switch',
                    'title' => esc_html__( 'Header Sticky Menu', 'woodstock' ),
                    'subtitle' => esc_html__( 'Check to enable Header Sticky Menu', 'woodstock' ),
                    'default' => 1,
                ),

                array(
                    'id' => 'tdl_sticky_menu_hide',
                    'type' => 'switch',
                    'on' => esc_html__('Enabled', 'woodstock'),
                    'off' => esc_html__('Disabled', 'woodstock'),
                    'title' => esc_html__( 'Header Sticky Menu Show/Hide on Scroll', 'woodstock' ),
                    'subtitle' => esc_html__( 'Check to enable Hide Header Sticky Menu on ScrollDown and Show on ScrollUp. Disable to Always Show Header Sticky Header.', 'woodstock' ),
                    'required' => array( 'tdl_sticky_menu', 'equals', array( '1' ) ),
                    'default' => 1,
                ),                
             
                array(
                    'id' => 'tdl_sticky_menu_mobile',
                    'type' => 'switch',
                    'on' => esc_html__('Show', 'woodstock'),
                    'off' => esc_html__('Hide', 'woodstock'),
                    'title' => esc_html__( 'Sticky Menu on Tablet/Mobile devices', 'woodstock' ),
                    'subtitle' => esc_html__( 'Check to Show Hide Header Sticky Menu on Tablet/Mobile devices.', 'woodstock' ),
                    'required' => array( 'tdl_sticky_menu', 'equals', array( '1' ) ),
                    'default' => 1,
                ), 

                // Header Search bar

                array(
                    'id' => 'info_search_bar',
                    'icon' => true,
                    'type' => 'info',
                    'raw' => esc_html__( 'Search Bar', 'woodstock' ),
                ),
                        
                array(
                    'title' => esc_html__('Header Search bar', 'woodstock'),
                    'subtitle' => esc_html__('Enable / Disable the Search Bar in the Header.', 'woodstock'),
                    'id' => 'tdl_header_search_bar',
                    'on' => esc_html__('Enabled', 'woodstock'),
                    'off' => esc_html__('Disabled', 'woodstock'),
                    'type' => 'switch',
                    'default' => 1,
                ),

                array(
                    'title' => esc_html__('AJAX search', 'woodstock'),
                    'subtitle' => esc_html__('Enable / Disable the AJAX in search.', 'woodstock'),
                    'required' => array( 'tdl_header_search_bar', 'equals', array( '1' ) ),
                    'id' => 'tdl_header_ajax_search',
                    'on' => esc_html__('Enabled', 'woodstock'),
                    'off' => esc_html__('Disabled', 'woodstock'),
                    'type' => 'switch',
                    'default' => 1,
                ),  

                array(
                    'title' => esc_html__('AJAX search results count', 'woodstock'),
                    'subtitle' => esc_html__('Number of products to display in AJAX search results.', 'woodstock'),
                    'required' => array(
                        array('tdl_header_search_bar', 'equals', array( '1' )),
                        array('tdl_header_ajax_search', 'equals', array( '1' )),
                    ),
                    'id' => 'tdl_header_ajax_search_count',
                    'min' => '3',
                    'step' => '1',
                    'max' => '30',
                    'type' => 'slider',
                    'default' => '20',
                ),                              

                // array(
                //     'title' => esc_html__('Show product categories dropdown', 'woodstock'),
                //     'required' => array( 'tdl_header_search_bar', 'equals', array( '1' ) ),
                //     'id' => 'tdl_header_search_categories',
                //     'on' => esc_html__('Enabled', 'woodstock'),
                //     'off' => esc_html__('Disabled', 'woodstock'),
                //     'type' => 'switch',
                //     'default' => 0,
                // ), 

                array(
                    'title' => esc_html__('Search by product SKU', 'woodstock'),
                    'required' => array( 'tdl_header_search_bar', 'equals', array( '1' ) ),
                    'id' => 'tdl_header_search_sku',
                    'on' => esc_html__('Enabled', 'woodstock'),
                    'off' => esc_html__('Disabled', 'woodstock'),
                    'type' => 'switch',
                    'default' => 1,
                ),               

                array(
                    'id' => 'tdl_header_search_pt',
                    'type' => 'button_set',
                    'required' => array( 'tdl_header_search_bar', 'equals', array( '1' ) ),
                    'title' => esc_html__('Header Search Post Type', 'woodstock'),
                    'subtitle' => esc_html__('Set whether you would like the site search limited to products, or all content.', 'woodstock'),
                    'desc' => '',
                    'options' => array('product' => 'Products', 'post' => 'Posts' ),
                    'default' => 'product'
                ),

                // Header Customer Support Box


                array(
                    'id' => 'info_header_support',
                    'icon' => true,
                    'type' => 'info',
                    'raw' => esc_html__( 'Header Customer Support Box', 'woodstock' ),
                ),
                        
                array(
                    'title' => esc_html__('Customer Support box', 'woodstock'),
                    'subtitle' => esc_html__('Enable / Disable the Customer Support in the Header.', 'woodstock'),
                    'id' => 'tdl_header_customer_bar',
                    'on' => esc_html__('Enabled', 'woodstock'),
                    'off' => esc_html__('Disabled', 'woodstock'),
                    'type' => 'switch',
                    'default' => 0,
                ), 

                array(
                    'id' => 'tdl_header_customer_bar_title',
                    'type' => 'text',
                    'title' => esc_html__('Customer Support bar Title', 'woodstock'),
                    'subtitle' => esc_html__('Enter the Customer Support bar Title', 'woodstock'),
                    'default' => '1-800-123-45-67',
                    'required' => array( 'tdl_header_customer_bar', 'equals', array( '1' ) ),
                ),

                array(
                    'id' => 'tdl_header_customer_bar_subtitle',
                    'type' => 'text',
                    'title' => esc_html__('Customer Support bar Subtitle', 'woodstock'),
                    'subtitle' => esc_html__('Enter the Customer Support bar Subtitle', 'woodstock'),
                    'default' => 'Customer Support',
                    'required' => array( 'tdl_header_customer_bar', 'equals', array( '1' ) ),
                ),   

                array(
                    'subtitle' => __('
Add HTML or shortcodes here that will show beside Cart and My Account links or replace them.<br />
You could use these:<br />
<b>[follow facebook="#" twitter="#" googleplus="#" rss="#"]<br />
[contact city="New York" phone="1-800-333-42-63" address="78 2nd House RD Montauk, NY, 11954" email="ny@woodstock.com"]<br />
[divider]
</b>

', 'woodstock'),
                    'id' => 'tdl_header_customer_bar_text',
                    'type' => 'textarea',
                    'title' => esc_html__('Customer Support bar Textarea', 'woodstock'),
                    'default' => '
[contact city="New York" phone="1-800-333-42-63" address="78 2nd House RD Montauk, NY, 11954" email="ny@woodstock.com"]
[divider]
[contact city="San Francisco" phone="1-800-444-23-54" address="1 Infinite Loop Cupertino, CA 95014" email="sf@woodstock.com"]
[follow facebook="#" twitter="#" googleplus="#" rss="#"]',
                    'required' => array( 'tdl_header_customer_bar', 'equals', array( '1' ) ),
                ), 

              
        )
    ) );

/* ---------------------------------------------------------------- */
/* Top Bar
/* ---------------------------------------------------------------- */


    Redux::setSection( $opt_name, array(
                'icon'  => 'fa fa-angle-right',
                'title' => esc_html__('Top Bar', 'woodstock'),
                'subsection' => true,
                'fields'    => array(
 
                array(
                    'title' => esc_html__('Top Bar', 'woodstock'),
                    'subtitle' => esc_html__('Enable / Disable the Top Bar.', 'woodstock'),
                    'id' => 'tdl_topbar_switch',
                    'on' => esc_html__('Enabled', 'woodstock'),
                    'off' => esc_html__('Disabled', 'woodstock'),
                    'type' => 'switch',
                    'title' => 'Top Bar',
                    'default'  => 0,
                ),

                array(
                    'title' => esc_html__('Show Top Bar on mobile', 'woodstock'),
                    'id' => 'tdl_topbar_mobile',
                    'on' => esc_html__('Enabled', 'woodstock'),
                    'off' => esc_html__('Disabled', 'woodstock'),
                    'type' => 'switch',
                    'default' => 0,
                    'required' => array('tdl_topbar_switch','=','1')
                ),                

                array(
                    'title' => esc_html__('Wishlist button', 'woodstock'),
                    'subtitle' => esc_html__('Enable / Disable Wishlist button. (Should be installed and activated YITH Wishlist plugin)', 'woodstock'),
                    'id' => 'tdl_topbar_wishlist',
                    'on' => esc_html__('Enabled', 'woodstock'),
                    'off' => esc_html__('Disabled', 'woodstock'),
                    'type' => 'switch',
                    'default' => 1,
                    'required' => array('tdl_topbar_switch','=','1')
                ), 

                array(
                    'title' => esc_html__('Languages/Currency select button', 'woodstock'),
                    'subtitle' => esc_html__('Enable / Disable Languages/Currency select button. (Should be installed and activated WPML and Woocommerce Currency plugins)', 'woodstock'),
                    'id' => 'tdl_topbar_wpml',
                    'on' => esc_html__('Enabled', 'woodstock'),
                    'off' => esc_html__('Disabled', 'woodstock'),
                    'type' => 'switch',
                    'default' => 1,
                    'required' => array('tdl_topbar_switch','=','1')
                ), 

                 array(
                    'title' => esc_html__('Top Bar Social Icons', 'woodstock'),
                    'subtitle' => esc_html__('Enable / Disable the Top Bar Social Icons. Please select socials in "Social Media" section', 'woodstock'),
                    'id' => 'tdl_topbar_social_icons',
                    'on' => esc_html__('Enabled', 'woodstock'),
                    'off' => esc_html__('Disabled', 'woodstock'),
                    'type' => 'switch',
                    'default' => 0,
                    'required' => array('tdl_topbar_switch','=','1')
                ),                                              
              
        )
    ) );


/* ---------------------------------------------------------------- */
/* Shop Settings
/* ---------------------------------------------------------------- */


    Redux::setSection( $opt_name, array(
            'title' => esc_html__('Shop Settings', 'woodstock'),
            'icon'  => 'fa fa-shopping-cart',
                 'fields'    => array(

                 array(
                    'subtitle' => esc_html__('Check to enable Catalog Mode. This option will turn off the shopping functionality of WooCommerce on theme pages.', 'woodstock'),
                    'id' => 'tdl_catalog_mode',
                    'type' => 'switch',
                    'on' => esc_html__('Enable', 'woodstock'),
                    'off' => esc_html__('Disable', 'woodstock'),
                    'title' => 'Catalog Mode',
                    'default'  => 0,
                ),

                array(
                    'id' => 'tdl_shop_breadcrumb',
                    'type' => 'switch',
                    'on' => esc_html__('Enabled', 'woodstock'),
                    'off' => esc_html__('Disabled', 'woodstock'),
                    'title' => esc_html__( 'Shop Breadcrumb', 'woodstock' ),
                    'subtitle' => esc_html__( 'Check to enable Breadcrumb on Shop', 'woodstock' ),
                    'default' => 1,
                ), 
                
                array(
                    'id' => 'tdl_offcanvas_minicart',
                    'type' => 'switch',
                    'on' => esc_html__('Enabled', 'woodstock'),
                    'off' => esc_html__('Disabled', 'woodstock'),
                    'title' => esc_html__( 'Off-canvas Mini Cart', 'woodstock' ),
                    'subtitle' => esc_html__( 'Check to enable Off-canvas Mini Cart', 'woodstock' ),
                    'default' => 1,
                ),                

        )
    ) );

/* ---------------------------------------------------------------- */
/* Shop Catalog
/* ---------------------------------------------------------------- */

    Redux::setSection( $opt_name, array(
                'title' => esc_html__('Shop Catalog', 'woodstock'),
                'subsection' => true,
                'fields'    => array(
 
                array(
                    'id'       => 'tdl_sidebar_listing',
                    'type'     => 'image_select',
                    'compiler' => true,
                    'title'    => esc_html__( 'Shop Sidebar', 'woodstock' ),
                    'subtitle' => esc_html__( 'Select the default sidebar for Shop', 'woodstock' ),
                    'options'  => array(
                        '1' => array(
                            'alt' => esc_html__( 'Left Sidebar', 'woodstock' ),
                            'img' => get_template_directory_uri() . '/images/theme-options/sidebar_1.png'
                        ),
                        '2' => array(
                            'alt' => esc_html__( 'Right Sidebar', 'woodstock' ),
                            'img' => get_template_directory_uri() . '/images/theme-options/sidebar_2.png'
                        ),
                        '3' => array(
                            'alt' => esc_html__( 'No Sidebar', 'woodstock' ),
                            'img' => get_template_directory_uri() . '/images/theme-options/sidebar_3.png'
                        ),
                    ),
                    'default'  => '3'
                ),

                array(
                    'id' => 'info_shop_display',
                    'icon' => true,
                    'type' => 'info',
                    'raw' => esc_html__( 'Shop Display', 'woodstock' ),
                ),  

                array(
                    'id' => 'tdl_product_display_thumb',
                    'title'    => esc_html__( 'Product Thumbs Display Type', 'woodstock' ),
                    'subtitle' => esc_html__( 'Choose the product display type for WooCommerce shop/category pages', 'woodstock' ),
                    'type' => 'select',
                    'options' => array (
                        'standart' => esc_html__('Standart', 'woodstock'),
                        'slider' => esc_html__('Slider', 'woodstock'),
                        'preview_slider' => esc_html__('Preview Slider', 'woodstock'),
                    ),
                    
                    'default' => 'standart',
                ),  
                
                array(
                    'title' => esc_html__('Second Image on Catalog Page (Hover)', 'woodstock'),
                    'subtitle' => esc_html__('Enable / Disable the Second Image on Product Listing.', 'woodstock'),
                    'id' => 'tdl_second_image_product_listing',
                    'on' => esc_html__('Enabled', 'woodstock'),
                    'off' => esc_html__('Disabled', 'woodstock'),
                    'type' => 'switch',
                    'default' => 1,
                    'required' => array( 'tdl_product_display_thumb', 'equals', 'standart' )
                ),  

                array(
                    'title' => esc_html__('Categories in page heading', 'woodstock'),
                    'subtitle' => esc_html__('This categories menu is generated automatically based on all categories in the shop. You are not able to manage this menu as other WordPress menus', 'woodstock'),
                    'id' => 'tdl_shop_categories',
                    'on' => esc_html__('Enabled', 'woodstock'),
                    'off' => esc_html__('Disabled', 'woodstock'),
                    'type' => 'switch',
                    'default' => 1,
                ), 

                array(
                    'title' => esc_html__('Maximum Images in Slider', 'woodstock'),
                    'subtitle' => esc_html__('Drag the slider to set the maximum images in slider.', 'woodstock'),
                    'id' => 'tdl_num_slider_images',
                    'min' => '2',
                    'step' => '1',
                    'max' => '6',
                    'type' => 'slider',
                    'default' => '3',
                    'required' => array( 'tdl_product_display_thumb', 'equals', 'slider' )
                ), 

                array(
                    'title' => esc_html__('Maximum Images in Slider', 'woodstock'),
                    'subtitle' => esc_html__('Drag the slider to set the maximum images in slider.', 'woodstock'),
                    'id' => 'tdl_num_prevslider_images',
                    'min' => '2',
                    'step' => '1',
                    'max' => '6',
                    'type' => 'slider',
                    'default' => '3',
                    'required' => array( 'tdl_product_display_thumb', 'equals', 'preview_slider' )
                ),  

                 array(
                    'id' => 'introduction',
                    'type' => 'info',
                    'raw' => esc_html__( 'Shop Layout', 'woodstock' ),
                ),

                 array(
                    'id' => 'tdl_product_display_type',
                    'title'    => esc_html__( 'Product Display Layout', 'woodstock' ),
                    'subtitle' => esc_html__( 'Choose the default product display layout for WooCommerce shop/category pages', 'woodstock' ),
                    'type' => 'select',
                    'options' => array (
                        'grid' => esc_html__('Grid', 'woodstock'),
                        'list' => esc_html__('List', 'woodstock'),
                    ),
                    
                    'default' => 'grid',
                ),

                array(
                    'title' => esc_html__('Products per page', 'woodstock'),
                    'subtitle' => esc_html__('Number of products per page', 'woodstock'),
                    'id' => 'tdl_shop_per_page',
                    'type' => 'text',
                    'default' => 12,
                ),                

                // array(
                //     'title' => esc_html__('Number of Categories per Column', 'woodstock'),
                //     'subtitle' => esc_html__('Drag the slider to set the number of categories per column to be listed on the shop page and catalog pages.', 'woodstock'),
                //     'id' => 'tdl_categories_per_column',
                //     'min' => '2',
                //     'step' => '1',
                //     'max' => '5',
                //     'type' => 'slider',
                //     'default' => '4',
                // ),                                          

                array(
                    'title' => esc_html__('Number of Products per Column', 'woodstock'),
                    'subtitle' => esc_html__('Drag the slider to set the number of products per column to be listed on the shop page and catalog pages.', 'woodstock'),
                    'id' => 'tdl_products_per_column',
                    'min' => '2',
                    'step' => '1',
                    'max' => '6',
                    'type' => 'slider',
                    'default' => '4',
                ),

                array(
                    'id'=>'tdl_product_count',
                    'type' => 'text',
                    'title' => esc_html__('Products per Page Box', 'woodstock'),
                    'subtitle' => esc_html__('For ex.: 12,24,36,-1. Use -1 to show all products on the page', 'woodstock'),
                    'default' => '12,24,36'
                ), 

                array(
                    'subtitle' => __('Show product attribute for each item listed under the item name.', 'woodstock'),
                    'id' => 'tdl_product_attribute',
                    'type' => 'select',
                    'title' => __('Product Attribute', 'woodstock'), 
                    'options'   => woodstock_product_attributes(),
                    'default' => 'none',

                ),                 

                array(
                    'subtitle' => 'Display Category/Categories name in Product Listing',
                    'id' => 'tdl_category_listing',
                    'type' => 'select',
                    'options' => array (
                        'none' => 'Disable',
                        'categories' => 'Display All Product Categories',
                        'first_category' => 'Display Only First Category',
                    ),
                    'title' => 'Category/Categories name in Product Listing',
                    'default' => 'first_category',
                ),
  

                array(
                    'title' => esc_html__('Ratings on Catalog Page', 'woodstock'),
                    'subtitle' => esc_html__('Enable / Disable Ratings on Catalog Page.', 'woodstock'),
                    'id' => 'tdl_ratings_catalog_page',
                    'on' => esc_html__('Enabled', 'woodstock'),
                    'off' => esc_html__('Disabled', 'woodstock'),
                    'type' => 'switch',
                    'default' => 1,
                ),                                                                                                              
                 array(
                    'title' => esc_html__('Product Short Description', 'woodstock'),
                    'subtitle' => esc_html__('Enable / Disable Product Short Description on Catalog Page.', 'woodstock'),
                    'id' => 'tdl_product_description',
                    'on' => esc_html__('Enabled', 'woodstock'),
                    'off' => esc_html__('Disabled', 'woodstock'),
                    'type' => 'switch',
                    'default' => 1,
                ),

                array(
                    'title' => esc_html__('Number of Words in Product Short Description', 'woodstock'),
                    'subtitle' => esc_html__('Enter Number of Words in Product Short Description', 'woodstock'),
                    'id' => 'tdl_product_description_number',
                    'min' => '1',
                    'step' => '1',
                    'max' => '100',
                    'type' => 'slider',
                    'edit' => '1',
                    'default' => '20',
                    'required' => array( 'tdl_product_description', 'equals', array( '1' ) )
                ),

                array(
                    'title' => esc_html__('Allow HTML tags in Product Short Description', 'woodstock'),
                    'subtitle' => esc_html__('Allow HTML tags in Product Short Description on Catalog Page.', 'woodstock'),
                    'id' => 'tdl_product_description_html',
                    'on' => esc_html__('Enabled', 'woodstock'),
                    'off' => esc_html__('Disabled', 'woodstock'),
                    'type' => 'switch',
                    'default' => 0,
                    'required' => array( 'tdl_product_description', 'equals', array( '1' ) )
                ),

                array(
                    'title' => __('Add to Cart Button Display', 'woodstock'),
                    'id' => 'tdl_add_to_cart_display',
                    'on' => __('When hovering', 'woodstock'),
                    'off' => __('At all times', 'woodstock'),
                    'type' => 'switch',
                    'default' => 1
                ), 

                array(
                    'title' => esc_html__('Product Hover Effect', 'woodstock'),
                    'subtitle' => esc_html__('Enable/Disable Product Hover Effect on shop/archive', 'woodstock'),
                    'id' => 'tdl_hover_product',
                    'on' => esc_html__('Enabled', 'woodstock'),
                    'off' => esc_html__('Disabled', 'woodstock'),
                    'type' => 'switch',
                    'default' => 1,
                ),

                 array(
                    'title' => esc_html__('Product Hover Effect only for mobile', 'woodstock'),
                    'subtitle' => esc_html__('Enable/Disable Product Hover Effect on shop/archive only for mobile', 'woodstock'),
                    'id' => 'tdl_hover_product_mobile',
                    'on' => esc_html__('Enabled', 'woodstock'),
                    'off' => esc_html__('Disabled', 'woodstock'),
                    'type' => 'switch',
                    'default' => 1,
                ),                               

                array(
                    'id' => 'introduction',
                    'icon' => true,
                    'type' => 'info',
                    'raw' => esc_html__('Shop Badges', 'woodstock'),
                ), 

                array(
                    'title' => esc_html__('"% Off" Badge', 'woodstock'),
                    'subtitle' => esc_html__('Check to enable "% Off" Badge in percentages instead "Sale" Badge', 'woodstock'),
                    'id' => 'tdl_sale_percentages',
                    'on' => esc_html__('Enabled', 'woodstock'),
                    'off' => esc_html__('Disabled', 'woodstock'),
                    'type' => 'switch',
                    'default' => 1,
                ),  

                array(
                    'title' => esc_html__('"Sale" Badge Label', 'woodstock'),
                    'subtitle' => esc_html__('Type in your custom "Sale" Badge Label Text.', 'woodstock'),
                    'id' => 'tdl_salebadge_text',
                    'type' => 'text',
                    'default' => 'Sale',
                    'required' => array( 'tdl_sale_percentages', 'equals', array( '0' ) )
                ),                           
                                                          
                array(
                    'title' => esc_html__('"New" Badge', 'woodstock'),
                    'subtitle' => esc_html__('Check to enable "New" Badge.', 'woodstock'),
                    'id' => 'tdl_newbadge',
                    'on' => esc_html__('Enabled', 'woodstock'),
                    'off' => esc_html__('Disabled', 'woodstock'),
                    'type' => 'switch',
                    'default' => 1,
                ), 

                array(
                    'title' => esc_html__('"New" Badge Label', 'woodstock'),
                    'subtitle' => esc_html__('Type in your custom "New" Badge Label Text.', 'woodstock'),
                    'id' => 'tdl_newbadge_text',
                    'type' => 'text',
                    'default' => 'New',
                    'required' => array( 'tdl_newbadge', 'equals', array( '1' ) )
                ),

                array(
                    'title' => esc_html__('"New" Badge Days', 'woodstock'),
                    'subtitle' => esc_html__('How many days "New" badge will display.', 'woodstock'),
                    'id' => 'tdl_newbadge_date',
                    'type' => 'text',
                    'default' => 5,
                    'required' => array( 'tdl_newbadge', 'equals', array( '1' ) )
                ), 

                array(
                    'title' => esc_html__('"Out of Stock" Label Text', 'woodstock'),
                    'subtitle' => esc_html__('Type in your custom "Out of Stock" Label Text.', 'woodstock'),
                    'id' => 'tdl_out_of_stock_text',
                    'type' => 'text',
                    'default' => 'Out of stock'
                ),                                                                            

        )
    ) );

/* ---------------------------------------------------------------- */
/* Product Page
/* ---------------------------------------------------------------- */


    Redux::setSection( $opt_name, array(
                'title' => esc_html__('Product Page', 'woodstock'),
                'subsection' => true,
                'fields'    => array(
 
                array(
                    'id'       => 'tdl_product_sidebar',
                    'type'     => 'image_select',
                    'compiler' => true,
                    'title'    => esc_html__( 'Product page sidebar', 'woodstock' ),
                    'subtitle' => esc_html__( 'Select the default sidebar for Shop Single Page', 'woodstock' ),
                    'options'  => array(
                        '1' => array(
                            'alt' => esc_html__( 'Left Sidebar', 'woodstock' ),
                            'img' => get_template_directory_uri() . '/images/theme-options/sidebar_1.png'
                        ),
                        '2' => array(
                            'alt' => esc_html__( 'Right Sidebar', 'woodstock' ),
                            'img' => get_template_directory_uri() . '/images/theme-options/sidebar_2.png'
                        ),
                        '3' => array(
                            'alt' => esc_html__( 'No Sidebar', 'woodstock' ),
                            'img' => get_template_directory_uri() . '/images/theme-options/sidebar_3.png'
                        ),
                    ),
                    'default'  => '3'
                ),

                array(
                    'title' => esc_html__('Add to Cart Ajax', 'woodstock'),
                    'subtitle' => esc_html__('Disable the add to cart AJAX on the product page.', 'woodstock'),
                    'id' => 'tdl_product_addtocart_ajax',
                    'on' => esc_html__('Enabled', 'woodstock'),
                    'off' => esc_html__('Disabled', 'woodstock'),
                    'type' => 'switch',
                    'default' => 0,
                ),

                 array(
                    'title' => esc_html__('Product Page Short Description', 'woodstock'),
                    'subtitle' => esc_html__('Enable / Disable Product Short Description on Product Page.', 'woodstock'),
                    'id' => 'tdl_productpage_description',
                    'on' => esc_html__('Enabled', 'woodstock'),
                    'off' => esc_html__('Disabled', 'woodstock'),
                    'type' => 'switch',
                    'default' => 0,
                ),

                array(
                    'title' => esc_html__('Number of Words in Product Short Description', 'woodstock'),
                    'subtitle' => esc_html__('Enter Number of Words in Product Short Description on Product Page.', 'woodstock'),
                    'id' => 'tdl_productpage_description_number',
                    'min' => '1',
                    'step' => '1',
                    'max' => '100',
                    'type' => 'slider',
                    'edit' => '1',
                    'default' => '40',
                    'required' => array( 'tdl_productpage_description', 'equals', array( '1' ) )
                ),

                // array(
                //     'title' => esc_html__('Allow HTML tags in Product Short Description', 'woodstock'),
                //     'subtitle' => esc_html__('Allow HTML tags in Product Short Description on Product Page.', 'woodstock'),
                //     'id' => 'tdl_productpage_description_html',
                //     'on' => esc_html__('Enabled', 'woodstock'),
                //     'off' => esc_html__('Disabled', 'woodstock'),
                //     'type' => 'switch',
                //     'default' => 0,
                //     'required' => array( 'tdl_productpage_description', 'equals', array( '1' ) )
                // ),                

                array(
                    'title' => esc_html__('Product Gallery Zoom', 'woodstock'),
                    'subtitle' => esc_html__('Enable / Disable Product Gallery Zoom.', 'woodstock'),
                    'id' => 'tdl_product_gallery_zoom',
                    'on' => esc_html__('Enabled', 'woodstock'),
                    'off' => esc_html__('Disabled', 'woodstock'),
                    'type' => 'switch',
                    'default' => 1,
                ),

                 array(
                    'title' => esc_html__('Product Image Lightbox', 'woodstock'),
                    'subtitle' => esc_html__('Enable / Disable Product Image Lightbox.', 'woodstock'),
                    'id' => 'tdl_product_lightbox',
                    'on' => esc_html__('Enabled', 'woodstock'),
                    'off' => esc_html__('Disabled', 'woodstock'),
                    'type' => 'switch',
                    'default' => 1,
                ),                   

                array(
                    'title' => esc_html__('Number of Related Products per View', 'woodstock'),
                    'subtitle' => esc_html__('Drag the slider to set the number of Related Products per View.', 'woodstock'),
                    'id' => 'tdl_related_products_per_view',
                    'min' => '3',
                    'step' => '1',
                    'max' => '6',
                    'type' => 'slider',
                    'default' => '4',
                ), 

                array(
                    'title' => esc_html__('Sharing Options', 'woodstock'),
                    'subtitle' => esc_html__('Enable / Disable Sharing Options on Product page.', 'woodstock'),
                    'id' => 'tdl_sharing_options',
                    'on' => esc_html__('Enabled', 'woodstock'),
                    'off' => esc_html__('Disabled', 'woodstock'),
                    'type' => 'switch',
                    'default' => 1,
                ),                               
              
        )
    ) );

/* ---------------------------------------------------------------- */
/* Footer Settings
/* ---------------------------------------------------------------- */


    Redux::setSection( $opt_name, array(
            'title' => esc_html__('Footer Settings', 'woodstock'),
            'icon'  => 'fa fa-chevron-down',
            'fields'    => array(
 
                array(
                    'subtitle' => esc_html__('Select how many footer widget areas you want to display.', 'woodstock'),
                    'id' => 'tdl_footer_layout',
                    'type' => 'image_select',
                    'options' => array (
                        '0' => array(
                            'alt' => esc_html__('Layout Off', 'woodstock'),
                            'img' => get_template_directory_uri() . '/images/theme-options/layout-off.png'
                        ),
                        '1' => array(
                            'alt' => esc_html__('Footer 1 column', 'woodstock'),
                            'img' => get_template_directory_uri() . '/images/theme-options/footer-widgets-1.png'
                        ),
                        '2' => array(
                            'alt' => esc_html__('Footer 2 columns', 'woodstock'),
                            'img' => get_template_directory_uri() . '/images/theme-options/footer-widgets-2.png'
                        ),      
                        '3' => array(
                            'alt' => esc_html__('Footer 3 columns', 'woodstock'),
                            'img' => get_template_directory_uri() . '/images/theme-options/footer-widgets-3.png'
                        ), 
                        '4' => array(
                            'alt' => esc_html__('Footer 4 columns', 'woodstock'),
                            'img' => get_template_directory_uri() . '/images/theme-options/footer-widgets-4.png'
                        ), 
                        '5' => array(
                            'alt' => esc_html__('Footer 1-1-2 columns', 'woodstock'),
                            'img' => get_template_directory_uri() . '/images/theme-options/footer-widgets-1-1-2.png'
                        ),                         
                        '6' => array(
                            'alt' => esc_html__('Footer 1-2-1 columns', 'woodstock'),
                            'img' => get_template_directory_uri() . '/images/theme-options/footer-widgets-1-2-1.png'
                        ), 
                        '7' => array(
                            'alt' => esc_html__('Footer 2-1-1 columns', 'woodstock'),
                            'img' => get_template_directory_uri() . '/images/theme-options/footer-widgets-2-1-1.png'
                        ),                        
                    ),
                    'title' => esc_html__('Footer Widget Areas', 'woodstock'),
                    'default' => 0,
                ),

                array(
                    'subtitle' => esc_html__('Check to Show Footer Logos/Credit Cards Sprite', 'woodstock'),
                    'id' => 'tdl_footer_logos_off',
                    'on' => esc_html__('Show', 'woodstock'),
                    'off' => esc_html__('Hide', 'woodstock'),
                    'type' => 'switch',
                    'title' => esc_html__('Show/Hide Footer Logos/Credit Cards Sprite', 'woodstock'),
                    'default' => 1,
                ),

                array(
                    'subtitle' => esc_html__('Upload your custom icons sprite.', 'woodstock'),
                    'id' => 'tdl_footer_logos',
                    'type' => 'media',
                    'title' => esc_html__('Custom Footer Logos/Credit Cards Sprite', 'woodstock'),
                    'url' => false,
                          'default' => array (
                          'url' => get_template_directory_uri() . '/images/payment_cards.png',
                       ),                   
                ), 

                array(
                    'subtitle' => esc_html__('Whatever text you enter here will be displayed in your website\'s footer area. The primary purpose of this option is to display your website\'s Copyright text, but you can enter whatever text you like.', 'woodstock'),
                    'id' => 'tdl_footer_text',
                    'type' => 'textarea',
                    'title' => esc_html__('Footer Copyright Text', 'woodstock'),
                    'default' => '&copy; 2021 - Woodstock Woocommerce Theme. Created by <a href=\'https://temash.design\'>temash.design</a>',
                ),


        )
    ) );

/* ---------------------------------------------------------------- */
/* Styling Settings
/* ---------------------------------------------------------------- */


    Redux::setSection( $opt_name, array(
            'title' => esc_html__('Styling', 'woodstock'),
            'icon'  => 'fa fa-magic',
            'fields'    => array(
 
                array(
                    'id' => 'introduction',
                    'icon' => true,
                    'type' => 'info',
                    'raw' => esc_html__('Main Color Styling', 'woodstock'),
                ), 

                array(
                    'subtitle' => esc_html__('Select a main color for your site.', 'woodstock'),
                    'id' => 'tdl_main_color',
                    'type' => 'color',
                    'title' => esc_html__('Main Theme Color', 'woodstock'),
                    'default' => '#6990cb',
                    'transparent' => false,
                ),

                array(
                    'subtitle' => esc_html__('Select a color for link', 'woodstock'),
                    'id' => 'tdl_color_link',
                    'type' => 'color',
                    'title' => esc_html__('Link Color', 'woodstock'),
                    'default' => '#6990cb',
                    'transparent' => false,
                ),

                 array(
                    'id' => 'info-ajax',
                    'icon' => true,
                    'type' => 'info',
                    'raw' => esc_html__('Ajax loaders', 'woodstock'),
                ),                  

                 array(
                    'id'       => 'tdl_header_ajax_loader',
                    'type'     => 'image_select',
                    'compiler' => true,
                    'title'    => esc_html__( 'Ajax Loader Icon', 'woodstock' ),
                    'subtitle' => esc_html__( 'Select the Ajax Loader Icon', 'woodstock' ),
                    'options'  => array(
                        'spinner-circle' => array(
                            'alt' => 'Spinner Icon 2',
                            'img' => get_template_directory_uri() . '/images/theme-options/spinner_icon_2.png'
                        ),                        
                         'spinner-bounce' => array(
                            'alt' => 'Spinner Icon 1',
                            'img' => get_template_directory_uri() . '/images/theme-options/spinner_icon_1.png'
                        ),                   
                    ),
                    'default'  => 'spinner-circle'
                ), 

                 array(
                    'id' => 'info-loader',
                    'icon' => true,
                    'type' => 'info',
                    'raw' => esc_html__('Page Loader', 'woodstock'),
                ),

                 array(
                    'id'       => 'tdl_page_loader_spinner',
                    'type'     => 'image_select',
                    'compiler' => true,
                    'title'    => esc_html__( 'Page Loader Icon', 'woodstock' ),
                    'subtitle' => esc_html__( 'Select the Page Loader Icon', 'woodstock' ),
                    'required' => array( 'tdl_page_loader', 'equals', array( '1' ) ),
                    'options'  => array(
                        '1' => array(
                            'alt' => 'Spinner Icon 1',
                            'img' => get_template_directory_uri() . '/images/theme-options/main_loader_1.png'
                        ),                        
                        '2' => array(
                            'alt' => 'Spinner Icon 2',
                            'img' => get_template_directory_uri() . '/images/theme-options/main_loader_2.png'
                        ),   
                        '3' => array(
                            'alt' => 'Spinner Icon 3',
                            'img' => get_template_directory_uri() . '/images/theme-options/main_loader_3.png'
                        ),
                        '4' => array(
                            'alt' => 'Spinner Icon 4',
                            'img' => get_template_directory_uri() . '/images/theme-options/main_loader_4.png'
                        ),                                                               
                    ),
                    'default'  => '1'
                ),                 

                array(
                    'subtitle' => esc_html__('Select a color for loader', 'woodstock'),
                    'id' => 'tdl_page_loader_color',
                    'type' => 'color',
                    'title' => esc_html__('Loader Color', 'woodstock'),
                    'default' => '#6990cb',
                    'transparent' => false,
                    'required' => array( 'tdl_page_loader', 'equals', array( '1' ) ),
                ), 


                array(
                    'subtitle' => esc_html__('Select a color for loader background', 'woodstock'),
                    'id' => 'tdl_page_loader_bg',
                    'type' => 'color',
                    'title' => esc_html__('Loader Background Color', 'woodstock'),
                    'default' => '#ffffff',
                    'transparent' => false,
                    'required' => array( 'tdl_page_loader', 'equals', array( '1' ) ),
                ), 

                array(
                    'subtitle' => esc_html__('Enable/Disable Page Loader', 'woodstock'),
                    'id' => 'tdl_page_loader',
                    'on' => esc_html__('Enable', 'woodstock'),
                    'off' => esc_html__('Disable', 'woodstock'),
                    'type' => 'switch',
                    'title' => esc_html__('Page Loader', 'woodstock'),
                    'default' => 0,
                ),                                                             
              
        )
    ) );

/* ---------------------------------------------------------------- */
/* Sticky Header Settings
/* ---------------------------------------------------------------- */


    Redux::setSection( $opt_name, array(
                'icon'       => 'fa fa-angle-right',
                'title' => esc_html__('Sticky Header', 'woodstock'),
                'subsection' => true,
                'fields'    => array(
 
                array(
                    'id' => 'tdl_sticky_introduction',
                    'icon' => true,
                    'type' => 'info',
                    'required' => array( 'tdl_sticky_menu', 'equals', array( '1' ) ),
                    'raw' => esc_html__('Sticky Header Styling', 'woodstock')
                ),                 

                array(
                    'id'       => 'tdl_sticky_color_scheme',
                    'type'     => 'image_select',
                    'compiler' => true,
                    'title' => esc_html__('Sticky Header Color Scheme', 'woodstock'),
                    'subtitle' => esc_html__('Choose the Sticky Header Color Scheme.', 'woodstock'),
                    'required' => array( 'tdl_sticky_menu', 'equals', array( '1' ) ),
                    'options'  => array(
                        'sth-light' => array(
                            'alt' => 'Layout 1',
                            'img' => get_template_directory_uri() . '/images/theme-options/color_1.png'
                        ),
                        'sth-dark' => array(
                            'alt' => 'Layout 2',
                            'img' => get_template_directory_uri() . '/images/theme-options/color_2.png'
                        ),
                    ),
                    'default'  => 'sth-light'
                ),

                array(
                    'title' => esc_html__('Sticky Header Background Color', 'woodstock'),
                    'subtitle' => esc_html__('Sticky Header background color.', 'woodstock'),
                    'id' => 'tdl_sticky_background_color',
                    'type' => 'color',
                    'default' => '#ffffff',
                    'transparent' => false,
                    'required' => array( 'tdl_sticky_menu', 'equals', array( '1' ) )
                ), 

                 array(
                    'id' => 'tdl_sticky_bgcolor_opacity',
                    'type' => 'slider',
                    'title' => esc_html__('Sticky Header Background Opacity', 'woodstock'),
                    'subtitle' => esc_html__('Pick the Opacity for Sticky Header Background', 'woodstock'),
                    'desc' => esc_html__('Min: 0, max: 100, step: 1, default value: 100', 'woodstock'),
                    "default" => 100,
                    "min" => 0,
                    "step" => 1,
                    "max" => 100,
                    'resolution' => 1,
                    'display_value' => 'text',
                ),

                // Sticky Header DropDown

                array(
                    'id' => 'tdl_stickydrop_introduction',
                    'icon' => true,
                    'type' => 'info',
                    'style' => 'warning',
                    'raw' => esc_html__('Sticky Header Navigation Dropdown Styling', 'woodstock')
                ),                 

                array(
                    'id'       => 'tdl_stickydrop_color_scheme',
                    'type'     => 'image_select',
                    'compiler' => true,
                    'title' => esc_html__('Sticky Header Navigation DropDown Color Scheme', 'woodstock'),
                    'subtitle' => esc_html__('Choose the Main Navigation DropDown Color Scheme.', 'woodstock'),
                    'options'  => array(
                        'shd-light' => array(
                            'alt' => 'Layout 1',
                            'img' => get_template_directory_uri() . '/images/theme-options/color_1.png'
                        ),
                        'shd-dark' => array(
                            'alt' => 'Layout 2',
                            'img' => get_template_directory_uri() . '/images/theme-options/color_2.png'
                        ),
                    ),
                    'default'  => 'shd-light'
                ), 

                array(
                    'title' => esc_html__('Sticky Header Navigation DropDown Background Color', 'woodstock'),
                    'subtitle' => esc_html__('Pick the Sticky Header Navigation DropDown Background Color.', 'woodstock'),
                    'id' => 'tdl_stickydrop_bgcolor',
                    'type' => 'color',
                    'default' => '#ffffff',
                    'transparent' => false,
                ), 

                array(
                    'id' => 'tdl_stickydrop_bgcolor_opacity',
                    'type' => 'slider',
                    'title' => esc_html__('Sticky Header Navigation DropDown Background Opacity', 'woodstock'),
                    'subtitle' => esc_html__('Pick the Opacity for Sticky Header Navigation DropDown Background.', 'woodstock'),
                    'desc' => esc_html__('Min: 0, max: 100, step: 1, default value: 100', 'woodstock'),
                    "default" => 100,
                    "min" => 0,
                    "step" => 1,
                    "max" => 100,
                    'resolution' => 1,
                    'display_value' => 'text',
                ),                                               
              
        )
    ) );

/* ---------------------------------------------------------------- */
/* Header Styling
/* ---------------------------------------------------------------- */


    Redux::setSection( $opt_name, array(
                'icon'       => 'fa fa-angle-right',
                'title' => esc_html__('Header', 'woodstock'),
                'subsection' => true,
                'fields'    => array(
 
                // Main Header Styling

                array(
                    'id' => 'introduction',
                    'icon' => true,
                    'type' => 'info',
                    'raw' => esc_html__('Main Header Styling', 'woodstock')
                ),

                array(
                    'id' => 'tdl_header_padding',
                    'type' => 'slider',
                    'title' => esc_html__('Header Paddings (Top/Bottom)', 'woodstock'),
                    'desc' => esc_html__('Drag the slider to set the paddings of the header.', 'woodstock'),
                    "default" => 30,
                    "min" => 0,
                    "step" => 1,
                    "max" => 200,
                    'display_value' => 'text',
                ),

                array(
                    'title' => esc_html__('Header Background Color/Image', 'woodstock'),
                    'subtitle' => esc_html__('Pick the Header background color or select background image.', 'woodstock'),
                    'id' => 'tdl_header_background_color',
                    'type' => 'background',
                    'transparent' => false,
                    'default'  => array(
                        'background-color' => '#ffffff',
                    )
                ),  

                // Top Bar Styling                 

                array(
                    'id' => 'top_bar_introduction',
                    'icon' => true,
                    'type' => 'info',
                    'raw' => esc_html__('Top Bar', 'woodstock'),
                    'required' => array( 'tdl_topbar_switch', 'equals', array( '1' ) )
                ),

                array(
                    'id'       => 'tdl_topbar_color_scheme',
                    'type'     => 'image_select',
                    'compiler' => true,
                    'title' => esc_html__('Top Bar Color Scheme', 'woodstock'),
                    'subtitle' => esc_html__('Choose Top Bar Color Scheme.', 'woodstock'),
                    'required' => array( 'tdl_topbar_switch', 'equals', array( '1' ) ),
                    'options'  => array(
                        'td_light' => array(
                            'alt' => 'Layout 1',
                            'img' => get_template_directory_uri() . '/images/theme-options/color_1.png'
                        ),
                        'td_dark' => array(
                            'alt' => 'Layout 2',
                            'img' => get_template_directory_uri() . '/images/theme-options/color_2.png'
                        ),
                    ),
                    'default'  => 'td_dark'
                ),   

                array(
                    'title' => esc_html__('Top Bar Background Color', 'woodstock'),
                    'subtitle' => esc_html__('The Top Bar background color.', 'woodstock'),
                    'id' => 'tdl_topbar_background_color',
                    'type' => 'color',
                    'default' => '#333333',
                    'transparent' => false,
                    'required' => array( 'tdl_topbar_switch', 'equals', array( '1' ) )
                ),

                array(
                    'id' => 'tdl_topbar_background_opacity',
                    'type' => 'slider',
                    'title' => esc_html__('Top Bar Background Opacity', 'woodstock'),
                    'subtitle' => esc_html__('This example displays float values', 'woodstock'),
                    'desc' => esc_html__('Min: 0, max: 100, step: 1, default value: 100', 'woodstock'),
                    "default" => 100,
                    "min" => 0,
                    "step" => 1,
                    "max" => 100,
                    'resolution' => 1,
                    'display_value' => 'text',
                    'required' => array( 'tdl_topbar_switch', 'equals', array( '1' ) )
                ),  

                array( 
                    'id'       => 'tdl_topbar_border',
                    'type'     => 'border',
                    'top' => false,
                    'left' => false,
                    'right' => false,
                    'title'    => esc_html__('Top Bar Bottom Border Option', 'redux-framework-demo'),
                    'subtitle' => esc_html__('Only color validation can be done on this field type', 'redux-framework-demo'),
                    'desc'     => esc_html__('This is the description field, again good for additional info.', 'redux-framework-demo'),
                    'required' => array( 'tdl_topbar_switch', 'equals', array( '1' ) ),
                    'default'  => array(
                        'border-color'  => '#333', 
                        'border-style'  => 'solid',  
                        'border-bottom' => '1px', 
                    )
                ), 

                array(
                    'id' => 'tdl_topbar_border_opacity',
                    'type' => 'slider',
                    'title' => esc_html__('Top Bar Botom Border Opacity', 'woodstock'),
                    'subtitle' => esc_html__('This example displays float values', 'woodstock'),
                    'desc' => esc_html__('Min: 0, max: 100, step: 1, default value: 100', 'woodstock'),
                    "default" => 100,
                    "min" => 0,
                    "step" => 1,
                    "max" => 100,
                    'resolution' => 1,
                    'display_value' => 'text',
                    'required' => array( 'tdl_topbar_switch', 'equals', array( '1' ) )
                ), 

                array(
                    'id' => 'top_bar_drop_introduction',
                    'icon' => true,
                    'type' => 'info',
                    'style' => 'warning',                   
                    'raw' => esc_html__('Top Bar Dropdown', 'woodstock'),
                    'required' => array( 'tdl_topbar_switch', 'equals', array( '1' ) )
                ),   

                array(
                    'id'       => 'tdl_topbar_drop_color_scheme',
                    'type'     => 'image_select',
                    'compiler' => true,
                    'title' => esc_html__('Top Bar Dropdown Color Scheme', 'woodstock'),
                    'subtitle' => esc_html__('Choose Top Bar Dropdown Color Scheme.', 'woodstock'),
                    'required' => array( 'tdl_topbar_switch', 'equals', array( '1' ) ),
                    'options'  => array(
                        'tbd_light' => array(
                            'alt' => 'Layout 1',
                            'img' => get_template_directory_uri() . '/images/theme-options/color_1.png'
                        ),
                        'tbd_dark' => array(
                            'alt' => 'Layout 2',
                            'img' => get_template_directory_uri() . '/images/theme-options/color_2.png'
                        ),
                    ),
                    'default'  => 'tbd_light'
                ),                 

                array(
                    'title' => esc_html__('Top Bar Dropdown Background Color', 'woodstock'),
                    'subtitle' => esc_html__('Pick the The Top Bar Dropdown background color.', 'woodstock'),
                    'id' => 'tdl_topbar_dropdown_background_color',
                    'type' => 'color',
                    'default' => '#ffffff',
                    'transparent' => false,
                    'required' => array( 'tdl_topbar_switch', 'equals', array( '1' ) )
                ), 

                array(
                    'id' => 'tdl_topbar_dropdown_background_opacity',
                    'type' => 'slider',
                    'title' => esc_html__('Top Bar Dopdown Background Opacity', 'woodstock'),
                    'subtitle' => esc_html__('Pick the Top Bar Dopdown Background Opacity', 'woodstock'),
                    'desc' => esc_html__('Min: 0, max: 100, step: 1, default value: 100', 'woodstock'),
                    "default" => 100,
                    "min" => 0,
                    "step" => 1,
                    "max" => 100,
                    'resolution' => 1,
                    'display_value' => 'text',
                    'required' => array( 'tdl_topbar_switch', 'equals', array( '1' ) )
                ),  

                // Header Search Box Styling              

                array(
                    'id' => 'info_search',
                    'icon' => true,
                    'type' => 'info',
                    'required' => array( 'tdl_header_search_bar', 'equals', array( '1' ) ),
                    'raw' => esc_html__('Header Search Box Styling', 'woodstock')
                ),           

                 array(
                    'id'       => 'tdl_header_search_icon',
                    'type'     => 'image_select',
                    'compiler' => true,
                    'title'    => esc_html__( 'Header Search Box Icon', 'woodstock' ),
                    'subtitle' => esc_html__( 'Select the Header Search Box Icon', 'woodstock' ),
                    'options'  => array(
                        'e601' => array(
                            'alt' => 'Search Icon 1',
                            'img' => get_template_directory_uri() . '/images/theme-options/search_icon_1.png'
                        ),
                        'e604' => array(
                            'alt' => 'Search Icon 2',
                            'img' => get_template_directory_uri() . '/images/theme-options/search_icon_2.png'
                        ),
                        'e605' => array(
                            'alt' => 'Search Icon 3',
                            'img' => get_template_directory_uri() . '/images/theme-options/search_icon_3.png'
                        ),
                    ),
                    'required' => array( 'tdl_header_search_bar', 'equals', array( '1' ) ),
                    'default'  => 'e601'
                ),

                array(
                    'title' => esc_html__('Header Search Box Icon Color', 'woodstock'),
                    'subtitle' => esc_html__('Pick the Header Search Box Icon Color', 'woodstock'),
                    'id' => 'tdl_header_search_icon_color',
                    'type' => 'color',
                    'default' => '#000000',
                    'transparent' => false,
                    'required' => array( 'tdl_header_search_bar', 'equals', array( '1' ) )
                ), 

     
                array(
                    'title' => esc_html__('Custom Header Search bar Icon', 'woodstock'),
                    'subtitle' => esc_html__('Upload your custom Search bar Icon image (45x45 px).<br />Ignore if you want to use the default icon.', 'woodstock'),
                    'id' => 'tdl_header_search_custom_icon',
                    'type' => 'media',
                    'required' => array( 'tdl_header_search_bar', 'equals', array( '1' ) ),
                ),

                array(
                    'title' => esc_html__('Search Box Input Text Color', 'woodstock'),
                    'subtitle' => esc_html__('Pick the Color for Search Box Input Text', 'woodstock'),
                    'id' => 'tdl_header_searchbox_input_color',
                    'type' => 'color',
                    'default' => '#000000',
                    'transparent' => false,
                    'required' => array( 'tdl_header_search_bar', 'equals', array( '1' ) )
                ),

                array(
                    'title' => esc_html__('Search Box Input Background Color', 'woodstock'),
                    'subtitle' => esc_html__('Pick the Color for Search Box Input Background', 'woodstock'),
                    'id' => 'tdl_header_searchbox_background_color',
                    'type' => 'color',
                    'default' => '#f5f5f5',
                    'transparent' => false,
                    'required' => array( 'tdl_header_search_bar', 'equals', array( '1' ) )
                ),

                array(
                    'id' => 'tdl_header_searchbox_background_opacity',
                    'type' => 'slider',
                    'title' => esc_html__('Search Box Input Background Opacity', 'woodstock'),
                    'subtitle' => esc_html__('Pick the Search Box Input Background Opacity', 'woodstock'),
                    'desc' => esc_html__('Min: 0, max: 100, step: 1, default value: 100', 'woodstock'),
                    "default" => 100,
                    "min" => 0,
                    "step" => 1,
                    "max" => 100,
                    'resolution' => 1,
                    'display_value' => 'text',
                    'required' => array( 'tdl_header_search_bar', 'equals', array( '1' ) )
                ),              

                array( 
                    'id'       => 'tdl_header_searchbox_border_color',
                    'type'     => 'border',
                    'title'    => esc_html__('Search Box Input Border', 'woodstock'),
                    'subtitle' => esc_html__('Pick the Color for Search Box Input Border', 'woodstock'),
                    'required' => array( 'tdl_header_search_bar', 'equals', array( '1' ) ),
                    'default'  => array(
                        'border-color'  => '#f5f5f5', 
                        'border-style'  => 'solid',  
                        'border-top'    => '1px', 
                        'border-right'  => '1px', 
                        'border-bottom' => '1px', 
                        'border-left'   => '1px'
                    )
                ),

                array(
                    'id' => 'tdl_header_searchbox_border_opacity',
                    'type' => 'slider',
                    'title' => esc_html__('Search Box Input Border Opacity', 'woodstock'),
                    'subtitle' => esc_html__('Pick the Opacity for Search Box Input Border', 'woodstock'),
                    'required' => array( 'tdl_header_search_bar', 'equals', array( '1' ) ),
                    'desc' => esc_html__('Min: 0, max: 100, step: 1, default value: 100', 'woodstock'),
                    "default" => 100,
                    "min" => 0,
                    "step" => 1,
                    "max" => 100,
                    'resolution' => 1,
                    'display_value' => 'text'
                ),  

                array(
                    'id' => 'tdl_header_ajax_dropdown_introduction',
                    'icon' => true,
                    'type' => 'info',
                    'style' => 'warning',
                    'required' => array( 'tdl_header_customer_bar', 'equals', array( '1' ) ),
                    'raw' => esc_html__('Search Box Ajax DropDown Styling', 'woodstock')
                ), 

                array(
                    'id'       => 'tdl_header_searchboxdrop_color_scheme',
                    'type'     => 'image_select',
                    'compiler' => true,
                    'required' => array( 'tdl_header_search_bar', 'equals', array( '1' ) ),
                    'title' => esc_html__('Search Box Ajax DropDown Color Scheme', 'woodstock'),
                    'subtitle' => esc_html__('Choose the Search Box Ajax DropDown Color Scheme. Should be installed "AJAX AutoSuggest" plugin.', 'woodstock'),
                    'options'  => array(
                        'sd-light' => array(
                            'alt' => 'Layout 1',
                            'img' => get_template_directory_uri() . '/images/theme-options/color_1.png'
                        ),
                        'sd-dark' => array(
                            'alt' => 'Layout 2',
                            'img' => get_template_directory_uri() . '/images/theme-options/color_2.png'
                        ),
                    ),
                    'default'  => 'sd-light'
                ),

                array(
                    'title' => esc_html__('Search Box Ajax DropDown Background Color', 'woodstock'),
                    'subtitle' => esc_html__('Pick the Search Box Ajax DropDown Background Color. Should be installed "AJAX AutoSuggest" plugin.', 'woodstock'),
                    'id' => 'tdl_header_searchboxdrop_bgcolor_scheme',
                    'type' => 'color',
                    'default' => '#ffffff',
                    'transparent' => false,
                    'required' => array( 'tdl_header_search_bar', 'equals', array( '1' ) )
                ),

                array(
                    'id' => 'tdl_header_searchboxdrop_bgcolor_opacity',
                    'type' => 'slider',
                    'title' => esc_html__('Search Box Ajax DropDown Background Opacity', 'woodstock'),
                    'subtitle' => esc_html__('Pick the Opacity for Search Box Ajax DropDown Background.', 'woodstock'),
                    'desc' => esc_html__('Min: 0, max: 100, step: 1, default value: 100', 'woodstock'),
                    "default" => 100,
                    "min" => 0,
                    "step" => 1,
                    "max" => 100,
                    'resolution' => 1,
                    'display_value' => 'text',
                    'required' => array( 'tdl_header_search_bar', 'equals', array( '1' ) )
                ),

                // Customer Support Box Styling

                array(
                    'id' => 'tdl_header_customer_bar_intro',
                    'icon' => true,
                    'type' => 'info',
                    'required' => array( 'tdl_header_customer_bar', 'equals', array( '1' ) ),
                    'raw' => esc_html__('Customer Support Box Styling', 'woodstock')
                ), 

                array(
                    'id'       => 'tdl_header_contactbox_icon',
                    'type'     => 'image_select',
                    'compiler' => true,
                    'title'    => esc_html__( 'Customer Support Box Icon', 'woodstock' ),
                    'subtitle' => esc_html__( 'Select the Customer Support Box Icon', 'woodstock' ),
                    'options'  => array(
                        'none' => array(
                            'alt' => 'Customer Support Icon Disable',
                            'img' => get_template_directory_uri() . '/images/theme-options/contact_icon_0.png'
                        ),                        
                        'e602' => array(
                            'alt' => 'Customer Support Icon 1',
                            'img' => get_template_directory_uri() . '/images/theme-options/contact_icon_1.png'
                        ),
                        'e60c' => array(
                            'alt' => 'Customer Support Icon 2',
                            'img' => get_template_directory_uri() . '/images/theme-options/contact_icon_2.png'
                        ),
                        'e607' => array(
                            'alt' => 'Customer Support Icon 3',
                            'img' => get_template_directory_uri() . '/images/theme-options/contact_icon_3.png'
                        ),
                        'e608' => array(
                            'alt' => 'Customer Support Icon 4',
                            'img' => get_template_directory_uri() . '/images/theme-options/contact_icon_4.png'
                        ),
                        'e60b' => array(
                            'alt' => 'Customer Support Icon 5',
                            'img' => get_template_directory_uri() . '/images/theme-options/contact_icon_5.png'
                        ),                        
                    ),
                    'required' => array( 'tdl_header_customer_bar', 'equals', array( '1' ) ),
                    'default'  => 'e602'
                ),

                array(
                    'title' => esc_html__('Customer Support Box Icon Color', 'woodstock'),
                    'subtitle' => esc_html__('Pick the Color for Customer Support Box Icon', 'woodstock'),
                    'id' => 'tdl_header_customer_bar_icon_color',
                    'type' => 'color',                  
                    'default' => '#000000',
                    'transparent' => false,
                    'required' => array( 'tdl_header_customer_bar', 'equals', array( '1' ) )
                ),

                array(
                    'title' => esc_html__('Custom Customer Support Box Icon', 'woodstock'),
                    'subtitle' => esc_html__('Upload your custom Customer Support Box Icon image (30x30 px).<br />Ignore if you want to use the default icon.', 'woodstock'),
                    'id' => 'tdl_header_customer_bar_icon',
                    'type' => 'media',
                    'required' => array( 'tdl_header_customer_bar', 'equals', array( '1' ) ),
                ), 

                array(
                    'id'       => 'tdl_header_customer_bar_color_scheme',
                    'type'     => 'image_select',
                    'compiler' => true,
                    'required' => array( 'tdl_header_customer_bar', 'equals', array( '1' ) ),
                    'title' => esc_html__('Customer Support Box Color Scheme', 'woodstock'),
                    'subtitle' => esc_html__('Choose the Customer Support Box Color Scheme.', 'woodstock'),
                    'options'  => array(
                        'hc-light' => array(
                            'alt' => 'Layout 1',
                            'img' => get_template_directory_uri() . '/images/theme-options/color_1.png'
                        ),
                        'hc-dark' => array(
                            'alt' => 'Layout 2',
                            'img' => get_template_directory_uri() . '/images/theme-options/color_2.png'
                        ),
                    ),
                    'default'  => 'hc-light'
                ), 

                array(
                    'title' => esc_html__('Customer Support Box Background Color', 'woodstock'),
                    'subtitle' => esc_html__('Pick the Customer Support Box Background Color.', 'woodstock'),
                    'id' => 'tdl_header_customer_bar_bgcolor',
                    'type' => 'color',                  
                    'default' => '#f5f5f5',
                    'transparent' => false,
                    'required' => array( 'tdl_header_customer_bar', 'equals', array( '1' ) )
                ), 

                array(
                    'id' => 'tdl_header_customer_bar_bgcolor_opacity',
                    'type' => 'slider',
                    'title' => esc_html__('Customer Support Box Background Opacity', 'woodstock'),
                    'subtitle' => esc_html__('Pick the Opacity for Customer Support Box', 'woodstock'),
                    'required' => array( 'tdl_header_customer_bar', 'equals', array( '1' ) ),
                    'desc' => esc_html__('Min: 0, max: 100, step: 1, default value: 100', 'woodstock'),
                    "default" => 100,
                    "min" => 0,
                    "step" => 1,
                    "max" => 100,
                    'resolution' => 1,
                    'display_value' => 'text'
                ),                 

                array( 
                    'id'       => 'tdl_header_customer_bar_border_color',
                    'type'     => 'border',
                    'title'    => esc_html__('Customer Support Box Border', 'woodstock'),
                    'subtitle' => esc_html__('Pick the Color for Customer Support Box Border', 'woodstock'),
                    'required' => array( 'tdl_header_customer_bar', 'equals', array( '1' ) ),
                    'default'  => array(
                        'border-color'  => '#f5f5f5', 
                        'border-style'  => 'solid',  
                        'border-top'    => '1px', 
                        'border-right'  => '1px', 
                        'border-bottom' => '1px', 
                        'border-left'   => '1px'
                    )
                ), 

                array(
                    'id' => 'tdl_header_customer_bar_border_opacity',
                    'type' => 'slider',
                    'title' => esc_html__('Customer Support Box Border Opacity', 'woodstock'),
                    'subtitle' => esc_html__('Pick the Opacity for Customer Support Box Border', 'woodstock'),
                    'required' => array( 'tdl_header_customer_bar', 'equals', array( '1' ) ),
                    'desc' => esc_html__('Min: 0, max: 100, step: 1, default value: 100', 'woodstock'),
                    "default" => 100,
                    "min" => 0,
                    "step" => 1,
                    "max" => 100,
                    'resolution' => 1,
                    'display_value' => 'text'
                ),

                array(
                    'id' => 'tdl_header_customer_bar_introduction',
                    'icon' => true,
                    'type' => 'info',
                    'style' => 'warning',
                    'required' => array( 'tdl_header_customer_bar', 'equals', array( '1' ) ),
                    'raw' => esc_html__('Customer Support Box Dropdown Styling', 'woodstock')
                ), 

                array(
                    'id'       => 'tdl_header_customerdrop_color_scheme',
                    'type'     => 'image_select',
                    'compiler' => true,
                    'required' => array( 'tdl_header_customer_bar', 'equals', array( '1' ) ),
                    'title' => esc_html__('Customer Support Box Color Scheme', 'woodstock'),
                    'subtitle' => esc_html__('Choose the Search Customer Support Box Color Scheme.', 'woodstock'),
                    'options'  => array(
                        'csd-light' => array(
                            'alt' => 'Layout 1',
                            'img' => get_template_directory_uri() . '/images/theme-options/color_1.png'
                        ),
                        'csd-dark' => array(
                            'alt' => 'Layout 2',
                            'img' => get_template_directory_uri() . '/images/theme-options/color_2.png'
                        ),
                    ),
                    'default'  => 'csd-light'
                ),

                array(
                    'title' => esc_html__('Customer Support Box DropDown Background Color', 'woodstock'),
                    'subtitle' => esc_html__('Pick the Customer Support Box DropDown Background Color. Should be installed "AJAX AutoSuggest" plugin.', 'woodstock'),
                    'id' => 'tdl_header_customerdrop_bgcolor_scheme',
                    'type' => 'color',
                    'default' => '#ffffff',
                    'transparent' => false,
                    'required' => array( 'tdl_header_customer_bar', 'equals', array( '1' ) )
                ), 

                array(
                    'id' => 'tdl_header_customerdrop_bgcolor_opacity',
                    'type' => 'slider',
                    'title' => esc_html__('Customer Support Box DropDown Background Opacity', 'woodstock'),
                    'subtitle' => esc_html__('Pick the Opacity for Customer Support Box Background.', 'woodstock'),
                    'desc' => esc_html__('Min: 0, max: 100, step: 1, default value: 100', 'woodstock'),
                    "default" => 100,
                    "min" => 0,
                    "step" => 1,
                    "max" => 100,
                    'resolution' => 1,
                    'display_value' => 'text',
                    'required' => array( 'tdl_header_customer_bar', 'equals', array( '1' ) )
                ), 

                // Shopping Cart Box

                array (
                    'id' => 'tdl_header_shopcart_introduction',
                    'icon' => true,
                    'type' => 'info',
                    'required' => array( 'tdl_catalog_mode', 'equals', array( '0' ) ),
                    'raw' => esc_html__('Shopping Cart Box Styling', 'woodstock')
                ),

                array(
                    'id'       => 'tdl_header_shopcart_icon',
                    'type'     => 'image_select',
                    'compiler' => true,
                    'title'    => esc_html__( 'Shopping Cart Box Icon', 'woodstock' ),
                    'subtitle' => esc_html__( 'Select the Shopping Cart Box Icon', 'woodstock' ),
                    'options'  => array(
                       
                        'e600' => array(
                            'alt' => 'Shopping Cart Icon 1',
                            'img' => get_template_directory_uri() . '/images/theme-options/shop_icon_1.png'
                        ),
                        'e603' => array(
                            'alt' => 'Shopping Cart Icon 2',
                            'img' => get_template_directory_uri() . '/images/theme-options/shop_icon_2.png'
                        ),
                        'e606' => array(
                            'alt' => 'Shopping Cart Icon 3',
                            'img' => get_template_directory_uri() . '/images/theme-options/shop_icon_3.png'
                        ), 
                         'e625' => array(
                            'alt' => 'Shopping Cart Icon 4',
                            'img' => get_template_directory_uri() . '/images/theme-options/shop_icon_4.png'
                        ), 
                        'e626' => array(
                            'alt' => 'Shopping Cart Icon 5',
                            'img' => get_template_directory_uri() . '/images/theme-options/shop_icon_5.png'
                        ),                                                                     
                    ),
                    'required' => array( 'tdl_catalog_mode', 'equals', array( '0' ) ),
                    'default'  => 'e600'
                ),

                array(
                    'title' => esc_html__('Customer Shopping Cart Box Icon Color', 'woodstock'),
                    'subtitle' => esc_html__('Pick the Color for Shopping Cart Box Box Icon', 'woodstock'),
                    'id' => 'tdl_header_shopcart_icon_color',
                    'type' => 'color',                  
                    'default' => '#000000',
                    'transparent' => false,
                    'required' => array( 'tdl_catalog_mode', 'equals', array( '0' ) )
                ),

                array(
                    'title' => esc_html__('Custom Shopping Cart Box Icon', 'woodstock'),
                    'subtitle' => esc_html__('Upload your custom Shopping Cart Box Icon image (45x45 px).<br />Ignore if you want to use the default icon.', 'woodstock'),
                    'id' => 'tdl_header_shopcart_custom_icon',
                    'type' => 'media',
                    'required' => array( 'tdl_catalog_mode', 'equals', array( '0' ) ),
                ), 

                array(
                    'id'       => 'tdl_header_shopcart_color_scheme',
                    'type'     => 'image_select',
                    'compiler' => true,
                    'required' => array( 'tdl_catalog_mode', 'equals', array( '0' ) ),
                    'title' => esc_html__('Shopping Cart Box Color Scheme', 'woodstock'),
                    'subtitle' => esc_html__('Choose the Shopping Cart Box Color Scheme.', 'woodstock'),
                    'options'  => array(
                        'shc-light' => array(
                            'alt' => 'Layout 1',
                            'img' => get_template_directory_uri() . '/images/theme-options/color_1.png'
                        ),
                        'shc-dark' => array(
                            'alt' => 'Layout 2',
                            'img' => get_template_directory_uri() . '/images/theme-options/color_2.png'
                        ),
                    ),
                    'default'  => 'shc-light'
                ),

                // Mobile Menu Button

                array(
                    'id' => 'tdl_header_mobmenu_introduction',
                    'icon' => true,
                    'type' => 'info',
                    'raw' => esc_html__('Mobile Menu Button Styling', 'woodstock')
                ),

                array(
                    'id'       => 'tdl_header_mobmenu_color_scheme',
                    'type'     => 'image_select',
                    'compiler' => true,
                    'title' => esc_html__('Mobile Menu Button Color Scheme', 'woodstock'),
                    'subtitle' => esc_html__('Choose the Mobile Menu Button Color Scheme.', 'woodstock'),
                    'options'  => array(
                        'mb-light' => array(
                            'alt' => 'Layout 1',
                            'img' => get_template_directory_uri() . '/images/theme-options/color_1.png'
                        ),
                        'mb-dark' => array(
                            'alt' => 'Layout 2',
                            'img' => get_template_directory_uri() . '/images/theme-options/color_2.png'
                        ),
                    ),
                    'default'  => 'mb-light'
                ),

                array(
                    'title' => esc_html__('Mobile Menu Button Background Color', 'woodstock'),
                    'subtitle' => esc_html__('Pick the Mobile Menu Button Background Color.', 'woodstock'),
                    'id' => 'tdl_header_mobmenu_bgcolor',
                    'type' => 'color',                  
                    'default' => '#f5f5f5',
                    'transparent' => false,
                ),

                array(
                    'id' => 'tdl_header_mobmenu_bgcolor_opacity',
                    'type' => 'slider',
                    'title' => esc_html__('Mobile Menu Button Background Opacity', 'woodstock'),
                    'subtitle' => esc_html__('Pick the Opacity for Mobile Menu Button', 'woodstock'),
                    'desc' => esc_html__('Min: 0, max: 100, step: 1, default value: 100', 'woodstock'),
                    "default" => 100,
                    "min" => 0,
                    "step" => 1,
                    "max" => 100,
                    'resolution' => 1,
                    'display_value' => 'text'
                ),

                array( 
                    'id'       => 'tdl_header_mobmenu_border_color',
                    'type'     => 'border',
                    'title'    => esc_html__('Mobile Menu Button Border', 'woodstock'),
                    'subtitle' => esc_html__('Pick the Color for Mobile Menu Button Border', 'woodstock'),
                    'default'  => array(
                        'border-color'  => '#f5f5f5', 
                        'border-style'  => 'solid',  
                        'border-top'    => '1px', 
                        'border-right'  => '1px', 
                        'border-bottom' => '1px', 
                        'border-left'   => '1px'
                    )
                ), 

                array(
                    'id' => 'tdl_header_mobmenu_border_opacity',
                    'type' => 'slider',
                    'title' => esc_html__('Mobile Menu Button Border Opacity', 'woodstock'),
                    'subtitle' => esc_html__('Pick the Opacity for Mobile Menu Button Border', 'woodstock'),
                    'desc' => esc_html__('Min: 0, max: 100, step: 1, default value: 100', 'woodstock'),
                    "default" => 100,
                    "min" => 0,
                    "step" => 1,
                    "max" => 100,
                    'resolution' => 1,
                    'display_value' => 'text'
                ),                                                                                                                                                                    
        )
    ) );

/* ---------------------------------------------------------------- */
/* Main Navigation Styling
/* ---------------------------------------------------------------- */


    Redux::setSection( $opt_name, array(
                'icon'       => 'fa fa-angle-right',
                'title' => esc_html__('Main Navigation', 'woodstock'),
                'subsection' => true,
                'fields'    => array(
 
            array(
                'id'       => 'tdl_mainnav_color_scheme',
                'type'     => 'image_select',
                'compiler' => true,
                'title' => esc_html__('Main Navigation Color Scheme', 'woodstock'),
                'subtitle' => esc_html__('Choose the Main Navigation Color Scheme.', 'woodstock'),
                'options'  => array(
                        'mn-light' => array(
                            'alt' => 'Layout 1',
                            'img' => get_template_directory_uri() . '/images/theme-options/color_1.png'
                        ),
                        'mn-dark' => array(
                            'alt' => 'Layout 2',
                            'img' => get_template_directory_uri() . '/images/theme-options/color_2.png'
                        ),
                ),
                'default'  => 'mn-light'
            ),

            array(
                'title' => esc_html__('Main Navigation Background Color', 'woodstock'),
                'subtitle' => esc_html__('Pick the Main Navigation Background Color.', 'woodstock'),
                'id' => 'tdl_mainnav_bgcolor',
                'type' => 'color',                  
                'default' => '#ffffff',
                'transparent' => false,
            ),                        

            array(
                'id' => 'tdl_mainnav_bgcolor_opacity',
                'type' => 'slider',
                'title' => esc_html__('Main Navigation Background Opacity', 'woodstock'),
                'subtitle' => esc_html__('Pick the Opacity for Main Navigation', 'woodstock'),
                'desc' => esc_html__('Min: 0, max: 100, step: 1, default value: 100', 'woodstock'),
                "default" => 100,
                "min" => 0,
                "step" => 1,
                "max" => 100,
                'resolution' => 1,
                'display_value' => 'text'
            ),

            array( 
                'id'       => 'tdl_mainnav_border',
                'type'     => 'border',
                'bottom' => false,
                'left' => false,
                'right' => false,
                'title'    => esc_html__('Main Navigation Border Option', 'redux-framework-demo'),
                'subtitle' => esc_html__('Only color validation can be done on this field type', 'redux-framework-demo'),
                'desc'     => esc_html__('This is the description field, again good for additional info.', 'redux-framework-demo'),
                'default'  => array(
                    'border-color'  => '#f5f5f5', 
                    'border-style'  => 'solid',  
                    'border-top' => '1px', 
                    'border-bottom' => '1px',
                )
            ), 

            array(
                'id' => 'tdl_mainnav_border_opacity',
                'type' => 'slider',
                'title' => esc_html__('Main Navigation Border Opacity', 'woodstock'),
                'subtitle' => esc_html__('This example displays float values', 'woodstock'),
                'desc' => esc_html__('Min: 0, max: 100, step: 1, default value: 100', 'woodstock'),
                "default" => 100,
                "min" => 0,
                "step" => 1,
                "max" => 100,
                'resolution' => 1,
                'display_value' => 'text',
            ), 

            // Main navigation DropDown

                array (
                    'id' => 'tdl_mainnav_introduction',
                    'icon' => true,
                    'type' => 'info',
                    'style' => 'warning',
                    'raw' => esc_html__('Main Navigation Dropdown Styling', 'woodstock')
                ),  

                array(
                    'id'       => 'tdl_mainnavdrop_color_scheme',
                    'type'     => 'image_select',
                    'compiler' => true,
                    'title' => esc_html__('Main Navigation DropDown Color Scheme', 'woodstock'),
                    'subtitle' => esc_html__('Choose the Main Navigation DropDown Color Scheme.', 'woodstock'),
                    'options'  => array(
                        'mnd-light' => array(
                            'alt' => 'Layout 1',
                            'img' => get_template_directory_uri() . '/images/theme-options/color_1.png'
                        ),
                        'mnd-dark' => array(
                            'alt' => 'Layout 2',
                            'img' => get_template_directory_uri() . '/images/theme-options/color_2.png'
                        ),
                    ),
                    'default'  => 'mnd-light'
                ),

                array(
                    'title' => esc_html__('Main Navigation DropDown Background Color', 'woodstock'),
                    'subtitle' => esc_html__('Pick the Main Navigation DropDown Background Color.', 'woodstock'),
                    'id' => 'tdl_mainnavdrop_bgcolor',
                    'type' => 'color',
                    'default' => '#ffffff',
                    'transparent' => false,
                ),

                array(
                    'id' => 'tdl_mainnavdrop_bgcolor_opacity',
                    'type' => 'slider',
                    'title' => esc_html__('Main Navigation DropDown Background Opacity', 'woodstock'),
                    'subtitle' => esc_html__('Pick the Opacity for Main Navigation Background.', 'woodstock'),
                    'desc' => esc_html__('Min: 0, max: 100, step: 1, default value: 100', 'woodstock'),
                    "default" => 100,
                    "min" => 0,
                    "step" => 1,
                    "max" => 100,
                    'resolution' => 1,
                    'display_value' => 'text',
                ),
              
        )
    ) );

/* ---------------------------------------------------------------- */
/* Main Title Area Styling
/* ---------------------------------------------------------------- */


    Redux::setSection( $opt_name, array(
                'icon'       => 'fa fa-angle-right',
                'title' => esc_html__('Main Title Area', 'woodstock'),
                'subsection' => true,
                'fields'    => array(
 
            array(
                'id' => 'info-shop-title',
                'icon' => true,
                'type' => 'info',
                'raw' => esc_html__('Shop Title Area', 'woodstock')
            ),

            array(
                'title' => esc_html__('Main Title Area Background Color', 'woodstock'),
                'subtitle' => esc_html__('Pick the Default Main Title Area Background Color.', 'woodstock'),
                'id' => 'tdl_title_bgcolor',
                'type' => 'color',                  
                'default' => '#f5f5f5',
                'transparent' => false,
            ),

            array(
                'desc' => 'Select Background Image for Default Shop Title Area',
                'id' => 'tdl_default_header_bg',
                'type' => 'media',
                'title' => 'Default Shop Title Area Background Image',
                'url' => false,                 
            ), 

            array(
                'id'       => 'tdl_title_color_scheme',
                'type'     => 'image_select',
                'compiler' => true,
                'title' => esc_html__('Main Title Area Color Scheme', 'woodstock'),
                'subtitle' => esc_html__('Choose the Default Main Title Area Color Scheme.', 'woodstock'),
                'options'  => array(
                        'mta-light' => array(
                            'alt' => 'Layout 1',
                            'img' => get_template_directory_uri() . '/images/theme-options/color_1.png'
                        ),
                        'mta-dark' => array(
                            'alt' => 'Layout 2',
                            'img' => get_template_directory_uri() . '/images/theme-options/color_2.png'
                        ),
                ),
                'default'  => 'mta-light'
            ),

            array (
                'id'       => 'tdl_title_align',
                'type'     => 'image_select',
                'compiler' => true,
                'title'    => esc_html__( 'Default Title Content Align', 'woodstock' ),
                'subtitle' => esc_html__( 'Select the Default Title Content Align.', 'woodstock' ),
                'options'  => array(
                    'title-left' => array(
                        'alt' => 'Left Align',
                        'img' => get_template_directory_uri() . '/images/theme-options/title_align_1.png'
                    ),
                    'title-center' => array(
                        'alt' => 'Center Align',
                        'img' => get_template_directory_uri() . '/images/theme-options/title_align_2.png'
                    ),
                ),
                'default'  => 'title-left'
            ),

            array(
                'title' => esc_html__('Shop Header Parallax', 'woodstock'),
                'subtitle' => esc_html__('Enable / Disable Parallax in the Shop Header.', 'woodstock'),
                'id' => 'tdl_shop_header_parallax',
                'on' => esc_html__('Enabled', 'woodstock'),
                'off' => esc_html__('Disabled', 'woodstock'),
                'type' => 'switch',
                'default' => 1,
            ),



            array(
                'title' => esc_html__('Shopping Cart Title Area', 'woodstock'),
                'subtitle' => esc_html__('Show / Hide Title Area in Shopping Cart Page', 'woodstock'),
                'id' => 'tdl_shop_titlearea_cart',
                'on' => esc_html__('Show', 'woodstock'),
                'off' => esc_html__('Hide', 'woodstock'),
                'type' => 'switch',
                'default' => 1,
            ),

            array(
                'title' => esc_html__('Checkout Page Title Area', 'woodstock'),
                'subtitle' => esc_html__('Show / Hide Title Area in Checkout Page', 'woodstock'),
                'id' => 'tdl_shop_titlearea_checkout',
                'on' => esc_html__('Show', 'woodstock'),
                'off' => esc_html__('Hide', 'woodstock'),
                'type' => 'switch',
                'default' => 1,
            ),

            array(
                'title' => esc_html__('My Account Title Area', 'woodstock'),
                'subtitle' => esc_html__('Show / Hide Title Area in My Account Section', 'woodstock'),
                'id' => 'tdl_shop_titlearea_myaccount',
                'on' => esc_html__('Show', 'woodstock'),
                'off' => esc_html__('Hide', 'woodstock'),
                'type' => 'switch',
                'default' => 1,
            ),            

            // Pages Title Area 

            array(
                'id' => 'info-page-title',
                'icon' => true,
                'type' => 'info',
                'raw' => esc_html__('Pages Title Area', 'woodstock')
            ), 

            array(
                'title' => esc_html__('Page Title Area Background Color', 'woodstock'),
                'subtitle' => esc_html__('Pick the Default Page Title Area Background Color.', 'woodstock'),
                'id' => 'tdl_page_title_bgcolor',
                'type' => 'color',                  
                'default' => '#f5f5f5',
                'transparent' => false,
            ),

            array(
                'desc' => 'Select Background Image for Default Page Title Area',
                'id' => 'tdl_page_default_header_bg',
                'type' => 'media',
                'title' => 'Default Page Area Background Image',
                'url' => false,                 
            ),

            array(
                'id'       => 'tdl_page_title_color_scheme',
                'type'     => 'image_select',
                'compiler' => true,
                'title' => esc_html__('Page Title Area Color Scheme', 'woodstock'),
                'subtitle' => esc_html__('Choose the Default Page Title Area Color Scheme.', 'woodstock'),
                'options'  => array(
                        'mta-light' => array(
                            'alt' => 'Layout 1',
                            'img' => get_template_directory_uri() . '/images/theme-options/color_1.png'
                        ),
                        'mta-dark' => array(
                            'alt' => 'Layout 2',
                            'img' => get_template_directory_uri() . '/images/theme-options/color_2.png'
                        ),
                ),
                'default'  => 'mta-light'
            ),

            array(
                    'id'       => 'tdl_page_title_align',
                    'type'     => 'image_select',
                    'compiler' => true,
                    'title'    => esc_html__( 'Default Page Title Content Align', 'woodstock' ),
                    'subtitle' => esc_html__( 'Select the Default Page Title Content Align.', 'woodstock' ),
                    'options'  => array(
                        'title-left' => array(
                            'alt' => 'Left Align',
                            'img' => get_template_directory_uri() . '/images/theme-options/title_align_1.png'
                        ),
                        'title-center' => array(
                            'alt' => 'Center Align',
                            'img' => get_template_directory_uri() . '/images/theme-options/title_align_2.png'
                        ),
                    ),
                    'default'  => 'title-left'
                ),            

            array(
                'title' => esc_html__('Page Header Parallax', 'woodstock'),
                'subtitle' => esc_html__('Enable / Disable Parallax in the Page Header.', 'woodstock'),
                'id' => 'tdl_page_header_parallax',
                'on' => esc_html__('Enabled', 'woodstock'),
                'off' => esc_html__('Disabled', 'woodstock'),
                'type' => 'switch',
                'default' => 1,
            ), 

           // Blog Title Area 

            array(
                'id' => 'info-blog-title',
                'icon' => true,
                'type' => 'info',
                'raw' => esc_html__('Blog Title Area', 'woodstock')
            ), 

            array(
                'title' => esc_html__('Blog Title Area Background Color', 'woodstock'),
                'subtitle' => esc_html__('Pick the Default Blog Title Area Background Color.', 'woodstock'),
                'id' => 'tdl_blog_title_bgcolor',
                'type' => 'color',                  
                'default' => '#f5f5f5',
                'transparent' => false,
            ),

            array(
                'desc' => 'Select Background Image for Default Blog Title Area',
                'id' => 'tdl_blog_default_header_bg',
                'type' => 'media',
                'title' => 'Default Blog Title Area Background Image',
                'url' => false,                 
            ), 

            array(
                'id'       => 'tdl_blog_title_color_scheme',
                'type'     => 'image_select',
                'compiler' => true,
                'title' => esc_html__('Blog Title Area Color Scheme', 'woodstock'),
                'subtitle' => esc_html__('Choose the Default Blog Title Area Color Scheme.', 'woodstock'),
                'options'  => array(
                        'mta-light' => array(
                            'alt' => 'Layout 1',
                            'img' => get_template_directory_uri() . '/images/theme-options/color_1.png'
                        ),
                        'mta-dark' => array(
                            'alt' => 'Layout 2',
                            'img' => get_template_directory_uri() . '/images/theme-options/color_2.png'
                        ),
                ),
                'default'  => 'mta-light'
            ),

            array(
                    'id'       => 'tdl_blog_title_align',
                    'type'     => 'image_select',
                    'compiler' => true,
                    'title'    => esc_html__( 'Default Blog Title Content Align', 'woodstock' ),
                    'subtitle' => esc_html__( 'Select the Default Blog Title Content Align.', 'woodstock' ),
                    'options'  => array(
                        'title-left' => array(
                            'alt' => 'Left Align',
                            'img' => get_template_directory_uri() . '/images/theme-options/title_align_1.png'
                        ),
                        'title-center' => array(
                            'alt' => 'Center Align',
                            'img' => get_template_directory_uri() . '/images/theme-options/title_align_2.png'
                        ),
                    ),
                    'default'  => 'title-left'
                ), 

            array(
                'title' => esc_html__('Blog Header Parallax', 'woodstock'),
                'subtitle' => esc_html__('Enable / Disable Parallax in the Blog Header.', 'woodstock'),
                'id' => 'tdl_blog_header_parallax',
                'on' => esc_html__('Enabled', 'woodstock'),
                'off' => esc_html__('Disabled', 'woodstock'),
                'type' => 'switch',
                'default' => 1,
            ), 
              
        )
    ) );

/* ---------------------------------------------------------------- */
/* General Settings
/* ---------------------------------------------------------------- */


    Redux::setSection( $opt_name, array(
                'icon'       => 'fa fa-angle-right',
                'title' => esc_html__('Main Content', 'woodstock'),
                'subsection' => true,
                'fields'    => array(

                array(
                    'title' => esc_html__('Main Content Background Color', 'woodstock'),
                    'subtitle' => esc_html__('Pick the Default Main Title Content Background Color.', 'woodstock'),
                    'id' => 'tdl_content_bgcolor',
                    'type' => 'color',                  
                    'default' => '#ffffff',
                    'transparent' => false,
                ),  

                array(
                    'id'       => 'tdl_maincontent_color_scheme',
                    'type'     => 'image_select',
                    'compiler' => true,
                    'title' => esc_html__('Main Content Color Scheme', 'woodstock'),
                    'subtitle' => esc_html__('Choose the Main Content Color Scheme', 'woodstock'),
                    'options'  => array(
                        'mc-light' => array(
                            'alt' => 'Layout 1',
                            'img' => get_template_directory_uri() . '/images/theme-options/color_1.png'
                        ),
                        'mc-dark' => array(
                            'alt' => 'Layout 2',
                            'img' => get_template_directory_uri() . '/images/theme-options/color_2.png'
                        ),
                    ),
                    'default'  => 'mc-light'
                ),


                array(
                    'id' => 'introduction',
                    'icon' => true,
                    'type' => 'info',
                    'raw' => esc_html__('Product Grid Styling', 'woodstock')
                ),

                array(
                    'id'       => 'tdl_product_border',
                    'type'     => 'image_select',
                    'compiler' => true,
                    'title' => esc_html__('Product Item Border', 'woodstock'),
                    'subtitle' => esc_html__('Choose to display or not Product Border', 'woodstock'),
                    'options'  => array(
                        'border' => array(
                            'alt' => 'With Border',
                            'img' => get_template_directory_uri() . '/images/theme-options/product_align_1.png'
                        ),
                        'no-border' => array(
                            'alt' => 'Without Border',
                            'img' => get_template_directory_uri() . '/images/theme-options/product_align_11.png'
                        ),
                    ),
                    'default'  => 'border'
                ),


                array(
                    'title' => esc_html__('Product Item Border Color', 'woodstock'),
                    'subtitle' => esc_html__('Pick the Product Border Color', 'woodstock'),
                    'id' => 'tdl_product_border_color',
                    'type' => 'color',                  
                    'default' => '#f5f5f5',
                    'transparent' => false,
                    'required' => array( 'tdl_product_border', 'equals', array( 'border' ) )
                ),

                array(
                    'id'       => 'tdl_product_align',
                    'type'     => 'image_select',
                    'compiler' => true,
                    'title' => esc_html__('Product Item Align', 'woodstock'),
                    'subtitle' => esc_html__('Choose the Product Item Align', 'woodstock'),
                    'options'  => array(
                        'palign-left' => array(
                            'alt' => 'Left Align',
                            'img' => get_template_directory_uri() . '/images/theme-options/product_align_1.png'
                        ),
                        'palign-center' => array(
                            'alt' => 'Center Align',
                            'img' => get_template_directory_uri() . '/images/theme-options/product_align_2.png'
                        ),
                    ),
                    'default'  => 'palign-left'
                ),

              
        )
    ) );

/* ---------------------------------------------------------------- */
/* Sidebars Styling
/* ---------------------------------------------------------------- */


    Redux::setSection( $opt_name, array(
                'icon'       => 'fa fa-angle-right',
                'title' => esc_html__('Sidebars', 'woodstock'),
                'subsection' => true,
                'fields'    => array(
 
                // Offcanvas Navigation

                array(
                    'id' => 'tdl_sidebarnav_introduction',
                    'icon' => true,
                    'type' => 'info',
                    'style' => 'warning',
                    'raw' => esc_html__('Offcanvas Left Sidebar Styling', 'woodstock')
                ), 

                array(
                    'id'       => 'tdl_sidebarnav_color_scheme',
                    'type'     => 'image_select',
                    'compiler' => true,
                    'title' => esc_html__('Offcanvas Navigation Sidebar Color Scheme', 'woodstock'),
                    'subtitle' => esc_html__('Choose the Offcanvas Navigation Sidebar Color Scheme.', 'woodstock'),
                    'options'  => array(
                        'snd-light' => array(
                            'alt' => 'Layout 1',
                            'img' => get_template_directory_uri() . '/images/theme-options/color_1.png'
                        ),
                        'snd-dark' => array(
                            'alt' => 'Layout 2',
                            'img' => get_template_directory_uri() . '/images/theme-options/color_2.png'
                        ),
                    ),
                    'default'  => 'snd-light'
                ),

                // Offcanvas Shopping Cart

                array(
                    'id' => 'tdl_sidebarcart_introduction',
                    'icon' => true,
                    'type' => 'info',
                    'style' => 'warning',
                    'raw' => esc_html__('Offcanvas Right Shopping Cart Styling', 'woodstock')
                ),

                array(
                    'id'       => 'tdl_sidebarcart_color_scheme',
                    'type'     => 'image_select',
                    'compiler' => true,
                    'title' => esc_html__('Offcanvas Shopping Cart Color Scheme', 'woodstock'),
                    'subtitle' => esc_html__('Choose the Offcanvas Shopping Cart Color Scheme.', 'woodstock'),
                    'options'  => array(
                        'scd-light' => array(
                            'alt' => 'Layout 1',
                            'img' => get_template_directory_uri() . '/images/theme-options/color_1.png'
                        ),
                        'scd-dark' => array(
                            'alt' => 'Layout 2',
                            'img' => get_template_directory_uri() . '/images/theme-options/color_2.png'
                        ),
                    ),
                    'default'  => 'scd-light'
                ),

        )
    ) );

/* ---------------------------------------------------------------- */
/* Footer Styling
/* ---------------------------------------------------------------- */


    Redux::setSection( $opt_name, array(
                'icon'       => 'fa fa-angle-right',
                'title' => esc_html__('Footer', 'woodstock'),
                'subsection' => true,
                'fields'    => array(

                // Offcanvas Navigation

                array(
                    'title' => esc_html__('Footer Background Color', 'woodstock'),
                    'subtitle' => esc_html__('Pick the Footer Background Color', 'woodstock'),
                    'id' => 'tdl_footer_bgcolor',
                    'type' => 'color',                  
                    'default' => '#333333',
                    'transparent' => false,
                ),  

                array(
                    'id'       => 'tdl_footer_color_scheme',
                    'type'     => 'image_select',
                    'compiler' => true,
                    'title' => esc_html__('Footer Color Scheme', 'woodstock'),
                    'subtitle' => esc_html__('Choose the Footer Color Scheme.', 'woodstock'),
                    'options'  => array(
                        'fc-light' => array(
                            'alt' => 'Layout 1',
                            'img' => get_template_directory_uri() . '/images/theme-options/color_1.png'
                        ),
                        'fc-dark' => array(
                            'alt' => 'Layout 2',
                            'img' => get_template_directory_uri() . '/images/theme-options/color_2.png'
                        ),
                    ),
                    'default'  => 'fc-dark'
                ), 
        )
    ) );

/* ---------------------------------------------------------------- */
/* General Settings
/* ---------------------------------------------------------------- */


    Redux::setSection( $opt_name, array(
            'title' => esc_html__('Typography', 'woodstock'),
            'icon'  => 'fa fa-font',
            'fields'    => array(
 
                array(
                    'id' => 'tdl_typo_introduction',
                    'icon' => true,
                    'type' => 'info',
                    'style' => 'warning',
                    'raw' => esc_html__('Content Typography', 'woodstock')
                ),

                array(
                    'id'=>'tdl_content_font',
                    'type' => 'typography',
                    'title' => esc_html__('Body Font', 'woodstock'),
                    'subtitle' => esc_html__('Specify the body font properties.', 'woodstock'),
                    'google'=> true,
                    'font-backup'=>true,
                    'text-align'=>false,
                    'color'=>false,
                    'font-size'     => true,
                    'line-height'   => true,
                    'letter-spacing'=>true,
                    'all_styles' => true, // Enable all Google Font style/weight variations to be added to the page
                    'output' => array('body,p,.contact-info .contact-info-title .contact-info-subtitle, nav#nav ul ul li a, nav#st-nav ul ul li a, .ajax_autosuggest_item_description, input[type="search"], .tooltipster-default .tooltipster-content, .arthref .icon-container ul li span, .blog-list-comment i span'), // An array of CSS selectors to apply this font style to dynamically
                    'compiler' => array('body,p,.contact-info .contact-info-title .contact-info-subtitle, nav#nav ul ul li a, nav#st-nav ul ul li a, .ajax_autosuggest_item_description, input[type="search"], .tooltipster-default .tooltipster-content, .arthref .icon-container ul li span, .blog-list-comment i span'), // An array of CSS selectors to apply this font style to dynamically
                    'units'=>'px', // Defaults to px
                    'default' => array(
                        'font-size'     => '16px',
                        'line-height'     => '26px',
                        'font-family'=>'Lato',
                        'font-weight'=>'300',
                        'letter-spacing'  => 0,
                        'subsets' => 'latin'
                        ),
                    ),

                array(
                    'id' => 'tdl_typo_introduction',
                    'icon' => true,
                    'type' => 'info',
                    'style' => 'warning',
                    'raw' => esc_html__('Heading Typography', 'woodstock')
                ),

                    array(
                        'id'=>'tdl_h1_heading_font',
                        'type' => 'typography',
                        'title' => esc_html__('H1 Heading Font', 'woodstock'),
                        'subtitle' => esc_html__('Specify the H1 font properties.', 'woodstock'),
                        'google'=> true,
                        'font-backup'=>true,
                        'text-align'=>false,
                        'font-size'     => true,
                        'line-height'   => true,
                        'color'=>false,
                        'letter-spacing'=>true,
                        'all_styles' => true, // Enable all Google Font style/weight variations to be added to the page
                        'output' => array('h1, #jckqv h1'), // An array of CSS selectors to apply this font style to dynamically
                        'compiler' => array('h1, #jckqv h1'), // An array of CSS selectors to apply this font style to dynamically
                        'units'=>'px', // Defaults to px
                        'default' => array(
                            'font-size'     => '36px',
                            'line-height'     => '50px',
                            'font-family'=>'Lato',
                            'font-weight'=>'700',
                            'letter-spacing'  => 0,
                            'subsets' => 'latin'
                            ),
                        ),

                    array(
                        'id'=>'tdl_h2_heading_font',
                        'type' => 'typography',
                        'title' => esc_html__('H2 Heading Font', 'woodstock'),
                        'subtitle' => esc_html__('Specify the H2 font properties.', 'woodstock'),
                        'google'=> true,
                        'font-backup'=>true,
                        'text-align'=>false,
                        'font-size'     => true,
                        'line-height'   => true,
                        'color'=>false,
                        'letter-spacing'=>true,
                        'all_styles' => true, // Enable all Google Font style/weight variations to be added to the page
                        'output' => array('h2, .widget_shopping_cart .total .amount, .account-tab-link'), // An array of CSS selectors to apply this font style to dynamically
                        'compiler' => array('h2, .widget_shopping_cart .total .amount, .account-tab-link'), // An array of CSS selectors to apply this font style to dynamically
                        'units'=>'px', // Defaults to px
                        'default' => array(
                            'font-size'     => '30px',
                            'line-height'     => '42px',
                            'font-family'=>'Lato',
                            'font-weight'=>'700',
                            'letter-spacing'  => 0,
                            'subsets' => 'latin'
                            ),
                        ),

                    array(
                        'id'=>'tdl_h3_heading_font',
                        'type' => 'typography',
                        'title' => esc_html__('H3 Heading Font', 'woodstock'),
                        'subtitle' => esc_html__('Specify the H3 font properties.', 'woodstock'),
                        'google'=> true,
                        'font-backup'=>true,
                        'text-align'=>false,
                        'font-size'     => true,
                        'line-height'   => true,
                        'color'=>false,
                        'letter-spacing'=>true,
                        'all_styles' => true, // Enable all Google Font style/weight variations to be added to the page
                        'output' => array('h3, .contact-info .contact-info-title, .contact-info .inside-area .inside-area-content span.phone, .mobile-menu-button a span, #mobiles-menu-offcanvas .mobile-menu-text'), // An array of CSS selectors to apply this font style to dynamically
                        'compiler' => array('h3, .contact-info .contact-info-title, .contact-info .inside-area .inside-area-content span.phone, .mobile-menu-button a span,  #mobiles-menu-offcanvas .mobile-menu-text'), // An array of CSS selectors to apply this font style to dynamically
                        'units'=>'px', // Defaults to px
                        'default' => array(
                            'font-size'     => '24px',
                            'line-height'     => '34px',
                            'font-family'=>'Lato',
                            'font-weight'=>'700',
                            'letter-spacing'  => 0,
                            'subsets' => 'latin'
                            ),
                        ),

                   array(
                        'id'=>'tdl_h4_heading_font',
                        'type' => 'typography',
                        'title' => esc_html__('H4 Heading Font', 'woodstock'),
                        'subtitle' => esc_html__('Specify the H4 font properties.', 'woodstock'),
                        'google'=> true,
                        'font-backup'=>true,
                        'text-align'=>false,
                        'font-size'     => true,
                        'line-height'   => true,
                        'color'=>false,
                        'letter-spacing'=>true,
                        'all_styles' => true, // Enable all Google Font style/weight variations to be added to the page
                        'output' => array('h4, .ajax_autosuggest_suggestions .ajax_autosuggest_category, #minicart-offcanvas .widget .widget_shopping_cart_content .product-name a, .woocommerce div.product .woocommerce-tabs ul.tabs li a, .woocommerce #content div.product .woocommerce-tabs ul.tabs li a, .woocommerce-page div.product .woocommerce-tabs ul.tabs li a, .woocommerce-page #content div.product .woocommerce-tabs ul.tabs li a, .shop_sidebar ul.product_list_widget li a .product-title, .woocommerce table.shop_table th, .woocommerce-page table.shop_table th, .cart-collaterals .shipping-calculator-button, .wc-block-grid__product .wc-block-grid__product-title, .widget .wp-block-woocommerce-all-reviews ul.wc-block-components-review-list li .wc-block-review-list-item__info .wc-block-review-list-item__meta .wc-block-review-list-item__product a'), // An array of CSS selectors to apply this font style to dynamically
                        'compiler' => array('h4, .ajax_autosuggest_suggestions .ajax_autosuggest_category, #minicart-offcanvas .widget .widget_shopping_cart_content .product-name a, .woocommerce div.product .woocommerce-tabs ul.tabs li a, .woocommerce #content div.product .woocommerce-tabs ul.tabs li a, .woocommerce-page div.product .woocommerce-tabs ul.tabs li a, .woocommerce-page #content div.product .woocommerce-tabs ul.tabs li a, .shop_sidebar ul.product_list_widget li a .product-title, .woocommerce table.shop_table th, .woocommerce-page table.shop_table th, .cart-collaterals .shipping-calculator-button, .wc-block-grid__product .wc-block-grid__product-title, .widget .wp-block-woocommerce-all-reviews ul.wc-block-components-review-list li .wc-block-review-list-item__info .wc-block-review-list-item__meta .wc-block-review-list-item__product a'), // An array of CSS selectors to apply this font style to dynamically
                        'units'=>'px', // Defaults to px
                        'default' => array(
                            'font-size'     => '18px',
                            'line-height'     => '25px',
                            'font-family'=>'Lato',
                            'font-weight'=>'700',
                            'letter-spacing'  => 0,
                            'subsets' => 'latin'
                            ),
                        ),

                    array(
                        'id'=>'tdl_h5_heading_font',
                        'type' => 'typography',
                        'title' => esc_html__('H5 Heading Font', 'woodstock'),
                        'subtitle' => esc_html__('Specify the H5 font properties.', 'woodstock'),
                        'google'=> true,
                        'font-backup'=>true,
                        'text-align'=>false,
                        'font-size'     => true,
                        'line-height'   => true,
                        'color'=>false,
                        'letter-spacing'=>true,
                        'all_styles' => true, // Enable all Google Font style/weight variations to be added to the page
                        'output' => array('h5, .ajax_autosuggest_suggestions li span.searchheading, .l-header-shop span.amount'), // An array of CSS selectors to apply this font style to dynamically
                        'compiler' => array('h5, .ajax_autosuggest_suggestions li span.searchheading, .l-header-shop span.amount'), // An array of CSS selectors to apply this font style to dynamically
                        'units'=>'px', // Defaults to px
                        'default' => array(
                            'font-size'     => '18px',
                            'line-height'     => '25px',
                            'font-family'=>'Lato',
                            'font-weight'=>'700',
                            'letter-spacing'  => 0,
                            'subsets' => 'latin'
                            ),
                        ),

                    array(
                        'id'=>'tdl_h6_heading_font',
                        'type' => 'typography',
                        'title' => esc_html__('H6 Heading Font', 'woodstock'),
                        'subtitle' => esc_html__('Specify the H6 font properties.', 'woodstock'),
                        'google'=> true,
                        'font-backup'=>true,
                        'text-align'=>false,
                        'font-size'     => true,
                        'line-height'   => true,
                        'color'=>false,
                        'letter-spacing'=>true,
                        'all_styles' => true, // Enable all Google Font style/weight variations to be added to the page
                        'output' => array('h6'), // An array of CSS selectors to apply this font style to dynamically
                        'compiler' => array('h6'), // An array of CSS selectors to apply this font style to dynamically
                        'units'=>'px', // Defaults to px
                        'default' => array(
                            'font-size'     => '12px',
                            'line-height'     => '17px',
                            'font-family'=>'Lato',
                            'font-weight'=>'700',
                            'letter-spacing'  => 0,
                            'subsets' => 'latin'
                            ),
                        ),

                 array (
                    'id' => 'tdl_typo_introduction',
                    'icon' => true,
                    'type' => 'info',
                    'style' => 'warning',
                    'raw' => esc_html__('Navigation Typography', 'woodstock')
                ),

                    array(
                        'id'=>'tdl_nav_font',
                        'type' => 'typography',
                        'title' => esc_html__('Navigation Font', 'woodstock'),
                        'subtitle' => esc_html__('Specify the Navigation font properties.', 'woodstock'),
                        'google'=> true,
                        'font-backup'=>true,
                        'text-align'=>false,
                        'font-size'     => true,
                        'line-height'   => true,
                        'color'=>false,
                        'text-transform'  => true,
                        'letter-spacing'=>true,
                        'all_styles' => true, // Enable all Google Font style/weight variations to be added to the page
                        'output' => array('nav#nav ul li > a, nav#st-nav ul li > a, #page_header_wrap .tdl-megamenu-wrapper .tdl-megamenu-title, #page_header_wrap .tdl-megamenu-wrapper .tdl-megamenu-title a, .mobile-navigation a, .mob-language-and-currency .select2-chosen'), // An array of CSS selectors to apply this font style to dynamically
                        'compiler' => array('nav#nav ul li > a, nav#st-nav ul li > a, #page_header_wrap .tdl-megamenu-wrapper .tdl-megamenu-title, #page_header_wrap .tdl-megamenu-wrapper .tdl-megamenu-title a, .mobile-navigation a, .mob-language-and-currency .select2-chosen'), // An array of CSS selectors to apply this font style to dynamically
                        'units'=>'px', // Defaults to px
                        'default' => array(
                            'font-family'=>'Lato',
                            'font-size'=>'17px',
                            'font-height'=>'22px',
                            'font-weight'=>'700',
                            'letter-spacing'  => 0,
                            'subsets' => 'latin',
                            'text-transform' => 'uppercase'
                            ),
                        ),

                    array(
                        'id'            => 'tdl_subnav_font',
                        'type'          => 'typography',
                        'title'         => esc_html__('Submenu/Subtitle Navigation Font', 'redux-framework-demo'),
                        //'compiler'      => true,  // Use if you want to hook in your own CSS compiler
                        'google'        => true,    // Disable google fonts. Won't work if you haven't defined your google api key
                        'font-backup'   => false,    // Select a backup non-google font in addition to a google font
                        'subsets'       => true, // Only appears if google is true and subsets not set to false
                        'font-size'     => false,
                        'line-height'   => false,
                        'text-align'   => false,
                        'letter-spacing'   => true,


                        'color'         => false,
                        //'preview'       => false, // Disable the previewer
                        'all_styles'    => false,    // Enable all Google Font style/weight variations to be added to the page
                        'units'         => 'px', // Defaults to px
                        'subtitle'      => esc_html__('Pick the navigation font for your website.', 'redux-framework-demo'),
                        'default'       => array(
                            'font-family'   => 'Lato',
                            'google'        => true,
                            'font-style'  => '300',
                            'letter-spacing'  => 0,
                            'subsets' => 'latin-ext'
                            ),
                    ),
                                                           

        )
    ) );

/* ---------------------------------------------------------------- */
/* Social Settings
/* ---------------------------------------------------------------- */


    Redux::setSection( $opt_name, array(
                'icon'   => 'fa fa-share',
                'title'  => esc_html__( 'Social Media / Sharing', 'woodstock' ),
                'fields'    => array(

                    array (
                        'id' => 'tdl_share_intro',
                        'icon' => true,
                        'type' => 'info',
                        'style' => 'warning',
                        'raw' => esc_html__('Social Network for Sharing', 'woodstock')
                    ),                   

                        array (
                            'id'       => 'tdl_share_select',
                            'type'     => 'select',
                            'multi'    => true,
                            'title'    => esc_html__('Social Network for Share', 'woodstock'), 
                            'subtitle' => esc_html__('Select Social Networks for Share', 'woodstock'),
                            //Must provide key => value pairs for radio options
                            'options'  => array(
                                'twitter' => 'Twitter',
                                'facebook' => 'Facebook',
                                'google' => 'Google+',
                                'pinterest' => 'Pinterest',
                                'linkedin' => 'LinkedIn',
                                'vk' => 'Vkontakte',
                                'blogger' => 'Blogger',
                                'delicious' => 'Delicious',
                                'digg' => 'Digg',
                                'friendFeed' => 'FriendFeed',
                                'myspace' => 'MySpace',
                                'stumbleUpon' => 'StumbleUpon',
                                'tumblr' => 'Tumblr',
                                'windows' => 'Windows',
                                'yahoo' => 'Yahoo',
                                'whatsapp' => 'WhatsApp'),
                            'default'  => array('twitter','facebook','google','pinterest','linkedin'),
                        ),

                    array (
                        'id' => 'tdl_social_intro',
                        'icon' => true,
                        'type' => 'info',
                        'style' => 'warning',
                        'raw' => esc_html__('Social Networks profiles', 'woodstock')
                    ),                            
 
                        array (
                            'title' => __('<i class="fa fa-twitter"></i> Twitter', 'woodstock'),
                            'subtitle' => esc_html__('Type your Twitter profile URL here.', 'woodstock'),
                            'id' => 'twitter_link',
                            'type' => 'text',
                            'default' => 'http://twitter.com/username',
                        ),                        
                        
                        array (
                            'title' => __('<i class="fa fa-facebook"></i> Facebook', 'woodstock'),
                            'subtitle' => esc_html__('Type your Facebook profile URL here.', 'woodstock'),
                            'id' => 'facebook_link',
                            'type' => 'text',
                            'default' => 'https://www.facebook.com/username',
                        ),

                        array (
                            'title' => __('<i class="fa fa-google-plus"></i> Google+', 'woodstock'),
                            'subtitle' => esc_html__('Type your Google+ profile URL here.', 'woodstock'),
                            'id' => 'googleplus_link',
                            'type' => 'text',
                        ), 

                        array (
                            'title' => __('<i class="fa fa-pinterest"></i> Pinterest', 'woodstock'),
                            'subtitle' => esc_html__('Type your Pinterest profile URL here.', 'woodstock'),
                            'id' => 'pinterest_link',
                            'type' => 'text',
                            'default' => 'http://www.pinterest.com/',
                        ),

                        array (
                            'title' => __('<i class="fa fa-vimeo-square"></i> Vimeo', 'woodstock'),
                            'subtitle' => esc_html__('Type your Vimeo profile URL here.', 'woodstock'),
                            'id' => 'vimeo_link',
                            'type' => 'text',
                        ), 
                        
                        array (
                            'title' => __('<i class="fa fa-youtube-play"></i> Youtube', 'woodstock'),
                            'subtitle' => esc_html__('Type your Youtube profile URL here.', 'woodstock'),
                            'id' => 'youtube_link',
                            'type' => 'text',
                        ),  

                        array (
                            'title' => __('<i class="fa fa-flickr"></i> Flickr', 'woodstock'),
                            'subtitle' => esc_html__('Type your Flickr profile URL here.', 'woodstock'),
                            'id' => 'flickr_link',
                            'type' => 'text',
                        ),

                       array (
                            'title' => __('<i class="fa fa-skype"></i> Skype', 'woodstock'),
                            'subtitle' => esc_html__('Type your Skype profile URL here.', 'woodstock'),
                            'id' => 'skype_link',
                            'type' => 'text',
                        ),

                        array (
                            'title' => __('<i class="fa fa-behance"></i> Behance', 'woodstock'),
                            'subtitle' => esc_html__('Type your Behance profile URL here.', 'woodstock'),
                            'id' => 'behance_link',
                            'type' => 'text',
                        ),

                        array (
                            'title' => __('<i class="fa fa-dribbble"></i> Dribble', 'woodstock'),
                            'subtitle' => esc_html__('Type your Dribble profile URL here.', 'woodstock'),
                            'id' => 'dribble_link',
                            'type' => 'text',
                        ),

                        array (
                            'title' => __('<i class="fa fa-tumblr"></i> Tumblr', 'woodstock'),
                            'subtitle' => esc_html__('Type your Tumblr URL here.', 'woodstock'),
                            'id' => 'tumblr_link',
                            'type' => 'text',
                        ),

                        array (
                            'title' => __('<i class="fa fa-linkedin"></i> LinkedIn', 'woodstock'),
                            'subtitle' => esc_html__('Type your LinkedIn profile URL here.', 'woodstock'),
                            'id' => 'linkedin_link',
                            'type' => 'text',
                        ),

                        array (
                            'title' => __('<i class="fa fa-github"></i> Github', 'woodstock'),
                            'subtitle' => esc_html__('Type your Github profile URL here.', 'woodstock'),
                            'id' => 'github_link',
                            'type' => 'text',
                        ),

                        array (
                            'title' => __('<i class="fa fa-vine"></i> Vine', 'woodstock'),
                            'subtitle' => esc_html__('Type your Vine profile URL here.', 'woodstock'),
                            'id' => 'vine_link',
                            'type' => 'text',
                        ),

                        array (
                            'title' => __('<i class="fa fa-instagram"></i> Instagram', 'woodstock'),
                            'subtitle' => esc_html__('Type your Instagram profile URL here.', 'woodstock'),
                            'id' => 'instagram_link',
                            'type' => 'text',
                        ),

                        array (
                            'title' => __('<i class="fa fa-dropbox"></i> Dropbox', 'woodstock'),
                            'subtitle' => esc_html__('Type your Dropbox profile URL here.', 'woodstock'),
                            'id' => 'dropbox_link',
                            'type' => 'text',
                        ),

                        array (
                            'title' => __('<i class="fa fa-rss"></i> RSS', 'woodstock'),
                            'subtitle' => esc_html__('Type your RSS Feed URL here.', 'woodstock'),
                            'id' => 'rss_link',
                            'type' => 'text',
                        ),
                        
                        array (
                            'title' => __('<i class="fa fa-stumbleupon"></i> Stumbleupon', 'woodstock'),
                            'subtitle' => esc_html__('Type your Stumbleupon URL here.', 'woodstock'),
                            'id' => 'stumbleupon_link',
                            'type' => 'text',
                        ),
                        
                        array (
                            'title' => __('<i class="fa fa-paypal"></i> Paypal', 'woodstock'),
                            'subtitle' => esc_html__('Type your Paypal URL here.', 'woodstock'),
                            'id' => 'paypal_link',
                            'type' => 'text',
                        ),

                        array (
                            'title' => __('<i class="fa fa-foursquare"></i> Foursquare', 'woodstock'),
                            'subtitle' => esc_html__('Type your Foursquare profile URL here.', 'woodstock'),
                            'id' => 'foursquare_link',
                            'type' => 'text',
                        ), 

                        array (
                            'title' => __('<i class="fa fa-soundcloud"></i> Soundcloud', 'woodstock'),
                            'subtitle' => esc_html__('Type your Soundcloud profile URL here.', 'woodstock'),
                            'id' => 'soundcloud_link',
                            'type' => 'text',
                        ),                                          

                        array (
                            'title' => __('<i class="fa fa-spotify"></i> Spotify', 'woodstock'),
                            'subtitle' => esc_html__('Type your Spotify profile URL here.', 'woodstock'),
                            'id' => 'spotify_link',
                            'type' => 'text',
                        ),                        

                        array (
                            'title' => __('<i class="fa fa-vk"></i> VKontakte', 'woodstock'),
                            'subtitle' => esc_html__('Type your VK profile URL here.', 'woodstock'),
                            'id' => 'vk_link',
                            'type' => 'text',
                        ),                        

                        array (
                            'title' => __('<i class="fa fa-android"></i> Android', 'woodstock'),
                            'subtitle' => esc_html__('Type your Android URL here.', 'woodstock'),
                            'id' => 'android_link',
                            'type' => 'text',
                        ), 

                        array (
                            'title' => __('<i class="fa fa-apple"></i> Apple', 'woodstock'),
                            'subtitle' => esc_html__('Type your Apple URL here.', 'woodstock'),
                            'id' => 'apple_link',
                            'type' => 'text',
                        ),
                        
                        array (
                            'title' => __('<i class="fa fa-windows"></i> Windows', 'woodstock'),
                            'subtitle' => esc_html__('Type your Windows profile URL here.', 'woodstock'),
                            'id' => 'windows_link',
                            'type' => 'text',
                        ), 

                         array (
                            'title' => __('<i class="fa fa-yelp"></i> Yelp', 'woodstock'),
                            'subtitle' => esc_html__('Type your Yelp profile URL here.', 'woodstock'),
                            'id' => 'yelp_link',
                            'type' => 'text',
                        ), 

                         array (
                            'title' => __('<i class="fa fa-bandcamp"></i> Bandcam', 'woodstock'),
                            'subtitle' => esc_html__('Type your Bandcamp profile URL here.', 'woodstock'),
                            'id' => 'bandcamp_link',
                            'type' => 'text',
                        ),  

                        array (
                            'title' => __('<i class="fa fa-whatsapp"></i> WhatsApp', 'woodstock'),
                            'subtitle' => esc_html__('Type your WhatsApp profile URL here.', 'woodstock'),
                            'id' => 'whatsapp_link',
                            'type' => 'text',
                        ),
                        
                        array (
                            'title' => __('<i class="fa fa-etsy"></i> Etsy', 'woodstock'),
                            'subtitle' => esc_html__('Type your Etsy profile URL here.', 'woodstock'),
                            'id' => 'etsy_link',
                            'type' => 'text',
                        ),                       
              
        )
    ) );

/* ---------------------------------------------------------------- */
/* Blog Settings
/* ---------------------------------------------------------------- */


    Redux::setSection( $opt_name, array(
            'title' => esc_html__('Blog Settings', 'woodstock'),
            'icon'   => 'fa fa-comments-o',
            'fields'    => array(
 
                array(
                    'id'       => 'tdl_blog_layout',
                    'type'     => 'image_select',
                    'compiler' => true,
                    'title'    => esc_html__( 'Blog Layout', 'woodstock' ),
                    'subtitle' => esc_html__( 'Select the layout style for the Blog Listing.', 'woodstock' ),
                    'options'  => array(
                        '0' => array(
                            'alt' => 'No Sidebar',
                            'img' => get_template_directory_uri() . '/images/theme-options/blog-layout-1.png'
                        ),
                        '1' => array(
                            'alt' => 'Right Sidebar',
                            'img' => get_template_directory_uri() . '/images/theme-options/blog-layout-2.png'
                        ),
                    ),
                    'default'  => '1'
                ),

                array(
                    'id'       => 'tdl_single_blog_layout',
                    'type'     => 'image_select',
                    'compiler' => true,
                    'title'    => esc_html__( 'Single Blog Post Layout', 'woodstock' ),
                    'subtitle' => esc_html__( 'Select the layout style for the Blog Post.', 'woodstock' ),
                    'options'  => array(
                        '0' => array(
                            'alt' => 'No Sidebar',
                            'img' => get_template_directory_uri() . '/images/theme-options/blog-layout-1.png'
                        ),
                        '1' => array(
                            'alt' => 'Right Sidebar',
                            'img' => get_template_directory_uri() . '/images/theme-options/blog-layout-2.png'
                        ),
                    ),
                    'default'  => '1'
                ),

                array(
                    'title' => esc_html__('Blog Post Title Area', 'woodstock'),
                    'subtitle' => esc_html__('Show / Hide Blog Title Area on Single Post', 'woodstock'),
                    'id' => 'tdl_blog_post_title',
                    'on' => esc_html__('Show', 'woodstock'),
                    'off' => esc_html__('Hide', 'woodstock'),
                    'type' => 'switch',
                    'default' => 0,
                ),                

                array(
                    'title' => esc_html__('Sharing Options', 'woodstock'),
                    'subtitle' => esc_html__('Enable / Disable Sharing Options on Blog single page.', 'woodstock'),
                    'id' => 'tdl_blog_sharing_options',
                    'on' => esc_html__('Enabled', 'woodstock'),
                    'off' => esc_html__('Disabled', 'woodstock'),
                    'type' => 'switch',
                    'default' => 0,
                ),  
              
        )
    ) );

/* ---------------------------------------------------------------- */
/* Custom Code Settings
/* ---------------------------------------------------------------- */


    Redux::setSection( $opt_name, array(
            'title' => esc_html__('Custom Code', 'woodstock'),
            'icon'   => 'fa fa-code',
            'fields'    => array(

                array(
                    'subtitle' => esc_html__('Paste your custom CSS code here. The code will be added to the header of your site.', 'woodstock'),
                    'id' => 'tdl_custom_css',
                    'type' => 'ace_editor',
                    'mode' => 'css',
                    'title' => esc_html__('Custom CSS', 'woodstock'),
                ),

                array(
                    'subtitle' => esc_html__('Here is the place to paste your Google Analytics code or any other JS code you might want to add to be loaded in the footer of your website.', 'woodstock'),
                    'id' => 'tdl_custom_js_footer',
                    'type' => 'ace_editor',
                    'mode' => 'javascript',
                    'title' => esc_html__('Google Analytics / Footer JavaScript Code', 'woodstock'),
                ), 

        )
    ) );

    Redux::setSection( $opt_name, array(
            'title' => esc_html__('Theme Documentation', 'woodstock'),
            'icon'   => 'fa fa-file-text-o',
            'fields'    => array(

            array(
                'id'   => 'info_docs',
                'type' => 'info',
                'style' => 'warning',
                'desc' => __('
                <a href="https://temashdesign.ticksy.com/articles/100001538/" target="_blank"><strong>Woodstock Theme&#39;s Documentation</strong></a></br> Everything you need to know about the theme, from installation and setup to customization.</br></br>
                <a href="http://codex.wordpress.org/Installing_WordPress" target="_blank"><strong>Installing WordPress</strong></a></br> Installing WordPress</br></br>
                <a href="https://www.youtube.com/playlist?list=PLfOXCtnURNbZjLUyU_Isp39VdAjqEctNw" target="_blank"><strong>WordPress for Beginners 2015</strong></a></br> WordPress for Beginners 2015 is a course specifically designed by the great folks from WordPress Informer for those who want to learn WordPress step-by-step, from the very beginning.</br></br>
                <a href="https://docs.woothemes.com/documentation/plugins/woocommerce/" target="_blank"><strong>WooThemes Documentation</strong></a></br> Documentation, Reference Materials, and Tutorials for your WooThemes products</br></br>
                <a href="https://www.youtube.com/playlist?list=PLHdG8zvZd0E575Ia8Mu3w1h750YLXNfsC" target="_blank"><strong>WooCommerce 101</strong></a></br> This series of videos covers anything and everything you&#39;d need to know about installing & setting up WooCommerce.</br></br>', 'redux-framework-demo')
            ),

        )
    ) );




    if( ! function_exists( 'woodstock_typography_compiler' ) ) {
        function woodstock_typography_compiler($options, $css, $changed_values) {
            echo '<h1>The compiler hook has run!</h1>';
             
            print_r ($options);
            print_r ($css);
            print_r ($changed_values);
        }
    }



