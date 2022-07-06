<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     3.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$tdl_options = woodstock_global_var();

if ( $related_products ) : ?>
  

        <div id="products-carousel">

        <?php
        $heading = apply_filters( 'woocommerce_product_related_products_heading', __( 'Related products', 'woocommerce' ) );

        if ( $heading ) :
            ?>
            <h2 class="carousel-title"><?php echo esc_html( $heading ); ?></h2>
        <?php endif; ?>            

            <ul id="products" class="products products-grid product-layout-grid owl-carousel owl-theme">

            <?php foreach ( $related_products as $related_product ) : ?>

                    <?php
                    $post_object = get_post( $related_product->get_id() );

                    setup_postdata( $GLOBALS['post'] =& $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

                    wc_get_template_part( 'content', 'product' );
                    ?>

            <?php endforeach; ?>

            </ul>

        </div>


    <?php
    
    if ( ( !isset($tdl_options['tdl_related_products_per_view']) ) ) {
        $related_products_per_view = 4;
    } else {
        $related_products_per_view = $tdl_options['tdl_related_products_per_view'];
    }
    
    ?>

    <script>
    jQuery(document).ready(function($) {

        "use strict";

        var owl = $('#products-carousel #products');
        owl.owlCarousel({
            rtl: (woodstock_scripts_vars.rtl === 'true'),
            items:<?php echo esc_attr($related_products_per_view); ?>,
            lazyLoad:true,
            dots:true,
            responsiveClass:true,
            nav:true,
            mouseDrag:true,
            navText: [
                "",
                ""
            ],
            responsive:{
                0:{
                    items:2,
                    nav:false,
                },
                600:{
                    items:3,
                    nav:false,
                },
                1000:{
                    items:4,
                    nav:true,
                    dots:false,
                },
                1200:{
                    items:<?php echo esc_attr($related_products_per_view); ?>,
                    nav:true,
                    dots:false,
                }
            }
        });
    
    });
    </script>



<?php endif;

wp_reset_postdata();
