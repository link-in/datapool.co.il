<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

$tdl_options = woodstock_global_var();
get_header('shop'); 

// Sidebar Settings
$shop_has_sidebar = false;

$shop_categories = (!empty($tdl_options['tdl_shop_categories'])) ? $tdl_options['tdl_shop_categories'] : 1; 
$shop_sidebar = (!empty($tdl_options['tdl_sidebar_listing'])) ? $tdl_options['tdl_sidebar_listing'] : 3; 
$title_color = (!empty($tdl_options['tdl_title_color_scheme'])) ? $tdl_options['tdl_title_color_scheme'] : 'mta-light'; 
$default_image_header = (!empty($tdl_options['tdl_default_header_bg']['url'])) ? $tdl_options['tdl_default_header_bg']['url'] : ''; 

if (is_active_sidebar('widgets-product-listing')) {if ($shop_sidebar == 3) {$shop_has_sidebar = false;} else {$shop_has_sidebar = true;}}
    else {$shop_has_sidebar = false;}

if ($shop_sidebar == 1) {$shop_sidebar = 'left-sidebar';} else if ($shop_sidebar == 2) {$shop_sidebar = 'right-sidebar';} else {$shop_sidebar = 'full-width';};
if (isset($_GET["shop_sidebar"])) $shop_sidebar = $_GET["shop_sidebar"];

$no_parallax = "";
if ((isset($tdl_options['tdl_shop_header_parallax'])) && ($tdl_options['tdl_shop_header_parallax'] == 0)) {
    $no_parallax = ' without_parallax';
}


get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );

?>

