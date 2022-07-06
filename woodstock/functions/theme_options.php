<?php 

define( 'WOODSTOCK_WOOCOMMERCE_IS_ACTIVE',	class_exists( 'WooCommerce' ) );
define( 'WOODSTOCK_VISUAL_COMPOSER_IS_ACTIVE',	defined( 'WPB_VC_VERSION' ) );
define( 'WOODSTOCK_REV_SLIDER_IS_ACTIVE',	class_exists( 'RevSlider' ) );
define( 'WOODSTOCK_WPML_IS_ACTIVE',	defined( 'ICL_SITEPRESS_VERSION' ) );
define( 'WOODSTOCK_WISHLIST_IS_ACTIVE',	class_exists( 'YITH_WCWL' ) );
define( 'WOODSTOCK_ACF_IS_ACTIVE',	class_exists( 'ACF' ) );


/**
 * ------------------------------------------------------------------------------------------------
 * Check if WooCommerce is active
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'woodstock_woocommerce_installed' ) ) {
	function woodstock_woocommerce_installed() {
	    return class_exists( 'WooCommerce' );
	}
}

/*-----------------------------------------------------------------------------------*/
/*	BREADCRUMBS
/*-----------------------------------------------------------------------------------*/

	function woodstock_breadcrumbs() {
		$breadcrumb_output = "";
		
		if ( function_exists('bcn_display') ) {
			$breadcrumb_output .= '<div id="breadcrumbs">'. "\n";
			$breadcrumb_output .= bcn_display(true);
			$breadcrumb_output .= '</div>'. "\n";
		} else if ( function_exists('yoast_breadcrumb') ) {
			$breadcrumb_output .= '<div id="breadcrumbs">'. "\n";
			$breadcrumb_output .= yoast_breadcrumb("","",false);
			$breadcrumb_output .= '</div>'. "\n";
		} else {
			if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			}
			$breadcrumb_output .= '<div id="breadcrumbs">'. "\n";
			$breadcrumb_output .= do_action('woocommerce_before_main_content_breadcrumb');
			$breadcrumb_output .= '</div>'. "\n";
		}
		
		return $breadcrumb_output;
	}

/*-----------------------------------------------------------------------------------*/
/*	Share
/*-----------------------------------------------------------------------------------*/

function woodstock_share() {
    global $post, $product, $tdl_options;
    if ( (isset($tdl_options['tdl_sharing_options'])) && ($tdl_options['tdl_sharing_options'] == "1" ) ) :
    $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
?>

<script>
jQuery(document).ready(function($) {
	jQuery('.social-sharing').socialShare({
	    social: '<?php echo implode(',', $tdl_options['tdl_share_select']);?>',
	    animation:'launchpadReverse',
	    blur:true
	});	
});
</script>

    <div class="box-share-master-container" data-name="<?php esc_html_e( 'Share', 'woodstock' )?>">
		<a href="javascript:;" class="social-sharing" data-name="<?php echo get_the_title(); ?>" data-shareimg="<?php echo esc_url($image[0]); ?>">
			<i class="fa fa-share-alt"></i>
			<span><?php esc_html_e( 'Share', 'woodstock' )?></span>
		</a>
    </div><!--.box-share-master-container-->

<?php
    endif;
}


/*-----------------------------------------------------------------------------------*/
/*	Main background
/*-----------------------------------------------------------------------------------*/

function woodstock_main_bg_color() {
	global $tdl_options;

	$style = '';
	$layout_type = (!empty($tdl_options['tdl_layout_type'])) ? $tdl_options['tdl_layout_type'] : 'fullwidth';
	$background_type = (!empty($tdl_options['tdl_background_type'])) ? $tdl_options['tdl_background_type'] : 'color';

	if ($layout_type != 'fullwidth' && $background_type != 'none') {
		$bg_type = $background_type;

		$style = 'style="';
		if ($bg_type == 'color') {
			$style .= 'background-color:' . $tdl_options['tdl_background_color'];
		}
		$style .= '"';
	}

	echo ! isset($bg_cover) ? $style : '';
}

