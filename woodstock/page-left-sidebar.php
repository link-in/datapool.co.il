<?php
/*
Template Name: Page with Left Sidebar
*/
?>

<?php
	$tdl_options = woodstock_global_var();

    $page_id = "";
    if ( is_single() || is_page() ) {
        $page_id = get_the_ID();
    } else if ( is_home() ) {
        $page_id = get_option('page_for_posts');		
    }


    $page_header_src = "";

    if (has_post_thumbnail()) $page_header_src = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );


    if ( WOODSTOCK_ACF_IS_ACTIVE ) {
        $page_title_option = esc_attr(get_field('tdl_hide_title', $page_id));
    }
    
	if (function_exists('is_cart') && is_cart() || function_exists('is_checkout') && is_checkout() || function_exists('is_account_page') && is_account_page()) 
	{
		$page_title_option = 1;
	}

?>

<?php get_header(); ?>

	<div id="primary" class="content-area">
	<?php if ( $page_title_option == 1 ): ?>

	<?php 

		// If Pages
		$title_color = $tdl_options['tdl_page_title_color_scheme'];
		$default_image_header = $tdl_options['tdl_page_default_header_bg']['url'];
		
		$header_content_type = get_field('tdl_page_header_content_type', $page_id);
		$custom_header = get_field('tdl_page_custom_header', $page_id);
		$image_header = get_field('tdl_page_image_header', $page_id);
		$image_header = $image_header['url'];

		if ($header_content_type == 'none') {
			if ($default_image_header) {
				$header_content_type = 'image';
				$image_header = $default_image_header;
			} 
		}

		$title_align = get_field('tdl_page_align_select', $page_id);
		$subtitle = get_field('tdl_subtitle', $page_id);

        $no_parallax = "";
        if ((isset($tdl_options['tdl_page_header_parallax'])) && ($tdl_options['tdl_page_header_parallax'] == 0)) {
            $no_parallax = ' without_parallax';
        }               
	?>

	<?php 
        if ($header_content_type !== false && $header_content_type != 'none') {
            if ($header_content_type == 'image')                
                echo '<div class="site_header with_featured_img' . $no_parallax . '" style="background-image:url(' . $image_header . ')">';              
            else if ($header_content_type == 'custom') 
                echo '<div class="site_header"><div class="tdl-shop-header-custom">' . $custom_header . '</div>';
        }  else 
                echo '<div class="site_header  without_featured_img ' . $title_color . '">';
	?>


    <?php if ($header_content_type != 'custom'): ?>
        <div class="site_header_overlay"></div>

        <div class="row">
            <div class="large-12 <?php echo esc_attr($title_align);?> large-centered columns">
                    <?php 
                    if ((isset($tdl_options['tdl_shop_breadcrumb'])) && ($tdl_options['tdl_shop_breadcrumb'] == "1"))
                        {
                        // BREADCRUMBS
                        echo woodstock_breadcrumbs();
                        }
                    ?>

                    <?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
                        <h1 class="page-title on-shop"><?php the_title(); ?></h1>


                            <?php if ( esc_attr( $subtitle ) ) : ?>
                                <div class="term-description"><p><?php echo esc_attr( $subtitle ); ?></p></div>
                            <?php endif; ?>


                    <?php endif; ?>
                    
            </div><!-- .large-12 -->

        </div><!-- .row -->
    <?php endif; ?>
    </div><!-- .site_header -->
    <?php endif; ?>

	<?php 
	    if (get_field('tdl_page_padding', $page_id) == 1) {
	        $page_content_style = 'padding: 50px 0;'; 
	    }
	 ?>

        <div id="content" class="site-content" role="main"  style="<?php echo esc_attr( $page_content_style ); ?>">


			<?php if (function_exists('wc_print_notices')) : ?>
				<div class="row woocommerce">
					<div class="large-12 columns">
						<?php wc_print_notices(); ?>
					</div>
				</div>
			<?php endif; ?>          

        	<div class="row">
        		<div class="xlarge-3 large-3 medium-3 columns page-sidebar">
					<div class="shop_sidebar wpb_widgetised_column">
						<div class="row">
	    					<div class="large-11 columns">					
								<?php get_sidebar(); ?>
							</div>
						</div>
					</div>       			
        		</div>       	
        		<div class="xlarge-9 large-9 medium-9 columns page-content">
					<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'page' ); ?>
		                    
					<?php if (function_exists('is_cart') && is_cart()) : ?>
						<?php else: ?>    
						<div class="clearfix"></div>
						<?php endif; ?>

                <?php
                    // If comments are open or we have at least one comment, load up the comment template.
                    if ( comments_open() || get_comments_number() ) {
                        comments_template();
                    }
                ?>

		            <?php endwhile; // end of the loop. ?>       			
        		</div>	
        	</div>

        </div><!-- #content -->   
        <?php if (is_active_sidebar( 'sidebar')) : ?>
            	<div id="button_offcanvas_sidebar_left"><i class="sidebar-icon"></i></div>
        <?php endif; ?>                   
    </div><!-- #primary -->
    
<?php get_footer(); ?>
