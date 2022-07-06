<?php 

/**
 * Class for all WooCommerce template modification
 *
 * @version 1.0
 */
class Woodstock_WooCommerce {

	/**
	 * Construction function
	 *
	 * @since  1.0
	 * @return Woodstock_WooCommerce
	 */
	function __construct() {
		// Check if Woocomerce plugin is actived
		if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			return;
		}

		// Define all hook
		add_action( 'template_redirect', array( $this, 'hooks' ) );
		

	}

	/**
	 * Hooks to WooCommerce actions, filters
	 *
	 * @since  1.0
	 * @return void
	 */
	function hooks() {

		//woocommerce_before_main_content
		remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
		remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);


		//woocommerce_before_shop_loop
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
		// remove_filter( 'woocommerce_product_loop_start', 'woocommerce_maybe_show_product_subcategories' );

		add_action( 'woocommerce_before_shop_loop_result_count', 'woocommerce_result_count', 20 );
		add_action( 'woocommerce_before_shop_loop_catalog_ordering', 'woocommerce_catalog_ordering', 30 );

		
		add_action( 'woocommerce_after_shop_loop_item_title', array( $this, 'product_attribute' ), 4 );




		// add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

	}

	//==============================================================================
	// Display product attribute
	//==============================================================================

	function product_attribute() {

		global $tdl_options;

		$product_attribute = (!empty($tdl_options['tdl_product_attribute'])) ? $tdl_options['tdl_product_attribute'] : 'none'; 

		$default_attribute = sanitize_title( $product_attribute );

		if ( $default_attribute == '' || $default_attribute == 'none' ) {
			return;
		}

		$default_attribute = 'pa_' . $default_attribute;

		global $product;
		$attributes         = maybe_unserialize( get_post_meta( $product->get_id(), '_product_attributes', true ) );
		$product_attributes = maybe_unserialize( get_post_meta( $product->get_id(), 'attributes_extra', true ) );

		if ( $product_attributes == 'none' ) {
			return;
		}

		if ( $product_attributes == '' ) {
			$product_attributes = $default_attribute;
		}


		$variations = $this->get_variations( $product_attributes );

		if ( ! $attributes ) {
			return;
		}

		foreach ( $attributes as $attribute ) {


			if ( $product->get_type() == 'variable' ) {
				if ( ! $attribute['is_variation'] ) {
					continue;
				}
			}

			if ( sanitize_title( $attribute['name'] ) == $product_attributes ) {

				echo '<div class="ev-attr-swatches">';
				if ( $attribute['is_taxonomy'] ) {
					$post_terms = wp_get_post_terms( $product->get_id(), $attribute['name'] );

					$attr_type = '';

					if ( function_exists( 'TA_WCVS' ) ) {
						$attr = TA_WCVS()->get_tax_attribute( $attribute['name'] );
						if ( $attr ) {
							$attr_type = $attr->attribute_type;
						}
					}

					$found = false;
					foreach ( $post_terms as $term ) {
						$css_class = '';
						if ( is_wp_error( $term ) ) {
							continue;
						}
						if ( $variations && isset( $variations[$term->slug] ) ) {
							$attachment_id = $variations[$term->slug];
							$attachment    = wp_get_attachment_image_src( $attachment_id, 'shop_catalog' );
							$image_srcset  = '';

								$image_srcset = wp_get_attachment_image_srcset( $attachment_id, 'shop_catalog' );


							if ( $attachment_id == get_post_thumbnail_id() && ! $found ) {
								$css_class .= ' selected';
								$found = true;
							}

							if ( $attachment ) {
								$css_class .= ' ev-swatch-variation-image';
								$img_src = $attachment[0];
								echo wp_kses_post($this->swatch_html( $term, $attr_type, $img_src, $css_class, $image_srcset ));
							}

						}
					}
				}
				echo '</div>';
				break;
			}
		}

	}

	//==============================================================================
	// Print HTML of a single swatch
	//==============================================================================

	public function swatch_html( $term, $attr_type, $img_src, $css_class, $image_srcset ) {

		$html = '';
		$name = $term->name;

		switch ( $attr_type ) {
			case 'color':
				$color = get_term_meta( $term->term_id, 'color', true );
				list( $r, $g, $b ) = sscanf( $color, "#%02x%02x%02x" );
				$html = sprintf(
					'<span class="swatch swatch-color %s" data-src="%s" data-src-set="%s" title="%s"><span class="sub-swatch" style="background-color:%s;color:%s;"></span> </span>',
					esc_attr( $css_class ),
					esc_url( $img_src ),
					esc_attr( $image_srcset ),
					esc_attr( $name ),
					esc_attr( $color ),
					"rgba($r,$g,$b,0.5)"
				);
				break;

			case 'image':
				$image = get_term_meta( $term->term_id, 'image', true );
				if ( $image ) {
					$image = wp_get_attachment_image_src( $image );
					$image = $image ? $image[0] : WC()->plugin_url() . '/assets/images/placeholder.png';
					$html  = sprintf(
						'<span class="swatch swatch-image %s" data-src="%s" data-src-set="%s" title="%s"><img src="%s" alt="%s"></span>',
						esc_attr( $css_class ),
						esc_url( $img_src ),
						esc_attr( $image_srcset ),
						esc_attr( $name ),
						esc_url( $image ),
						esc_attr( $name )
					);
				}

				break;

			default:
				$label = get_term_meta( $term->term_id, 'label', true );
				$label = $label ? $label : $name;
				$html  = sprintf(
					'<span class="swatch swatch-label %s" data-src="%s" data-src-set="%s" title="%s">%s</span>',
					esc_attr( $css_class ),
					esc_url( $img_src ),
					esc_attr( $image_srcset ),
					esc_attr( $name ),
					esc_html( $label )
				);
				break;


		}

		return $html;
	}


	//==============================================================================
	// Get variations
	//==============================================================================

	function get_variations( $default_attribute ) {
		global $product;

		$variations = array();
		if ( $product->get_type() == 'variable' ) {
			$args = array(
				'post_parent' => $product->get_id(),
				'post_type'   => 'product_variation',
				'orderby'     => 'menu_order',
				'order'       => 'ASC',
				'fields'      => 'ids',
				'post_status' => 'publish',
				'numberposts' => - 1
			);

			if ( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) ) {
				$args['meta_query'][] = array(
					'key'     => '_stock_status',
					'value'   => 'instock',
					'compare' => '=',
				);
			}

			$thumbnail_id = get_post_thumbnail_id();

			$posts = get_posts( $args );

			foreach ( $posts as $post_id ) {
				$attachment_id = get_post_thumbnail_id( $post_id );
				$attribute     = $this->get_variation_attributes( $post_id, 'attribute_' . $default_attribute );

				if ( ! $attachment_id ) {
					$attachment_id = $thumbnail_id;
				}

				if ( $attribute ) {
					$variations[$attribute[0]] = $attachment_id;
				}

			}

		}

		return $variations;
	}	

	//==============================================================================
	// Get variation attribute
	//==============================================================================

	public function get_variation_attributes( $child_id, $attribute ) {
		global $wpdb;

		$values = array_unique(
			$wpdb->get_col(
				$wpdb->prepare(
					"SELECT meta_value FROM {$wpdb->postmeta} WHERE meta_key = %s AND post_id IN (" . $child_id . ")",
					$attribute
				)
			)
		);

		return $values;
	}		

}

