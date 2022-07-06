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
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$tdl_options = woodstock_global_var();

global $woocommerce;
global $product;
// Related products are found from category and tag
$cats_array = array(0);
// Get categories
$terms = wp_get_post_terms($product->id, 'product_cat');
foreach ( $terms as $key => $term ){
    $check_for_children = get_categories(array('parent' => $term->term_id, 'taxonomy' => 'product_cat'));
    if(empty($check_for_children)){
        $cats_array[] = $term->term_id;
    }
}
// Don't bother if none are set
if ( sizeof($cats_array)==1 ) return array();
// Meta query
$meta_query = array();
$meta_query[] = $woocommerce->query->visibility_meta_query();
$meta_query[] = $woocommerce->query->stock_status_meta_query();
$meta_query   = array_filter( $meta_query );
// Get the posts

$related_products_list = get_posts( array(
        'orderby'        => 'rand',
        'posts_per_page' => 12,
        'post_type'      => 'product',
        'fields'         => 'ids',
        'meta_query'     => $meta_query,
        'tax_query'      => array(
            'relation'      => 'OR',
            array(
                'taxonomy'     => 'product_cat',
                'field'        => 'id',
                'terms'        => $cats_array
            )
        )
    ) );
foreach($related_products_list as $_product){
    $related_products[] = wc_get_product($_product);
}


if ( $related_products ) : ?>
  

        <div id="products-carousel">

        <h2 class="carousel-title"><?php esc_html_e( 'Related products', 'woocommerce' ); ?></h2>

            <ul id="products" class="products products-grid product-layout-grid owl-carousel owl-theme">

            <?php foreach ( $related_products as $related_product ) : ?>

                <?php
                    $post_object = get_post( $related_product->get_id() );

                    setup_postdata( $GLOBALS['post'] =& $post_object );

                    wc_get_template_part( 'content', 'product' ); ?>

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
