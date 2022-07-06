<?php
    $tdl_options = woodstock_global_var();
    $blog_with_sidebar = "yes"; 
?>

<?php get_header(); ?>

<?php 
    $title_style = 'margin-bottom: 50px;';
    $blog_content_style = 'margin-bottom: 30px;'; 
 ?>

<div id="primary" class="content-area" style="<?php echo esc_attr( $blog_content_style ); ?>">

<?php 

    $title_color = (!empty($tdl_options['tdl_page_title_color_scheme'])) ? $tdl_options['tdl_blog_title_color_scheme'] : 'mta-light';

    $default_image_header = "";

    if ( (isset($tdl_options['tdl_page_default_header_bg']['url'])) && (trim($tdl_options['tdl_page_default_header_bg']['url']) != "" ) ) {
        $default_image_header = $tdl_options['tdl_page_default_header_bg']['url'];
    }    


    if ($default_image_header) {
        $header_content_type = 'image';
        $image_header = $default_image_header;
    } else {
        $header_content_type = '';
    }

    $title_align = (!empty($tdl_options['tdl_page_title_align'])) ? $tdl_options['tdl_page_title_align'] : 'title-left';


    $no_parallax = "";
    if ((isset($tdl_options['tdl_page_header_parallax'])) && ($tdl_options['tdl_page_header_parallax'] == 0)) {
        $no_parallax = ' without_parallax';
    }          
?>

    <?php 

    if ($header_content_type == 'image')                
        echo '<div class="site_header with_featured_img' . $no_parallax . '" style="' . $title_style . 'background-image:url(' . $image_header . ')">';           
    else 
        echo '<div class="site_header  without_featured_img ' . $title_color . '" style="' . $title_style . '">';

    ?>


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
                        <h1 class="page-title on-shop"><?php printf( esc_html__( 'Search Results for: %s', 'woodstock' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
                        <?php endif; ?>
                        
                </div><!-- .large-12 -->
            </div><!-- .row -->

    </div><!-- .site_header -->
	
        <?php if ( $blog_with_sidebar == "yes" ) : ?>
            <div class="row"><div class="large-8 columns with-sidebar">
        <?php endif; ?>
        
                <div id="content" class="site-content" role="main">
                
                    <?php if ( have_posts() ) : ?>
            
                        <?php while ( have_posts() ) : the_post(); ?>
            
                            <?php
                                //get_template_part( 'content', 'search' );
								get_template_part( 'includes/content', get_post_format() );
                            ?>
								<hr class="content_hr" />
                        <?php endwhile; ?>
            
                        <?php woodstock_content_nav( 'nav-below' ); ?>
            
                    <?php else : ?>
            
                        <?php get_template_part( 'includes/content', 'none' ); ?>
            
                    <?php endif; ?>
                    
                </div><!-- #content --> 
                         
            <?php if ( $blog_with_sidebar == "yes" ) : ?>
        		</div><!-- .columns -->
            <?php endif; ?>
            
            <?php if ( $blog_with_sidebar == "yes" ) : ?>
                <div class="xlarge-3 large-4 columns show-for-large-up">
                    <div class="shop_sidebar wpb_widgetised_column">
                        <div class="row">
                            <div class="large-10 large-push-2 columns">                 
                                <?php get_sidebar(); ?>
                            </div>
                        </div>
                    </div>                  
                </div>
            <?php endif; ?>
            
        <?php if ( $blog_with_sidebar == "yes" ) : ?>
        	</div><!-- .row -->
        <?php endif; ?>

    <?php if ( $blog_with_sidebar == "yes" ) : ?>
        <?php if (is_active_sidebar( 'sidebar')) : ?>
                <div id="button_offcanvas_sidebar_left"><i class="sidebar-icon"></i></div>
        <?php endif; ?>
    <?php endif; ?>
                            
    </div><!-- #primary -->

<?php get_footer(); ?>
