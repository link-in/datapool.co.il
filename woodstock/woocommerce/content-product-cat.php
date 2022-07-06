<?php
/**
 * The template for displaying product category thumbnails within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product-cat.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$thumbnail_id = get_term_meta( $category->term_id, 'thumbnail_id', true );
$image = wp_get_attachment_url( $thumbnail_id );

?>

<li class="category_grid_item">
	<div class="category_grid_box">
	<span class="category_item_bkg" style="background-image:url(<?php echo esc_url($image); ?>)"></span>
	<a class="category_item" href="<?php echo get_term_link( $category->slug, 'product_cat' ); ?>">
		<span class="category_name">
			<h3><?php echo esc_html($category->name); ?></h3>
			<span><?php echo sprintf (_n( '%d item', '%d items', $category->count , 'woodstock'), $category->count ); ?></span>
		</span>
	</a>
	</div>                                           
</li>
