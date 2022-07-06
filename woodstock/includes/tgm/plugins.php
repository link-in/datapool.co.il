<?php

function woodstock_theme_register_required_plugins() {

  $plugins = array(
        'woocommerce' => array(
        'name'               => 'WooCommerce',
        'slug'               => 'woocommerce',
        'required'           => true,
        'description'        => 'The eCommerce engine of your WordPress site.',
        'demo_required'      => true
        ),

        'redux-framework'=> array(
            'name'               => 'Redux Framework',
            'slug'               => 'redux-framework',
            'required'           => true,
            'description'        => 'Build better sites in WordPress fast!',
            'demo_required'      => true
          ),

        'woodstock-extensions' => array(
            'name'               => 'Woodstock Extensions',
            'slug'               => 'woodstock-extensions',
            'source'             => 'https://temash.design/tdplugins/woodstock/2.8/woodstock-extensions.zip',
            'required'           => true,
            'external_url'       => '',
            'description'        => 'Extends the functionality of with theme-specific features.',
            'demo_required'      => true,
            'version'            => '2.5'
        ),

        'js_composer' => array(
          'name'               => 'WPBakery Page Builder',
          'slug'               => 'js_composer',
          'source'             => 'https://temash.design/tdplugins/woodstock/2.7/js_composer.zip',
          'required'           => true,
          'external_url'       => '',
          'description'        => 'The page builder plugin coming with the theme.',
          'demo_required'      => true,
          'version'            => '6.7.0'
        ),
        'revslider' => array(
          'name'               => 'Slider Revolution',
          'slug'               => 'revslider',
          'source'             => 'https://temash.design/tdplugins/woodstock/2.7/revslider.zip',
          'required'           => false,
          'external_url'       => '',
          'description'        => 'Slider Revolution - Premium responsive slider',
          'demo_required'      => true,
          'version'            => '6.5.8'
        ),  

        'masterslider' => array(
            'name'               => 'Master Slider Pro',
            'slug'               => 'masterslider',
            'source'             => 'https://temash.design/tdplugins/woodstock/2.7/masterslider.zip',
            'required'           => false,
            'external_url'       => '',
            'description'        => 'Master Slider is the most advanced responsive HTML5 WordPress slider plugin with layer and Touch Swipe Navigation that works smoothly on devices too.',
            'demo_required'      => true,
            'version'            => '3.5.7'
        ), 

        'jck-woo-quickview' => array(
            'name'               => 'WooCommerce Quickview',
            'slug'               => 'jck-woo-quickview',
            'source'             => 'https://temash.design/tdplugins/woodstock/2.7/jck-woo-quickview.zip',
            'required'           => false,
            'external_url'       => '',
            'description'        => 'Quickview plugin for WooCommerce',
            'demo_required'      => true,
            'version'            => '3.4.6'
        ), 

        'advanced-custom-fields'=> array(
            'name'               => 'Advanced Custom Fields',
            'slug'               => 'advanced-custom-fields',
            'required'           => false,
            'description'        => 'Customize WordPress with powerful, professional and intuitive fields.',
            'demo_required'      => true      
        ), 

        'breadcrumb-navxt'=> array(
            'name'               => 'Breadcrumb NavXT',
            'slug'               => 'breadcrumb-navxt',
            'required'           => false,
            'description'        => 'Adds a breadcrumb navigation showing the visitors path to their current location.',
            'demo_required'      => false      
        ), 

        'yith-woocommerce-wishlist'=> array(
          'name'               => 'YITH WooCommerce Wishlist',
          'slug'               => 'yith-woocommerce-wishlist',
          'required'           => false,
          'description'        => 'YITH WooCommerce Wishlist gives your users the possibility to create, fill, manage and share their wishlists allowing you to analyze their interests and needs to improve your marketing strategies.',
          'demo_required'      => false
        ), 

        'contact-form-7'=> array(
          'name'               => 'Contact Form 7',
          'slug'               => 'contact-form-7',
          'required'           => false,
          'description'        => 'Just another contact form plugin. Simple but flexible.',
          'demo_required'      => false
        ), 
        // 'variation-swatches-for-woocommerce'=> array(
        //   'name'               => 'WooCommerce Variation Swatches',
        //   'slug'               => 'variation-swatches-for-woocommerce',
        //   'required'           => false,
        //   'description'        => 'An extension of WooCommerce to make variable products be more beauty and friendly with users.',
        //   'demo_required'      => false
        // ),         

        'envato-market'        => array(
          'name'               => 'Envato Market',
          'slug'               => 'envato-market',
          'required'           => false,
          'demo_required'      => false,
          'source'             => 'https://envato.github.io/wp-envato-market/dist/envato-market.zip',
          'description'        => 'Enables updates for all your Envato purchases.',
        ),

        'safe-svg'=> array(
          'name'               => 'Safe SVG',
          'slug'               => 'safe-svg',
          'required'           => false,
          'description'        => 'Allows SVG uploads into WordPress and sanitizes the SVG before saving it',
          'demo_required'      => true
        ),
      );

  $config = array(
    'id'               => 'woodstock',
    'default_path'      => '',
    'parent_slug'       => 'themes.php',
    'menu'              => 'tgmpa-install-plugins',
    'has_notices'       => false,
    'is_automatic'      => true,
  );

  tgmpa( $plugins, $config );
}

add_action( 'tgmpa_register', 'woodstock_theme_register_required_plugins' );