function woodstock_main_bg() {

	global $tdl_options;

	$style = '';
	$layout_type = (!empty($tdl_options['tdl_layout_type'])) ? $tdl_options['tdl_layout_type'] : 'fullwidth';
	$background_type = (!empty($tdl_options['tdl_background_type'])) ? $tdl_options['tdl_background_type'] : 'color';

	if ($layout_type != 'fullwidth' && $background_type != 'none') {
		$bg_type = $background_type;

		$style = 'style="';
		if ($bg_type == 'color') {
			$style .= 'background-color:' . $tdl_options['tdl_background_color'];
		} elseif ($bg_type == 'custom_back') {
			if (! empty($tdl_options['tdl_background_img']['url'])) {
				$style .= 'background-image:url(' . $tdl_options['tdl_background_img']['url'] . ');' . ($tdl_options['tdl_background_repeat'] ? 'background-repeat:repeat;' : 'background-repeat:no-repeat;background-position:center;background-size:100%;background-size:cover;background-attachment:fixed;');

				$bg_image = '<img class="tdl-page-background" src="' . $tdl_options['tdl_background_img']['url'] . '" />';
			}
		} elseif ($bg_type == 'pattern_back') {
			$style .= 'background-image:url('. $tdl_options['tdl_pattern_back'] . '); background-repeat:repeat;';
		}
		$style .= '"';

		if ($bg_type != 'color')
			$bg_cover = '<div class="tdl-background-cover' . ($bg_type == 'custom_back' ? ' tdl-image' : '') . '" ' . $style . '></div>';
	}

	if (isset($bg_image)) printf( '%s', $bg_image );
	if (isset($bg_cover)) printf( '%s', $bg_cover );
}

/*-----------------------------------------------------------------------------------*/
/*	WPML dropdown
/*-----------------------------------------------------------------------------------*/

	function woodstock_language_and_currency() { 
		global $tdl_options;
		?>

		<?php if ( (isset($tdl_options['tdl_topbar_wpml'])) && (trim($tdl_options['tdl_topbar_wpml']) == "1" ) ) : ?>
            <div class="language-and-currency">
                
                <?php if (function_exists('icl_get_languages')) { ?>
                
                    <?php $additional_languages = icl_get_languages('skip_missing=N&orderby=KEY&order=DIR&link_empty_to=str'); ?>
                    
                    <select class="topbar-language-switcher">
                        <option><?php echo ICL_LANGUAGE_NAME; ?></option>
                        <?php
                                
                        if (count($additional_languages) > 1) {
                            foreach($additional_languages as $additional_language){
                              if(!$additional_language['active']) $langs[] = '<option value="'.$additional_language['url'].'">'.$additional_language['native_name'].'</option>';
                            }
                            echo join(', ', $langs);
                        }
                        
                        ?>
                    </select>
                
                <?php } ?>
                
                <?php if (class_exists('woocommerce_wpml')) { ?>
                    <?php do_action('wcml_currency_switcher', array('format' => '%code% (%symbol%)','switcher_style' => 'wcml-dropdown-click')); ?>
                <?php } ?>
                
            </div><!--.language-and-currency-->
        <?php endif; ?>	

	<?php }

	function woodstock_mob_language_and_currency() { 
		global $tdl_options;
		?>
	
		        <?php if ( (isset($tdl_options['tdl_topbar_wpml'])) && (trim($tdl_options['tdl_topbar_wpml']) == "1" ) ) : ?>
		            <div class="mob-language-and-currency">
		                
		                <?php if (function_exists('icl_get_languages')) { ?>
		                
		                    <?php $additional_languages = icl_get_languages('skip_missing=N&orderby=KEY&order=DIR&link_empty_to=str'); ?>
		                    
		                    <select class="topbar-language-switcher">
		                        <option><?php echo ICL_LANGUAGE_NAME; ?></option>
		                        <?php
		                                
		                        if (count($additional_languages) > 1) {
		                            foreach($additional_languages as $additional_language){
		                              if(!$additional_language['active']) $langs[] = '<option value="'.$additional_language['url'].'">'.$additional_language['native_name'].'</option>';
		                            }
		                            echo join(', ', $langs);
		                        }
		                        
		                        ?>
		                    </select>
		                
		                <?php } ?>
		                
		                <?php if (class_exists('woocommerce_wpml')) { ?>
		                    <?php do_action('wcml_currency_switcher', array('format' => '%code% (%symbol%)','switcher_style' => 'wcml-dropdown-click')); ?>
		                <?php } ?>
		                
		            </div><!--.language-and-currency-->
		        <?php endif; ?>
	<?php }