/******************************************************************************/
/*******Show Woocommerce Cart Widget Everywhere *******************************/
/******************************************************************************/

if ( ! function_exists('woodstock_woocommerce_widget_cart_everywhere') ) :
	function woodstock_woocommerce_widget_cart_everywhere() { 
	    return false; 
	};
	add_filter( 'woocommerce_widget_cart_is_hidden', 'woodstock_woocommerce_widget_cart_everywhere', 10, 1 );
endif;
	
/**
 * ------------------------------------------------------------------------------------------------
 * Get base shop page link
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodstock_shop_page_link' ) ) {
	function woodstock_shop_page_link( $keep_query = false, $taxonomy = '' ) {
		// Base Link decided by current page
		if ( Automattic\Jetpack\Constants::is_defined( 'SHOP_IS_ON_FRONT' ) ) {
			$link = home_url();
		} elseif ( is_post_type_archive( 'product' ) || is_page( wc_get_page_id( 'shop' ) ) || is_shop() ) {
			$link = get_permalink( wc_get_page_id( 'shop' ) );
		} elseif( is_product_category() ) {
			$link = get_term_link( get_query_var('product_cat'), 'product_cat' );
		} elseif( is_product_tag() ) {
			$link = get_term_link( get_query_var('product_tag'), 'product_tag' );
		} elseif ( get_queried_object() ) {
			$queried_object = get_queried_object();
			$link           = get_term_link( $queried_object->slug, $queried_object->taxonomy );
		} else {
			$link = '';
		}

		if( $keep_query ) {

			// Min/Max
			if ( isset( $_GET['min_price'] ) ) {
				$link = add_query_arg( 'min_price', wc_clean( $_GET['min_price'] ), $link );
			}

			if ( isset( $_GET['max_price'] ) ) {
				$link = add_query_arg( 'max_price', wc_clean( $_GET['max_price'] ), $link );
			}

			// Orderby
			if ( isset( $_GET['orderby'] ) ) {
				$link = add_query_arg( 'orderby', wc_clean( $_GET['orderby'] ), $link );
			}
			
			if ( isset( $_GET['stock_status'] ) ) {
				$link = add_query_arg( 'stock_status', wc_clean( $_GET['stock_status'] ), $link );
			}

			/**
			 * Search Arg.
			 * To support quote characters, first they are decoded from &quot; entities, then URL encoded.
			 */
			if ( get_search_query() ) {
				$link = add_query_arg( 's', rawurlencode( wp_specialchars_decode( get_search_query() ) ), $link );
			}

			// Post Type Arg
			if ( isset( $_GET['post_type'] ) ) {
				$link = add_query_arg( 'post_type', wc_clean( wp_unslash( $_GET['post_type'] ) ), $link );

				// Prevent post type and page id when pretty permalinks are disabled.
				if ( is_shop() ) {
					$link = remove_query_arg( 'page_id', $link );
				}
			}

			// Min Rating Arg
			if ( isset( $_GET['min_rating'] ) ) {
				$link = add_query_arg( 'min_rating', wc_clean( $_GET['min_rating'] ), $link );
			}

			// All current filters
			if ( $_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes() ) {
				foreach ( $_chosen_attributes as $name => $data ) {
					if ( $name === $taxonomy ) {
						continue;
					}
					$filter_name = sanitize_title( str_replace( 'pa_', '', $name ) );
					if ( ! empty( $data['terms'] ) ) {
						$link = add_query_arg( 'filter_' . $filter_name, implode( ',', $data['terms'] ), $link );
					}
					if ( 'or' == $data['query_type'] ) {
						$link = add_query_arg( 'query_type_' . $filter_name, 'or', $link );
					}
				}
			}
		}
		
		$link = apply_filters( 'woodstock_shop_page_link', $link, $keep_query, $taxonomy );
		
		if ( is_string( $link ) ) {
			return $link;
		} else {
			return '';
		}
	}
}


