<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

//woocommerce_before_main_content
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );

//woocommerce_after_main_content
//nothing changed

//woocommerce_after_single_product_summary
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

add_action( 'woocommerce_after_single_product_summary_upsell_display', 'woocommerce_upsell_display', 15 );
add_action( 'woocommerce_after_single_product_summary_related_products', 'woocommerce_output_related_products', 20 );

get_header('shop');

?>


<div id="primary" class="content-area">
        
    <div id="content" class="site-content" role="main">

    
		<?php while ( have_posts() ) : the_post(); ?>
            
            <?php 
            if(!empty(get_field("product_script"))){
                ?>



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
                    <h1 class="product_title entry-title"><?php echo the_title_datapool(get_the_title())?></h1>
                    <?php
                   the_field("product_script");
                    ?>

                    <div class="row">
                        <div class="xlarge-12 large-12 columns">
                            <div class="add_to_cart_box">
                                <p class="<?php echo esc_attr( apply_filters( 'woocommerce_product_price_class', 'price' ) ); ?>"><?php echo $product->get_price_html(); ?></p>
                                <?php  woocommerce_simple_add_to_cart();?>
                             </div>
                        </div>                                  
                    </div>
				</div><!--.columns-->
                <div class="row">
                    <div class="xlarge-12 large-12 columns content-pos">
                    <?php
                    
                    require_once( ABSPATH.'/wp-content/themes/woodstock-child/woocommerce/single-product/meta.php');
                    ?>
                    </div>
                    </div>      
                </div><!--.row-->
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


 
                <?php
            }else{
                wc_get_template_part( 'content', 'single-product' ); 
            }
            ?>

        <?php endwhile; // end of the loop. ?>
    
    </div><!-- #content -->           

</div><!-- #primary -->

<div class="single_product_upsell">
    <div class="row">
        <div class="large-12 columns">
            <?php do_action( 'woocommerce_after_single_product_summary_upsell_display' ); ?> 
        </div>
    </div><!-- .row -->         
</div><!-- .single_product_summary_upsell -->

<div class="single_product_related">
    <div class="row">
        <div class="large-12 columns">
            <?php do_action( 'woocommerce_after_single_product_summary_related_products' ); ?>
        </div>
    </div><!-- .row -->
</div><!-- .single_product_summary_related -->



<?php get_footer('shop'); ?>