<div id="primary" class="content-area shop-page<?php echo esc_attr($shop_has_sidebar) ? ' '. esc_attr($shop_sidebar):'';?>">
    <!-- Shop Header -->

    <?php 
        if (is_shop()) {
            $page_id = wc_get_page_id('shop');
            $page_title_option = get_field('tdl_hide_title', $page_id);
            $header_content_type = get_field('tdl_page_header_content_type', $page_id);
            $custom_header = get_field('tdl_page_custom_header', $page_id);

            $image_header = get_field('tdl_page_image_header', $page_id);
            if ($image_header) {
                $image_header = $image_header['url'];
            }
            

            if ($header_content_type == 'none') {
                if ($default_image_header) {
                    $header_content_type = 'image';
                    $image_header = $default_image_header;
                } 
            }

            $title_align = get_field('tdl_page_align_select', $page_id);
            $subtitle = get_field('tdl_subtitle', $page_id);

            if (get_field('tdl_align_select', $page_id)) {
                $title_align = get_field('tdl_align_select', $page_id);
            } else {
                $title_align = (!empty($tdl_options['tdl_title_align'])) ? $tdl_options['tdl_title_align'] : 'title-left'; 
            }
                       
        } else {
            $term = get_queried_object();
            $header_content_type = get_field('tdl_header_content_type', $term);
            $custom_header = get_field('tdl_custom_header', $term);
            $image_header = get_field('tdl_image_header', $term);

            $image_header = $image_header['url'];
            
            if ($header_content_type == 'none' or $header_content_type == false) {
                
                if ($default_image_header) {
                    $header_content_type = 'image';
                    $image_header = $default_image_header;
                } 
            }

            if ($header_content_type == 'hide' or $header_content_type == false) {
                $page_title_option = 0;
            } else {
                $page_title_option = 1;
            }


            if (get_field('tdl_align_select', $term)) {
                $title_align = get_field('tdl_align_select', $term);
            } else {
                $title_align = $tdl_options['tdl_title_align'];
            }
        } 
        
     ?>

    <?php if ( $page_title_option == 1 ): ?>

        <?php 
        if ($header_content_type !== false && $header_content_type != 'none') {
            if ($header_content_type == 'image')    
                echo '<div class="site_header with_featured_img' . $no_parallax . '" style="background-image:url(' . $image_header . ')">';                                     
            else if ($header_content_type == 'custom') 
                echo '<div class="site_header"><div class="tdl-shop-header-custom">' . $custom_header . '</div>';
        }  else 
                echo '<div class="site_header without_featured_img ' . $title_color . '">';
        ?>

        <?php if ($header_content_type != 'custom'): ?> 
            <div class="site_header_overlay"></div>

            <div class="row">
                <div class="large-12 <?php echo esc_attr( $title_align );?> large-centered columns">
                        <?php 
                        if ((isset($tdl_options['tdl_shop_breadcrumb'])) && ($tdl_options['tdl_shop_breadcrumb'] == "1"))
                            {
                            // BREADCRUMBS
                            echo woodstock_breadcrumbs();
                            }
                        ?>

                        <?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>   
                            <h1 class="page-title on-shop"><?php woocommerce_page_title(); ?></h1>

                            <?php if ( is_shop() ) : ?>
                                <?php if ( !is_search() ) : ?>
                                    <?php if ( esc_attr( $subtitle ) ) : ?>
                                        <div class="term-description"><p><?php echo esc_attr( $subtitle ); ?></p></div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php else: ?>
                                <?php do_action( 'woocommerce_archive_description' ); ?>
                            <?php endif; ?>

                        <?php endif; ?>

                </div><!-- .large-12 -->

            </div><!-- .row -->           
        <?php endif; ?>
        </div><!-- .site_header -->


        <!-- Shop Categories Area -->  

        <?php 
        // Find the category + category parent, if applicable
        if ($tdl_options['tdl_shop_categories'] == 1) {
        $term           = get_queried_object();
        $parent_id      = empty( $term->term_id ) ? 0 : $term->term_id;
        $categories     = get_terms('product_cat', array('hide_empty' => 1, 'parent' => $parent_id));
        if ($categories) :
        ?>    

        <div id="archive-categories" <?php if ($header_content_type == 'custom') {echo 'class="custom-header-content"';}; ?> >
            <div class="row">
                <div class="large-12 columns">
                    <div class="category-box">                             
                        <ul class="list_shop_categories <?php if ($tdl_options['main_header_layout'] == 2) {echo 'cat-center';}; ?> ">
                                    
                            <?php $cat_counter = 0; ?>
                                    
                            <?php foreach($categories as $category) : ?>

                                <li class="category_item">
                                    <a href="<?php echo get_term_link( $category->slug, 'product_cat' ); ?>">

                                    <?php if( $catalog_icon = get_field('tdl_catalog_icon', 'product_cat_'.$category->term_id) ): ?>
                                        <div class="caterory-thumb">
                                            <img src="<?php echo esc_url($catalog_icon['url']) ?>">
                                        </div>
                                    <?php endif; ?>

                                        <div class="category-item-desc">
                                            <h4><?php echo esc_html($category->name); ?></h4>
                                            <span class="cat-count">
                                                <?php echo sprintf (_n( '%d item', '%d items', $category->count , 'woodstock'), $category->count ); ?>
                                            </span>
                                        </div>
                                    </a>   
                                    </li>
                            
                            <?php endforeach; ?>
                                    
                        </ul><!-- .list_shop_categories-->
                    </div>
                </div>
            </div>
        </div>  
        <?php endif; ?>
    <?php } endif; ?>
    

    <?php if ( $shop_sidebar != "full-width" ) : ?>
        <?php if (is_active_sidebar( 'widgets-product-listing')) : ?>
            <!-- Shop Sidebar Button --> 
            <div id="button_offcanvas_sidebar_left"><i class="sidebar-icon"></i></div>
        <?php endif; ?>
    <?php endif; ?>  


    <!-- Shop Content Area --> 

    <div class="before_main_content">
        <?php do_action( 'woocommerce_before_main_content'); ?>
        <?php do_action( 'woodstock_before_shop_page' ); ?>
    </div> 

    <div id="content" class="site-content" role="main">
        <div class="row">

            <?php if ( $shop_sidebar != "full-width" ) : ?>
                           
                <div class="xlarge-2 large-3 medium-3 columns sidebar-pos">
                    <div class="shop_sidebar wpb_widgetised_column">
                        <?php if ( is_active_sidebar( 'widgets-product-listing' ) ) { ?>
                            <?php dynamic_sidebar( 'widgets-product-listing' ); ?>
                        <?php } ?>
                    </div>
                </div>
                
                <div class="xlarge-10 large-9 medium-9 columns content-pos">
                
                
            <?php else : ?>
            
                <div class="large-12 columns">
                
            <?php endif; ?>

                <!-- Shop Order Bar -->

                <div class="top_bar_shop">
                    <div class="catalog-ordering">
                        <?php if ( have_posts() ) : ?>
                                <?php do_action( 'woocommerce_before_shop_loop_result_count' ); ?>
                        <?php endif; ?>
                    </div> <!--catalog-ordering-->
                    <div class="clearfix"></div>
                </div><!-- .top_bar_shop--> 

                <?php if ( woocommerce_product_loop() ) { ?>
                                    
                    <?php do_action( 'woocommerce_before_shop_loop' ); ?>
        
                        <div class="active_filters_ontop"><?php the_widget( 'WC_Widget_Layered_Nav_Filters', 'title=' ); ?></div>
                        
                        <?php 
                            woocommerce_product_loop_start();

                            if ( wc_get_loop_prop( 'total' ) ) {
                                while ( have_posts() ) {
                                    the_post();

                                    /**
                                     * Hook: woocommerce_shop_loop.
                                     *
                                     * @hooked WC_Structured_Data::generate_product_data() - 10
                                     */
                                    do_action( 'woocommerce_shop_loop' );

                                    wc_get_template_part( 'content', 'product' );
                                }
                            }

                            woocommerce_product_loop_end();
                            ?>
                            

                    <div class="woocommerce-after-shop-loop-wrapper">
                        <?php do_action( 'woocommerce_after_shop_loop' ); ?>
                    </div>
                    
                <?php } else { ?>
                
                    <?php wc_get_template( 'loop/no-products-found.php' ); ?>
        
                <?php } ?>

                </div><!-- .large-9 or .large-12 -->


        </div>
    </div>

</div><!-- #primary -->

<?php get_footer('shop'); ?>
