<?php
/**
 * Product Loop Start
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

global $woocommerce_loop;
$tdl_options = woodstock_global_var();
$custom_products_columns = (!empty($tdl_options['tdl_products_per_column'])) ? $tdl_options['tdl_products_per_column'] : '4';
$product_display_type = (!empty($tdl_options['tdl_product_display_type'])) ? $tdl_options['tdl_product_display_type'] : 'grid';
?>

<?php 


if ( WC()->version < '3.3.0' ){
	
	if ( ( isset($woocommerce_loop['columns']) && $woocommerce_loop['columns'] != "" ) ) {
		$products_per_column = $woocommerce_loop['columns'];
	} else {
		if ( ( !isset($custom_products_columns) ) ) {
			$products_per_column = 4;
		} else {
			$products_per_column = $custom_products_columns;

	        if (isset($_GET["products_per_column"])) $products_per_column = $_GET["products_per_column"];
		}
	}

} else {

	if ( isset( $woocommerce_loop['is_shortcode'] ) && !$woocommerce_loop['is_shortcode'] && !wc_get_loop_prop( 'is_shortcode' ) ) {
		$value = ( $custom_products_columns );
		wc_set_loop_prop( 'columns', $value );
	}

	$products_per_column = wc_get_loop_prop( 'columns' );
	if (isset($_GET["products_per_column"])) $products_per_column = $_GET["products_per_column"];

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
?>


<ul id="products" class="product-category-list products products-grid small-block-grid-2 medium-block-grid-<?php echo esc_attr($products_per_column_medium); ?> large-block-grid-<?php echo esc_attr($products_per_column_large); ?> xlarge-block-grid-<?php echo esc_attr($products_per_column_xlarge); ?> xxlarge-block-grid-<?php echo esc_attr($products_per_column); ?> columns-<?php echo esc_attr($products_per_column); ?> product-layout-<?php echo esc_attr($product_display_type);?>">