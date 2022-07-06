<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

$tdl_options = woodstock_global_var();

//woocommerce_before_single_product_summary
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
	
add_action( 'woocommerce_before_single_product_summary_product_images', 'woocommerce_show_product_images', 20 );

//custom actions
add_action( 'woocommerce_product_summary_thumbnails', 'woocommerce_show_product_thumbnails', 20 );

//woocommerce_single_product_summary
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
// remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );

add_action( 'woocommerce_single_product_summary_single_title', 'woocommerce_template_single_title', 5 );
add_action( 'woocommerce_single_product_summary_single_rating', 'woocommerce_template_single_rating', 10 );
add_action( 'woocommerce_single_product_summary_single_price', 'woocommerce_template_single_price', 10 );
add_action( 'woocommerce_single_product_summary_single_excerpt', 'woocommerce_template_single_excerpt', 20 );
add_action( 'woocommerce_single_product_summary_single_meta', 'woocommerce_template_single_meta', 40 );
// add_action( 'woocommerce_single_product_summary_single_add_to_cart', 'woocommerce_template_single_add_to_cart', 30 );

//woocommerce_after_single_product_summary
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
	
add_action( 'woocommerce_after_single_product_summary_data_tabs', 'woocommerce_output_product_data_tabs', 10 );

$product_sidebar = (!empty($tdl_options['tdl_product_sidebar'])) ? $tdl_options['tdl_product_sidebar'] : '3'; 

if ($product_sidebar == 1) {$product_sidebar = 'left-sidebar';} else if ($product_sidebar == 2) {$product_sidebar = 'right-sidebar';} else {$product_sidebar = 'full-width';};
if (isset($_GET["product_sidebar"])) { $product_sidebar = $_GET["product_sidebar"]; }
?>


<div class="row">
	<div class="large-12 columns">
	<?php
		/**
		 * woocommerce_before_single_product hook.
		 *
		 * @hooked wc_print_notices - 10
		 */
		 do_action( 'woocommerce_before_single_product' );

		 if ( post_password_required() ) {
		 	echo get_the_password_form();
		 	return;
		 }
	?>
	</div>
</div>