/*-----------------------------------------------------------------------------------*/
/*	Add Fresco to Galleries
/*-----------------------------------------------------------------------------------*/

add_filter( 'wp_get_attachment_link', 'woodstock_sant_prettyadd', 10, 6);
function woodstock_sant_prettyadd ($content, $id, $size, $permalink, $icon, $text) {
    if ($permalink) {
    	return $content;    
    }
    $content = preg_replace("/<a/","<span class=\"fresco\" data-fresco-group=\"\"", $content, 1);
    return $content;
}

/*-----------------------------------------------------------------------------------*/
/*	Ajax Search
/*-----------------------------------------------------------------------------------*/

if( ! function_exists( 'woodstock_search_form' ) ) {
	function woodstock_search_form( $args = array() ) {

		$tdl_options = woodstock_global_var();

		$args = wp_parse_args( $args, array(
			'ajax' => false,
			'post_type' => false,
			'show_categories' => false,
			'type' => 'form',
			'thumbnail' => true,
			'price' => true,
			'count' => 20,
			'el_classes' => '',
		) ); 

		extract( $args ); 

		$class = '';
		$data  = '';

		if ( $show_categories && $post_type == 'product' ) {
			$class .= ' has-categories-dropdown';
		} 

		$ajax_args = array(
			'thumbnail' => $thumbnail,
			'price' => $price,
			'post_type' => $post_type,
			'count' => $count
		);

		if( $ajax ) {
			$class .= ' woodstock-ajax-search';
			// woodstock_register_js( 'wstock-autocomplete' );
			foreach ($ajax_args as $key => $value) {
				$data .= ' data-' . $key . '="' . $value . '"';
			}
		}

		switch ( $post_type ) {
			case 'product':
				$placeholder = esc_attr_x( 'Search for products', 'submit button', 'woodstock' );
				$description = esc_html__( 'Start typing to see products you are looking for.', 'woodstock' );
			break;
		
			default:
				$placeholder = esc_attr_x( 'Search for posts', 'submit button', 'woodstock' );
				$description = esc_html__( 'Start typing to see posts you are looking for.', 'woodstock' );
			break;
		}

		if ( $el_classes ) {
			$class .= ' ' . $el_classes;
		}

		?>

		<div class="woodstock-search-<?php echo esc_attr( $type ); ?>">

			

			<form role="search" method="get" class="searchform <?php echo esc_attr( $class ); ?>" action="<?php echo esc_url( home_url( '/' ) ); ?>" <?php echo ! empty( $data ) ? $data : ''; ?>>
				<input type="text" class="s ajax-search-input" placeholder="<?php echo esc_attr( $placeholder ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
				<input type="hidden" name="post_type" value="<?php echo esc_attr( $post_type ); ?>">
				<?php if( $show_categories && $post_type == 'product' ) woodstock_show_categories_dropdown(); ?>
				<div class="ajax-loading <?php echo esc_attr($tdl_options['tdl_header_ajax_loader']); ?>"><div class="spinner"></div></div>
				<button type="submit" class="searchsubmit">
					<?php echo esc_attr_x( 'Search', 'submit button', 'woodstock' ); ?>
				</button>
			</form>	
			<?php if ( $ajax ): ?>
				<div class="search-results-wrapper <?php echo esc_attr($tdl_options['tdl_header_searchboxdrop_color_scheme']); ?>" ><div class="woodstock-scroll nano"><div class="woodstock-search-results woodstock-scroll-content nano-content"></div></div><div class="woodstock-search-loader"></div></div>
			<?php endif ?>

		</div>


		<?php
	}
}

