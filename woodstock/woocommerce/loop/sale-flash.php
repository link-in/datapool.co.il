<?php
/**
 * Product loop sale flash
 *
 * @author 	Vivek R @ WPSTuffs.com
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $post, $product;
$tdl_options = woodstock_global_var();
?>

<?php if ( $tdl_options['tdl_sale_percentages'] ) { ?>

	<?php if ($product->is_on_sale() && $product->is_type( 'variable' )) : ?>

		<span class="ribbon onsale">
			<?php 
			$product_variation_prices = $product->get_variation_prices();
			
			$highest_sale_percent = 0;
			
			foreach( $product_variation_prices['regular_price'] as $key => $regular_price ) {
				// Get sale price for current variation
				$sale_price = $product_variation_prices['sale_price'][$key];
				
				// Is product variation on sale?
				if ( $sale_price < $regular_price ) {
					$sale_percent = round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 );
					
					// Is current sale percent highest?
					if ( $sale_percent > $highest_sale_percent ) {
						$highest_sale_percent = $sale_percent;
					}
				}
			}
			
			// Return the highest product variation sale percent

			echo sprintf( esc_html__('-%s Off', 'woodstock' ), $highest_sale_percent . '%' ); 

			 ?>
	     </span><!-- end onsale -->

	<?php elseif($product->is_on_sale() && $product->is_type( 'simple' )) : ?>
		
		<span class="ribbon onsale">
		<?php 
			$percentage = round( ( ( $product->get_regular_price() - $product->get_sale_price() ) / $product->get_regular_price() ) * 100 );
			echo sprintf( esc_html__('-%s Off', 'woodstock' ), $percentage . '%' ); ?>
		</span><!-- end onsale -->

	<?php endif; ?>

<?php } else { ?>
	<?php if ( $product->is_on_sale() ) : ?>

		<?php echo apply_filters( 'woocommerce_sale_flash', '<span class="ribbon onsale">'.esc_attr($tdl_options['tdl_salebadge_text']).'</span>', $post, $product ); ?>

	<?php endif; ?>
<?php } ?>

            <?php 

				if ( (isset($tdl_options['tdl_newbadge'])) && ($tdl_options['tdl_newbadge'] == 1) ) {
			
					$postdate 		= get_the_time( 'Y-m-d' );			// Post date
					$postdatestamp 	= strtotime( $postdate );			// Timestamped post date
					$newness 		= $tdl_options['tdl_newbadge_date']; 	// Newness in days

				if ( ( time() - ( 60 * 60 * 24 * $newness ) ) < $postdatestamp ) { // If the product was published within the newness time frame display the new badge
					  echo '<span class="ribbon newbadge">'.esc_attr($tdl_options['tdl_newbadge_text']).'</span>';
					}				
				}
            ?>