// Adding custom attributes in menu 

add_filter('woocommerce_attribute_show_in_nav_menus', 'woodstock_wc_reg_for_menus', 1, 2);

function woodstock_wc_reg_for_menus( $register, $name = '' ) {
	global $product, $woocommerce; 
     if ( $name == 'pa_os' ) $register = true;
     return $register;
}

/******************************************************************************/
/* WooCommerce Number of Related Products *************************************/
/******************************************************************************/

function woocommerce_output_related_products() {
	global $product, $woocommerce; 
	$atts = array(
		'posts_per_page' => '12',
		'orderby'        => 'rand'
	);
	woocommerce_related_products($atts);
}


/******************************************************************************/
/* WooCommerce Wrap Oembed Stuff **********************************************/
/******************************************************************************/
add_filter('embed_oembed_html', 'woodstock_embed_oembed_html', 99, 4);
function woodstock_embed_oembed_html($html, $url, $attr, $post_id) {
	return '<div class="video-container">' . $html . '</div>';
}

/******************************************************************************/
/*  Remove Default Woocommerce Breadcrumbs  ***********************************/
/******************************************************************************/

add_action( 'init', 'woodstock_remove_wc_breadcrumbs' );
function woodstock_remove_wc_breadcrumbs() {
	global $product, $woocommerce; 
    remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
}


/******************************************************************************/
/* Product Availability *******************************************************/
/******************************************************************************/