// Show Search Categories


if( ! function_exists( 'woodstock_show_categories_dropdown' ) ) {
	function woodstock_show_categories_dropdown() {
		$args = array( 
			'hide_empty' => 1,
			'parent' => 0
		);
		$terms = get_terms('product_cat', $args);
		if( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
			?>
			<div class="search-by-category input-dropdown">
				<div class="input-dropdown-inner woodstock-scroll-content">
					<input type="hidden" name="product_cat" value="0">
					<a href="#" data-val="0"><?php esc_html_e('Select category', 'woodstock'); ?></a>
					<div class="list-wrapper woodstock-scroll">
						<ul class="woodstock-scroll-content">
							<li style="display:none;"><a href="#" data-val="0"><?php esc_html_e('Select category', 'woodstock'); ?></a></li>
							<?php
								if( ! apply_filters( 'woodstock_show_only_parent_categories_dropdown', false ) ) {
							        $args = array(
							            'title_li' => false,
										'taxonomy' => 'product_cat',
										'use_desc_for_title' => false,
							            'walker' => new WOODSTOCK_Custom_Walker_Category(),
							        );
							        wp_list_categories($args);
								} else {
								    foreach ( $terms as $term ) {
								    	?>
											<li><a href="#" data-val="<?php echo esc_attr( $term->slug ); ?>"><?php echo esc_attr( $term->name ); ?></a></li>
								    	<?php
								    }
								}
							?>
						</ul>
					</div>
				</div>
			</div>
			<?php
		}
	}
}


if ( ! function_exists( 'woodstock_init_search_by_sku' ) ) {
	function woodstock_init_search_by_sku() {
		global $tdl_options;

		if ( apply_filters( 'woodstock_search_by_sku', !empty($tdl_options['tdl_header_search_sku']) ) && woodstock_woocommerce_installed() ) {
			add_filter( 'posts_search', 'woodstock_product_search_sku', 9 );
		}
	}

	add_action( 'init', 'woodstock_init_search_by_sku', 10 );
}



if ( ! function_exists( 'woodstock_ajax_suggestions' ) ) {
	function woodstock_ajax_suggestions() {
		global $tdl_options;

		$allowed_types = array( 'post', 'product' );
		$post_type = 'product';

		if ( apply_filters( 'woodstock_search_by_sku', !empty($tdl_options['tdl_header_search_sku']) ) && woodstock_woocommerce_installed() ) {
			add_filter( 'posts_search', 'woodstock_product_ajax_search_sku', 10 );
		}
		
		$query_args = array(
			'posts_per_page' => 5,
			'post_status'    => 'publish',
			'post_type'      => $post_type,
			'no_found_rows'  => 1,
		);

		if ( ! empty( $_REQUEST['post_type'] ) && in_array( $_REQUEST['post_type'], $allowed_types ) ) {
			$post_type = strip_tags( $_REQUEST['post_type'] );
			$query_args['post_type'] = $post_type;
		}

		if ( $post_type == 'product' && woodstock_woocommerce_installed() ) {
			
			$product_visibility_term_ids = wc_get_product_visibility_term_ids();
			$query_args['tax_query'][] = array(
				'taxonomy' => 'product_visibility',
				'field'    => 'term_taxonomy_id',
				'terms'    => $product_visibility_term_ids['exclude-from-search'],
				'operator' => 'NOT IN',
			);

			if ( ! empty( $_REQUEST['product_cat'] ) ) {
				$query_args['product_cat'] = strip_tags( $_REQUEST['product_cat'] );
			}
		}

		if ( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) ) {
			$query_args['meta_query'][] = array( 'key' => '_stock_status', 'value' => 'outofstock', 'compare' => 'NOT IN' );
		}

		if ( ! empty( $_REQUEST['query'] ) ) {
			$query_args['s'] = sanitize_text_field( $_REQUEST['query'] );
		}

		if ( ! empty( $_REQUEST['number'] ) ) {
			$query_args['posts_per_page'] = (int) $_REQUEST['number'];
		}

		$results = new WP_Query( apply_filters( 'woodstock_ajax_search_args', $query_args ) );

		$suggestions = array();

		if ( $results->have_posts() ) {

			if ( $post_type == 'product' && woodstock_woocommerce_installed() ) {
				$factory = new WC_Product_Factory();
			}

			while ( $results->have_posts() ) {
				$results->the_post();

				if ( $post_type == 'product' && woodstock_woocommerce_installed() ) {
					$product = $factory->get_product( get_the_ID() );

					$suggestions[] = array(
						'value' => get_the_title(),
						'permalink' => get_the_permalink(),
						'price' => $product->get_price_html(),
						'thumbnail' => $product->get_image(),
					);
				} else {
					$suggestions[] = array(
						'value' => get_the_title(),
						'permalink' => get_the_permalink(),
						'thumbnail' => get_the_post_thumbnail( null, 'medium', '' ),
					);
				}
			}

			wp_reset_postdata();
		} else {
			$suggestions[] = array(
				'value' => ( $post_type == 'product' ) ? esc_html__( 'No products found', 'woodstock' ) : esc_html__( 'No posts found', 'woodstock' ),
				'no_found' => true,
				'permalink' => ''
			);
		}

		echo json_encode( array(
			'suggestions' => $suggestions
		) );

		die();
	}

	add_action( 'wp_ajax_woodstock_ajax_search', 'woodstock_ajax_suggestions', 10 );
	add_action( 'wp_ajax_nopriv_woodstock_ajax_search', 'woodstock_ajax_suggestions', 10 );
}

