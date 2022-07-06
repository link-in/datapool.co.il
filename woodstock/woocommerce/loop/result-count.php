<?php
/**
 * Result Count
 *
 * Shows text: Showing x - x of x results.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/result-count.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$tdl_options = woodstock_global_var();
?>
<p class="woocommerce-result-count">
	<?php
	// phpcs:disable WordPress.Security
	if ( 1 === intval( $total ) ) {
		_e( 'Showing the single result', 'woocommerce' );
	} elseif ( $total <= $per_page || -1 === $per_page ) {
		/* translators: %d: total results */
		printf( _n( 'Showing all %d result', 'Showing all %d results', $total, 'woocommerce' ), $total );
	} else {
		$first = ( $per_page * $current ) - $per_page + 1;
		$last  = min( $total, $per_page * $current );
		/* translators: 1: first result 2: last result 3: total results */
		printf( _nx( 'Showing %1$d&ndash;%2$d of %3$d result', 'Showing %1$d&ndash;%2$d of %3$d results', $total, 'with first and last result', 'woocommerce' ), $first, $last, $total );
	}
	// phpcs:enable WordPress.Security
	?>
</p>

<ul class="shop-ordering">
    <?php 
    $product_display_type = (!empty($tdl_options['tdl_product_display_type'])) ? $tdl_options['tdl_product_display_type'] : 'grid';
    ?>

    <li>
        <div class="shop-layout-opts" data-display-type="<?php echo esc_attr($product_display_type); ?>">
            <a href="#" class="layout-opt tooltip" data-layout="grid" title="<?php esc_html_e('Grid Layout', 'woodstock'); ?>"><i class="grid-icon <?php if ($product_display_type == "grid") {echo 'active';} ?>"></i></a>
            <a href="#" class="layout-opt tooltip" data-layout="list" title="<?php esc_html_e('List Layout', 'woodstock'); ?>"><i class="list-icon <?php if ($product_display_type == "list") {echo 'active';} ?>"></i></a>
        </div>           
    </li>

    <?php do_action( 'woodstock_per_page_loop' );?>

    <li><?php do_action( 'woocommerce_before_shop_loop_catalog_ordering' ); ?></li>
</ul>