function woodstock_availability() {
	global $product, $tdl_options;
	$availability = $product->get_availability();
	$stock_status = $availability['class'];
		
	if( $stock_status == 'out-of-stock' ) {
		if (isset($tdl_options['tdl_out_of_stock_text'])) {
			$label = esc_html($tdl_options['tdl_out_of_stock_text']);
		} else {
			$label = esc_html__('Out of stock', 'woocommerce');
		}		
		$label_class = 'not-available';
	} else {
		$label = esc_html__( 'In stock', 'woocommerce' ) ;
		$label_class = 'available';
	}

	echo apply_filters( 'woodstock_loop_stock_availability_html',
		sprintf( '<div class="availability"><label>%s</label><span class="%s">%s</span></div>',
				esc_html__( 'Availability: ', 'woodstock' ),
		$label_class,
		$label
		),
	$product );
}


/******************************************************************************/
/* WooCommerce Update Number of Items in the cart *****************************/
/******************************************************************************/


add_action('woocommerce_ajax_added_to_cart', 'woodstock_ajax_added_to_cart');
function woodstock_ajax_added_to_cart() {

	add_filter('woocommerce_add_to_cart_fragments', 'woodstock_shopping_bag_items_number');
	function woodstock_shopping_bag_items_number( $fragments ) 
	{
		global $woocommerce;
		ob_start(); ?>

		<script>
		(function($){
			$('.shop-bag').trigger('click');
		})(jQuery);
		</script>
		
		<span class="bag-items-number"><?php echo sprintf (_n( '%d item', '%d items', WC()->cart->cart_contents_count, 'woodstock' ), WC()->cart->cart_contents_count ); ?></span>

		<?php
		$fragments['.bag-items-number'] = ob_get_clean();
		ob_start(); ?>
		
        <span class="shopbag_items_number"><?php echo WC()->cart->cart_contents_count; ?></span>

		<?php
		$fragments['.shopbag_items_number'] = ob_get_clean();
		ob_start(); ?>
		
		<?php echo WC()->cart->get_cart_subtotal(); ?>	

		<?php
		$fragments['.shop-bag .overview .amount'] = ob_get_clean();
		return $fragments;

	}
}


/******************************************************************************/
/****** WOO GET PRODUCT PER PAGE **********************************************/
/******************************************************************************/


	if( ! function_exists( 'woodstock_products_per_page_select' ) ) {
		add_action( 'woodstock_per_page_loop', 'woodstock_products_per_page_select', 25 );

		function woodstock_products_per_page_select() {

			global $tdl_options;

			$product_count = (!empty($tdl_options['tdl_product_count'])) ? $tdl_options['tdl_product_count'] : '12,24,36'; 

			if ( !$product_count || ( wc_get_loop_prop( 'is_shortcode' ) || ! wc_get_loop_prop( 'is_paginated' ) || ! woocommerce_products_will_display() ) ) return;

			global $wp_query;


			$per_page_options = $product_count;

			$products_per_page_options = (!empty($per_page_options)) ? explode(',', $per_page_options) : array(12,24,36,-1);


			?>

			<li>
				<form class="woocommerce-viewing" method="get">
					<select name="per_page" class="count">
							<?php foreach( $products_per_page_options as $key => $value ) : ?>
									<option value="<?php echo esc_attr( $value ); ?>" <?php selected( woodstock_get_products_per_page(), $value ); ?>><?php
										$text = '%s';
										esc_html( printf( $text, $value == -1 ? esc_html__( 'All', 'woodstock' ) : $value ) );
									?></option>
							<?php endforeach; ?>
					</select>
					<input type="hidden" name="paged" value=""/>
						<?php
						// Keep query string vars intact
						foreach ( $_GET as $key => $val ) {
								if ( 'per_page' === $key || 'submit' === $key || 'paged' === $key ) {
										continue;
								}
								if ( is_array( $val ) ) {
										foreach( $val as $innerVal ) {
												echo '<input type="hidden" name="' . esc_attr( $key ) . '[]" value="' . esc_attr( $innerVal ) . '" />';
										}
								} else {
										echo '<input type="hidden" name="' . esc_attr( $key ) . '" value="' . esc_attr( $val ) . '" />';
								}
						}
						?>
				</form>
			</li>
			<?php
		}
	}