if ( ! function_exists( 'woodstock_product_search_sku' ) ) {
	function woodstock_product_search_sku( $where, $class = false ) {
		global $pagenow, $wpdb, $wp;

		$type = array('product', 'jam');
		
		if ( ( is_admin() ) //if ((is_admin() && 'edit.php' != $pagenow) 
				|| !is_search()  
				|| !isset( $wp->query_vars['s'] ) 
				//post_types can also be arrays..
				|| (isset( $wp->query_vars['post_type'] ) && 'product' != $wp->query_vars['post_type'] )
				|| (isset( $wp->query_vars['post_type'] ) && is_array( $wp->query_vars['post_type'] ) && !in_array( 'product', $wp->query_vars['post_type'] ) ) 
				) {
			return $where;
		}

		$s = $wp->query_vars['s'];

		return woodstock_sku_search_query( $where, $s );
	}
}

if ( ! function_exists( 'woodstock_product_ajax_search_sku' ) ) {
	function woodstock_product_ajax_search_sku( $where ) {
		if ( ! empty( $_REQUEST['query'] ) ) {
			$s = sanitize_text_field( $_REQUEST['query'] );
			return woodstock_sku_search_query( $where, $s );
		}

		return $where;
	}
}

if ( ! function_exists( 'woodstock_sku_search_query' ) ) {
	function woodstock_sku_search_query( $where, $s ) {
		global $wpdb;

		$search_ids = array();
		$terms = explode( ',', $s );

		foreach ( $terms as $term ) {
			//Include the search by id if admin area.
			if ( is_admin() && is_numeric( $term ) ) {
				$search_ids[] = $term;
			}
			// search for variations with a matching sku and return the parent.

			$sku_to_parent_id = $wpdb->get_col( $wpdb->prepare( "SELECT p.post_parent as post_id FROM {$wpdb->posts} as p join {$wpdb->postmeta} pm on p.ID = pm.post_id and pm.meta_key='_sku' and pm.meta_value LIKE '%%%s%%' where p.post_parent <> 0 group by p.post_parent", wc_clean( $term ) ) );

			//Search for a regular product that matches the sku.
			$sku_to_id = $wpdb->get_col( $wpdb->prepare( "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key='_sku' AND meta_value LIKE '%%%s%%';", wc_clean( $term ) ) );

			$search_ids = array_merge( $search_ids, $sku_to_id, $sku_to_parent_id );
		}

		$search_ids = array_filter( array_map( 'absint', $search_ids ) );

		if ( sizeof( $search_ids ) > 0 ) {
			$where = str_replace( ')))', ") OR ({$wpdb->posts}.ID IN (" . implode( ',', $search_ids ) . "))))", $where );
		}
		
		#remove_filters_for_anonymous_class('posts_search', 'WC_Admin_Post_Types', 'product_search', 10);
		return $where;
	}
}

