<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
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
$num_words = (!empty($tdl_options['tdl_product_description_number'])) ? $tdl_options['tdl_product_description_number'] : '20';
$product_display_thumb = (!empty($tdl_options['tdl_product_display_thumb'])) ? $tdl_options['tdl_product_display_thumb'] : 'standart';
$category_listing = (!empty($tdl_options['tdl_category_listing'])) ? $tdl_options['tdl_category_listing'] : 'first_category';


//woocommerce_after_shop_loop_item_title
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

add_action( 'woocommerce_after_shop_loop_item_title_loop_price', 'woocommerce_template_loop_price', 10 );
add_action( 'woocommerce_after_shop_loop_item_title_loop_rating', 'woocommerce_template_loop_rating', 5 );

//woocommerce_before_shop_loop_item_title
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );

$catalog_mode = (!empty($tdl_options['tdl_catalog_mode'])) ? $tdl_options['tdl_catalog_mode'] : 0; 
$header_ajax_loader = (!empty($tdl_options['tdl_header_ajax_loader'])) ? $tdl_options['tdl_header_ajax_loader'] : 'spinner-circle'; 
$tdl_product_align = (!empty($tdl_options['tdl_product_align'])) ? $tdl_options['tdl_product_align'] : 'palign-left'; 
$add_to_cart_display = (!empty($tdl_options['tdl_add_to_cart_display'])) ? $tdl_options['tdl_add_to_cart_display'] : 0;
$hover_product = (!empty($tdl_options['tdl_hover_product'])) ? $tdl_options['tdl_hover_product'] : 0;  
$hover_product_mobile = (!empty($tdl_options['tdl_hover_product_mobile'])) ? $tdl_options['tdl_hover_product_mobile'] : 0; 

// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