<div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>

	<?php if ( $product_sidebar != "full-width" ) : ?>
		<div class="single-product with-sidebar <?php echo esc_attr($product_sidebar); ?>">
			<div class="row">
				
				<div class="xlarge-2 large-3 columns show-for-large-up sidebar-pos">
					<div class="shop_sidebar wpb_widgetised_column">
						<?php if ( is_active_sidebar( 'widgets-product-page-listing' ) ) { ?>
							<?php dynamic_sidebar( 'widgets-product-page-listing' ); ?>
						<?php } ?>					
					</div>
				</div><!--.columns-->	

				<div class="xlarge-10 large-9 columns content-pos">
				

						<div class="single-product-images with_sidebar">
						

							<?php				
								if ( (isset($tdl_options['tdl_catalog_mode'])) && ($tdl_options['tdl_catalog_mode'] == 0) ) {
									wc_get_template( 'loop/sale-flash.php' );
								}
								do_action( 'woocommerce_before_single_product_summary_product_images' );
								do_action( 'woocommerce_before_single_product_summary' );
							?>

							<div class="product_summary_thumbnails_wrapper with-sidebar">
								<div><?php do_action( 'woocommerce_product_summary_thumbnails' ); ?></div>
							</div><!-- .product_summary_thumbnails_wrapper-->
							
						</div>

						<?php
						$addtocart_class = "";
						if ((isset($tdl_options['tdl_product_addtocart_ajax'])) && ($tdl_options['tdl_product_addtocart_ajax'] == "1")) {
							$addtocart_class = (!empty($tdl_options['tdl_header_ajax_loader'])) ? $tdl_options['tdl_header_ajax_loader'] : 'spinner-circle'; 
						}
						?>

						<!-- Product Content -->

						<div class="single-product-infos">
							<div class="product_infos <?php echo esc_attr($addtocart_class) ?>">						

							<?php 
							woodstock_share();

							if ((isset($tdl_options['tdl_shop_breadcrumb'])) && ($tdl_options['tdl_shop_breadcrumb'] == "1"))
								{
								// BREADCRUMBS
								echo woodstock_breadcrumbs();
								}
							?>
								
							<?php

								$shortexcerpt = wp_trim_words( $post->post_excerpt, $num_words = $tdl_options['tdl_product_description_number'], $more = '...' );

								do_action( 'woocommerce_single_product_summary_single_title' );
								do_action( 'woocommerce_single_product_summary_single_rating' );
								do_action( 'woocommerce_single_product_summary_single_price' );
								// do_action( 'woocommerce_single_product_summary_single_excerpt' );
								// echo $shortexcerpt;

								if ( (isset($tdl_options['tdl_productpage_description'])) && ($tdl_options['tdl_productpage_description'] == 1) ) {
									echo force_balance_tags( html_entity_decode( wp_trim_words( htmlentities( wpautop($post->post_excerpt) ), $num_words, $shortexcerpt ) ) );
								} else {
									do_action( 'woocommerce_single_product_summary_single_excerpt' );
								}								

								
								do_action( 'woocommerce_single_product_summary_single_add_to_cart' );
								do_action( 'woocommerce_single_product_summary' );

							?>

							</div>
						</div>


					<div class="clearfix"></div>

					<div class="summary-description">
						<?php
							do_action( 'woocommerce_single_product_summary_single_meta' );
							do_action( 'woocommerce_after_single_product_summary_data_tabs' );
							do_action( 'woocommerce_single_product_summary_single_sharing' );
						?>
					</div><!-- .columns -->


				</div><!--.columns-->

			</div><!--.row-->

					<div class="row">
						<div class="large-12 large-uncentered columns">
							<?php
								do_action( 'woocommerce_after_single_product_summary' );
							?>
							<div class="product_navigation">
								<?php woodstock_product_nav( 'nav-below' ); ?>
							</div>
						</div><!-- .columns -->
					</div><!-- .row -->
		</div><!--.single-product .with-sidebar-->
	<?php else : ?>
		<div class="single-product without-sidebar">
			<div class="row">
				<div class="large-12 columns"><?php do_action( 'woocommerce_before_single_product' ); ?></div>
				<div class="large-12 columns content-pos">

						<div class="image-content">

								<div class="product_summary_thumbnails_wrapper without_sidebar">
									<div><?php do_action( 'woocommerce_product_summary_thumbnails' ); ?>&nbsp;</div>
								</div><!-- .columns -->	

								<div class="single-product-images without_sidebar">

									<?php				
										if ( (isset($tdl_options['tdl_catalog_mode'])) && ($tdl_options['tdl_catalog_mode'] == 0) ) {
											wc_get_template( 'loop/sale-flash.php' );
										}
										do_action( 'woocommerce_before_single_product_summary_product_images' );
										do_action( 'woocommerce_before_single_product_summary' );
									?>

								</div>

						</div>

						<!-- Product Content -->

						<div class="single-product-infos">
							<div class="product_infos">						

							<?php 
							woodstock_share();

							if ((isset($tdl_options['tdl_shop_breadcrumb'])) && ($tdl_options['tdl_shop_breadcrumb'] == "1"))
								{
								// BREADCRUMBS
								echo woodstock_breadcrumbs();
								}
							?>
								
							<?php
								do_action( 'woocommerce_single_product_summary_single_title' );
								do_action( 'woocommerce_single_product_summary_single_rating' );
								do_action( 'woocommerce_single_product_summary_single_price' );
								do_action( 'woocommerce_single_product_summary_single_excerpt' );
								do_action( 'woocommerce_single_product_summary_single_add_to_cart' );
								do_action( 'woocommerce_single_product_summary' );
							?>
								
							</div>
						</div>


					<div class="clearfix"></div>

					<div class="summary-description">
						<?php
							do_action( 'woocommerce_single_product_summary_single_meta' );
							do_action( 'woocommerce_after_single_product_summary_data_tabs' );
							do_action( 'woocommerce_single_product_summary_single_sharing' );
						?>
					</div><!-- .columns -->


				</div><!--.columns-->

			</div><!--.row-->

					<div class="row">
						<div class="large-12 large-uncentered columns">
							<?php
								do_action( 'woocommerce_after_single_product_summary' );
							?>
							<div class="product_navigation">
								<?php woodstock_product_nav( 'nav-below' ); ?>
							</div>
						</div><!-- .columns -->
					</div><!-- .row -->
		</div>
	<?php endif; ?>

	<meta itemprop="url" content="<?php the_permalink(); ?>" />

	<?php if ( $product_sidebar != "full-width" ) : ?>
		<?php if (is_active_sidebar( 'widgets-product-page-listing')) : ?>
				<div id="button_offcanvas_sidebar_left"><i class="sidebar-icon"></i></div>
		<?php endif; ?>
	<?php endif; ?>

</div><!-- #product-<?php the_ID(); ?> -->


<?php do_action( 'woocommerce_after_single_product' ); ?>