/*-----------------------------------------------------------------------------------*/
/*	Post Get URL
/*-----------------------------------------------------------------------------------*/

function woodstock_get_link_url() {
	$content = get_the_content();
	$has_url = get_url_in_content( $content );

	return ( $has_url ) ? $has_url : apply_filters( 'the_permalink', get_permalink() );
}

/*-----------------------------------------------------------------------------------*/
/*	Post Meta
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'woodstock_post_header_entry' ) ) :
function woodstock_post_header_entry( $echo = true ) {
	if ( has_post_format( array( 'chat', 'status' ) ) )
		$format_prefix = _x( '%1$s on %2$s', '1: post format name. 2: date', 'woodstock' );
	else
		$format_prefix = '%2$s';

	if ( $echo )
		echo sprintf( '<a href="%1$s" title="%2$s" rel="bookmark" class="entry-date"><time datetime="%3$s">%4$s</time></a>',
			esc_url( get_permalink() ),
			esc_attr( sprintf( esc_html__( 'Permalink to %s', 'woodstock' ), the_title_attribute( 'echo=0' ) ) ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( sprintf( $format_prefix, get_post_format_string( get_post_format() ), get_the_date() ) )
		);

	if ( comments_open() ) :
	  echo '<p>';
	  comments_popup_link( 
    	esc_html__( 'No comments yet', 'woodstock' ), 
    	esc_html__( '1 Comment', 'woodstock' ), 
    	esc_html__( '% Comments', 'woodstock' ),
    	'comments-link',
    	esc_html__( 'Comments are off for this post', 'woodstock' )
);
	  echo '</p>';
	endif;
}
endif;


/*-----------------------------------------------------------------------------------*/
/*	Blog Meta
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'woodstock_entry_meta' ) ) :
function woodstock_entry_meta() {
	
	if ( is_sticky() && is_home() && ! is_paged() )
		echo '<span class="featured-post">' . esc_html__( 'Sticky', 'woodstock' ) . '</span>';

	// Post author
	if ( 'post' == get_post_type() ) {
		printf( esc_html__( ' This entry was posted by ', 'woodstock' ) . '<a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( esc_html__( 'View all posts by %s', 'woodstock' ), get_the_author() ) ),
			get_the_author()
		);
	}
	
	/*if ( ! has_post_format( 'link' ) && 'post' == get_post_type() )
		woodstock_post_header_entry();*/

	// Translators: used between list items, there is a space after the comma.
	$categories_list = get_the_category_list( ', ' );
	if ( $categories_list ) {
		echo esc_html__( ' in ', 'woodstock' ) . $categories_list . '';
	}

	// Translators: used between list items, there is a space after the comma.
	$tag_list = get_the_tag_list( '', ', ' );
	if ( $tag_list ) {
		echo esc_html__( ' and tagged ', 'woodstock' ) . $tag_list . '';
	}
}
endif;


/*-----------------------------------------------------------------------------------*/
/*	Blog Gallery
/*-----------------------------------------------------------------------------------*/


if ( ! is_admin() ) {

function woodstock_grab_ids_from_gallery() {
			
	global $post;
    
    if ( !isset($post) ) return;
    
	$attachment_ids = array();
	$pattern = get_shortcode_regex();
	$ids = array();
	
	if (preg_match_all( '/'. $pattern .'/s', $post->post_content, $matches ) ) {   //finds the "gallery" shortcode and puts the image ids in an associative array at $matches[3]
		//$count = count($matches[3]); //in case there is more than one gallery in the post.
		$count = 1;
		for ($i = 0; $i < $count; $i++){
			$atts = shortcode_parse_atts( $matches[3][$i] );
			if ( isset( $atts['ids'] ) ){
				$attachment_ids = explode( ',', $atts['ids'] );
				$ids = array_merge($ids, $attachment_ids);
			}
		}
	}
	
	return $ids;
	
}
add_action( 'wp', 'woodstock_grab_ids_from_gallery' );

}