?>
<li class="product-item <?php if ( ($catalog_mode) && ($catalog_mode == 1) ) : ?>catalog_mode<?php endif; ?> <?php echo esc_attr($header_ajax_loader); ?> <?php echo esc_attr($tdl_product_align); ?> <?php if ( !$add_to_cart_display) echo 'display_buttons' ?> <?php if ( !$hover_product) { echo 'product_hover_disable'; } else { echo 'product_hover_enable'; } ?> <?php if ( !$hover_product_mobile) { echo 'product_hover_mob_disable'; } else { echo 'product_hover_mob_enable'; } ?>" >

	<figure class="product-inner">

		<?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>
		
		<!-- Product Thumbnail -->

		<div class="image-container <?php echo esc_attr($product_display_thumb); ?>">		
		<a href="<?php the_permalink(); ?>">
		<?php if ( $product_display_thumb == 'standart') { ?>

		<?php
			$attachment_ids = $product->get_gallery_image_ids();
			if ( $attachment_ids ) {
				$loop = 0;
				foreach ( $attachment_ids as $attachment_id ) {
					$image_link = wp_get_attachment_url( $attachment_id );
					if (!$image_link) continue;
					$loop++;
					$product_thumbnail_second = wp_get_attachment_image_src($attachment_id, 'shop_catalog');
					if ($loop == 1) break;
				}
			}
		?>

		<?php
		$style = '';
		$class = '';        
		if (isset($product_thumbnail_second[0])) {            
			$style = 'background-image:url(' . $product_thumbnail_second[0] . ')';
			$class = 'with_second_image';     
		}
		
		if ( (isset($tdl_options['tdl_second_image_product_listing'])) && ($tdl_options['tdl_second_image_product_listing'] == "0" ) ) {
			$style = '';
			$class = '';
		}
		?>

		<div class="product_thumbnail_wrapper">	
			<div class="product_thumbnail <?php echo esc_attr($class); ?>">

					<span class="product_thumbnail_background" style="<?php echo esc_attr($style); ?>"></span>
					<?php
						if ( has_post_thumbnail( $post->ID ) ) { 	
							echo  get_the_post_thumbnail( $post->ID, 'shop_catalog');
						}else{
							 echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="Placeholder" />', wc_placeholder_img_src() ), $post->ID );
						}
					?>

			</div>
		</div><!--.product_thumbnail_wrapper-->

		<?php } else if ( $product_display_thumb == 'slider') { ?>

		<div id="owl-demo-<?php echo esc_attr($post->ID); ?>" class="product_thumbnail_wrapper owl-carousel owl-theme">

					<?php
						if ( has_post_thumbnail( $post->ID ) ) { 	
							echo get_the_post_thumbnail( $post->ID, 'shop_catalog');
						}else{
							 echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="Placeholder" />', wc_placeholder_img_src() ), $post->ID );
						}
					?>		

		<?php
			$slider_num = $tdl_options['tdl_num_slider_images'] - 1;
			$attachment_ids = $product->get_gallery_image_ids();
			if ( $attachment_ids ) {
				$loop = 0;
				foreach ( $attachment_ids as $attachment_id ) {
					$image_link = wp_get_attachment_url( $attachment_id );
					if (!$image_link) continue;
					$loop++;
					$product_thumbnail_second = wp_get_attachment_image_src($attachment_id, 'shop_catalog');?>

		<a href="<?php the_permalink(); ?>">
			<div class="item"><img class="owl-lazy" data-src="<?php echo esc_url($product_thumbnail_second[0]) ?>" width="350" height="380"></div>
		</a>
				<?php if ($loop == $slider_num) break;
				}
			}
		?>		
		</div><!--.product_thumbnail_wrapper-->

		<?php } else { ?>

		<ul class="cd-gallery"><li>
			<a href="<?php the_permalink(); ?>">
				<ul class="cd-item-wrapper">
					<li class="selected">
						<?php
							if ( has_post_thumbnail( $post->ID ) ) { 	
								echo  get_the_post_thumbnail( $post->ID, 'shop_catalog');
							}else{
								 echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="Placeholder" />', wc_placeholder_img_src() ), $post->ID );
							}
						?>						
					</li>

				<?php
					$slider_num = $tdl_options['tdl_num_prevslider_images'] - 1;
					$attachment_ids = $product->get_gallery_image_ids();
					if ( $attachment_ids ) {
						$loop = 0;
						foreach ( $attachment_ids as $attachment_id ) {
							$image_link = wp_get_attachment_url( $attachment_id );
							if (!$image_link) continue;
							$loop++;
							$product_thumbnail_second = wp_get_attachment_image_src($attachment_id, 'shop_catalog');?>
						
						<?php if ($loop == 1): ?>
						<li class="move-right">
						<?php else: ?>
						<li>
						<?php endif; ?>
							<img src="<?php echo esc_url($product_thumbnail_second[0]); ?>" alt="Image 2">
						</li>

						<?php if ($loop == $slider_num) break;
						}
					}
				?>					
	 
				</ul> <!-- cd-item-wrapper -->
			</a>
		</li></ul>
		<?php } ?>

			<?php if ( (isset($tdl_options['tdl_catalog_mode'])) && ($tdl_options['tdl_catalog_mode'] == 0) ) : ?>
				<?php wc_get_template( 'loop/sale-flash.php' ); ?>
            <?php endif; ?>

			<?php if ( (isset($tdl_options['tdl_catalog_mode'])) && ($tdl_options['tdl_catalog_mode'] == 0) ) : ?>
				<?php if ( !$product->is_in_stock() ) : ?>            
					<span class="out_of_stock_title">
						<?php 
							if (isset($tdl_options['tdl_out_of_stock_text'])) {
								echo esc_html($tdl_options['tdl_out_of_stock_text']);
							} else {
								echo sc_html__('Out of stock', 'woocommerce');
							}
						 ?>
					</span>            
		    <?php endif; ?>


				<?php if ( in_array( 'jck-woo-quickview/jck-woo-quickview.php', apply_filters( 'active_plugins', get_option( 'active_plugins' )  ) ) ) { ?> 
					<span class="quick-view-button tip-bottom" data-jckqvpid="<?php echo esc_attr($post->ID); ?>" title="<?php esc_html_e( 'Quick View', 'woodstock' );?>"></span>					                       
	            <?php } ?> 	

			<?php endif; ?>	
	</a>
	<?php do_action( 'woocommerce_after_shop_loop_item_title' ); ?>
	</div><!--.image-container-->




	<div class="category-discription-grid-list">
	

		<?php 
		
		
		if ( $category_listing !== 'none') { ?>
             
			<?php if ( $category_listing == 'brand') { ?>
             
                <?php if(($term_id = get_brands_term_by_product_id($product->get_id())) > 0): $term = get_term($term_id,'brands');?>
                    <p class="product-category-listing"><a href="<?php echo get_term_link($term_id,'brands');?>" class="product-category-link"><?php echo esc_attr($term->name) ?></a></p>
                <?php endif; ?>          
             
             <?php } else if ( $category_listing == 'first_category') { ?>

                    <?php 

                    $product_cats = strip_tags(wc_get_product_category_list ($product->get_id(), '|||', '', '')); 
                    list($firstpart) = explode('|||', $product_cats);
                    $category_object = get_term_by('name', $firstpart, 'product_cat');
                    $category_id = $category_object->term_id;
                    if(empty($category_id)){
                        $category_url = $firstpart;
                    } else {
                        $category_url = get_term_link( (int)$category_id, 'product_cat' );
                    }
                    ?>
		            <p class="product-category-listing"><a href="<?php echo esc_url($category_url); ?>" class="product-category-link"><?php echo esc_attr($firstpart); ?></a></p>

			<?php } else { ?>
                    <?php
						echo wc_get_product_category_list($product->get_id(), ', ', '<p class="product-category-listing">', '</p>');

                    ?>
			<?php } ?>

		<?php } ?>


		<h4><a class="product-title-link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>	

        <?php if ( (isset($tdl_options['tdl_ratings_catalog_page'])) && ($tdl_options['tdl_ratings_catalog_page'] == "1" ) ) : ?>
	        <div class="archive-product-rating">
				<?php do_action( 'woocommerce_after_shop_loop_item_title_loop_rating' ); ?>
			</div>
        <?php endif; ?>

		<?php if ( (isset($tdl_options['tdl_product_description'])) && ($tdl_options['tdl_product_description'] == 1) ) : ?>
			<?php if ( (isset($tdl_options['tdl_product_description_html'])) && ($tdl_options['tdl_product_description_html'] == 1) ) : ?>
				<p><?php echo force_balance_tags( html_entity_decode( wp_trim_words( htmlentities( wpautop($post->post_excerpt) ), $num_words, $shortexcerpt ) ) ); ?></p>
			<?php else : ?>
				<p class="description-list"><?php echo esc_attr($shortexcerpt = wp_trim_words( $post->post_excerpt, $num_words, $more = '...' )); ?></p>
			<?php endif; ?>
		<?php endif; ?>
	</div><!--.category-discription-grid-list-->



	<div class="category-price-grid-list">
		<?php do_action( 'woocommerce_after_shop_loop_item_title_loop_price' ); ?>
		<div class="clearfix"></div>
		<?php if ( (isset($tdl_options['tdl_catalog_mode'])) && ($tdl_options['tdl_catalog_mode'] == 0) ) : ?>
			<?php echo woodstock_availability(); ?>
			<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
			<?php do_action( 'woocommerce_after_shop_loop_item' ); ?> 
			<div class="clearfix"></div>
		<?php endif; ?>
		<?php woodstock_loop_action_buttons(); ?>		

	</div><!--.category-price-grid-list-->	



	<div class="category-discription-grid">
		<?php 
		if ( $category_listing !== 'none') { ?>
                         
             <?php if ( $category_listing == 'first_category') { ?>
                    <?php 

                    $product_cats = strip_tags(wc_get_product_category_list ($product->get_id(), '|||', '', '')); 
                    list($firstpart) = explode('|||', $product_cats);
                    $category_object = get_term_by('name', $firstpart, 'product_cat');
                    $category_id = $category_object->term_id;
                    if(empty($category_id)){
                        $category_url = $firstpart;
                    } else {
                        $category_url = get_term_link( (int)$category_id, 'product_cat' );
                    }
                    ?>

		            <p class="product-category-listing"><a href="<?php echo esc_url($category_url); ?>" class="product-category-link"><?php echo esc_attr($firstpart); ?></a></p>

			<?php } else { ?>

                    <?php
						echo wc_get_product_category_list($product->get_id(), ', ', '<p class="product-category-listing">', '</p>');
                    ?>
			<?php } ?>

		<?php } ?>


		<h4><a class="product-title-link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>	

        <?php if ( (isset($tdl_options['tdl_ratings_catalog_page'])) && ($tdl_options['tdl_ratings_catalog_page'] == "1" ) ) : ?>
	        <div class="archive-product-rating">
				<?php do_action( 'woocommerce_after_shop_loop_item_title_loop_rating' ); ?>
			</div>
        <?php endif; ?>
        


		<div class="product_after_shop_loop">
			
			
			
			<div class="product_after_shop_loop_switcher">
				
				<div class="product_after_shop_loop_price">
					<?php do_action( 'woocommerce_after_shop_loop_item_title_loop_price' ); ?>
				</div>

				<div class="product_after_shop_loop_buttons">
					<?php do_action( 'woocommerce_after_shop_loop_item' ); ?> 
				</div>

				
			</div>
			
		</div>

	</div><!--.category-discription-grid-->	

		<div class="inner-desc">
		<?php if ( (isset($tdl_options['tdl_product_description'])) && ($tdl_options['tdl_product_description'] == 1) ) : ?>
			<?php if ( (isset($tdl_options['tdl_product_description_html'])) && ($tdl_options['tdl_product_description_html'] == 1) ) : ?>
				<p><?php echo force_balance_tags( html_entity_decode( wp_trim_words( htmlentities( wpautop($post->post_excerpt) ), $num_words, $shortexcerpt ) ) ); ?></p>
			<?php else : ?>
				<p class="description-list"><?php echo esc_attr($shortexcerpt = wp_trim_words( $post->post_excerpt, $num_words, $more = '...' )); ?></p>
			<?php endif; ?>
		<?php endif; ?>
		
			<?php woodstock_loop_action_buttons(); ?>
		</div>

	</figure>
	<!-- <div class="clearfix"></div> -->
</li>