/**
 * ------------------------------------------------------------------------------------------------
 * Change number of products displayed per page
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodstock_shop_products_per_page' ) ) {
	function woodstock_shop_products_per_page() {
		$per_page = 12;
		$number = apply_filters('woodstock_shop_per_page', woodstock_get_products_per_page() );
		if( is_numeric( $number ) ) {
			$per_page = $number;
		}
		return $per_page;
	}

	add_filter( 'loop_shop_per_page', 'woodstock_shop_products_per_page', 20 );
}

// **********************************************************************//
// ! Get Items per page number on the shop page
// **********************************************************************//

if( ! function_exists( 'woodstock_get_products_per_page' ) ) {
	function woodstock_get_products_per_page() {
		if ( apply_filters( 'woodstock_woo_session', false ) ) {
			return woodstock_woo_get_products_per_page();
		} else {
			return woodstock_new_get_products_per_page();
		}
	}
}

if( ! function_exists( 'woodstock_new_get_products_per_page' ) ) {
	function woodstock_new_get_products_per_page() {
		global $tdl_options;

		$shop_per_page = (!empty($tdl_options['tdl_shop_per_page'])) ? $tdl_options['tdl_shop_per_page'] : 12; 
		if ( isset( $_REQUEST['per_page'] ) && ! empty( $_REQUEST['per_page'] ) ) {
			return intval( $_REQUEST['per_page'] );
		} elseif ( isset( $_COOKIE['shop_per_page'] ) ) {
			$val = $_COOKIE['shop_per_page'];
			
			if ( ! empty( $val ) ) {
				return intval( $val );
			}
		}
		
		return intval( $shop_per_page );
	}
}

if( ! function_exists( 'woodstock_woo_get_products_per_page' ) ) {
	function woodstock_woo_get_products_per_page() {
		global $tdl_options;
		if( ! class_exists('WC_Session_Handler') ) return;
		$s = WC()->session; // WC()->session
		if ( is_null( $s ) ) return intval( $tdl_options['tdl_shop_per_page'] );
		
		if ( isset( $_REQUEST['per_page'] ) && ! empty( $_REQUEST['per_page'] ) ) :
			return intval( $_REQUEST['per_page'] );
		elseif ( $s->__isset( 'shop_per_page' ) ) :
			$val = $s->__get( 'shop_per_page' );
			if( ! empty( $val ) )
				return intval( $s->__get( 'shop_per_page' ) );
		endif;
		return intval( $tdl_options['tdl_shop_per_page'] );
	}
}


if( ! function_exists( 'woodstock_set_customer_session' ) ) {
	function woodstock_set_customer_session() {
		if ( ! function_exists( 'WC' ) || ! apply_filters( 'woodstock_woo_session', false ) ) {
			return;
		}

		if ( WC()->version > '2.1' && ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' ) ) :
			WC()->session->set_customer_session_cookie( true );
		endif;
	}
	add_action( 'woodstock_before_shop_page', 'woodstock_set_customer_session', 10 );
}


/******************************************************************************/
/****** WOO REMOVE PRODUCT FROM CART ******************************************/
/******************************************************************************/


	if ( ! function_exists('woodstock_cart_product_remove')){
		function woodstock_cart_product_remove() {

    		global $wpdb, $woocommerce;

			$id = 0; 
			$variation_id = 0;
			
            if ( ! empty( $_REQUEST['product_id'] ) ) {
                $id = $_REQUEST['product_id'];
            }
            
            if ( ! empty( $_REQUEST['variation_id'] ) ) {
                $variation_id = $_REQUEST['variation_id'];
            }
                                                
            $cart = $woocommerce->cart;
            
            foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
            	
            	    if ( ($cart_item['product_id'] == $id && $variation_id <= 0) || ($cart_item['variation_id'] == $variation_id && $variation_id > 0 ) ){
            	   		$cart->set_quantity($cart_item_key,0);	
					}           
		
            }
            if ( $woocommerce->tax_display_cart == 'excl' ) {
				$totalamount  = wc_price($woocommerce->cart->get_total());
			} else {
				$totalamount  = wc_price($woocommerce->cart->cart_contents_total + $woocommerce->cart->tax_total);
			} 	

			printf( '%s', $totalamount );			

			die();
    	}

    	add_action( 'wp_ajax_tdl_cart_product_remove', 'woodstock_cart_product_remove' );
		add_action( 'wp_ajax_nopriv_tdl_cart_product_remove', 'woodstock_cart_product_remove' );
	}

