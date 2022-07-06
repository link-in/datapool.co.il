<?php
/**
 * Single Product Up-Sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/up-sells.php.
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

        if ( ( !isset($tdl_options['tdl_related_products_per_view']) ) ) {
            $products_per_column = 4;
        } else {
            $products_per_column = $tdl_options['tdl_related_products_per_view'];
        }


    if ($products_per_column == 6) {
        $products_per_column_xlarge = 6;
        $products_per_column_large = 4;
        $products_per_column_medium = 3;
    }

    if ($products_per_column == 5) {
        $products_per_column_xlarge = 5;
        $products_per_column_large = 4;
        $products_per_column_medium = 3;
    }

    if ($products_per_column == 4) {
        $products_per_column_xlarge = 4;
        $products_per_column_large = 4;
        $products_per_column_medium = 3;
    }

    if ($products_per_column == 3) {
        $products_per_column_xlarge = 3;
        $products_per_column_large = 3;
        $products_per_column_medium = 2;
    }

    if ($products_per_column == 2) {
        $products_per_column_xlarge = 2;
        $products_per_column_large = 2;
        $products_per_column_medium = 2;
    }

if ( $upsells ) : ?>


	<div class="upsells products">

		<h2><?php esc_html_e( 'You may also like&hellip;', 'woocommerce' ) ?></h2>

        <ul id="products" class="products products-grid small-block-grid-2 medium-block-grid-<?php echo esc_attr($products_per_column_medium); ?> large-block-grid-<?php echo esc_attr($products_per_column_large); ?> xlarge-block-grid-<?php echo esc_attr($products_per_column_xlarge); ?> xxlarge-block-grid-<?php echo esc_attr($products_per_column); ?> columns-<?php echo esc_attr($products_per_column); ?> product-layout-grid">

            <?php foreach ( $upsells as $upsell ) : ?>

                <?php
                    $post_object = get_post( $upsell->get_id() );
                    setup_postdata( $GLOBALS['post'] =& $post_object );
                    wc_get_template_part( 'content', 'product' ); ?>

                <?php endforeach; ?>

		</ul>

	</div>

<?php endif;

wp_reset_postdata();