/*-----------------------------------------------------------------------------------*/
/*	Blog Navigation
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'woodstock_content_nav' ) ) :
function woodstock_content_nav( $nav_id ) {
	global $wp_query, $post, $tdl_options;
    
    $blog_with_sidebar = "";
    if ( (isset($tdl_options['tdl_single_blog_layout'])) && ($tdl_options['tdl_single_blog_layout'] == "1" ) ) $blog_with_sidebar = "yes";
    if (isset($_GET["blog_with_sidebar"])) $blog_with_sidebar = $_GET["blog_with_sidebar"];

	
	$blog_masonry = "";
	if ( (isset($tdl_options['tdl_blog_layout'])) && ($tdl_options['tdl_blog_layout'] == "2" ) ) :
		$blog_masonry = "yes";
	endif;
	
	
	// Don't print empty markup on single pages if there's nowhere to navigate.
	if ( is_single() ) {
		$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
		$next = get_adjacent_post( false, '', false );

		if ( ! $next && ! $previous )
			return;
	}

	// Don't print empty markup in archives if there's only one page.
	if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
		return;

	$nav_class = ( is_single() ) ? 'post-navigation' : 'paging-navigation';

	?>
	<nav id="<?php echo esc_attr( $nav_id ); ?>" class="<?php echo esc_attr($nav_class); ?>">

        <div class="row">
        
			<?php if ( $blog_masonry == "yes" && !is_single() ) : ?>
            <div class="large-12 columns">
        	<?php elseif ( $blog_with_sidebar == "yes" ) : ?>
            <div class="large-12 columns">
        	<?php else : ?>
            <div class="large-8 large-centered columns without-sidebar">
        	<?php endif; ?>
        
				<?php if ( is_single() ) : // navigation links for single posts ?>
        
                    <div class="row">
                        
                        <div class="large-6 columns nav-left">
                            <?php previous_post_link( '<div class="nav-previous">%link', '<div class="nav-previous-title">'.esc_html__( "Previous Reading", "woodstock" ).'</div>%title</div>' ); ?>
                        </div><!-- .columns -->
                        
                        <div class="large-6 columns nav-right">
                            <?php next_post_link( '<div class="nav-next">%link', '<div class="nav-next-title">'.esc_html__( "Next Reading", "woodstock" ).'</div> %title</div>' ); ?>
                        </div><!-- .columns -->
                        
                    </div><!-- .row -->
            
				<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>
            
					<div class="archive-navigation">
						<div class="row">
							
							<div class="small-6 columns text-left">
								<?php if ( get_next_posts_link() ) : ?>
								<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'woodstock' ) ); ?></div>
								<?php endif; ?>
							</div>
							
							<div class="small-6 columns text-right">
								<?php if ( get_previous_posts_link() ) : ?>
								<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'woodstock' ) ); ?></div>
							<?php endif; ?>
							</div>
						
						</div>
					</div>
				
                <?php endif; ?>
            
            </div><!-- .columns -->
        
        </div><!-- .row -->

	</nav><!-- #<?php echo esc_html( $nav_id ); ?> -->
	<?php
}
endif; // woodstock_content_nav


/*-----------------------------------------------------------------------------------*/
/*	Blog Comments
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'woodstock_comment' ) ) :
function woodstock_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;

	if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
		<div class="comment-body">
			<?php esc_html_e( 'Pingback:', 'woodstock' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( esc_html__( 'Edit', 'woodstock' ), '<span class="edit-link">', '</span>' ); ?>
		</div>

	<?php else : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
		<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">

			<div class="comment-content">
				
				<div class="comment-author-avatar">
					<?php echo get_avatar( $comment, 140 ); ?>
				</div><!-- .comment-author-avatar -->
				
				<?php if ( '0' == $comment->comment_approved ) : ?>
					<p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'woodstock' ); ?></p>
				<?php endif; ?>
				
				<?php printf( esc_html__( '%s', 'woodstock' ), sprintf( '<h3 class="comment-author">%s</h3>', get_comment_author_link() ) ); ?>
                
                <div class="comment-metadata">
                    <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
                        <time datetime="<?php comment_time( 'c' ); ?>">
                            <?php printf( esc_html__( '%1$s at %2$s', 'woodstock' ), get_comment_date(), get_comment_time() ); ?>
                        </time>
                    </a>
                </div><!-- .comment-metadata -->

				<div class="comment-text"><?php comment_text(); ?></div><!-- .comment-text -->
                
                <?php
					comment_reply_link( array_merge( $args, array(
						'add_below' => 'div-comment',
						'depth'     => $depth,
						'max_depth' => $args['max_depth'],
						'before'    => '<span class="comment-reply"><i class="fa fa-reply"></i>',
						'after'     => '</span>',
					) ) );
				?>
				
				<?php edit_comment_link( esc_html__( 'Edit', 'woodstock' ), '<span class="comment-edit-link"><i class="fa fa-pencil-square-o"></i>', '</span>' ); ?>
                
			</div><!-- .comment-content -->
            
		</article><!-- .comment-body -->

	<?php
	endif;
}
endif; // ends check for woodstock_comment()

/*-----------------------------------------------------------------------------------*/
/*	Import Settings
/*-----------------------------------------------------------------------------------*/