/******************************************************************************/
/****** WISHLIST / COMPARE BUTTONS ********************************************/
/******************************************************************************/	

if( ! function_exists ( 'woodstock_loop_action_buttons' ) ) {
	function woodstock_loop_action_buttons() {
		?>
		
		<div class="prod-plugins">
			<ul>
				<?php


					echo '<li>'.do_shortcode('[yith_wcwl_add_to_wishlist]').'</li>';

					echo '<li>'.do_shortcode('[yith_compare_button]').'</li>';

				?>
			</ul>
		</div>

		<?php
	}
}

// Wishlist Topbar/Mobile Menu Button

if( ! function_exists ( 'woodstock_wishlist_topbar' ) ) {
	function woodstock_wishlist_topbar() {
		global $yith_wcwl, $tdl_options;
		?>
	<?php if (in_array( 'yith-woocommerce-wishlist/init.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) )) : ?>			

		<?php if ( (isset($tdl_options['tdl_topbar_wishlist'])) && (trim($tdl_options['tdl_topbar_wishlist']) == "1" ) ) : ?>
			<?php if (class_exists('YITH_WCWL')) : ?>
			<li class="wishlist-link"><a href="<?php echo esc_url($yith_wcwl->get_wishlist_url()); ?>" class="acc-link"><i class="wishlist-icon"></i><?php esc_html_e('Wishlist', 'woodstock'); ?></a></li>
			<?php endif; ?>  
		<?php endif; ?>

	<?php endif; ?> 
		<?php
	}
}


/******************************************************************************/
/****** PRODUCT SHORT TITLE ****************************************************/
/******************************************************************************/	

// WordPress Hack by Knowtebook.com
// Shorten any text you want
if ( ! function_exists( 'woodstock_short_title' ) ) :
	function woodstock_short_title($text) {
	// Change to the number of characters you want to display

	$chars_limit = 30;
	$chars_text = strlen($text);
	$text = $text." ";
	$text = substr($text,0,$chars_limit);
	$text = substr($text,0,strrpos($text,' '));

	// If the text has more characters that your limit,
	//add ... so the user knows the text is actually longer

	if ($chars_text > $chars_limit)
	{
	$text = $text."...";
	}

	return $text;
	}
endif; // woodstock_short_title

/******************************************************************************/
/****** PRODUCT NAVIGATION ****************************************************/
/******************************************************************************/

if ( ! function_exists( 'woodstock_product_nav' ) ) :
function woodstock_product_nav($nav_id) {

	global $wp_query, $post, $tdl_options;
    // get categories
    $terms = wp_get_post_terms( $post->ID, 'product_cat' );
    foreach ( $terms as $term ) $cats_array[] = $term->term_id;

    // get all posts in current categories


    $postlist_args = array('posts_per_page' => -1, 'orderby' => 'menu_order title', 'order'	=> 'ASC', 'post_status' => 'publish', 'post_type' => 'product', 'tax_query' => array(
        array(
            'taxonomy' => 'product_cat',
            'field' => 'id',
            'terms' => $cats_array
        )));

    $postlist = get_posts( $postlist_args );

	// get ids of posts retrieved from get_posts
	
	$ids = array();
	
	foreach ($postlist as $thepost) {
	   $ids[] = $thepost->ID;
	}
	
	// get and echo previous and next post in the same taxonomy        
	
	$thisindex = array_search($post->ID, $ids);
	
	$previd = "";
	$nextid = "";
	
	if (isset($ids[$thisindex-1])) $previd = $ids[$thisindex-1];
	
	if (isset($ids[$thisindex+1])) $nextid = $ids[$thisindex+1];

	if (defined('ICL_SITEPRESS_VERSION')) {
		$product_prev_link = get_permalink(icl_object_id($previd, 'product', true));
		$product_next_link = get_permalink(icl_object_id($nextid, 'product', true));
	} else {
		$product_prev_link = get_permalink($previd);
		$product_next_link = get_permalink($nextid);
	}

	$category_listing = (!empty($tdl_options['tdl_category_listing'])) ? $tdl_options['tdl_category_listing'] : 'first_category'; 
 
?>

	<nav id="<?php echo esc_attr( $nav_id ); ?>" class="nav-fillslide">
		<?php if ( !empty($previd) ) : ?>
			<a class="prev" href="<?php echo esc_attr($product_prev_link); ?>">
				<span class="icon-wrap"><i class="icon-woodstock-icons-43"></i></span>
				<div>
					
					<?php if ($category_listing !== 'none') { ?>
	            		<?php $product = new WC_Product($previd); 
	            		$product_cats = strip_tags(wc_get_product_category_list ($product->get_id(), '|||', '', '')); 
		            ?>
						<span><?php list($firstpart) = explode('|||', $product_cats); echo esc_attr($firstpart); ?></span>
					<?php } ?>

					<h4><?php echo woodstock_short_title(get_the_title($previd)); ?></h4>
					<?php $product_nav_img_prev = wp_get_attachment_image_src( get_post_thumbnail_id($previd), 'shop_thumbnail' ); ?>
					<img src="<?php echo esc_url($product_nav_img_prev[0]); ?>" alt="<?php echo get_the_title($previd); ?>"/>
				</div>
			</a>			
		<?php endif; ?>

		<?php if ( !empty($nextid) ) : ?>
			<a class="next" href="<?php echo esc_attr($product_next_link); ?>">
				<span class="icon-wrap"><i class="icon-woodstock-icons-44"></i></span>
				<div>
					<?php
					
					if ( $category_listing !== 'none') { ?>
	            		<?php $product = new WC_Product($nextid); 
	            		$product_cats = strip_tags(wc_get_product_category_list ($product->get_id(), '|||', '', ''));
		            ?>
						<span><?php list($firstpart) = explode('|||', $product_cats); echo esc_attr($firstpart); ?></span>
					<?php } ?>
					<h4><?php echo woodstock_short_title(get_the_title($nextid)); ?></h4>
					<?php $product_nav_img_next = wp_get_attachment_image_src( get_post_thumbnail_id($nextid), 'shop_thumbnail' ); ?>
					<img src="<?php echo esc_url($product_nav_img_next[0]); ?>" alt="<?php echo get_the_title($nextid); ?>"/>
				</div>
			</a>			
		<?php endif; ?>
	</nav><!-- #<?php echo esc_html( $nav_id ); ?> -->


<?php	
	wp_reset_query();
}
endif; // woodstock_product_nav


/******************************************************************************/
/* WooCommerce Add data-src & lazyOwl to Thumbnails ***************************/
/******************************************************************************/

function woocommerce_get_product_thumbnail( $size = 'woodstock_product_small_thumbnail', $placeholder_width = 0, $placeholder_height = 0  ) {
	global $post;

	if ( has_post_thumbnail() ) {
		$image_src = wp_get_attachment_image_src( get_post_thumbnail_id(), 'shop_catalog' );
		return get_the_post_thumbnail( $post->ID, $size, array('data-src' => $image_src[0], 'class' => 'lazyOwl') );
	} elseif ( wc_placeholder_img_src() ) {
		return wc_placeholder_img( $size );
	}
}

function woocommerce_subcategory_thumbnail( $category ) {
	$small_thumbnail_size  	= apply_filters( 'single_product_small_thumbnail_size', 'woodstock_product_small_thumbnail' );
	$thumbnail_size  		= apply_filters( 'single_product_small_thumbnail_size', 'shop_catalog' );
	$dimensions    			= wc_get_image_size( $small_thumbnail_size );
	$thumbnail_id  			= get_term_meta( $category->term_id, 'thumbnail_id', true  );

	if ( $thumbnail_id ) {
		$image_small = wp_get_attachment_image_src( $thumbnail_id, $small_thumbnail_size  );
		$image_small = $image_small[0];
		$image = wp_get_attachment_image_src( $thumbnail_id, $thumbnail_size  );
		$image = $image[0];
	} else {
		$image = $image_small = wc_placeholder_img_src();
		
	}

	if ( $image_small )
		echo '<img data-src="' . esc_url( $image ) . '" class="lazyOwl" src="' . esc_url( $image_small ) . '" alt="' . esc_attr( $category->name ) . '" width="' . esc_attr( $dimensions['width'] ) . '" height="' . esc_url( $dimensions['height'] ) . '" />';
}


// Categories Walker


class WOODSTOCK_Custom_Walker_Category extends Walker_Category {

    public function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
		/** This filter is documented in wp-includes/category-template.php */
		$cat_name = apply_filters(
			'list_cats',
			esc_attr( $category->name ),
			$category
		);

		// Don't generate an element if the category name is empty.
		if ( ! $cat_name ) {
			return;
		}

		$link = '<a class="pf-value" href="' . esc_url( get_term_link( $category ) ) . '" data-val="' . esc_attr( $category->slug ) . '" data-title="' . esc_attr( $category->name ) . '" ';
		if ( $args['use_desc_for_title'] && ! empty( $category->description ) ) {
			/**
			 * Filters the category description for display.
			 *
			 * @since 1.2.0
			 *
			 * @param string $description Category description.
			 * @param object $category    Category object.
			 */
			$link .= 'title="' . esc_attr( strip_tags( apply_filters( 'category_description', $category->description, $category ) ) ) . '"';
		}

		$link .= '>';
		$link .= $cat_name . '</a>';

		if ( ! empty( $args['feed_image'] ) || ! empty( $args['feed'] ) ) {
			$link .= ' ';

			if ( empty( $args['feed_image'] ) ) {
				$link .= '(';
			}

			$link .= '<a href="' . esc_url( get_term_feed_link( $category->term_id, $category->taxonomy, $args['feed_type'] ) ) . '"';

			if ( empty( $args['feed'] ) ) {
				$alt = ' alt="' . sprintf(esc_html__( 'Feed for all posts filed under %s', 'woodstock' ), $cat_name ) . '"';
			} else {
				$alt = ' alt="' . $args['feed'] . '"';
				$name = $args['feed'];
				$link .= empty( $args['title'] ) ? '' : $args['title'];
			}

			$link .= '>';

			if ( empty( $args['feed_image'] ) ) {
				$link .= $name;
			} else {
				$link .= "<img src='" . $args['feed_image'] . "'$alt" . ' />';
			}
			$link .= '</a>';

			if ( empty( $args['feed_image'] ) ) {
				$link .= ')';
			}
		}

		if ( ! empty( $args['show_count'] ) ) {
			$link .= ' (' . number_format_i18n( $category->count ) . ')';
		}
		if ( 'list' == $args['style'] ) {
			$output .= "\t<li";
			$css_classes = array(
				'cat-item',
				'cat-item-' . $category->term_id,
			);

			if ( ! empty( $args['current_category'] ) ) {
				// 'current_category' can be an array, so we use `get_terms()`.
				$_current_terms = get_terms( $category->taxonomy, array(
					'include' => $args['current_category'],
					'hide_empty' => false,
				) );

				foreach ( $_current_terms as $_current_term ) {
					if ( $category->term_id == $_current_term->term_id ) {
						$css_classes[] = 'current-cat pf-active';
					} elseif ( $category->term_id == $_current_term->parent ) {
						$css_classes[] = 'current-cat-parent';
					}
					while ( $_current_term->parent ) {
						if ( $category->term_id == $_current_term->parent ) {
							$css_classes[] =  'current-cat-ancestor';
							break;
						}
						$_current_term = get_term( $_current_term->parent, $category->taxonomy );
					}
				}
			}

			/**
			 * Filters the list of CSS classes to include with each category in the list.
			 *
			 * @since 4.2.0
			 *
			 * @see wp_list_categories()
			 *
			 * @param array  $css_classes An array of CSS classes to be applied to each list item.
			 * @param object $category    Category data object.
			 * @param int    $depth       Depth of page, used for padding.
			 * @param array  $args        An array of wp_list_categories() arguments.
			 */
			$css_classes = implode( ' ', apply_filters( 'category_css_class', $css_classes, $category, $depth, $args ) );

			$output .=  ' class="' . $css_classes . '"';
			$output .= ">$link\n";
		} elseif ( isset( $args['separator'] ) ) {
			$output .= "\t$link" . $args['separator'] . "\n";
		} else {
			$output .= "\t$link<br />\n";
		}
	} 
} 

 ?>