function woodstock_merlin_import_files() {
	return [
		[
			'type'                     => 'electronics',
			'import_file_name'         => 'Electronics - Light Demo',
			'categories'               => [],
			'local_import_file'        => get_parent_theme_file_path() . '/includes/demo/electronics/content.xml',
			'local_import_widget_file' => get_parent_theme_file_path() . '/includes/demo/electronics/widgets.json',
			'local_import_rev_slider_file' => get_parent_theme_file_path() . '/includes/demo/electronics/homepage-2.zip',
			'import_preview_image_url' => get_parent_theme_file_uri() . '/includes/demo/electronics/classic.jpg',
			'import_notice'            => esc_html__( 'Electronics demo import', 'woodstock' ),
			'local_import_redux'       => [
				[
					'file_path'   => get_parent_theme_file_path() . '/includes/demo/electronics/redux_options.json',
					'option_name' => 'tdl_options',
				],
			],
			'preview_url'              => esc_url( 'https://woodstock.temashdesign.com/electronics/' ),
		],
		[
			'type'                     => 'watch',
			'import_file_name'         => 'Watch - Dark Demo',
			'categories'               => [],
			'local_import_file'        => get_parent_theme_file_path() . '/includes/demo/watch/content.xml',
			'local_import_widget_file' => get_parent_theme_file_path() . '/includes/demo/watch/widgets.json',
			'local_import_rev_slider_file' => get_parent_theme_file_path() . '/includes/demo/watch/watch-homepage.zip',
			'import_preview_image_url' => get_parent_theme_file_uri() . '/includes/demo/watch/watch.jpg',
			'import_notice'            => esc_html__( 'Watch demo import', 'woodstock' ),
			'local_import_redux'       => [
				[
					'file_path'   => get_parent_theme_file_path() . '/includes/demo/watch/redux_options.json',
					'option_name' => 'tdl_options',
				],
			],
			'preview_url'              => esc_url( 'https://woodstock.temashdesign.com/watch/' ),
		],
	];
}

add_filter( 'merlin_import_files', 'woodstock_merlin_import_files' );


function woodstock_import_options_demo( $fields ) {
	if ( empty( $fields ) ) {
		return false;
	}

	$fields = json_decode( $fields, true );

	foreach ( $fields as $key => $value ) {
		update_option( $key, $value, false );
	}

	return true;
}

 ?>